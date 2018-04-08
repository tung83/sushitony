<?php
	global $vamtam_theme;

	$row_width = 0;
?>
<div id="<?php echo esc_attr( $area ) ?>-sidebars" class="limit-wrapper">
	<div class="row">
		<?php for ( $i = 1; $i <= 8; $i++ ) : ?>
			<?php
				$active = is_active_sidebar( "$area-sidebars-$i" );
			?>
			<?php if ( $active ) : ?>
				<?php
					$width = rd_vamtam_get_option( "$area-sidebars-$i-width" );
					$fit   = ( $width != 'full' ) ? 'fit' : '';

					$width_num = explode( '-', str_replace( 'cell-', '', $width ) );
					$width_num = $width_num[0] / $width_num[1];

					$row_width += $width_num;

					if ( $row_width > 1 ) {
						echo '</div><div class="row">';

						$row_width = $width_num;
					}
				?>
				<aside class="<?php echo esc_attr( $width ) ?> <?php echo esc_attr( $fit ) ?>" data-id="<?php echo esc_attr( $i ) ?>">
					<?php dynamic_sidebar( "$area-sidebars-$i" ); ?>
				</aside>
			<?php endif; ?>
		<?php endfor ?>
	</div>
</div>
