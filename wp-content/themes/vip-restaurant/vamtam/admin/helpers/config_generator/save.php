<p class="save-vamtam-config">
	<input type="hidden" name="page" value="<?php echo esc_attr( $_GET['page'] ) ?>" class="static" />
	<input type="hidden" name="action" value="vamtam-save-options" class="static" />
	<input type="submit" name="save-vamtam-config" class="button-primary autowidth static" value="<?php isset( $_GET['allowreset'] ) ? esc_attr_e( 'Delete options', 'wpv' ) : esc_attr_e( 'Save Changes', 'wpv' )?>" />
</p>
