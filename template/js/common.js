$(function() {

	$('.main-radio').audioPlayer(
	{
		classPrefix: 'main-player',
		strPlay: 'Пуск',
		strPause: 'Пауза',
		strVolume: 'Звук',
	});

	$('.mini-radio').audioPlayer(
	{
		classPrefix: 'mini-player',
		strPlay: 'Пуск',
		strPause: 'Пауза',
		strVolume: 'Звук',
	});

	$('.city-filter').selectize({
		create: true,
		fortField: 'text'
	});

	$('.cat-filter').selectize({
		create: true,
		fortField: 'text',
		placeholder: 'Рубрика'
	});

	$(".toggle-menu").on("click", function() {
		$(this).toggleClass("on");
		$(".toggle-mobile-menu").slideToggle();
		return false;
	});

	$(".main-menu ul li").on("click", function() {
		$(".main-menu ul li").removeClass("active");
		$(this).addClass("active");
	});

	$(".main-player-volume-button").on("click", function() {
		$(this).toggleClass("off");
		$(".main-player-big-volume-button span").toggleClass("off");
	});

	$(".main-player-big-volume-button").on("click", function() {
		$(".main-player-big-volume-button span").toggleClass("off");
		$(".main-player-volume-button").toggleClass("off");
	});

	$(".mini-player-volume-button").on("click", function() {
		$(this).toggleClass("off");
	});

});
