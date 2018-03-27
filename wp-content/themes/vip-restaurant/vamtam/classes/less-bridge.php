<?php

/**
 * LESSPHP wrapper
 *
 * @package vip-restaurant
 */

/**
 * class VamtamLessBridge
 */
class VamtamLessBridge {

	/**
	 * List of option names which are known to be percentages
	 *
	 * @var array
	 */
	private static $percentages = array(
		'left-sidebar-width',
		'right-sidebar-width',
	);

	/**
	 * Compiles the LESS files
	 */
	public static function compile( $vars ) {
		global $vamtam_mocked;

		self::export_vars( $vars );

		$preview = isset( $GLOBALS['vamtam_less_preview'] ) && $GLOBALS['vamtam_less_preview'] ? '-preview' : '';

		$file_from = VAMTAM_CSS_DIR . 'all.less';
		$file_to   = VAMTAM_CACHE_DIR . 'all' . ( is_multisite() ? $GLOBALS['blog_id'] : '' ) . $preview . '.css';

		$file_preview = VAMTAM_CACHE_DIR . 'all' . ( is_multisite() ? $GLOBALS['blog_id'] : '' ) . '-preview.css';

		if ( empty( $preview ) && file_exists( $file_preview ) ) {
			unlink( $file_preview );
		}

		if ( $vamtam_mocked ) {
			try {
				$l = new VamtamLessc();
				$l->importDir = '.';

				include VAMTAM_HELPERS . 'lessphp-extensions.php';

				return $l->compileFile( $file_from );
			} catch ( Exception $e ) {
				self::warning( $e->getMessage() );
			}
		} else {
			$response = false;

			if ( isset( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
				$cookies = array(
					LOGGED_IN_COOKIE => $_COOKIE[ LOGGED_IN_COOKIE ],
				);

				$nonce = wp_create_nonce( 'vamtam-compile-less' );

				$response = wp_safe_remote_post(
					admin_url( 'admin-ajax.php' ),
					array(
						'body' => array(
							'input'  => $file_from,
							'output' => $file_to,
							'action' => 'vamtam-compile-less',
							'_nonce' => $nonce,
						),
						'cookies' => $cookies
					)
				);
			}

			if ( false === $response || is_wp_error( $response ) ) {
				// echo '<!--' . esc_html( $response->get_error_message() ) . "-->\n";
				return self::basic_compile( $file_from, $file_to );
			} else {
				$result = json_decode( $response['body'] );

				if ( is_null( $result ) ) {
					// echo '<!--' . esc_html( $response['body'] ) . "-->\n";
					return self::basic_compile( $file_from, $file_to );
				} else {
					if ( $result->status !== 'ok' ) {
						// echo '(error) ' . esc_html( $result->message );

						return 1;
					} elseif ( isset( $result->message ) ) {
						// echo esc_html( $result->message );
					} else {
						// esc_html_e( 'Saved', 'wpv' );
					}

					if ( isset( $result->memory ) ) {
						// echo "\n<!--" . round( $result->memory, 2 ) . 'M -->';
					}
				}
			}
		}

		return 0;
	}

	public static function basic_compile( $file_from, $file_to ) {
		if ( ! isset( $GLOBALS['vamtam_only_smart_less_compilation'] ) ) {
			try {
				$l = new VamtamLessc();
				$l->importDir = '.';

				include VAMTAM_HELPERS . 'lessphp-extensions.php';

				$l->compileFile( $file_from, $file_to ); // esc_html_e( 'Saved', 'wpv' );
			} catch ( Exception $e ) {
				self::warning( $e->getMessage() );

				return 12;
			}
		} else {
			// echo '<!-- smart less failed -->';
			// esc_html_e( 'Cannot compile LESS file', 'wpv' );

			return 11;
		}

		return 0;
	}

	private static function export_vars( $vars_raw ) {
		global $wpdb, $vamtam_mocked, $vamtam_defaults;

		if ( $vamtam_mocked ) {
			$vars_raw = self::flatten_vars( $vars_raw );

			$vars_raw['mobile-top-bar-resolution'] = '959px';
			$vars_raw['woocommerce-mobile']        = '768px';
		} else {
			$vars_raw = apply_filters( 'vamtam_less_vars', self::flatten_vars( $vars_raw ) );
		}

		$vars = array();

		foreach ( $vars_raw as $name => $value ) {
			if ( trim( $value ) === '' && preg_match( '/\bbackground-image\b/i', $name ) ) {
				$vars[ $name ] = '';
			 	continue;
			}

			if ( preg_match( '/^[-\w\d]+$/i', $name ) ) {
				if ( ! empty( $value ) && ( $clean_value = self::prepare( $name, $value ) ) ) {
					$vars[ $name ] = $clean_value;
				} else {
					$vars[ $name ] = null;
				}
			}
		}

		$vars['theme-images-dir'] = '"' . addslashes( VAMTAM_IMAGES ) . '"';

		// -----------------------------------------------------------------------------
		$out = '';
		foreach ( $vars as $name => $value ) {
			if ( ! $value ) {
				$value = 'false';

				if ( strpos( $name, 'color' ) !== false ) {
					$value = 'transparent';
				} elseif ( strpos( $name, 'background-attachment' ) !== false ) {
					$value = 'scroll';
				} elseif ( strpos( $name, 'background-position' ) !== false ) {
					$value = 'left top';
				} elseif ( strpos( $name, 'background-repeat' ) !== false ) {
					$value = 'no-repeat';
				} elseif ( strpos( $name, 'background-size' ) !== false ) {
					$value = 'auto';
				}
			} else {
				$possible_opacity = preg_replace( '/-color$/', '-opacity', $name );
				if ( $possible_opacity !== $name && isset( $vars[ $possible_opacity ] ) && trim( $value ) !== 'transparent' ) {
					$value = 'fade( ' . $value . ',' . ( $vars[ $possible_opacity ] * 100 ) . '% )';
				}
			}

			$out .= "@$name:$value;\n";
		}

		$file_vars = VAMTAM_CACHE_DIR . 'variables.less';

		vamtam_silent_put_contents( $file_vars, $out );
	}

	private static function flatten_vars( $vars, $prefix = '' ) {
		$flat_vars = array();

		foreach ( $vars as $key => $var ) {
			if ( is_array( $var ) ) {
				$flat_vars = array_merge( $flat_vars, self::flatten_vars( $var, $prefix . $key . '-' ) );

				unset( $flat_vars[ $key ] );
			} else {
				$flat_vars[ $prefix . $key ] = $var;
			}
		}

		return $flat_vars;
	}

	/**
	 * Sanitizes a variable
	 *
	 * @param  string  $name           option name
	 * @param  string  $value          option value from db
	 * @param  boolean $returnOriginal whether to return the db value if no good sanitization is found
	 * @return int|string|null         sanitized value
	 */
	private static function prepare( $name, $value, $returnOriginal = false ) {
		$good = true;
		$name = preg_replace( '/^vamtam_/', '', $name );
		$originalValue = $value;

		// duck typing values
		if ( preg_match( '/(^share|^has-|^show|-last$)/i', $name ) ) {
			$good = false;
		} elseif ( preg_match( '/(%|px|em)$/i', $value ) ) { // definitely a number, leave it as is

		} elseif ( is_numeric( $value ) ) { // most likely dimensions, must differentiate between percentages and pixels
			if ( in_array( $name, self::$percentages ) ) {
				$value .= '%';
			} elseif ( preg_match( '/(size|width|height)$/', $name ) ) { // treat as px
				$value .= 'px';
			}
		} elseif ( preg_match( '/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $value ) ) { // colors
			// as is
		} elseif ( preg_match( '/^http|^url/i', $value ) || preg_match( '/(family|weight)$/', $name ) ) { // urls and other strings
			$value = "'" . str_replace( "'", '"', $value ) . "'";
		} elseif ( preg_match( '/^accent(?:-color-)?\d$/', $value ) ) { // accents
			$value = vamtam_sanitize_accent( $value );
		} else {
			if ( ! preg_match( '/\bfamily\b|\burl\b/i', $name ) ) {
				// check keywords
				$keywords   = explode( ' ', 'top right bottom left fixed static scroll cover contain auto repeat repeat-x repeat-y no-repeat center normal italic bold 100 200 300 400 500 600 700 800 900 transparent' );
				$sub_values = explode( ' ', $value );
				foreach ( $sub_values as $s ) {
					if ( ! in_array( $s, $keywords ) ) {
						$good = false;
						break;
					}
				}
			}
		}

		return $good ? $value : ( $returnOriginal ? $originalValue : null );
	}

	/**
	 * shows a warning
	 *
	 * @param  string $message warning message
	 */
	private static function warning( $message ) {
		global $vamtam_mocked;

		$message = str_replace( '*/', '* /', $message );

		if ( $vamtam_mocked ) {
			echo "/* WARNING:" . esc_html( $message ) . "*/";
		}
	}
}
