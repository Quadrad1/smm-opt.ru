<?php

$metatags['title'] = 'Восстановление пароля';
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';

$tpl->set('content_header', $metatags['title']);
$tpl->set('action', $action);

if ($is_logged) {
	$tpl->set('info', 'Вы уже авторизованы на сайте.');

// Send mail with link
} elseif ($action == 'send_mail') {
	$email = !empty($_POST['email']) ? trim($_POST['email']) : '';

	$result = $db->query("SELECT `id` FROM `user` WHERE `email` = '" . $db->escape($email) . "'");

	if (!$result->num_rows) {
		$tpl->set('error', 'Указанный электронный адрес не зарегистрирован в нашей системе.');
		$tpl->set('email', $email);
	} else {
		do {
			$token = token(32);

			$user = $db->query("SELECT `id` FROM `user` WHERE `token` = '" . $db->escape($token) . "'");
			if ($user->num_rows) {
				$token = null;
			}
		} while (!$token);

		$db->query("UPDATE `user` SET `token` = '" . $db->escape($token) . "' WHERE `id` = '" . (int)$result->row['id'] . "'");
		$link = SITE_URL . '/index.php?mod=password&amp;action=recovery&amp;email=' . urlencode($email) . '&amp;token=' . urlencode($token);

		$mail = new PHPMailer();
		$mail->CharSet = 'utf-8';
		$mail->Encoding = 'base64';
		$mail->isHTML(true);

		$mail->addAddress($email);
		$mail->Subject = 'Восстановление пароля';
		$mail->Body = 'Для изменения пароля Вам необходимо перейти по нижеследующей ссылке<br><a href="' . $link . '">' . $link . '</a>';

		if (!$mail->send()) {
			$tpl->set('error', 'Письмо не может быть отправлено на ваш почтовый адрес.<br>Информация об ошибке: ' . $mail->ErrorInfo);
		}

		$mail->clearAllRecipients();

		$tpl->set('info', 'Письмо с инструкцией по изменению пароля было выслано Вам на почту.');
	}

// Show recovery form
} elseif ($action == 'recovery') {
	$email = !empty($_GET['email']) ? trim($_GET['email']) : '';
	$token = !empty($_GET['token']) ? trim($_GET['token']) : '';

	$user = $db->query("SELECT `id` FROM `user` WHERE `email` = '" . $db->escape($email) . "' AND `token` = '" . $db->escape($token) . "'");

	if (!$user->num_rows) {
		$tpl->set('info', 'Неправильная ссылка.');
	} else {
		$tpl->set('email', $email);
		$tpl->set('token', $token);
	}

// Set new password
} elseif ($action == 'set_new_password') {
	$email = !empty($_POST['email']) ? trim($_POST['email']) : '';
	$token = !empty($_POST['token']) ? trim($_POST['token']) : '';
	$password = !empty($_POST['password']) ? $_POST['password'] : '';
	$password_confirm = !empty($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

	if (empty($password)) {
		$tpl->set('error', 'Указан пустой пароль.');
	} elseif ($password != $password_confirm) {
		$tpl->set('error', 'Пароли не совпадают.');
	} else {
		$user = $db->query("SELECT `id` FROM `user` WHERE `email` = '" . $db->escape($email) . "' AND `token` = '" . $db->escape($token) . "'");

		if (!$user->num_rows) {
			$tpl->set('error', 'Пользователь не найден.');
		} else {
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			if (!$password_hash) {
				die('PHP extension Crypt must be loaded for password_hash function');
			}

			$db->query("UPDATE `user` SET `password_hash` = '" . $db->escape($password_hash) . "', `token` = NULL WHERE `id` = '" . (int)$user->row['id'] . "'");

			$tpl->set('info', 'Пароль был успешно изменён. Теперь Вы можете войти на сайт, используя новый пароль.');
		}
	}
}
