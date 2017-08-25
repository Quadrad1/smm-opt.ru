<?php

final class Template
{
	private $twig;
	private $data = array();
	
	public function __construct()
	{
		// include and register Twig auto-loader
		#include_once(ROOT_DIR . '/libs/Twig/Autoloader.php');
		
		#Twig_Autoloader::register();
		
		// specify where to look for templates
		$loader = new Twig_Loader_Filesystem(TEMPLATE_DIR);
		
		// initialize Twig environment
		$this->twig = new Twig_Environment($loader, array(
			'autoescape' => false
		));
	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($template) {
		try {
			$template = $this->twig->loadTemplate($template . '.tpl');
			
			return $template->render($this->data);
			
		} catch (Exception $e) {
			throw new Exception('Error: Could not load template ' . str_replace(ROOT_DIR, '', TEMPLATE_DIR) . '/' . $template . '.tpl');
		}	
	}	
}
