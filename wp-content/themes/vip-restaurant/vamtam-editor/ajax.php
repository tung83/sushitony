<?php

class Vamtam_Editor_AJAX {
	public function __construct() {
		$actions = array( 'markup', 'config', 'get_slide_html', 'init_html' );
		foreach ( $actions as $name ) {
			add_action( "wp_ajax_vamtam_editor_$name", array( &$this, $name ) );
		}

		$this->special_markup_list = apply_filters( 'vamtam_editor_special_markup_list', array( 'accordion', 'tabs', 'services_expandable' ) );
	}

	public function markup() {
		$id = ( isset( $_POST['element'] ) ) ? $_POST['element'] : '';

		if ( ! empty( $id ) ) {
			echo $this->markup_handler( $id ); // xss ok
		}

		exit;
	}

	private function get_uniqid_suffix() {
		return str_replace( '.', '-', uniqid( '', true ) ).'-'.mt_rand();
	}

	private function get_uniqid( $id ) {
		return 'vamtamed-'.$id.'-'.$this->get_uniqid_suffix();
	}

	private function markup_handler( $id, $attributes = null, $content = '' ) {
		global $vamtam_sc;

		$accepted = '';

		if ( ! is_null( $attributes ) ) {
			if ( $id == 'column' ) {
				$accepted = $content;
				$id .= '-'.str_replace( '/', '', $attributes['width'] );
			} else {
				if ( isset( $vamtam_sc[ $id ]['accepting'] ) && $vamtam_sc[ $id ]['accepting'] ) {
					$accepted = $content;
				} else {
					if ( in_array( $id, $this->special_markup_list ) ) {
						$accepted = $this->get_special_markup( $id, $content );
					} else {
						$attributes['html-content'] = $content;
					}
				}
			}
		}

		ob_start();

		if ( strpos( $id, 'column' ) === 0 ) :
		?>
			<div id="<?php echo esc_attr( $this->get_uniqid( $id ) ) ?>" class="vamtam_ed_column vamtam_sortable inner-sortable column column-<?php echo esc_attr( preg_replace( '/column-(\d)(\d)/', '$1-$2', $id ) ) ?> expandable expanded" data-basename="column">
				<?php echo $this->getControls( 'size name add edit clone delete handle', preg_replace( '/column-(\d)(\d)/', '$1/$2', $id ), esc_html__( 'Column', 'wpv' ), $attributes ); // xss ok ?>
				<?php echo $this->loopShortcodeParameters( 'column', $attributes ); // xss ok ?>
				<?php echo $accepted; // xss ok ?>
			</div>
		<?php else : ?>

			<?php
				$controls = isset( $vamtam_sc[ $id ]['controls'] ) ? $vamtam_sc[ $id ]['controls'] : 'name delete';
				$class = isset( $vamtam_sc[ $id ]['class'] ) ? $vamtam_sc[ $id ]['class'] : '';

				$accepting = isset( $vamtam_sc[ $id ]['accepting'] ) && $vamtam_sc[ $id ]['accepting'] ? 'inner-sortable expanded' : '';
				$size = isset( $attributes['column_width'] ) ? $attributes['column_width'] : '1/1';
				$size_class = 'column-'.str_replace( '/', '-', $size );

				$expandable = strpos( $controls, 'handle' ) !== false ? 'expandable' : 'non-expandable';

				if ( strpos( $controls, 'always-expanded' ) )
					$expandable = 'expandable expanded';
			?>

			<div id="<?php echo esc_attr( $this->get_uniqid( $id ) ) ?>" class="vamtamed-<?php echo esc_attr( "$id $accepting $class" ) ?> vamtam_sortable column <?php echo esc_attr( "$size_class $expandable" ) ?>" <?php echo $this->getCallbacks( $id ) // xss ok ?> data-basename="<?php echo esc_attr( $id ) ?>">
				<?php echo $this->getControls( $controls, $size, $vamtam_sc[ $id ]['name'], $attributes ); // xss ok ?>
				<?php echo $this->loopShortcodeParameters( $id, $attributes ); // xss ok ?>
				<?php echo $accepted; // xss ok ?>
			</div>
		<?php
		endif;

		return ob_get_clean();
	}

	private function getControls( $controls, $size_str, $name = '', $atts = array() ) {
		$output = '<div class="controls">';

		$orig_name = $name;
		if ( isset( $atts['column_title'] ) ) {
			if ( ! empty( $atts['column_title'] ) && $atts['column_title'] !== 'undefined' ) {
				$name = $atts['column_title'];
			}
		} elseif ( isset( $atts['title'] ) && ! empty( $atts['title'] ) && $atts['title'] !== 'undefined' ) {
			$name = $atts['title'];
		} elseif ( isset( $atts['name'] ) && ! empty( $atts['name'] ) && $atts['name'] !== 'undefined' ) {
			$name = $atts['name'];
		}
		$name = strip_tags( $name );

		$controls_html = array(
			'name' => "<span class='column-name' data-orig-title='" . esc_attr( $orig_name ) . "'>$name</span>",
			'size' => "<div class='column-size-wrapper'>
							<div class='column-increase-decrease'><a class='column-increase icon-plus' href='#' title='" . esc_attr__( 'Increase width', 'wpv' ) . "'></a> <a class='column-decrease icon-minus' href='#' title='" . esc_attr__( 'Decrease width', 'wpv' ) . "'></a></div>
							<span class='column-size'>$size_str</span>
						</div>",
			// 'add' => " <a class='column-add icon-plus' href='#' title='".esc_attr__( 'Insert element', 'wpv' )."'></a> ",
			'clone' => " <a class='column-clone icon-copy' href='#' title='" . esc_attr__( 'Clone', 'wpv' )."'></a> ",
			'edit' => ' <a class="column-edit icon-edit" href="#" title="' . esc_attr__( 'Edit shortcode properties', 'wpv' ).'"></a>',
			'delete' => ' <a class="column-remove icon-remove" href="#" title="' . esc_attr__( 'Remove shortcode', 'wpv' ).'"></a>',
			'handle' => '<div class="handlediv" title="' . esc_attr__( 'Click to toggle', 'wpv' ).'"><br /></div>',
		);

		if ( $controls == 'full' )
			$controls = 'size edit delete';

		$controls = explode( ' ', $controls );
		foreach ( $controls as $c ) {
			if ( isset( $controls_html[ $c ] ) )
				$output .= $controls_html[ $c ];
		}

		$output .= '</div>';

		return $output;
	}

	private function getCallbacks( $id ) {
		global $vamtam_sc;
		$output = '';

		if ( isset( $vamtam_sc[ $id ]['callbacks'] ) )
			$output = esc_attr( json_encode( $vamtam_sc[ $id ]['callbacks'] ) );

		return "data-callbacks='$output'";
	}

	private function loopShortcodeParameters( $id, $attributes ) {
		global $vamtam_sc;
		$output = '';

		if ( isset( $vamtam_sc[ $id ]['options'] ) ) {
			foreach ( $vamtam_sc[ $id ]['options'] as $param ) {
				if ( $param['type'] == 'select-row' ) {
					foreach ( $param['selects'] as $sid => $s ) {
						$value = isset( $attributes[ $sid ] ) ? $attributes[ $sid ] : null;
						$s['type'] = 'select';
						$s['id'] = $sid;
						$output .= $this->formatParam( $s, $value );
					}
				} elseif ( $param['type'] == 'range-row' ) {
					foreach ( $param['ranges'] as $sid => $s ) {
						$value = isset( $attributes[ $sid ] ) ? $attributes[ $sid ] : null;
						$s['type'] = 'range';
						$s['id'] = $sid;
						$output .= $this->formatParam( $s, $value );
					}
				} elseif ( $param['type'] == 'color-row' ) {
					foreach ( $param['inputs'] as $sid => $s ) {
						$value = isset( $attributes[ $sid ] ) ? $attributes[ $sid ] : null;
						$s['type'] = 'color';
						$s['id'] = $sid;
						$output .= $this->formatParam( $s, $value );
					}
				} elseif ( $param['type'] == 'background' ) {
					$opts = explode( ',', $param['only'] );
					$opt_types = array(
						'color' => 'color',
						'opacity' => 'range',
						'image' => 'upload',
						'repeat' => 'select',
						'attachment' => 'select',
						'position' => 'select',
						'size' => 'toggle',
					);

					foreach ( $opts as $opt_name ) {
						$oid = $param['id'].'_'.$opt_name;
						$value = isset( $attributes[ $oid ] ) ? $attributes[ $oid ] : null;
						$default = ( $opt_name == 'size' ) ? 'auto' : '';

						$output .= $this->formatParam( array(
							'id' => $oid,
							'type' => $opt_types[ $opt_name ],
							'default' => $default,
						), $value );
					}
				} elseif ( isset( $param['id'] ) ) {
					$value = isset( $attributes[ $param['id'] ] ) ? $attributes[ $param['id'] ] : null;
					$output .= $this->formatParam( $param, $value );
				}
			}
		}
		return $output;
	}

	private function formatParam( $param, $value ) {
		extract( $param );

		if ( is_null( $value ) )
			$value = isset( $default ) ? $default : '';

		$class = isset( $class ) ? $class : '';
		$placeholder = isset( $placeholder ) ? $placeholder : ( isset( $name ) ? $name : '' );

		if ( is_array( $value ) )
			$value = json_encode( $value );

		if ( isset( $type ) ) {
			$attr = "class='vamtam-ed-param-holder $id $type $class' name='$id'";

			if ( ! isset( $holder ) || $holder == 'hidden' )
				return "<input type='hidden' $attr value='".esc_attr( $value )."' />";

			if ( $holder == 'img' )
				return "<img src='".esc_attr( $value )."' $attr placeholder='$placeholder' />";

			if ( $holder != 'textarea' )
				$value = wpautop( $value );

			return "<$holder $attr placeholder='$placeholder'>$value</$holder>";
		}
	}

	private function get_special_markup( $id, $content ) {
		$result = apply_filters( 'vamtam_editor_get_special_markup', $content, $id );

		if ( $result !== $content )
			return $result;

		ob_start();

		switch ( $id ) {
			case 'accordion':
				if ( ! function_exists( 'vamtam_sub_shortcode') || ! vamtam_sub_shortcode( 'pane', $content, $params, $sub_contents ) )
					return $content;

				echo '<div class="vamtam_accordion">';

				foreach ( $sub_contents as $i => $text ) : ?>

					<div>
						<h3 class="title-wrapper clearfix">
							<a class="accordion-title"><?php echo wp_kses_post( $params[ $i ]['title'] ) ?></a>
							<a class="accordion-remove icon-remove" title="<?php esc_attr_e( 'Remove', 'wpv' ) ?>"></a>
							<a class="accordion-clone icon-copy" title="<?php esc_attr_e( 'Clone', 'wpv' ) ?>"></a>
							<a class="accordion-background-selector" data-background-image="<?php if ( isset( $params[ $i ]['background_image'] ) ) echo esc_attr( $params[ $i ]['background_image'] ) ?>" title="<?php esc_attr_e( 'Change Pane Background', 'wpv' ) ?>"><?php vamtam_icon( 'image' ) ?></a>
						</h3>
						<div class="pane clearfix inner-sortable"><?php echo $this->do_parse( $text ) // xss ok ?></div>
					</div>

				<?php endforeach;

				echo '<div><h3><a class="accordion-add icon-plus"></a></h3></div>';
				echo '</div>';
			break;

			case 'tabs':
				if ( ! function_exists( 'vamtam_sub_shortcode') || ! vamtam_sub_shortcode( 'tab', $content, $params, $sub_contents ) )
					return $content;

				$suffix = 'tabs-' . $this->get_uniqid_suffix();

				echo '<div class="vamtam_tabs"><ul>';

				foreach ( $params as $i => $pi ) :
					$p = shortcode_atts( array(
						'title' => '',
						'icon' => '',
					), $pi );
				?>
					<li>
						<a href="<?php echo esc_url( '#tabs-' . $suffix . $i ) ?>" class="tab-title"><?php echo wp_kses_post( $p['title'] ) ?></a>
						<a class="tab-remove icon-remove" title="<?php esc_attr_e( 'Remove', 'wpv' ) ?>"></a>
						<a class="tab-clone icon-copy" title="<?php esc_attr_e( 'Clone', 'wpv' ) ?>"></a>
						<a class="vamtam-icon-selector-trigger tab-icon-selector vamtam-icon <?php echo esc_attr( vamtam_get_icon_type( $p['icon'] ) ) ?> <?php if ( empty( $p['icon'] ) ) echo 'no-icon' ?>" data-icon-name="<?php echo esc_attr( $p['icon'] ) ?>" title="<?php esc_attr_e( 'Change Icon', 'wpv' ) ?>"><?php vamtam_icon( $p['icon'] ) ?></a>
					</li>
				<?php endforeach;
				echo '<li class="ui-state-default"><a class="tab-add icon-plus"></a></li>';
				echo '</ul>';

				foreach ( $sub_contents as $i => $text ) : ?>
					<div id="tabs-<?php echo esc_attr( $suffix . $i ) ?>" class="clearfix inner-sortable"><?php echo $this->do_parse( $text ); // xss ok ?></div>
				<?php endforeach;

				echo '</div>';
			break;

			case 'services_expandable':
				echo "<textarea class='inner-content'>" . esc_textarea( $content ) . '</textarea>';
			break;

			default:
				echo $content; // xss ok
		}

		return ob_get_clean();
	}

	public function config() {
		global $vamtam_sc;

		include_once plugin_dir_path( __FILE__ ) . 'config-generator.php';

		$id = ( isset( $_POST['element'] ) ) ? $_POST['element'] : '';

		Vamtam_Editor_Shortcode_Config::setConfig( $vamtam_sc[ $id ] )->render();

		exit;
	}

	public function get_slide_html() {
		$id = $this->get_uniqid_suffix();
		$value = array( 'static' => false );

		include VAMTAM_ADMIN_HELPERS . 'config_generator/slide.php';

		exit;
	}

	public function init_html() {
		echo $this->do_parse( $_POST['content'] ); // xss ok
		exit;
	}

	private function do_parse( $content ) {
		global $vamtam_sc;

		require_once plugin_dir_path( __FILE__ ) . 'parser.php';

		$content = stripslashes( $content );

		$content = vamtam_fix_shortcodes( $content );

		try {
			$parser = new Vamtam_Editor_Parser( $content, $vamtam_sc );
			$tree = $parser->parse();

			return $this->html_from_tree_node( $tree );
		} catch ( Exception $e ) {
			return '<span style="font: 14px / 18px sans-serif;">'.$e->getMessage().'</span>';
		}
	}

	private function html_from_tree_node( $tree ) {
		global $vamtam_sc;

		$result = '';

		$column_atts = array( 'width', 'title', 'divider', 'title_type', 'animation' );

		foreach ( $tree->children as $node ) {
			$content = $node->content;
			$implicit_column = ( $node->type === 'column' &&
								( isset( $node->atts['implicit'] ) && $node->atts['implicit'] === 'true' ) &&
								count( $node->children ) <= 1 );

			if ( $node->type == 'ROOT' ||
				$node->type === 'column' ||
				( isset( $vamtam_sc[ $node->type ]['accepting'] ) && $vamtam_sc[ $node->type ]['accepting'] )
			  ) {

				if ( $implicit_column ) {
					foreach ( $node->children as $inner_node ) {
						foreach ( $column_atts as $catt ) {
							if ( isset( $node->atts[ $catt ] ) )
								$inner_node->atts[ 'column_'.$catt ] = $node->atts[ $catt ];
						}
					}
				}

				$content = $this->html_from_tree_node( $node );
			}

			$result .= $implicit_column && ! empty( $content ) ? $content : $this->markup_handler( $node->type, $node->atts, $content );
		}

		return $result;
	}
};

new Vamtam_Editor_AJAX();
