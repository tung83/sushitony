<?php
/**
 * single checkbox
 */

$option = $value;
$value = vamtam_sanitize_bool( vamtam_get_option( $id, $default ) );
?>

<div class="vamtam-config-row <?php echo esc_attr( $class ) ?>">
	<div class="ritlte">
		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<label>
			<input type="checkbox" name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" value="true" class="<?php vamtam_static( $option )?>" <?php checked( $value, true ) ?> />
			<?php echo esc_html( $name ) ?>
		</label>
	</div>
</div>
