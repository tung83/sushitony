<?php
/**
 * icons selector
 */

	$checked = vamtam_get_option( $id, $default );
?>

<div class="vamtam-config-row icons clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="vamtam-config-icons-selector">
			<input type="search" placeholder="<?php esc_attr_e( 'Filter icons', 'wpv' ) ?>" class="icons-filter"/>
			<div class="icons-wrapper spinner">
				<input type="radio" name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id . '-initial' ) ?>" value="" checked="checked"/>
			</div>
		</div>
	</div>
</div>
