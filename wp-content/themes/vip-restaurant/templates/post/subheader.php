<?php
/**
 * Post sub-header template
 *
 * @package vip-restaurant
 */

$title = get_the_title();
?>
<div class="post-subheader">
	<?php $show_date = rd_vamtam_get_optionb( 'post-meta', 'date' ) ?>
	<?php if ( $show_date || is_customize_preview() ) : ?>
		<h6 class="post-date vamtam-meta-date" <?php VamtamTemplates::display_none( $show_date ) ?>>
			<?php if ( empty( $title ) ) :  ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
					<?php the_time( get_option( 'date_format' ) ) ?>
				</a>
			<?php else : ?>
				<?php the_time( get_option( 'date_format' ) ) ?>
			<?php endif ?>
		</h6>
	<?php endif ?>
</div>
