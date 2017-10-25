$(function() {

	$('.dropdown-button').on("click", function() {
		$(this).toggleClass('changed');
		var id = $(this).attr("id");
		$(".dropdown-list-" + id).slideToggle('fast');
	});

	$('.indropdown-button').on("click", function() {
		$(this).toggleClass('changed');
		var id = $(this).attr("id");
		$(".indropdown-list-" + id).slideToggle('fast');
	});

	$('.filter-select').selectize({
		create: true,
		fortField: 'text'
	});

	$('#maincheck').on("click", function() {
		if($('#maincheck').prop('checked')) {
			$('.mc').prop('checked', true);
		} else {
			$('.mc').prop('checked', false);
		}
	});

	var main = function() {

		$('.arrows-hamburger-wrap').on("click", function() {

			$('.arrows-hamburger-wrap').css("opacity", "0");

			$('.mobile-menu').css("visibility", "visible");
	
			$('.mobile-menu').animate({
				left: '0px'
			}, 200);

			$('.main-header').animate({
				left: '285px'
			}, 200);
			
			$('body').animate({
				left: '285px'
			}, 200);
		});
	
		$('.arrows-remove-wrap').on("click", function() {

			$('.arrows-hamburger-wrap').css("opacity", "1");

			$('.mobile-menu').css("visibility", "hidden");
	
			$('.mobile-menu').animate({
				left: '-285px'
			}, 200);

			$('.main-header').animate({
				left: '0px'
			}, 200);
			
			$('body').animate({
				left: '0px'
			}, 200);
		});
	};
	
	$(document).ready(main);
});
