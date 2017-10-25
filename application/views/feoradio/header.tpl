<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">

	<title><?=$this->headers['title']?></title>
	<meta name="description" content="">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<meta property="og:image" content="/application/views/feoradio/path/to/image.jpg">
	<link rel="shortcut icon" href="/application/views/feoradio/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="/application/views/feoradio/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/application/views/feoradio/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/application/views/feoradio/img/favicon/apple-touch-icon-114x114.png">

	<link rel="stylesheet" href="/application/views/feoradio/libs/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" href="/application/views/feoradio/libs/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/application/views/feoradio/css/main.min.css">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#000">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#000">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#000">
	<?php wp_print_styles();?>
	<?php wp_print_scripts();?>
</head>

<body>
	<header class="main-header">
		<div class="container">
			<div class="row">
				<nav class="main-menu hidden-xs">
					<ul>
						<li class="<?=$this->data['menu']['index']?>"><a href="/"><span class="icon-home"></span></a></li>
						<li><a href="onas.html">О нас</a></li>
						<li><a href="vedushie.html">Ведущие</a></li>
						<li><a href="novosti.html">Новости</a></li>
						<li><a href="arhiv.html">Архив</a></li>
						<li><a href="vizitki.html">Визитки программ</a></li>
						<li><a href="setka.html">Сетка вещания</a></li>
						<li class="hidden-sm hidden-xs"><a href="prais.html">Прайс</a></li>
						<li class="hidden-sm hidden-xs"><a href="galereya.html">Галерея</a></li>
						<li class="hidden-sm hidden-xs"><a href="contacti.html">Контакты</a></li>
						<li class="hidden-lg hidden-md has-drop">
							<a href="#">Ещё<span class="icon-arrow-down"></span></a>
							<ul>
								<li class="hidden-lg hidden-md"><a href="prais.html">Прайс</a></li>
								<li class="hidden-lg hidden-md"><a href="galereya.html">Галерея</a></li>
								<li class="hidden-lg hidden-md"><a href="contacti.html">Контакты</a></li>
							</ul>
						</li>
					</ul>
				</nav>
				<div class="top-sect">
					<div class="row">
						<div class="col-sm-3 col-xs-6">
							<div class="logo-wrap">
								<a href="/">
									<img src="/application/views/feoradio/img/logo.png" alt="полезное радио">
								</a>
							</div>
						</div>
						<div class="col-sm-3 col-xs-6">
							<div class="city-select">
								<span>Выберите город</span>
								<select class="city-filter">
									<option value="Феодосия">Феодосия</option>
									<option value="Ялта">Ялта</option>
									<option value="Керчь">Керчь</option>
									<option value="Симферополь">Симферополь</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3 hidden-xs">
							<div class="social-wrap">
								<div class="social-descr hidden-sm hidden-xs">
									<span>Мы в<br>соц.сетях</span>
								</div>
								<div class="social-items">
									<a href="#" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#" class="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>
									<a href="#" class="od"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
						<div class="col-sm-3 hidden-xs">
							<div class="phone">
								<span>
									8 800 575 65 65
								</span>
							</div>
							<div class="phone-descr">
								<span>
									Телефон в студии
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="main-mobile-menu hidden-lg hidden-md hidden-sm">
					<div class="phone">
						<span>
							8 800 575 65 65
						</span>
					</div>
					<a href="#" class="toggle-menu hidden-lg hidden-md hidden-sm"><span></span></a>
					<ul class="toggle-mobile-menu">
						<li><a href="/">Главная</a></li>
						<li><a href="onas.html">О нас</a></li>
						<li><a href="vedushie.html">Ведущие</a></li>
						<li><a href="novosti.html">Новости</a></li>
						<li><a href="arhiv.html">Архив</a></li>
						<li><a href="vizitki.html">Визитки программ</a></li>
						<li><a href="setka.html">Сетка вещания</a></li>
						<li><a href="prais.html">Прайс</a></li>
						<li><a href="galereya.html">Галерея</a></li>
						<li><a href="contacti.html">Контакты</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<main class="main-content">
