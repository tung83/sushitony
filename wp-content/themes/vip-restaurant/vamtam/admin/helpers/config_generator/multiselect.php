<?php
/**
 * select multiple
 */
?>

<?php
	$size = isset( $size ) ? $size : '5';
	if ( isset( $target ) ) {
		if ( isset( $options ) ) {
			$options = $options + VamtamConfigGenerator::get_select_target_config( $target );
		} else {
			$options = VamtamConfigGenerator::get_select_target_config( $target );
		}
	}
	if ( ! is_array( $default ) ) {
		$default = unserialize( $default );
	}
	$selected = vamtam_default( vamtam_get_option( $id, $default, false ), array() );
?>

<div class="vamtam-config-row <?php echo esc_attr( $class ) ?> clearfix">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">

		<?php if ( ! isset( $layout ) || $layout === 'select' ) : ?>
			<select name="<?php echo esc_attr( $id ) ?>[]" id="<?php echo esc_attr( $id ) ?>" multiple="multiple" size="<?php echo esc_attr( $size ) ?>" class="<?php vamtam_static( $value ) ?>">

				<?php if ( ! empty( $options ) && is_array( $options ) ) : ?>
					<?php foreach ( $options as $key => $option ) : ?>
						<option value="<?php echo esc_attr( $key ) ?>" <?php is_array( $selected ) ? selected( in_array( $key, $selected ), true ) : selected( $key, $selected ) ?>>
							<?php echo esc_html( $option ) ?>
						</option>
					<?php endforeach ?>
				<?php endif ?>

			</select>
		<?php else : ?>
			<?php if ( ! empty( $options ) && is_array( $options ) ) : ?>
				<?php foreach ( $options as $key => $option ) : ?>
					<label class="checkbox-row">
						<input type="checkbox" name="<?php echo esc_attr( $id ) ?>[]"  class="<?php vamtam_static( $value ) ?>" value="<?php echo esc_attr( $key ) ?>" <?php is_array( $selected ) ? checked( in_array( $key, $selected ), true ) : checked( $key, $selected ) ?> />
						<?php echo esc_html( $option ) ?>
					</label>
					<br />
				<?php endforeach ?>
			<?php endif ?>
		<?php endif ?>

	</div>
</div>
