<?php
/**
 * tinymce
 */
?>

<div class="vamtam-config-row editor <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4>
			<label for="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $name ) ?></label>
		</h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<?php wp_editor( vamtam_get_option( $id, $default ), $id ) ?>
	</div>
</div>
