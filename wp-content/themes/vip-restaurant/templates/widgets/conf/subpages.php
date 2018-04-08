<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpv' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php esc_html_e( 'Sort by:', 'wpv' ); ?></label>
	<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
		<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php esc_html_e( 'Page order', 'wpv' ); ?></option>
		<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php esc_html_e( 'Page title', 'wpv' ); ?></option>
		<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php esc_html_e( 'Page ID', 'wpv' ); ?></option>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_html_e( 'Exclude:', 'wpv' ); ?></label>
	<input type="text" value="<?php echo esc_attr( $exclude ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />

	<small><?php esc_html_e( 'Page IDs, separated by commas.', 'wpv' ); ?></small>
</p>
