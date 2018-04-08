<?php

class Vamtam_Customize_Switch_Control extends Vamtam_Customize_Control {
	public $type = 'vamtam-switch';

	/**
	 * Render the control's content.
	 */
	protected function render_content() {
		if ( empty( $this->choices ) ) {
			$this->choices = array(
				'1' => esc_html__( 'On', 'wpv' ),
				'0' => esc_html__( 'Off', 'wpv' ),
			);
		}

		$setting_value = $this->value();

		if ( $setting_value === 'false' ) {
			$setting_value = '0';
		} else if ( $setting_value === 'true' ) {
			$setting_value = '1';
		}

		$name = '_customize-switch-' . $this->id;

		if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif;
		if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description ; ?></span>
		<?php endif;

		foreach ( $this->choices as $value => $label ) :
			?>
			<label>
				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $setting_value, $value ); ?> />
				<?php echo esc_html( $label ); ?>
			</label>
			<?php
		endforeach;
	}

	public static function sanitize_callback( $value ) {
		if ( 'true' === $value ) {
			return '1';
		} else if ( 'false' === $value ) {
			return '0';
		}

		return (string) $value;
	}
}