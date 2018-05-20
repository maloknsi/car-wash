jQuery(document).ready(function () {

	$(document).ajaxError(function( event, jqxhr, settings, exception ) {
		gritterAdd('Error', exception, 'gritter-danger');
	});

	$(document).on("click", ".btn-show-modal-form", function () {
		var buttonCalled = $(this),
			modalForm = buttonCalled.attr('data-modal-form') ? buttonCalled.attr('data-modal-form') : '#modal-form-ajax',
			actionUrl = buttonCalled.attr('data-action-url');
		$(modalForm).find('.modal-header h4').html(buttonCalled.attr('title'));
		$(modalForm).find('.modal-content .modal-body').html('Загрузка...');
		$(modalForm).modal('show')
			.find('.modal-content .modal-body')
			.load(actionUrl, function(response, status, xhr) {
				$(modalForm).find('.modal-active-form').attr('data-modal-form',modalForm);
				if (status == 'error') {
					$(modalForm).find('.modal-content .modal-body').html('Ошибка:' + xhr.status + " " + xhr.statusText);
				}
			});
	});

	$(document).on("beforeSubmit", ".modal-active-form", function () {
		var form = $(this),
			modalForm = form.attr('data-modal-form');
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
				}else{
					$(modalForm).find('.modal-content .modal-body').html('');
					if ($(".grid-view").length){
						$(".grid-view").yiiGridView("applyFilter");
					}
					gritterAdd('Выполнено!', response.data, 'gritter-success');
					setTimeout(function() {
						$(modalForm).modal('hide');
					}, 500);
				}
			}
		});
		return false;
	});
	$(document).on("click", ".btn-show-confirm-form", function () {
		var buttonCalled = $(this);
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
							}
						});
					}
				},
				danger: {
					label: "Нет",
					className: "btn-success",
					callback: function() {
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
