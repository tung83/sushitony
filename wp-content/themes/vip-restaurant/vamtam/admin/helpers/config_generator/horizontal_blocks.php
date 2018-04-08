<?php
	/**
	 * used in header/footer advanced sidebar editor
	 */

	$active   = vamtam_get_option( $id_prefix, $default );

	$min = (int) $min;
	$max = (int) $max;
	$step = (int) $step;

	$min_str  = isset( $min ) ? "min='$min' " : '';
	$max_str  = isset( $max ) ? "max='$max' " : '';
	$step_str = isset( $step ) ? "step='$step' " : '';

	$widths = array(
		'full' => esc_html__( 'Full', 'wpv' ),
		'cell-1-2' => '1/2',
		'cell-1-3' => '1/3',
		'cell-1-4' => '1/4',
		'cell-1-5' => '1/5',
		'cell-1-6' => '1/6',
		'cell-2-3' => '2/3',
		'cell-3-4' => '3/4',
		'cell-2-5' => '2/5',
		'cell-3-5' => '3/5',
		'cell-4-5' => '4/5',
		'cell-5-6' => '5/6',
	);
?>

<div class="vamtam-config-row horizontal_blocks clearfix <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>
		<?php vamtam_description( $id_prefix, $desc ) ?>
	</div>
	<div class="rcontent">
		<span>
			<input name="<?php echo esc_attr( $id_prefix ) ?>" id="<?php echo esc_attr( $id_prefix ) ?>" type="range" value="<?php echo esc_attr( $active ) ?>" <?php echo $min_str.$max_str.$step_str // xss ok ?> class="vamtam-range-input <?php vamtam_static( $value )?>" />
		</span>
		<input name="<?php echo esc_attr( $id_prefix . '-max' ) ?>" type="hidden" value="<?php echo esc_attr( $max ) ?>" class="static" />

		<div class="blocks clearboth">
			<?php
				for ( $i = 1; $i <= $max; $i++ ) :
					$is_last  = vamtam_get_option( $id_prefix . "-$i-last" );
					$is_empty = vamtam_get_option( $id_prefix . "-$i-empty" );
					$width    = vamtam_get_option( $id_prefix . "-$i-width" );

					$class = array();
					if ( $is_last ) {
						$class[] = 'last';
					}

					if ( $i <= $active ) {
						$class[] = 'active';
					}

					$class[] = $width;
			?>
				<div class="<?php echo esc_attr( implode( ' ', $class ) ) ?>" rel="<?php echo esc_attr( $id_prefix ) ?>" data-width="<?php echo esc_attr( $width )?>">
					<div class="block">
						<div class="options">
							<select name="<?php echo esc_attr( "$id_prefix-$i-width" ) ?>" id="<?php echo esc_attr( "$id_prefix-$i-width" ) ?>" class="<?php vamtam_static( $value )?>">
								<?php foreach ( $widths as $key => $option ) : ?>
									<option value="<?php echo esc_attr( $key ) ?>" <?php selected( $width, $key ) ?>><?php echo esc_html( $option ) ?></option>
								<?php endforeach ?>
							</select>

							<div>
								<label <?php if ( 'full' === $width ) : ?>style="display:none"<?php endif?>>
									<input type="checkbox" name="<?php echo esc_attr( "$id_prefix-$i-last" ) ?>" id="<?php echo esc_attr( "$id_prefix-$i-last" ) ?>" value="true" class="<?php vamtam_static( $value )?>" <?php checked( $is_last, true ) ?> />&nbsp;<?php esc_html_e( 'last?', 'wpv' ) ?>
								</label>
								<label>
									<input type="checkbox" name="<?php echo esc_attr( "$id_prefix-$i-empty" ) ?>" id="<?php echo esc_attr( "$id_prefix-$i-empty" ) ?>" value="true" class="<?php vamtam_static( $value )?>" <?php checked( $is_empty, true ) ?> />&nbsp;<?php esc_html_e( 'empty?', 'wpv' ) ?>
								</label>
							</div>
						</div>
					</div>
				</div>
				<?php if ( $is_last ) : ?>
					<div class="clearboth"></div>
				<?php endif ?>
			<?php endfor ?>
		</div>
	</div>
</div>

