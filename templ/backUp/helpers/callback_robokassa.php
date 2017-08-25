<?php

$robokassa['OutSum'] = !empty($_POST['OutSum']) ? $_POST['OutSum'] : 0;
$robokassa['InvId'] = !empty($_POST['InvId']) ? $_POST['InvId'] : 0;
$robokassa['Shp_user'] = !empty($_POST['Shp_user']) ? $_POST['Shp_user'] : 0;
$robokassa['SignatureValue'] = !empty($_POST['SignatureValue']) ? $_POST['SignatureValue'] : '';

$signature = md5($robokassa['OutSum'] . ':' . $robokassa['InvId'] . ':' . $config['robokassa_password2'] . ':Shp_user=' . $robokassa['Shp_user']);

if ($signature == strtolower($robokassa['SignatureValue'])) {
	$comment = 'Пополнение баланса (Robokassa)';
	
	$db->query("UPDATE `user` SET `balance` = `balance` + '" . (float)$robokassa['OutSum'] . "' WHERE `id` = '" . (int)$robokassa['Shp_user'] . "'");
	$db->query("INSERT INTO `transaction` SET `user_id` = '" . (int)$robokassa['Shp_user'] . "', `sum` = '" . (float)$robokassa['OutSum'] . "', `comment` = '" . $db->escape($comment) . "'");
	
	echo 'OK' . $robokassa['InvId'];
}
