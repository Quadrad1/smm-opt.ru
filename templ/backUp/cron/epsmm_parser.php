<?php

define('ROOT_DIR', dirname(__DIR__));

$curl_opts = array(
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 5
);
$insert_values = array();

require(ROOT_DIR . '/helpers/config.php');

##############################################

$ch = curl_init();
curl_setopt_array($ch, $curl_opts);

// Get social networks list
curl_setopt($ch, CURLOPT_URL, 'https://epsmm.com/api/v1/social_networks?token=' . $config['epsmm_token']);
$result = curl_exec($ch);

$networks = json_decode($result, true);

// Get service list by each network
foreach ($networks as $network) {
	curl_setopt($ch, CURLOPT_URL, 'https://epsmm.com/api/v1/social_networks/' . $network['id'] . '/services?token=' . $config['epsmm_token']);
	$result = curl_exec($ch);
	
	$services = json_decode($result, true);
	foreach ($services as $service) {
		$quantity = array(
			'min' => $service['min'],
			'max' => $service['max'],
			'per' => $service['price']['per']
		);
		
		$insert_values[] = array(
			(int)$service['id'],
			$network['name'],
            $service['name'],
			(float)$service['price']['amount'],
			serialize($quantity),
			(int)$service['active']
		);
	}
}

curl_close($ch);

##############################################

if (count($insert_values)) {
	require(ROOT_DIR . '/helpers/config.php');
	require(ROOT_DIR . '/libs/Database.php');

	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
	
	foreach ($insert_values as $key => $value) {
		foreach ($value as $key2 => $value2) {
			$value[$key2] = $db->escape($value2);
		}
		
		$insert_values[$key] = "('" . implode("', '", $value) . "')";
	}
	
	$db->query("INSERT INTO `service` (`epsmm_id`, `network`, `name`, `price`, `quantity`, `active`) VALUES " . implode(', ', $insert_values) .
	           "ON DUPLICATE KEY UPDATE `network` = VALUES(`network`), `name` = VALUES(`name`), `price` = VALUES(`price`), `quantity` = VALUES(`quantity`), `active` = VALUES(`active`)");
}

echo 'Complete';
