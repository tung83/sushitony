<div id="vamtam-editor-shortcodes" class="clearfix">
	<ul>
		<?php echo $this->complex_elements(); // xss ok ?>
	</ul>
</div>

<div class="metabox-editor-content">
	<div id="visual_editor_edit_form"></div>
	<div id="visual_editor_content" class="vamtam_main_sortable inner-sortable main_wrapper clearfix"></div>
</div>

<?php $status = get_post_meta( $post->ID, '_vamtam_ed_js_status', true ) ?>
<input type="hidden" id="vamtam_ed_js_status" name="_vamtam_ed_js_status" value="<?php echo esc_attr( empty( $status ) ? 'true' : $status ) ?>" />
