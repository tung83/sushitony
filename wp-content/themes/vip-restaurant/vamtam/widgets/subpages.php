<?php

/**
 * list either subpages or siblings
 */

class vamtam_subpages extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'vamtam_subpages',
			'description'                 => esc_html__( 'Displays a list of SubPages', 'wpv' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'vamtam_subpages', esc_html__( 'Vamtam - List subpages', 'wpv' ) , $widget_ops );
	}

	function widget( $args, $instance ) {
		global $post;
		$children = wp_list_pages( 'echo=0&child_of=' . $post->ID . '&title_li=' );

		if ($children)
			$parent = $post->ID; // try listing children
		else {
			$parent = $post->post_parent; // try siblings
			if ( ! $parent)
				$parent = $post->ID;
		}
		$parent_title = get_the_title( $parent );
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? $parent_title : $instance['title'], $instance, $this->id_base );
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = $instance['exclude'];

		include locate_template( 'templates/widgets/front/subpages.php' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		if (in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ))
			$instance['sortby'] = $new_instance['sortby'];
		else $instance['sortby'] = 'menu_order';

		$instance['exclude'] = strip_tags( $new_instance['exclude'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'sortby' => 'menu_order',
			'title' => '',
			'exclude' => '',
		));
		$title = esc_attr( $instance['title'] );
		$exclude = esc_attr( $instance['exclude'] );

		include locate_template( 'templates/widgets/conf/subpages.php' );
	}
}
register_widget( 'vamtam_subpages' );
