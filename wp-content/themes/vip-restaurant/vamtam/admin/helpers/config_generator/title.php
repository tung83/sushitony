<?php
	/**
	 * config page title
	 */

	$tabs = array();

	foreach ( $this->options as $option ) {
		if ( 'start' === $option['type'] ) {
			$href = isset( $option['slug'] ) ? $option['slug'] : $option['name'];

			if ( isset( $option['sub'] ) ) {
				$href = $option['sub'] . " $href";
			}

			$href = preg_replace( '/[^\w]+/', '-', strtolower( $href ) );

			$tabs[] = array(
				'href'   => $href,
				'name'   => $option['name'],
				'nosave' => isset( $option['nosave'] ) && $option['nosave'],
			);
		}
	}
?>

<div id="vamtam-ajax-overlay"></div><div id="vamtam-ajax-content"><?php esc_html_e( 'Loading', 'wpv' )?></div>

<div id="vamtam-config" class="clearfix ui-tabs">
	<div id="vamtam-config-tabs-wrapper" class="clearfix">
		<div id="icon-index" class="icon32"><br></div>
		<?php if ( count( $tabs ) === 1 ) :?>
			<h2 class="vamtam-config-no-tabs"><?php echo esc_html( $tabs[0]['name'] ) ?></h2>
		<?php endif ?>
		<h2 id="vamtam-config-tabs" class="nav-tab-wrapper <?php if ( count( $tabs ) === 1 ) echo esc_attr( 'hidden' ) ?>">
			<ul>
				<?php foreach ( $tabs as $i => $tab ) : ?>
					<li class="<?php if ( $tab['nosave'] ) echo 'nosave'; ?>"><a href="#<?php echo esc_url( $tab['href'] ) ?>-tab-<?php echo esc_url( $i ) ?>" title="<?php echo esc_attr( $tab['name'] ) ?>" class="nav-tab"><?php echo esc_html( $tab['name'] ) ?></a></li>
				<?php endforeach ?>
			</ul>

		</h2>
	</div>

	<?php global $vamtam_config_messages; echo $vamtam_config_messages; // xss ok ?>

<?php
	global $vamtam_loaded_config_groups;
	$vamtam_loaded_config_groups = 0;
?>
