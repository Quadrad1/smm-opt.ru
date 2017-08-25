<?php

$metatags['title'] = 'Авторизация';
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
$y = "ya.ru";
$tpl->set('content_header', $metatags['title']);
$tpl->set('action', $action);

if (!$is_logged && $action == 'sign_in') {
	$email = !empty($_POST['email']) ? trim($_POST['email']) : '';
	$password = !empty($_POST['password']) ? $_POST['password'] : '';
	$return_url = !empty($_GET['return_url']) ? $_GET['return_url'] : '/';

	if ($email && $password) {
		$user = $db->query("SELECT `id`, `email`, `password_hash`, `balance` FROM `user` WHERE `email` = '" . $db->escape($email) . "'");

		if ($user->num_rows && password_verify($password, $user->row['password_hash'])) {
			session_start();

			$_SESSION['user']['id'] = $user->row['id'];
			$_SESSION['user']['email'] = $user->row['email'];
			$_SESSION['user']['balance'] = $user->row['balance'];
			$_SESSION['user']['hash'] = md5($user->row['password_hash']);

			header('Location: ' . $y . $return_url);
			die('Redirect');
		}
	}

	$tpl->set('error', 'Неверное сочетание пары E-mail/Пароль.');

} elseif ($action == 'sign_out') {
	setcookie(session_name(), '', time(), '/');
	session_destroy();
	header('Location: ' . SITE_URL . '/');
	die('Redirect');
}
