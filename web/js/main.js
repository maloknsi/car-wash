jQuery(document).ready(function () {

	$(document).ajaxError(function( event, jqxhr, settings, exception ) {
		gritterAdd('Error', exception, 'gritter-danger');
	});

	jQuery(document).ready(function(){

		// моб меню
		jQuery('.popup_triger').click(function(e){
			if (jQuery('body').hasClass('popup_open')) {
				jQuery('body').removeClass('popup_open');
			}
			else {
				jQuery('body').addClass('popup_open');
			}
			e.preventDefault();
		});

		jQuery('body').mouseup( function(e){
			var div = jQuery(".column_aside");
			if ( !div.is(e.target)
				&& div.has(e.target).length === 0 ) {
				jQuery('body').removeClass('popup_open');
			}
		});

	});

	$(document).on("click", ".btn-show-modal-form", function () {
		var buttonCalled = $(this),
			modalForm = buttonCalled.attr('data-modal-form') ? buttonCalled.attr('data-modal-form') : '#modal-form-ajax',
			actionUrl = buttonCalled.attr('data-action-url');

		if ($(buttonCalled).hasClass('disabled')) return false;
		$(buttonCalled).addClass('disabled');

		$(modalForm).find('.modal-header').html(buttonCalled.attr('title'));
		$(modalForm).find('.modal-body').html('Загрузка...');

		$('body').addClass('popup_open')
		if ($(modalForm).hasClass('modal')) $(modalForm).modal('show')

		$(modalForm).find('.modal-body')
			.load(actionUrl, function(response, status, xhr) {
				$(buttonCalled).removeClass('disabled');
				$(modalForm).find('.modal-active-form').attr('data-modal-form',modalForm);
				if (status == 'error') {
					$(modalForm).find('.modal-body').html('Ошибка:' + xhr.status + " " + xhr.statusText);
				}
			});
	});

	$(document).on("beforeSubmit", ".modal-active-form", function () {
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
					$(modalForm).removeClass('disabled');
					form.find('.error-summary').html(response.error).show();
				}else{
					$(modalForm).removeClass('disabled');
					$(modalForm).find('.modal-body').html('');
					if ($(".grid-view").length){
						$(".grid-view").yiiGridView("applyFilter");
					}
					gritterAdd('Выполнено!', response.data, 'gritter-success');
					setTimeout(function() {
						$('body').removeClass('popup_open')
						if ($(modalForm).hasClass('modal')) $(modalForm).modal('hide')
					}, 500);
				}
			}
		});
		return false;
	});

	$(document).on("click", ".btn-show-confirm-form", function () {
		var buttonCalled = $(this);
		if ($(buttonCalled).hasClass('disabled')) return false;
		$(buttonCalled).addClass('disabled');

		bootbox.dialog({
			message: buttonCalled.attr('title')+'?',
			title: "Подтвердите",
			buttons: {
				success: {
					label: "Да",
					className: "btn-danger",
					callback: function() {
						jQuery.ajax({
							url: buttonCalled.attr('data-action-url'),
							type: "POST",
							dataType: "json",
							data: false,
							cache: false,
							contentType: false,
							processData: false,
							success: function(response) {
								if (response.error){
									gritterAdd('Ошибка!', response.error, 'gritter-success');
								}else{
									gritterAdd('Выполнено!', response.data, 'gritter-success');
									if ($(".grid-view").length){
										$(".grid-view").yiiGridView("applyFilter");
									}
								}
								$(buttonCalled).removeClass('disabled');
							}
						});
					}
				},
				danger: {
					label: "Нет",
					className: "btn-success",
					callback: function() {
						$(buttonCalled).removeClass('disabled');
					}
				}
			}
		});
	});

	$(document).on("click", ".btn-execute-ajax", function () {
		var buttonCalled = $(this);
		sendPostAjax(buttonCalled.attr('data-action-url'), {}, function () {
			if (this.error) {
				showErrorAlert(this.error);
			} else if (this.data) {
				showSuccessAlert(this.data);
				if ($(".grid-view").length){
					$(".grid-view").yiiGridView("applyFilter");
				}
			}
		});
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
					if (response.data == 'admin'){
						window.location = '/order'
					}
					$(modalForm).removeClass('disabled');
					$(modalForm).find('.modal-body').html('');
					if ($(".grid-view").length){
						$(".grid-view").yiiGridView("applyFilter");
					}
					gritterAdd('Выполнено!', '', 'gritter-success');
					$('div.header-top #block_user_guest').hide();
					$('div.header-top #block_user_authorized').show().find('span').html(response.data);
					setTimeout(function() {
						$('body').removeClass('popup_open')
					}, 500);
				}
			}
		});
		return false;
	});


	$(".scroll").on("click","a", function (event) {
		//отменяем стандартную обработку нажатия по ссылке
		event.preventDefault();

		//забираем идентификатор бока с атрибута href
		var id  = $(this).attr('href'),

			//узнаем высоту от начала страницы до блока на который ссылается якорь
			top = $(id).offset().top;

		//анимируем переход на расстояние - top за 1500 мс
		$('body,html').animate({scrollTop: top}, 500);
	});

	$(document).on("beforeSubmit", "#reservation-form", function () {
		setTimeout(function() {
			$.pjax.reload({container:'#site-boxes-timetable-pjax', url: "/site/index/", 'push':false, 'replace': false});
		}, 500);
	});
	$('.js-select-date').on('click',function(){
		$('#site-boxes_timetable_date').val($(this).data('value'))
		$('#site-boxes_timetable_date').change()
	})
	$('#site-boxes_timetable_date').on('change', function () {
		$.pjax.reload({container:'#site-boxes-timetable-pjax', url: "/site/index/", 'push':false, 'replace': false});
	});

	$('#site-boxes-timetable-pjax').on('pjax:beforeSend', function (e, jqXHR, settings) {
		settings.url = settings.url + '&date_start='+$('#site-boxes_timetable_date').val();
	});

	$(document).on('click', '.reload-siteBoxesTimetable button.close, .reload-siteBoxesTimetable  button.btn-close', function () {
		$.pjax.reload({container:'#site-boxes-timetable-pjax', url: "/site/index/", 'push':false, 'replace': false});
	});
});