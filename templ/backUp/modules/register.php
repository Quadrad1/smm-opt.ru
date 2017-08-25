<?php

$metatags['title'] = 'Регистрация';

$tpl->set('content_header', $metatags['title']);

if ($is_logged) {
	$tpl->set('info', 'Вы уже авторизованы на сайте.');
	
// Register user
} elseif (isset($_POST['email'])) {
	$email = !empty($_POST['email']) ? trim($_POST['email']) : '';
	$password = !empty($_POST['password']) ? $_POST['password'] : '';
	$password_confirm = !empty($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
	
	$tpl->set('email', $email);
	
	if (empty($email)) {
		$tpl->set('error', 'Указан пустой электронный адрес.');
	} elseif (!strpos($email, '@')) {
		$tpl->set('error', 'Указан некорректный электронный адрес.');
	} elseif (empty($password)) {
		$tpl->set('error', 'Указан пустой пароль.');
	} elseif ($password != $password_confirm) {
		$tpl->set('error', 'Пароли не совпадают.');
	} else {
		$result = $db->query("SELECT `id` FROM `user` WHERE `email` = '" . $db->escape($email) . "'");
		
		if ($result->num_rows) {
			$tpl->set('error', 'Указанный электронный адрес уже зарегистрирован в нашей системе. Если Вы забыли пароль, его можно восстановить на странице <a href="' . SITE_URL . '/index.php?mod=password">восстановления пароля</a>.');
		} else {
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			if (!$password_hash) {
				die('PHP extension Crypt must be loaded for password_hash function');
			}
			
			$db->query("INSERT INTO `user` SET `email` = '" . $db->escape($email) . "', `password_hash` = '" . $db->escape($password_hash) . "'");
			
			$tpl->set('info', 'Вы были успешно зарегистрированы и можете <a href="' . SITE_URL . '/index.php?mod=auth">войти на сайт</a> используя электронный адрес и пароль указанные при регистрации.');
		}
	}
}
