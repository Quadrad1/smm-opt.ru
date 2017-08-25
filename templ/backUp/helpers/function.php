<?php

function autoload($lib)
{
	$file = ROOT_DIR . '/libs/' . str_replace('_', '/', $lib) . '.php';
	
	if (is_file($file)) {
		include_once($file);
		return true;
	} else {
		return false;
	}
}

function exception_handler($exception)
{
	echo $exception->getMessage();
	exit;
}

function token($length = 32)
{
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	
	return $token;
}
