jQuery(function($) {'use strict',

	//Countdown js
	$("#countdown").countdown({
			date: "10 july 2014 12:00:00",
			format: "on"
		},

		function() {
			// callback function
		});



	//Scroll Menu

	function menuToggle()
	{
		var windowWidth = $(window).width();

		if(windowWidth > 767 ){
			$(window).on('scroll', function(){
				if( $(window).scrollTop()>405 ){
					$('.main-nav').addClass('fixed-menu animated slideInDown');
				} else {
					$('.main-nav').removeClass('fixed-menu animated slideInDown');
				}
			});
		}else{

			$('.main-nav').addClass('fixed-menu animated slideInDown');

		}
	}

	menuToggle();


	// Carousel Auto Slide Off
	$('#event-carousel, #twitter-feed, #sponsor-carousel ').carousel({
		interval: false
	});


	// Contact form validation
	var form = $('.contact-form');
	form.submit(function () {'use strict',
		$this = $(this);
		$.post($(this).attr('action'), function(data) {
			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
		},'json');
		return false;
	});

	$( window ).resize(function() {
		menuToggle();
	});

	$('.main-nav ul').onePageNav({
		currentClass: 'active',
		changeHash: false,
		scrollSpeed: 900,
		scrollOffset: 0,
		scrollThreshold: 0.3,
		filter: ':not(.no-scroll)'
	});
});


jQuery(document).ready(function () {
	$(document).on("beforeSubmit", ".modal-active-form-site#login-form", function () {
		var form = $(this),
			modalForm = form.attr('data-modal-form');
		if ($(modalForm).hasClass('disabled')) return false;
		$(modalForm).addClass('disabled');
		jQuery.ajax({
			url: form.attr('action'),
			type: "POST",
			dataType: "json",
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.error){
					form.find('.error-summary').html(response.error).show();
					$(modalForm).removeClass('disabled');
				} else if(response.notify){
					form.find('.error-summary').html(response.notify).show();
					form.find('#panel_input_phone').hide();
					form.find('#panel_input_sms_code').show();
					$(modalForm).removeClass('disabled');
				} else {
					$(modalForm).removeClass('disabled');
					$(modalForm).find('.modal-content .modal-body').html('');
					if ($(".grid-view").length){
						$(".grid-view").yiiGridView("applyFilter");
					}
					gritterAdd('Выполнено!', '', 'gritter-success');
					$('div.header-top #block_user_guest').hide();
					$('div.header-top #block_user_authorized').show().find('span').html(response.data);
					setTimeout(function() {
						$('#modal-form-ajax').modal('hide');
					}, 500);
				}
			}
		});
		return false;
	});
});
