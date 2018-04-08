<?php

/**

Demo content import/export

**/

class Vamtam_Customize_Skins_Control extends Vamtam_Customize_Control {
	public $type = 'vamtam-background';

	public $prefix = 'theme';

	public function to_json() {
		parent::to_json();

		$this->json['nonce']  = wp_create_nonce( 'vamtam-skins-nonce' );
		$this->json['prefix'] = $this->prefix;

		$this->json['l10n'] = array(
			'auth_expired'   => esc_html__( 'Authentication expired. Please reload the page.', 'wpv' ),
			'import_confirm' => esc_html__( 'Are you sure you want to import "%s"? You will lose any changes you have made since you last exported this skin. If you proceed this page will be reloaded once the action is complete.', 'wpv' ),
			'delete_confirm' => esc_html__( "Are you sure you want to delete this skin (%s)? You will not be able to recover it later on.", 'wpv' ),
		);
	}

	protected function render_content() {
		if ( false !== ( $last_active_skin = get_option( 'vamtam-last-skin' ) ) ) {
			echo '<p>';
			echo wp_kses_post( sprintf( __( 'Last active skin: <b id="vamtam-skins-last-active">%s</b>', 'wpv' ), $last_active_skin ) );
			echo '</p>';
		}

		echo '<div style="display: flex">';
		echo '<input type="text" id="export-config-name" value="" class="static" />';
		echo '<input type="button" id="export-config" class="button static" value="' . esc_attr__( 'Save Skin', 'wpv' ) . '" />';
		echo '</div>';

		echo '<div style="display: flex">';
		echo '<select id="import-config-available" class="static">';
			echo '<option value="">' . esc_html__( 'Available skins', 'wpv' ) . '</option>';
		echo '</select>';
		echo '<input type="button" id="import-config" class="button static" value="' . esc_attr__( 'Load Skin', 'wpv' ) . '" />';
		echo '<input type="button" id="delete-config" class="button static" value="' . esc_attr__( 'Delete', 'wpv' ) . '" />';
		echo '</div>';

		echo '<span class="result"></span>';

		echo '<span class="spinner" style="float:none"></span>';
	}

	public function enqueue() {
		wp_enqueue_script(
			'customizer-control-vamtam-skins-js',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/js/skins' . ( WP_DEBUG ? '' : '.min' ) . '.js',
			array( 'jquery', 'customize-base' ),
			time(),
			true
		);
	}
}