<?php
	global $vamtam_fonts;

	$current_size    = vamtam_get_option( $id . '-size' );
	$current_lheight = vamtam_get_option( $id . '-lheight' );
	$current_face    = vamtam_get_option( $id . '-face' );
	$current_weight  = vamtam_get_option( $id . '-weight' );
	$current_color   = vamtam_get_option( $id . '-color' );

	$weights = array(
		'300',
		'300 italic',
		'normal',
		'italic',
		'600',
		'600 italic',
		'bold',
		'bold italic',
		'800',
		'800 italic',
	);

	if ( ! isset( $only ) ) {
		$only = array();
	} else {
		$only = explode( ',', $only );
	}

	$show = new stdClass;
	$show->size             = ( in_array( 'size', $only ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
	$show->size_lheight_sep = ( ( in_array( 'size', $only ) && in_array( 'lheight', $only ) ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
	$show->lheight          = ( in_array( 'lheight', $only ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
	$show->face             = ( in_array( 'face', $only ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
	$show->weight           = ( in_array( 'weight', $only ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
	$show->color            = ( in_array( 'color', $only ) || sizeof( $only ) == 0 )  ? '' : 'hidden';
?>

<div class="vamtam-config-row font clearfix <?php echo esc_attr( $class ) ?>">
	<?php if ( isset( $name ) ) : ?>
		<div class="rtitle">
			<h4><?php echo esc_html( $name ) ?></h4>
			<?php vamtam_description( $id, $desc ) ?>
		</div>
	<?php endif ?>

	<div class="rcontent">

		<div class="font-preview"><?php esc_html_e( 'The quick brown fox jumps over the lazy dog', 'wpv' )?></div>
		<div class="font-styles"></div>

		<span class="wrapper size-wrapper <?php echo esc_attr( $show->size ) ?>">
			<select name="<?php echo esc_attr( $id ) ?>-size" class="size <?php vamtam_static( $value )?>">
				<?php for ( $i = $min; $i <= $max; $i++ ) : ?>
					<option value="<?php echo intval( $i ) ?>" <?php selected( $i, $current_size ) ?>><?php echo intval( $i ) ?> px</option>
				<?php endfor ?>
			</select>
			<div class="sub-desc"><?php esc_html_e( 'font size', 'wpv' )?></div>
		</span>

		<span class="size-lheight-separator <?php echo esc_attr( $show->size_lheight_sep ) ?>">/</span>

		<span class="wrapper lheight-wrapper <?php echo esc_attr( $show->lheight ) ?>">
			<select name="<?php echo esc_attr( $id )?>-lheight" class="lheight <?php vamtam_static( $value )?>">
				<?php for ( $i = $lmin; $i <= $lmax; $i++ ) : ?>
					<option value="<?php echo esc_attr( $i )?>" <?php selected( $i, $current_lheight ) ?>><?php echo intval( $i )?> px</option>
				<?php endfor ?>
			</select>
			<div class="sub-desc"><?php esc_html_e( 'line height', 'wpv' )?></div>
		</span>

		<span class="wrapper face-wrapper <?php echo esc_attr( $show->face ) ?>">
			<select name="<?php echo esc_attr( $id )?>-face" class="face <?php vamtam_static( $value )?>">
				<?php foreach ( $vamtam_fonts as $face => $font ) : ?>
					<option value="<?php echo esc_attr( $face )?>" <?php selected( $face, $current_face ) ?>><?php echo esc_html( $face ) ?></option>
				<?php endforeach ?>
			</select>
			<div class="sub-desc"><?php esc_html_e( 'font', 'wpv' )?></div>
		</span>

		<span class="wrapper weight-wrapper <?php echo esc_attr( $show->weight ) ?>">
			<select name="<?php echo esc_attr( $id ) ?>-weight" class="weight <?php vamtam_static( $value )?>">
				<?php foreach ( $weights as $w ) : ?>
					<option value="<?php echo esc_attr( $w ) ?>" <?php selected( $w, $current_weight ) ?>><?php echo esc_html( ucwords( $w ) ) ?></option>
				<?php endforeach ?>
			</select>
			<div class="sub-desc"><?php esc_html_e( 'style', 'wpv' )?></div>
		</span>

		<span class="wrapper color-wrapper <?php echo esc_attr( $show->color ) ?>">
			<input type="text" name="<?php echo esc_attr( $id ) ?>-color" class="vamtam-color-input <?php vamtam_static( $value )?>" data-hex="true" value="<?php echo esc_attr( $current_color ) ?>" />
			<div class="sub-desc"><?php esc_html_e( 'color', 'wpv' )?></div>
		</span>
	</div>
</div>
