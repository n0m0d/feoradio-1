<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$this->headers['title']?></title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta property="og:image" content="/admin/application/views/path/to/image.jpg">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css">
	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" rel="stylesheet">
	
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

	
	<script src="/admin/application/views/js/chosen.jquery.js"></script>
	<link rel="stylesheet" type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.css" />
	
	<link rel="shortcut icon" href="/admin/application/views/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="/admin/application/views/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/admin/application/views/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/admin/application/views/img/favicon/apple-touch-icon-114x114.png">

	<link rel="stylesheet" href="/admin/application/views/libs/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/admin/application/views/css/nprogress.css">
	<script src="/admin/application/views/js/nprogress.js"></script>
	<link rel="stylesheet" href="/admin/application/views/css/footable.bootstrap.css">
	<script src="/admin/application/views/js/footable.js"></script>
	<link rel="stylesheet" href="/admin/application/views/css/main.min.css">

	<meta name="theme-color" content="#000">
	<meta name="msapplication-navbutton-color" content="#000">
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">
</head>

<body>

	<div class="mobile-menu">
		<nav class="main-menu">
			<div class="arrows-remove-wrap">
				<div class="arrows-remove"></div>
			</div>
			<ul>
				<li><a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>" target="_blank">Сайт</a></li>
				<li><a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/">Администрирование</a></li>
				<li><a href="#">Настройки</a></li>
				<li><a href="#">Помощь</a></li>
			</ul>

			<form class="search">
				<input class="search-input" type="text" placeholder="Поиск...">
			</form>
		</nav>
	</div>

	<header class="main-header">
		<div class="head-block-1">
			<div class="logo">
				<img src="/application/views/feoradio/img/logo.png" height="30px" alt="полезное радио">
				<!--
				<div class="logo-left">город</div>
				<div class="logo-right">
					<div class="logo-right-text">
						24
					</div>
				</div>
				-->
			</div>
			<div class="descr">
				<div class="descr-text">
					информационная<br>сеть
				</div> 
			</div>
		</div>
		<div class="head-block-2">
			<nav class="menu">
				<ul class="menu-ul">
					<li class="menu-ul-li"><a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>" target="_blank" class="menu-ul-li-a">Сайт</a></li>
					<li class="menu-ul-li menu-ul-active"><a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/" class="menu-ul-li-a">Администрирование</a></li>
					<li class="menu-ul-li"><a href="#" class="menu-ul-li-light"><span class="menu-ul-li-light-img"><i class="fa fa-cog" aria-hidden="true"></i></span>Настройки</a></li>
					<li class="menu-ul-li"><a href="#" class="menu-ul-li-light"><span class="menu-ul-li-light-img"><i class="fa fa-question-circle" aria-hidden="true"></i></span>Помощь</a></li>
				</ul>
			</nav>
			<form class="search">
				<input class="search-input" type="text" placeholder="Поиск...">
			</form>
		</div>
		<div class="head-block-3">
			<div class="auth">
				<ul class="auth-ul">
					<li class="auth-ul-li"><a href="#" class="auth-ul-li-a"><span class="auth-ul-li-light-img"><i class="fa fa-user-o" aria-hidden="true"></i></span><?=$_SESSION['user_name']?></a></li>
					<li class="auth-ul-li"><a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/exit/" class="auth-ul-li-light">Выйти</a></li>
				</ul>
			</div>
		</div>
		<div class="arrows-hamburger-wrap">
			<div class="arrows-hamburger"></div>
		</div>
	</header>

	<section class="main-section">
		<div class="sections">
			<div class="sectleft">
				<a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/buhg/" class="sectleft-item ajax-load <?=($this->data['main-menu']['Бухгалтерия']?'active':'')?>">
					<span class="sectleft-item-icon"><i class="fa fa-calculator" aria-hidden="true"></i></span>
					<p class="sectleft-item-text">Бухгалтерия</p>
				</a>
				<a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/tasks/" class="sectleft-item ajax-load <?=($this->data['main-menu']['Задачи']?'active':'')?>">
					<span class="sectleft-item-icon"><i class="fa fa-list" aria-hidden="true"></i></span>
					<p class="sectleft-item-text">Задачи</p>
				</a>
				<a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/control/" class="sectleft-item ajax-load <?=($this->data['main-menu']['Управление']?'active':'')?>">
					<span class="sectleft-item-icon"><i class="fa fa-sliders" aria-hidden="true"></i></span>
					<p class="sectleft-item-text">Управление</p>
				</a>
				<a href="<?=$GLOBALS['CONFIG']['HTTP_HOST']?>/admin/settings/" class="sectleft-item ajax-load <?=($this->data['main-menu']['Настройки']?'active':'')?>">
					<span class="sectleft-item-icon"><i class="fa fa-cog" aria-hidden="true"></i></span>
					<p class="sectleft-item-text">Настройки</p>
				</a>
			</div>
