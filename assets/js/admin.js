(function($) {
	"use strict";

	$(document).ready(function() {

		$(':input.ace-editor').each(function() {
			var input = $(this);
			var mode = input.attr('data-ace-mode');
				mode = (mode == 'undefined') ? 'html' : mode;
			var theme = input.attr('data-ace-theme');
				theme = (theme == 'undefined') ? 'chrome' : theme;
			var container = $('<div>', {
				'class': input.attr('class'),
				'height': '150px',
				'width': '100%',
				'position': 'absolute'
			}).insertBefore(input);

			// Hide the native textarea
			input.hide();

			// Prepare the ACE editor
			var editor = ace.edit(container[0]);

			editor.renderer.setShowGutter(true);
			editor.getSession().setValue(input.val());
			editor.getSession().setMode('ace/mode/' + mode);
			editor.setTheme('ace/theme/' + theme);
			editor.getSession().on('change', function() {
				input.val(editor.getSession().getValue());
			});
		});

		$(document).on('click', '.custom-body-campaign .notice-dismiss', function (event) {

			$.ajax({
				url: ajaxurl,
				method: 'post',
				data: {
					action: 'custom_body_admin_ignore'
				},
				success: function (response) {
					console.log(response);
				}
			});
		});
	});

})(jQuery);