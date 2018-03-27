<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpv' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Display:', 'wpv' ); ?></label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>[]" multiple="multiple">
		<option value="comment_count" <?php selected( in_array( 'comment_count', $orderby ), true ); ?>><?php esc_html_e( 'Popular Posts', 'wpv' ) ?></option>
		<option value="date" <?php selected( in_array( 'date', $orderby ), true ); ?>><?php esc_html_e( 'Recent Posts', 'wpv' ) ?></option>
		<option value="comments" <?php selected( in_array( 'comments', $orderby ), true ); ?>><?php esc_html_e( 'Recent Comments', 'wpv' ) ?></option>
		<option value="tags" <?php selected( in_array( 'tags', $orderby ), true ); ?>><?php esc_html_e( 'Tags', 'wpv' ) ?></option>
	</select>
</p>

<h4><?php esc_html_e( 'Posts / Comments', 'wpv' ) ?></h4>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of items:', 'wpv' ); ?></label>
	<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
</p>

<p>
	<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'disable_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_thumbnail' ) ); ?>"<?php checked( $disable_thumbnail ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_thumbnail' ) ); ?>"><?php esc_html_e( 'Disable Thumbnails?', 'wpv' ); ?></label>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php esc_html_e( 'Categories:', 'wpv' ); ?></label>
	<select style="height:5.5em" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>[]" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" class="widefat" multiple="multiple">
		<?php foreach ( $categories as $category ) :  ?>
			<option value="<?php echo esc_attr( $category->term_id ) ?>"<?php selected( in_array( $category->term_id, $cat ), true ) ?>><?php echo esc_html( $category->name ) ?></option>
		<?php endforeach; ?>
	</select>
</p>

<h4><?php esc_html_e( 'Tags', 'wpv' ) ?></h4>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'tag_taxonomy' ) ); ?>"><?php esc_html_e( 'Taxonomy:', 'wpv' ) ?></label>
	<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag_taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag_taxonomy' ) ); ?>">
		<?php foreach ( get_object_taxonomies( 'post' ) as $taxonomy ) :
					$tax = get_taxonomy( $taxonomy );
					if ( ! $tax->show_tagcloud || empty( $tax->labels->name ) )
						continue;
		?>
			<option value="<?php echo esc_attr( $taxonomy ) ?>" <?php selected( $taxonomy, $tag_taxonomy ) ?>><?php echo esc_html( $tax->labels->name ) ?></option>
		<?php endforeach; ?>
	</select>
</p>
