<?php

$is_logged = false;

if (isset($_COOKIE[session_name()])) {
	session_start();
	
	if (!empty($_SESSION['user']['id']) && !empty($_SESSION['user']['hash'])) {
		$user = $db->query("SELECT `password_hash`, `balance` FROM `user` WHERE `id` = '" . (int)$_SESSION['user']['id'] . "'");
		
		if ($user->num_rows && md5($user->row['password_hash']) == $_SESSION['user']['hash']) {
			$is_logged = true;
			
			$_SESSION['user']['balance'] = $user->row['balance'];
			$tpl->set('user', $_SESSION['user']);
		} else {
			setcookie(session_name(), '', time(), '/');
			unset($_SESSION);
			session_destroy();
		}
	}
}

$tpl->set('is_logged', $is_logged);
