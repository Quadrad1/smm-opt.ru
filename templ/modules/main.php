<?php

$metatags['title'] = 'Список услуг';

$tpl->set('content_header', $metatags['title']);

$result = $db->query("SELECT `id`, `network`, `name`, `price` FROM `service` WHERE `active` = '1' ORDER BY `network`, `name` ASC");

if (!$result->num_rows) {
	$tpl->set('info', 'Список услуг пока ещё пуст.');
	
} else {
	$service_list = array();
	
	foreach ($result->rows as $row) {
		$row['price'] = number_format($row['price'], 2, '.', ' ');
        $row['network'] = mb_strtolower($row['network'], 'utf-8');
        
		$service_list[$row['network']][] = $row;
	}
	
	$tpl->set('service_list', $service_list);
}
