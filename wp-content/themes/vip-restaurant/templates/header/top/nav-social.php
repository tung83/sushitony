<div class="grid-1-2 lowres-width-override lowres-grid-1-2" id="top-nav-social">
	<?php if ( rd_vamtam_get_option( 'top-bar-social-lead' ) !== '' ) :  ?>
		<span><?php echo rd_vamtam_get_option( 'top-bar-social-lead' ) // xss ok ?></span>
	<?php endif ?>
	<?php
		$map = array(
			'fb'        => 'theme-facebook',
			'twitter'   => 'twitter',
			'linkedin'  => 'linkedin',
			'gplus'     => 'googleplus',
			'flickr'    => 'flickr',
			'pinterest' => 'pinterest',
			'dribbble'  => 'dribbble2',
			'instagram' => 'instagram',
			'youtube'   => 'youtube',
			'vimeo'     => 'vimeo',
		);

		foreach ( $map as $option => $icon ) :  ?>
			<?php if ( rd_vamtam_get_option( "top-bar-social-$option" ) !== '' ) :  ?>
				<a href="<?php echo esc_url( rd_vamtam_get_option( "top-bar-social-$option" ) ) ?>" target="_blank"><?php
					echo vamtam_get_icon_html( array( // xss ok
						'name'       => $icon,
						'link_hover' => false,
					) );
				?></a>
			<?php endif ?>
		<?php endforeach; ?>
</div>
