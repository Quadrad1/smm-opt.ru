<?php

$metatags['title'] = 'Заказ услуги';
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
$service_id = !empty($_REQUEST['service_id']) ? (int)$_REQUEST['service_id'] : 0;

$tpl->set('content_header', $metatags['title']);

if (!$is_logged) {
	$tpl->set('info', 'Для доступа к этой странице требуется <a href="' . SITE_URL . '/index.php?mod=auth&amp;return_url=' . urlencode($_SERVER['REQUEST_URI']) . '">авторизация</a>.');
	
// Checkout
} elseif ($action == 'checkout') {
	$target_page = !empty($_POST['target_page']) ? trim($_POST['target_page']) : '';
	$quantity = !empty($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $comments = !empty($_POST['comments']) ? trim($_POST['comments']) : '';
	$comment = 'Заказ услуги (ID: ' . $service_id . ')';
	$output = array();
	
	$service = $db->query("SELECT `id`, `epsmm_id`, `network`, `name`, `price`, `quantity`, `active` FROM `service` WHERE `id` = '" . $service_id . "'");
	$service_quantity = unserialize($service->row['quantity']);
    $service->row['network'] = mb_strtolower($service->row['network'], 'utf-8');
	
	$total_price = round(($service->row['price'] / $service_quantity['per']) * $quantity, 2);
	
	if ($total_price > $_SESSION['user']['balance']) {
		$output['error'] = 'Имеющихся средств недостаточно для оплаты заказа. <a href="' . SITE_URL . '/index.php?mod=account&amp;action=payment">Пополните баланс</a> на сумму <b style="color: #000;">' . ($total_price - $_SESSION['user']['balance']) . ' руб.</b> и повторите попытку.';
	} elseif (!$service->num_rows) {
		$output['error'] = 'Услуга не найдена.';
	} elseif (!$service->row['active']) {
		$output['error'] = 'Услуга неактивна.';
	} elseif ($quantity < $service_quantity['min']) {
		$output['error'] = 'Указанное кол-во единиц ниже минимально допустимого значения ' . $service_quantity['min'] . ' ед.';
	} elseif ($quantity > $service_quantity['max']) {
		$output['error'] = 'Указанное кол-во единиц превышает максимально допустимое значение ' . $service_quantity['max'] . ' ед.';
		
	// EPSMM order
	} elseif ($service->row['epsmm_id']) {
		$curl_opts = array(
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 5
		);
		$post_fields = array(
			'order' => array(
				'service_id' => $service->row['epsmm_id'],
				'target' => $target_page,
				'quantity' => $quantity,
                'order_fields_attributes' => array(
                    0 => array(
                        'field_id' => '5',
                        'value' => $comments
                    )
                )
			)
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, $curl_opts);
		curl_setopt($ch, CURLOPT_URL, 'https://epsmm.com/api/v1/orders?token=' . $config['epsmm_token']);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
		$result = curl_exec($ch);
		
		$result = json_decode($result, true);
		if (isset($result['errors'])) {
			$output['error'] = '';
			
			foreach ($result['errors'] as $name => $errors) {
				$name = str_replace(['service_id', 'target', 'quantity'], ['Услуга ', 'Целевая страница ', 'Кол-во единиц '], $name);
				
				foreach ($errors as $error) {
					$output['error'] .= $name . $error . '<br>';
				}
			}
		} else {
			$db->query("UPDATE `user` SET `balance` = `balance` - " . (float)$total_price . " WHERE `id` = '" . (int)$_SESSION['user']['id'] . "'");
			$db->query("INSERT INTO `order` SET `user_id` = '" . (int)$_SESSION['user']['id'] . "', `service_network` = '" . $db->escape($service->row['network']) . "', `service_name` = '" . $db->escape($service->row['name']) . "', `target_page` = '" . $db->escape($target_page) . "', `quantity` = '" . $quantity . "', `price` = '" . (float)$total_price . "', `comments` = '" . $db->escape($comments) . "'");
			$db->query("INSERT INTO `transaction` SET `user_id` = '" . (int)$_SESSION['user']['id'] . "', `sum` = '-" . (float)$total_price . "', `comment` = '" . $db->escape($comment) . "'");
			
			$output['data'] = $result['order']['state'];
		}
		
	// Mail order
	} else {
		$mail = new PHPMailer();
		$mail->CharSet = 'utf-8';
		$mail->Encoding = 'base64';
		$mail->isHTML(true);
		
		$mail->addAddress($config['admin_email']);
		$mail->Subject = $comment;
		$mail->Body = '<b>E-mail заказчика:</b> ' . $_SESSION['user']['email'] . '<br>';
		$mail->Body = '<b>Соцсеть:</b> ' . $service->row['network'] . '<br>';
		$mail->Body = '<b>Название услуги:</b> ' . $service->row['name'] . '<br>';
		$mail->Body .= '<b>Стоимость услуги:</b> ' . (float)$service->row['price'] . ' руб. за ' . $service_quantity['per'] . ' ед.<br>';
		$mail->Body .= '<b>Целевая страница соцсети:</b> <a href="' . $target_page . '" target="_blank">' . $target_page . '</a><br>';
		$mail->Body .= '<b>Кол-во заказанных единиц:</b> ' . (int)$quantity . ' ед.<br>';
		$mail->Body .= '<b>Итоговая стоимость:</b> ' . (float)$total_price . ' руб.';
		
		if (!$mail->send()) {
			$output['error'] = 'Письмо с информацией о заказе не может быть нам доставлено.<br>Информация об ошибке: ' . $mail->ErrorInfo;
		} else {
			$db->query("UPDATE `user` SET `balance` = `balance` - " . (float)$total_price . " WHERE `id` = '" . (int)$_SESSION['user']['id'] . "'");
			$db->query("INSERT INTO `order` SET `user_id` = '" . (int)$_SESSION['user']['id'] . "', `service_network` = '" . $db->escape($service->row['network']) . "', `service_name` = '" . $db->escape($service->row['name']) . "', `target_page` = '" . $db->escape($target_page) . "', `quantity` = '" . $quantity . "', `price` = '" . (float)$total_price . "'");
			$db->query("INSERT INTO `transaction` SET `user_id` = '" . (int)$_SESSION['user']['id'] . "', `sum` = '-" . (float)$total_price . "', `comment` = '" . $db->escape($comment) . "'");
			
			$output['data'] = 'OK';
		}
		
		$mail->clearAllRecipients();
	}
	
	echo json_encode($output);
	exit;
	
} else {
	$service = $db->query("SELECT `id`, `epsmm_id`, `network`, `name`, `price`, `quantity`, `active` FROM `service` WHERE `id` = '" . $service_id . "'");

	if (!$service->num_rows) {
		$tpl->set('info', 'Услуга не найдена.');
	} elseif (!$service->row['active']) {
		$tpl->set('info', 'Услуга неактивна.');
	} else {
		$service->row['quantity'] = unserialize($service->row['quantity']);
		$service->row['price'] = number_format($service->row['price'], 2, '.', ' ');
        $service->row['network'] = mb_strtolower($service->row['network'], 'utf-8');
        
        $target_page_placeholder = $service_id == 22 ? 'ник / название аккаунта' : 'укажите полную ссылку на страницу';
		
		$tpl->set('service', $service->row);
		$tpl->set('target_page_placeholder', $target_page_placeholder);
	}
}
