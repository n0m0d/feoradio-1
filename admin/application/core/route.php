<?php
/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{
	
	function __construct(){

	}

	
	public function start(){
		// Контроллер и действие по умолчанию
		$controller = 'index';
		$action = 'index';
		
		$REQUEST_URI = $_SERVER['REQUEST_URI'];
		$REQUEST_URI = (mb_substr_count( $_SERVER['REQUEST_URI'], '?') > 0) ? substr($REQUEST_URI, 0, strpos($REQUEST_URI,'?')) : $REQUEST_URI;
		$REQUEST_URI = apply_filters('the_uri',$REQUEST_URI);
		if( mb_substr_count( $_SERVER['REQUEST_URI'], '?') == 1 )
		{
			$get = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'],'?')+1); 
			$ampCount = mb_substr_count( $get, '&');
			if($ampCount>0) { $get = explode('&', $get); } else { $get = array($get);}
			
			foreach($get as $str) {
				  list($key, $value) = explode('=', $str);
				  $key=htmlspecialchars(strip_tags($key));
				  $value=htmlspecialchars(strip_tags($value));
				  $_GET[$key] = urldecode($value);
			   }
		}
		
		
		$routes = explode('/', $REQUEST_URI);
		foreach ($routes as $i => $route){
			if($route == '' or $route == 'admin') unset ($routes[$i]);
		}
		sort($routes);
		// Получаем имя контроллера
		if ( !empty($routes[0]) ){	
			$controller = $routes[0];
		}
		// Получаем имя экшена
		if ( !empty($routes[1]) ){
			$action = $routes[1];
		}
		if ( !empty($routes[2]) ){
			header("Location:{$routes[0]}/{$controller}/{$action}");
		}
		
		// Добавляем префиксы
		$controller_name = 'controller_'.$controller;
		$action_name = 'action_'.$action;
		
		// Подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = ADMINDIR."/application/controllers/".$controller_file; 
		// Если файл контроллера существует, значит его подключаем и определяем. что страница является статической
		
		if(file_exists($controller_path)){
			require_once ADMINDIR.'/application/controllers/'.$controller_file;
			$controller_name = str_replace('-', '_', $controller_name);
			if (class_exists($controller_name)){
				// создаем контроллер
				$controller = new $controller_name();
				$action = $action_name; 
				if(method_exists($controller_name, $action_name)){
					// вызываем действие контроллера
					$controller->$action();
				}
				else{
					Route::ErrorPage404();
				}
			}	else Route::ErrorPage404();
		}
		// Если файл контроллера отсутствует подключаем файл контроллера динамических страниц, который отвечает за поиск диначеской страници в БД
		else{
			Route::ErrorPage404();
		}
	}
	
	public static function ErrorPage404()
	{
		header('HTTP/1.1 404 Not Found');
		header('Status: 404 Not Found');
		include APPDIR.'/application/controllers/controller_404.php';
		$controller = new controller_404();
		$controller->action_index();
    }
	
	public function session_run(){
		if ($_COOKIE['session_id']) session_id($_COOKIE['session_id']);
		session_start();
		setcookie('session_id', session_id(), 0, '/');
			$session_time_left = $_SESSION['session_time'] - $_SESSION['session_start_time'];
		if($_SESSION['session_time'] == time()) {
			$_SESSION['session_conn_count'] = $_SESSION['session_conn_count'] + 1; 
		} else { $_SESSION['session_conn_count'] = 0; }
		if(!$_SESSION['session_start_time']) 	$_SESSION['session_start_time'] = time(); 	//Время начала сессии
												$_SESSION['session_time'] = time();			//Текуущее время сессии
	}
	
	
}
