<div id="shortcode_<?php echo esc_attr( $this->shortcode['value'] ) ?>" class="vamtam-config-group metabox shortcode_wrap clearfix">
	<div class="shortcode_content">
		<p class="shortcode_buttons top">
			<input type="button" class="button-primary shortcode_send" value="<?php esc_attr_e( 'Send Shortcode to Editor &raquo;', 'wpv' ) ?>"/>
		</p>

		<?php if ( isset( $this->shortcode['sub'] ) ) : ?>
			<div class="shortcode_sub_selector vamtam-config-row">
				<h4><?php esc_html_e( 'Type', 'wpv' )?></h4>

				<div class="content">
					<select name="sc_<?php echo esc_attr( $this->shortcode['value'] ) ?>_selector">
						<?php foreach ( $this->shortcode['options'] as $i => $sub_shortcode ) : ?>
							<option value="<?php echo esc_attr( $sub_shortcode['value'] ) ?>" <?php selected( $i, 0 )?>>
								<?php echo esc_html( $sub_shortcode['name'] ) ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<?php foreach ( $this->shortcode['options'] as $i => $sub_shortcode ) : ?>
				<div id="sub_shortcode_<?php echo esc_attr( $sub_shortcode['value'] ) ?>" class="sub_shortcode_wrap" <?php if ( 0 === $i ) :?>style="display:block"<?php endif?>>
					<?php
						foreach ( $sub_shortcode['options'] as $option ) {
							$option['id'] = 'sc_' . $this->shortcode['value'] . '_' . $sub_shortcode['value'] . '_' . $option['id']; $this->tpl( $option['type'], $option );
						}
					?>
				</div>
			<?php endforeach ?>
		<?php else :

			foreach ( $this->shortcode['options'] as $option ) {
				if ( isset( $option['id'] ) ) {
					$option['id'] = 'sc_'.$this->shortcode['value'].'_'.$option['id'];
				} else {
					if ( $option['type'] == 'select-row' ) {
						$new_selects = array();
						foreach ( $option['selects'] as $key => $select ) {
							$new_selects[ 'sc_'.$this->shortcode['value'].'_'.$key ] = $select;
						}

						$option['selects'] = $new_selects;
					}
				}

				$this->tpl( $option['type'], $option );
			}

		endif ?>

		<p class="shortcode_buttons">
			<a href="#shortcode_preview" class="button"><?php esc_html_e( 'Preview', 'wpv' ) ?></a>
			<input type="button" class="button-primary shortcode_send" value="<?php esc_attr_e( 'Send Shortcode to Editor &raquo;', 'wpv' ) ?>"/>
		</p>
	</div>
	<div id="shortcode_preview">
		<h4><?php esc_html_e( 'Preview', 'wpv' )?></h4>
		<div class="the_preview">
			<iframe name="shortcode_preview_iframe"></iframe>
		</div>
		<form action="<?php echo esc_url( home_url( '/?vamtam_shortcode_preview' ) ) ?>" method="post" target="shortcode_preview_iframe">
			<input type="hidden" name="data" id="shortcode_preview_content" />
		</form>
	</div>
</div>
