jQuery(document).ready(function($) {

	/**
	 * Configure editor modal
	 */

	var launch_button = $('#summation-launch-css-editor');

	launch_button.show();

	var style_tag = $('style#summation-custom-css');

	launch_button.click(function(e) {

		e.preventDefault();

		if ( launch_button.attr('rel') !== 'editor' ) {
			return;
		}

		// Target container
		var target = $('#' + launch_button.data('editor-target'));

		target.fadeIn();

		$('#' + target.data('close-editor')).click(function() {
			target.fadeOut();
		});
	});

	/**
	 * Make resizable
	 */

	$('#summation-css-editor-form').resizable({
		minHeight: 300,
		minWidth: 400,
		maxHeight: 600,
		resize: function(event,ui) {
			$('#editor').css({
				height: ui.size.height,
				width: ui.size.width
			});
		}
	}).draggable({
		cancel: '.ace_scroller',
		cursor: 'crosshair',
		handle: '.editor-drag'
	});

	/**
	 * Configure Ace
	 */
	
	// Initialize
	ace.require('ace/ext/language_tools');
	var editor = ace.edit('editor');

	var textarea = $('#editor-textarea');
	var saved_css = textarea.val();
	var unsaved_css = saved_css;

	// Enable autocompletion and snippets
	editor.setOptions({
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true
	});

	// Theme and mode
	editor.setTheme('ace/theme/monokai');
	editor.getSession().setMode('ace/mode/css');

	// Initial value (saved CSS)
	textarea.val(editor.getSession().getValue());

	// Update CSS as user types
	editor.getSession().on('change', function() {
		textarea.val(editor.getSession().getValue());
		unsaved_css = editor.getSession().getValue();
		style_tag.text(unsaved_css);
	});

	// Click to drag
	$('#editor').append($('.editor-drag'));
	// Click to resize
	$('.ui-icon').append($('.editor-resize'));

	/**
	 *	Send AJAX request
	 */
	$('#summation-css-save-changes').click(function(e){

		e.preventDefault();

		// Response container
		var response_container = $('#summation-editor-response');

		// No changes
		if ( unsaved_css === saved_css ) {
			response_container.addClass('warning').text(summation_editor.no_changes_msg).slideDown().delay(2000).slideUp(400, function(){
				response_container.removeClass('warning');
			});
			return;
		}

		var save_icon = $('i.fa.save-icon');

		var nonce = $('input#summation_css_editor_nonce').val();

		// Data for login request
		summation_save_css_data = {
			action: 'summation_genesis_save_css',
			nonce: nonce,
			css: unsaved_css
		};

		// Make save button spin
		save_icon.addClass('fa-spin');

		// AJAX request
		$.post( summation_editor.ajax_url, summation_save_css_data, function(response) {

			// Save failed
			if ( response.status === 'failed' ) {

				// Update the message container
				response_container.addClass('error').text(response.message).slideDown().delay(2000).slideUp(400, function(){
					response_container.removeClass('error');
				});
			}

			// Save successful
			else {

				// Update the message container
				response_container.addClass('success').text(response.message).slideDown().delay(2000).slideUp(400, function(){
					response_container.removeClass('success');
				});

				saved_css = unsaved_css;
				style_tag.text(saved_css);
			}
		});

		// Wait 750ms, then remove spin
		setInterval(function() {
			save_icon.removeClass('fa-spin');
		}, 750);
		
		return false;
	});
});