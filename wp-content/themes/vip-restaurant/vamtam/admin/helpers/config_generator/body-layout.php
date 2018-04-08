<?php
/**
 * adds several links that allow the user to easily set several predefined options
 */

$available_layouts = array(
	'full',
	'left-only',
	'right-only',
	'left-right',
);

$selected = vamtam_get_option( $id, $default );

?>

<div class="vamtam-config-row body-layout <?php if ( isset( $class ) ) echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<?php foreach ( $available_layouts as $layout ) : ?>
			<span class="layout-type">
				<label for="<?php echo esc_attr( $id.$layout ) ?>" class="<?php if ( $selected == $layout ) echo 'selected' ?>"><img src="<?php echo esc_attr( VAMTAM_ADMIN_ASSETS_URI ) ?>images/body-<?php echo esc_attr( $layout ) ?>.png" alt="" /></label>
				<input type="radio" name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id.$layout ) ?>" value="<?php echo esc_attr( $layout ) ?>" class="<?php vamtam_static( $value )?>" <?php checked( $selected, $layout )?>/>
			</span>
		<?php endforeach ?>
		<?php if ( isset( $has_default ) && $has_default ) : ?>
			<span class="layout-type default">
				<input type="radio" name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>default" value="default" class="<?php vamtam_static( $value )?>" <?php checked( $selected, 'default' )?>/>
				<label for="<?php echo esc_attr( $id ) ?>default" class="<?php if ( $selected == 'default' ) echo 'selected' ?>"><?php esc_html_e( 'Default', 'wpv' ) ?></label>
			</span>
		<?php endif ?>
	</div>
</div>
