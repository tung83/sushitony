<?php
$show = rd_vamtam_get_optionb( 'post-meta', 'tax' );

if ( $show || is_customize_preview() ) :
?>
	<div class="vamtam-meta-tax" <?php VamtamTemplates::display_none( $show ) ?>><span class="icon theme"><?php vamtam_icon( 'theme-layers' ); ?></span> <span class="visuallyhidden"><?php esc_html_e( 'Category', 'wpv' ) ?> </span><?php the_category( ' ' ); ?></div>
<?php
	$tags = get_the_tags();

	if ( count( $tags ) ) : ?>
		<div class="the-tags vamtam-meta-tax" <?php VamtamTemplates::display_none( $show ) ?>>
			<?php the_tags( '<span class="icon">' . vamtam_get_icon( 'theme-tag3' ) . '</span> <span class="visuallyhidden">'.esc_html__( 'Tags', 'wpv' ).'</span> ', ' ', '' ); ?>
		</div>
<?php
	endif;
endif;