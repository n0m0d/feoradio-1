<?php
/*
Plugin Name: test
Plugin URI: test
Description: Плагин для примера
Version: 1.0
Author: Заднепряный Андрей
Author URI: 

*/

if(!class_exists('Test', false)){
	class Test{
		
		function __construct(){
			register_controller('onas.html', array($this, 'onas'), 'О нас');
		}
		
		function onas( $controller, $routes ){
			$view = new View();
			$view->renderHeader();
			$view->renderBody();
			echo 'О нас';
			$view->renderFooter();
			//include APPDIR.'/template/onas.html';
		}

		
	}
	global $Test;
	$Test = new Test();
	
}