<?php

/**
 * posts widget
 */

class vamtam_posts extends WP_Widget {

	public function __construct() {
		$widget_options = array(
			'classname' => 'vamtam_posts',
			'description' => esc_html__( 'Displays a list of posts/comments', 'wpv' ),
		);
		parent::__construct( 'vamtam_posts', esc_html__( 'Vamtam - Multi widget', 'wpv' ) , $widget_options );
		$this->alt_option_name = 'vamtam_posts';
		add_action( 'save_post', array( &$this, 'flush_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_cache' ) );
	}

	public function widget( $args, $instance ) {
		$cache = wp_cache_get( 'theme_vamtam_posts', 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ]; // xss ok
			return;
		}

		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		if ( ! $number = (int) $instance['number'] )
			$number = 10;
		elseif ( $number < 1 )
			$number = 1;
		elseif ( $number > 15 )
			$number = 15;

		if ( ! $desc_length = (int) $instance['desc_length'] )
			$desc_length = 0;
		elseif ( $desc_length < 1 )
			$desc_length = 1;
		$disable_thumbnail = $instance['disable_thumbnail'];
		$tag_taxonomy = $instance['tag_taxonomy'];

		$orderby = is_string( $instance['orderby'] ) ? array( $instance['orderby'] ) :   // backwards compatible with non-tabbed widget
					( is_array( $instance['orderby'] ) ? $instance['orderby'] : array() ); // just in case if orderby is not an array - pass an empty array

		$img_size = apply_filters( 'vamtam_posts_widget_img_size', 300, $args );
		$thumbnail_name = apply_filters( 'vamtam_posts_widget_thumbnail_name', 'thumbnail', $args );

		ob_start();
		include locate_template( 'templates/widgets/front/posts.php' );
		$cache[ $args['widget_id'] ] = ob_get_flush();

		wp_cache_set( 'theme_vamtam_posts', $cache, 'widget' );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['desc_length'] = (int) $new_instance['desc_length'];
		$instance['disable_thumbnail'] = ! empty( $new_instance['disable_thumbnail'] );
		$instance['cat'] = $new_instance['cat'];
		$instance['tag_taxonomy'] = $new_instance['tag_taxonomy'];

		$this->flush_cache();

		return $instance;
	}

	public function flush_cache() {
		wp_cache_delete( 'theme_vamtam_posts', 'widget' );
	}

	private function get_section_title( $orderby, $single = false ) {
		if ( 'comment_count' == $orderby ) {
			return apply_filters( 'vamtam_multiwidget_tab_title', esc_html__( 'Popular', 'wpv' ), $orderby, $single );
		}

		if ( 'date' == $orderby ) {
			return apply_filters( 'vamtam_multiwidget_tab_title', esc_html__( 'Newest', 'wpv' ), $orderby, $single );
		}

		if ( 'comments' == $orderby ) {
			return apply_filters( 'vamtam_multiwidget_tab_title', esc_html__( 'Comments', 'wpv' ), $orderby, $single );
		}

		if ( 'tags' == $orderby ) {
			return apply_filters( 'vamtam_multiwidget_tab_title', esc_html__( 'Tags', 'wpv' ), $orderby, $single );
		}
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$disable_thumbnail = isset( $instance['disable_thumbnail'] ) ? (bool) $instance['disable_thumbnail'] : false;
		$orderby = isset( $instance['orderby'] ) ?
					( is_string( $instance['orderby'] ) ? array( $instance['orderby'] ) :   // backwards compatible with non-tabbed widget
						( is_array( $instance['orderby'] ) ? $instance['orderby'] : array() ) // just in case if orderby is not an array - pass an empty array
					) : array( 'comment_count' );
		$cat = isset( $instance['cat'] ) ? $instance['cat'] : array();
		$tag_taxonomy = isset( $instance['tag_taxonomy'] ) ? $instance['tag_taxonomy'] : '';

		if ( ! isset( $instance['number'] ) || ! $number = (int) $instance['number'] )
			$number = 5;

		$desc_length = isset( $instance['desc_length'] ) ? $instance['desc_length'] : 80;
		$categories = get_categories( 'orderby=name&hide_empty=0' );

		include locate_template( 'templates/widgets/conf/posts.php' );
	}
}
register_widget( 'vamtam_posts' );
