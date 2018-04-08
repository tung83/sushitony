<?php

class Vamtam_Customize_Skins_Ajax {
	public $prefix = 'theme';

	private $options;

	public function __construct( $options ) {
		$this->options = $options;
	}

	private function respond_with_nonce( $data ) {
		header( 'Content-Type: application/json' );

		echo json_encode( array(
			'data' => $data,
			'nonce' => wp_create_nonce( 'vamtam-skins-nonce' ),
		) );

		exit;
	}

	public function ajax_import() {
		global $vamtam_fonts;

		check_ajax_referer( 'vamtam-skins-nonce', 'nonce' );

		update_option( 'vamtam-last-skin', str_replace( $this->prefix . '_', '', $_POST['file'] ), false );

		$options = $this->full_skin( vamtam_silent_get_contents( VAMTAM_SAVED_OPTIONS . $_POST['file'] ) );

		// build Google fonts URL

		$fonts_by_family = vamtam_get_fonts_by_family();

		$google_fonts = array();

		$fields  = $GLOBALS['vamtam_theme_customizer']->get_fields_by_id();

		foreach ( $fields as $id => $field ) {
			$full_id = 'vamtam_theme[' . $id . ']';

			// cache google fonts, so we can just load them later
			if ( 'typography' === $field['type'] ) {
				$font_id = $fonts_by_family[ $options[ $id ]['font-family'] ];
				$font    = $vamtam_fonts[ $font_id ];

				if ( isset( $font['gf'] ) && $font['gf'] ) {
					$google_fonts[ $font_id ][] = $options[ $id ]['variant'];
				}
			}
		}

		$options['google_fonts'] = Vamtam_Customizer::build_google_fonts_url( $google_fonts, $options['gfont-subsets'] );

		// save options and compile
		$GLOBALS['vamtam_theme_customizer']->set_options( $options );

		VamtamLessBridge::compile( $options );

		$this->respond_with_nonce( '<span class="success">'. esc_html__( 'Imported.', 'wpv' ) . '</span>' );
	}

	private function full_skin( $skin ) {
		global $vamtam_theme;

		return array_merge( $vamtam_theme, json_decode( $skin, true ) );
	}

	public function ajax_delete() {
		$_POST['file'] = trim( $_POST['file'] );

		if ( @unlink( VAMTAM_SAVED_OPTIONS . $_POST['file'] ) ) {
			$this->respond_with_nonce( '<span class="success">'. esc_html__( 'Success.', 'wpv' ) . '</span>' );
		}

		$this->respond_with_nonce( '<span class="error">'. esc_html__( 'Cannot delete file.', 'wpv' ) . '</span>' );
	}

	public function ajax_available() {
		check_ajax_referer( 'vamtam-skins-nonce', 'nonce' );

		$options = '';
		if ( isset( $_POST['prefix'] ) ) {
			$prefix = $_POST['prefix'].'_';

			$options .= '<option value="">' . esc_html__( 'Available skins', 'wpv' ) . '</option>';

			$skins = glob( VAMTAM_SAVED_OPTIONS . '*' );
			if ( is_array( $skins ) ) {
				foreach ( $skins as $filepath ) {
					$file = explode( DIRECTORY_SEPARATOR, $filepath );
					$file = end( $file );

					$options .= '<option value="' . esc_attr( $file ) . '">' . str_replace( $prefix, '', $file ) . '</option>';
				}
			}
		}

		$this->respond_with_nonce( $options );
	}

	public function ajax_save() {
		global $vamtam_theme;

		check_ajax_referer( 'vamtam-skins-nonce', 'nonce' );

		$exported_options = array();

		$options = $GLOBALS['vamtam_theme_customizer']->get_fields_by_id();

		foreach ( $options as $id => $option ) {
			if ( isset( $option['skin'] ) && $option['skin'] ) {
				$exported_options[ $id ] = $vamtam_theme[ $id ];
			}
		}

		// No need to escape this, as it's been properly escaped previously and through json_encode
		$content = json_encode( $exported_options );

		$filename = sanitize_title( $_POST['file'] );

		if ( vamtam_silent_put_contents( VAMTAM_SAVED_OPTIONS . $filename, $content ) ) {
			$this->respond_with_nonce( '<span class="success">'. esc_html__( 'Success.', 'wpv' ) . '</span>' );
		} else {
			$this->respond_with_nonce( '<span class="error">'. esc_html__( 'Cannot save skin file.', 'wpv' ) . '</span>' );
		}
	}
}