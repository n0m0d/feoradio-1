<?php

class controller_control extends Controller
{
	function __construct(){
		$this->view = new View('control.tpl');
		$this->view->setTemplatesFolder(ADMINDIR.'/application/views/');
		$this->view->headers['title'] = 'Управление | Администрирование Полезного радио';
		$this->view->data['main-menu']['Управление'] = true;
	}
	
	function action_index($array = array()){
		$this->view->data['breadcrumbs'] = [ "Управление"=>$GLOBALS['CONFIG']['HTTP_HOST'].'/admin/control/'];
		$this->view->data['header'] = "Управление";
		/*
		$this->view->template = 'admin_view.php';
		$this->view->generate(ADMINDIR.'/application/views/index_view.php', ADMINDIR.'/application/views/'.$this->view->template, array('rubrics' => $rubrics));
		*/
	}
	
	function action_users(){
		$this->view->headers['title'] = 'Пользователи | Администрирование Полезного радио';
		$this->view->data['breadcrumbs'] = [ "Управление"=>$GLOBALS['CONFIG']['HTTP_HOST'].'/admin/control/', "Пользователи"=>""];
		$this->view->data['header'] = "Пользователи";
	}
	
	
}