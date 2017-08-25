<?php
/**
* 
* {{ user.arr }} set in /helpers/login.php
* 
*/
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';

if ($action == 'change_password') {
	$metatags['title'] = 'Изменение пароля';
} elseif ($action == 'payment') {
	$metatags['title'] = 'Пополнение баланса';
} else {
	$metatags['title'] = 'Личный кабинет';
}

$tpl->set('content_header', $metatags['title']);
$tpl->set('action', $action);

if (!$is_logged) {
	$tpl->set('info', 'Для доступа к этой странице требуется <a href="' . SITE_URL . '/index.php?mod=auth&amp;return_url=' . urlencode($_SERVER['REQUEST_URI']) . '">авторизация</a>.');
	
// Change password
} elseif ($action == 'change_password' && isset($_POST['current_password'])) {
	$current_password = !empty($_POST['current_password']) ? $_POST['current_password'] : '';
	$password = !empty($_POST['password']) ? $_POST['password'] : '';
	$password_confirm = !empty($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
	
	$user = $db->query("SELECT `password_hash` FROM `user` WHERE `id` = '" . (int)$_SESSION['user']['id'] . "'");
	
	if (!$user->num_rows || !password_verify($current_password, $user->row['password_hash'])) {
		$tpl->set('error', 'Указан неправильный действующий пароль.');
	} elseif (empty($password)) {
		$tpl->set('error', 'Указан пустой новый пароль.');
	} elseif ($password != $password_confirm) {
		$tpl->set('error', 'Новые пароли не совпадают.');
	} else {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		if (!$password_hash) {
			die('PHP extension Crypt must be loaded for password_hash function');
		}
		
		$db->query("UPDATE `user` SET `password_hash` = '" . $db->escape($password_hash) . "' WHERE `id` = '" . (int)$_SESSION['user']['id'] . "'");
		
		$_SESSION['user']['hash'] = md5($password_hash);
		
		$tpl->set('info', 'Пароль был успешно изменён.');
	}
	
// Payment via robokassa
} elseif ($action == 'payment') {
	if (isset($_GET['result']) && ($_GET['result'] == 'success' || $_GET['result'] == 'fail')) {
		$tpl->set('result', $_GET['result']);
	} elseif (isset($_POST['payment_sum']) && (float)$_POST['payment_sum'] > 0) {
		$robokassa = array(
			'MerchantLogin' => 'smmopt',
			'OutSum' => (float)$_POST['payment_sum'],
			'InvDesc' => 'Пополнение баланса пользователя ' . $_SESSION['user']['email'],
			'Encoding' => 'utf-8',
			'Email' => $_SESSION['user']['email'],
			'Shp_user' => $_SESSION['user']['id'],
            'IncCurrLabel' => 'QCardR'
		);
		$robokassa['SignatureValue'] = md5($robokassa['MerchantLogin'] . ':' . $robokassa['OutSum'] . '::' . $config['robokassa_password1'] . ':Shp_user=' . $robokassa['Shp_user']);
		#$robokassa['IsTest'] = 1; # Test mode
		
		$tpl->set('robokassa', $robokassa);
	}
	
// Default page
} else {
	// Get transaction list
	$result = $db->query("SELECT DATE_FORMAT(`date`, '%d.%m.%Y, %H:%i') AS `datetime`, `sum`, `comment` FROM `transaction` WHERE `user_id` = '" . (int)$_SESSION['user']['id'] . "' ORDER BY `date` DESC LIMIT 10");
	if ($result->num_rows) {
		$tpl->set('transaction_list', $result->rows);
	}
	
	// Get order list
	$result = $db->query("SELECT DATE_FORMAT(`date`, '%d.%m.%Y, %H:%i') AS `datetime`, `service_name`, `price` FROM `order` WHERE `user_id` = '" . (int)$_SESSION['user']['id'] . "' ORDER BY `date` DESC LIMIT 10");
	if ($result->num_rows) {
		$tpl->set('order_list', $result->rows);
	}
}
