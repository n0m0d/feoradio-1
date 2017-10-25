<?php
class controller_index extends Controller
{
	function __construct(){
		$this->view = new View('index.tpl');
		$this->view->headers['title'] = 'Главная | Полезное радио';
		$this->view->data['menu']['index'] = 'active';
	}
	
	function action_index($array = array()){
		$this->view->data['file'] = __FILE__;
	}
}