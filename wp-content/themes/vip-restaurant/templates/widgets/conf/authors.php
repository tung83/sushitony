<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpv' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label><?php esc_html_e( 'Show Avatar:', 'wpv' ); ?></label>
	<?php
		$id = $this->get_field_name( 'show_avatar' );
		$checked = $show_avatar;
		include VAMTAM_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label><?php esc_html_e( 'Show Post Count:', 'wpv' ); ?></label>
	<?php
		$id = $this->get_field_name( 'show_post_count' );
		$checked = $show_post_count;
		include VAMTAM_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'How many authors to display?', 'wpv' ); ?></label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" class="num_shown" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>">
		<?php for ( $i = 1; $i <= $this->max_authors; $i++ ) :  ?>
			<option <?php selected( $i, $count ) ?>><?php echo intval( $i ) ?></option>
		<?php endfor ?>
	</select>
</p>

<div class="authors_wrap hidden_wrap">
	<?php
		for ( $i = 1; $i <= $this->max_authors; $i++ ) :
			$author_id = "author_id_$i";
			$author_desc = "author_desc_$i";
	?>
		<div class="hidden_el" <?php if ( $i > $count ) : ?>style="display:none"<?php endif;?>>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $author_id ) ); ?>">
					<?php esc_html_e( 'Author:', 'wpv' )?>
				</label>
				<select name="<?php echo esc_attr( $this->get_field_name( $author_id ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $author_id ) ); ?>" class="widefat">
					<?php foreach ( $authors as $user_id => $display_name ) : ?>
						<option value="<?php echo esc_attr( $user_id ) ?>" <?php if ($selected_author[ $i ] == $user_id) echo 'selected="selected"'?>><?php echo esc_html( $display_name ) ?></option>;
					<?php endforeach ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $author_desc ) ); ?>">
					<?php esc_html_e( 'Author Description (optional):', 'wpv' )?>
				</label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr( $this->get_field_id( $author_desc ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $author_desc ) ); ?>"><?php echo esc_textarea( $author_descriptions[ $i ] ); ?></textarea>
			</p>

		</div>

	<?php endfor;?>
</div>
