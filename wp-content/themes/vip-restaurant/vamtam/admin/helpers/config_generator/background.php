<?php

$fields = array(
	'color'      => esc_html__( 'Color:', 'wpv' ),
	'opacity'    => esc_html__( 'Opacity:', 'wpv' ),
	'image'      => esc_html__( 'Image / pattern:', 'wpv' ),
	'repeat'     => esc_html__( 'Repeat:', 'wpv' ),
	'attachment' => esc_html__( 'Attachment:', 'wpv' ),
	'position'   => esc_html__( 'Position:', 'wpv' ),
	'size'       => esc_html__( 'Size:', 'wpv' ),
);

$sep = isset( $sep ) ? $sep : '-';

$current = array();

if ( ! isset( $only ) ) {
	if ( isset( $show ) ) {
		$only = explode( ',', $show );
	} else {
		$only = array();
	}
} else {
	$only = explode( ',', $only );
}

$show = array();

global $post;
foreach ( $fields as $field => $fname ) {
	if ( isset( $GLOBALS['vamtam_in_metabox'] ) ) {
		$current[ $field ] = get_post_meta( $post->ID, "$id-$field", true );
	} else {
		$current[ $field ] = vamtam_get_option( "$id-$field" );
	}
	$show[ $field ] = ( in_array( $field, $only ) || sizeof( $only ) == 0 );
}

$selects = array(
	'repeat' => array(
		'no-repeat' => esc_html__( 'No repeat', 'wpv' ),
		'repeat-x'  => esc_html__( 'Repeat horizontally', 'wpv' ),
		'repeat-y'  => esc_html__( 'Repeat vertically', 'wpv' ),
		'repeat'    => esc_html__( 'Repeat both', 'wpv' ),
	),
	'attachment' => array(
		'scroll' => esc_html__( 'scroll', 'wpv' ),
		'fixed'  => esc_html__( 'fixed', 'wpv' ),
	),
	'position' => array(
		'left center'   => esc_html__( 'left center', 'wpv' ),
		'left top'      => esc_html__( 'left top', 'wpv' ),
		'left bottom'   => esc_html__( 'left bottom', 'wpv' ),
		'center center' => esc_html__( 'center center', 'wpv' ),
		'center top'    => esc_html__( 'center top', 'wpv' ),
		'center bottom' => esc_html__( 'center bottom', 'wpv' ),
		'right center'  => esc_html__( 'right center', 'wpv' ),
		'right top'     => esc_html__( 'right top', 'wpv' ),
		'right bottom'  => esc_html__( 'right bottom', 'wpv' ),
	),
);

?>

<div class="vamtam-config-row background clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="bg-inner-row">
			<?php if ( $show['color'] ) : ?>
				<div class="bg-block color">
					<div class="single-desc"><?php esc_html_e( 'Color:', 'wpv' ) ?></div>
					<input name="<?php echo esc_attr( $id . $sep . 'color' ) ?>" id="<?php echo esc_attr( $id ) ?>-color" text" data-hex="true" value="<?php echo esc_attr( $current['color'] ) ?>" class="wpv-color-input" />
				</div>
			<?php endif ?>

			<?php if ( $show['opacity'] ) : ?>
				<div class="bg-block opacity range-input-wrap clearfix">
					<div class="single-desc"><?php esc_html_e( 'Opacity:', 'wpv' ) ?></div>
					<span>
						<input name="<?php echo esc_attr( $id . $sep . 'opacity' ) ?>" id="<?php echo esc_attr( $id ) ?>-opacity" type="range" value="<?php echo esc_attr( $current['opacity'] )?>" min="0" max="1" step="0.05" class="vamtam-range-input" />
					</span>
				</div>
			<?php endif ?>
		</div>

		<div class="bg-inner-row">
			<?php if ( $show['image'] ) : ?>
				<div class="bg-block bg-image">
					<div class="single-desc"><?php esc_html_e( 'Image / pattern:', 'wpv' ) ?></div>
					<?php $_id = $id;	$id .= $sep.'image'; // temporary change the id so that we can reuse the upload field ?>
					<div class="image <?php vamtam_static( $value ) ?>">
						<?php include VAMTAM_ADMIN_CGEN . 'upload-basic.php'; ?>
					</div>
					<?php $id = $_id; unset( $_id ); ?>
				</div>
			<?php endif ?>

			<?php if ( $show['size'] ) : ?>
				<div class="bg-block bg-size">
					<div class="single-desc"><?php esc_html_e( 'Cover:', 'wpv' ) ?></div>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id.$sep ) ?>size" value="cover" <?php checked( $current['size'], 'cover' ) ?>/>
						<span><?php esc_html_e( 'On', 'wpv' ) ?></span>
					</label>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id.$sep ) ?>size" value="auto" <?php checked( $current['size'], 'auto' ) ?>/>
						<span><?php esc_html_e( 'Off', 'wpv' ) ?></span>
					</label>
				</div>
			<?php endif ?>

			<?php foreach ( $selects as $s => $options ) : ?>
				<?php if ( $show[ $s ] ) : ?>
					<div class="bg-block bg-<?php echo esc_attr( $s )?>">
						<div class="single-desc"><?php echo wp_kses_post( $fields[ $s ] ) ?></div>
						<select name="<?php echo esc_attr( $id.$sep.$s ) ?>" class="bg-<?php echo esc_attr( $s ) ?>">
							<?php foreach ( $options as $val => $opt ) : ?>
								<option value="<?php echo esc_attr( $val ) ?>" <?php selected( $val, $current[ $s ] ) ?>><?php echo esc_html( $opt ) ?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
