<?php

/**
 * Portfolio scrollable template
 *
 * @package vip-restaurant
 */

$slider_options = array(
	'layoutMode'       => 'slider',
	'drag'             => true,
	'auto'             => false,
	'autoTimeout'      => 5000,
	'autoPauseOnHover' => true,
	'showNavigation'   => true,
	'showPagination'   => false,
	'scrollByPage'     => false,
	'gridAdjustment'   => 'responsive',
	'mediaQueries'     => VamtamTemplates::scrollable_columns( $max_columns ),
	'gapHorizontal'    => 0,
	'gapVertical'      => 0,
	'displayTypeSpeed' => 100,
);

wp_enqueue_script( 'cubeportfolio' );
wp_enqueue_style( 'cubeportfolio' );

$GLOBALS['vamtam_inside_cube'] = true;

?>

<section class="portfolios title-<?php echo esc_attr( $show_title ) ?> <?php echo $desc ? 'has-description' : 'no-description' ?> <?php if ( ! empty( $class ) ) echo esc_attr( $class ) ?>">
	<div class="portfolio-items vamtam-cubeportfolio cbp cbp-slider-edge" data-options="<?php echo esc_attr( json_encode( $slider_options ) ) ?>">
		<?php
			while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
				include locate_template( 'templates/portfolio/loop/item.php' );
			endwhile;
		?>
	</div>
</section>
<?php

$GLOBALS['vamtam_inside_cube'] = false;
