<?php
/**
 *	CSS editor markup and styling
 *
 *	@package Summation Child Theme
 *	@author Ren Ventura
 */
?>

<style>
	#summation-css-editor {
		width: 100%;
		display: table;
		position: relative;
		z-index: 99;
	}
	#summation-css-editor-form {
		border-radius: 5px;
		display: none;
		left: 15%;
		position: fixed;
		top: 150px;
		width: 70%;
	}
	.ace-monokai .ace_print-margin {
		display: none;
	}
	.editor-wrap {
		background: transparent;
	}
	#editor {
		font-size: 16px;
		height: 500px; /** Required **/
	}
	#editor-textarea {
		height: 0;
		padding: 0;
		display: none;
	}
	#summation-editor-response {
		bottom: 0;
		color: #fff;
		display: none;
		font-size: 20px;
		font-weight: bold;
		left: 0;
		padding: 20px;
		position: absolute;
		text-align: center;
		width: 100%;
		z-index: 99;
	}
	#summation-editor-response.error {
		background-color: #ff0101;
	}
	#summation-editor-response.success {
		background-color: #5BC15B;
	}
	#summation-editor-response.warning {
		background-color: #FDDE02;
		color: #333;
	}
	#summation-launch-css-editor {
		background: #4476CF;
		color: #fff;
		display: table;
		height: 60px;
		left: 0;
		position: fixed;
		text-align: center;
		top: 50%;
		width: 60px;
	}
	#summation-launch-css-editor i {
		display: table-cell;
		font-size: 1.5em;
		vertical-align: middle;
	}
	#summation-launch-css-editor:hover {
		cursor: pointer;
	}
	.controls {
		position: absolute;
		right: -85px;
		top: -5px;
		z-index: 99;
	}
	.control {
		border-radius: 50%;
		color: #fff;
		cursor: pointer;
		display: table;
		height: 50px;
		margin: 0 30px 10px;
		text-align: center;
		width: 50px;
	}
	.control i {
		display: table-cell;
		font-size: 1.5em;
		vertical-align: middle;
	}
	.save-changes {
		background-color: #5BC15B;
	}
	.close-editor {
		background-color: #DF0101;
	}
	.editor-drag,
	.editor-resize {
		position: absolute;
		z-index: 999999999999999;
		bottom: 5px;
		color: #fff;
		font-size: 16px;
	}
	.editor-drag:hover,
	.editor-resize:hover {
		cursor: pointer;
	}
	.editor-drag {
		left: 5px;
	}
	.editor-resize {
		right: 5px;
	}
	@media only screen and (max-width: 768px) {
		#editor {
			width: 100%;
		}
		#summation-css-editor-form {
			left: 5%;
			width: 90%;
			top: 60px;
		}
		.controls {
			position: relative;
			right: 0;
			top: -25px;
		}
		.control {
			float: left;
			margin: -10px 10px -10px 0;
		}
	}
</style>

<span id="summation-launch-css-editor" rel="editor" data-editor-target="summation-css-editor-form"><span class="screen-reader-text"><?php _e( 'CSS Editor', 'summation-genesis' ); ?></span><i class="fa fa-paint-brush"></i></span>

<div id="summation-css-editor">

	<div class="editor-wrap">
	
		<form id="summation-css-editor-form" method="post" action="" data-close-editor="close-editor">
		
			<div id="summation-editor-response"></div>
		
			<div class="controls">
				<span class="control close-editor" id="close-editor"><i class="fa fa-times close-icon"><span class="screen-reader-text"><?php _e( 'Close editor', 'summation-genesis' ); ?></span></i></span>
				<span class="control save-changes" id="summation-css-save-changes"><i class="fa fa-refresh save-icon"><span class="screen-reader-text"><?php _e( 'Save changes', 'summation-genesis' ); ?></span></i></span>
			</div>
			
			<div class="container">
				<div id="editor"><?php echo esc_attr_e( $custom_css ); ?></div>
				<textarea name="summation_genesis_custom_css" id="editor-textarea" rows="5" cols="70" disabled="disabled"><?php echo esc_attr_e( $custom_css ); ?></textarea>
				<?php wp_nonce_field( 'summation_css_editor_nonce', 'summation_css_editor_nonce' ); ?>
			</div>
		
		</form>

	</div>

	<i class="fa fa-arrows editor-drag" title="Drag editor"><span class="screen-reader-text"><?php _e( 'Drag editor', 'summation-genesis' ); ?></span></i>
	<i class="fa fa-arrows-alt editor-resize" title="Resize editor"><span class="screen-reader-text"><?php _e( 'Drag editor', 'summation-genesis' ); ?></span></i>

</div>
