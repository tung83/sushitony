<div class="wrap">
	<h2><?php esc_html_e( 'VamTam Icons', 'wpv' ); ?></h2>

	<div id="dashboard-widgets-wrap" class="vamtam-icon-font-setup">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="postbox-container-1" class="step-1 postbox-container">
				<h3><?php esc_html_e( 'Step 1.', 'wpv' ) ?></h3>

				<hr>

				<div class="step-description"><?php printf( wp_kses_post( __( 'Use the <a href="%s" title="Generate an icon font" target="_blank">IcoMoon App</a> to generate an icon font. Download the generated icon font and upload the ZIP archive using the button below.', 'wpv' ) ), 'https://icomoon.io/app' ) ?></div>

				<button class="vamtam-upload-icon-font button"><?php esc_html_e( 'Upload', 'wpv' ) ?></button>

				<br>

				<em class="step-in-progress"></em>
			</div>
			<div id="postbox-container-2" class="step-2 postbox-container inactive">
				<h3><?php esc_html_e( 'Step 2.', 'wpv' ) ?></h3>

				<hr>

				<div class="step-description"><?php esc_html_e( 'Good! Now we have to process the font uploaded in the previous step. Please note that the default icon font will not be erased. Click the button below if you want to proceed.', 'wpv' ) ?></div>

				<button class="vamtam-process-icon-font button button-primary" data-nonce="<?php echo esc_attr( wp_create_nonce( 'vamtam-icon-manager' ) ) ?>"><?php esc_html_e( 'Process', 'wpv' ) ?></button>

				<br>

				<em class="step-in-progress"><?php esc_html_e( 'This may take a bit of time. Please wait...', 'wpv' ) ?></em>
			</div>
			<div id="postbox-container-3" class="step-3 postbox-container inactive">
				<h3><?php esc_html_e( 'Done', 'wpv' ) ?></h3>

				<hr>

				<div class="result-wrapper">
					<?php esc_html_e( 'The following icons were successfully imported:', 'wpv' ); ?>

					<div class="result-generated"></div>
				</div>

			</div>
		</div>
	</div>
</div>
