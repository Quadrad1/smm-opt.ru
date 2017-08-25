<?php
/**
* Developed by MikeTheRaven
*/
define('ROOT_DIR', __DIR__);
define('TEMPLATE_DIR', ROOT_DIR . '/templates');

require(ROOT_DIR . '/helpers/config.php');
require(ROOT_DIR . '/helpers/function.php');

spl_autoload_register('autoload');
spl_autoload_extensions('.php');
set_exception_handler('exception_handler');

$metatags = array(
	'title' => 'Project name'
);

// Init libs
$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$tpl = new Template();

// Callback request handler
if (isset($_GET['callback']) && is_file(ROOT_DIR . '/helpers/callback_' . $_GET['callback'] . '.php')) {
	include(ROOT_DIR . '/helpers/callback_' . $_GET['callback'] . '.php');
	exit;
}

// Check auth
include(ROOT_DIR . '/helpers/login.php');

// Include needed module
$module = !empty($_GET['mod']) ? $_GET['mod'] : 'main';

if (is_file(ROOT_DIR . '/modules/' . $module . '.php')) {
	$tpl_name = $module;
	include(ROOT_DIR . '/modules/' . $module . '.php');
} else {
	$tpl_name = '404';
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
}

// Set common template values
$tpl->set('SITE_URL', SITE_URL);
$tpl->set('TEMPLATE_URL', TEMPLATE_URL);
$tpl->set('meta_title', $metatags['title']);

// Render template and show output
echo $tpl->render($tpl_name);
