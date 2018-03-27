<?php $theme_setup = admin_url( 'themes.php?page=vamtam_theme_setup' ); ?>

<div class="wrap">

<table class="form-table vamtam-table">
<tbody>
	<tr>
		<th scope="row">
			<label for="blogname">Support and Documentation</label>
			<br><br><p class="description" id="tagline-description">Thank you for purchasing our theme! Feel free to browse our knowledgebase for videos and extra help.</p>
		</th>
		<td>
			<a href="https://support.vamtam.com" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-book-open' ) ?></span>
				<span class="label">Knowledgebase</span>
			</a>

			<a href="http://restaurant.support.vamtam.com/support/solutions/articles/219852-how-to-install-the-theme-via-the-admin-panel-new" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-cloud-download' ) ?></span>
				<span class="label">Installation Guide</span>
			</a>

			<a href="http://restaurant.support.vamtam.com/support/solutions/articles/219853-how-to-update-a-vamtam-theme-and-the-bundled-plugins-new" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-question' ) ?></span>
				<span class="label">How to Update Guide</span>
			</a>

			<br/>

			<a href="http://restaurant.support.vamtam.com/support/solutions/articles/215918-video-guides-for-beginners-new" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-camcorder' ) ?></span>
				<span class="label">Video Guides for Beginners</span>
			</a>

			<a href="https://vamtam.com/child-themes" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-layers' ) ?></span>
				<span class="label">Child Themes</span>
			</a>

			<a href="https://vamtam.com/changelog" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-list' ) ?></span>
				<span class="label">Changelog</span>
			</a>

		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<th scope="row"><label for="blogdescription">Have any queries outside of the scope?</label>
			<br><br><p class="description" id="tagline-description">Should you have any queries outside of the scope of the help materials and the video guides don't hesitate to submit a ticket on our secure help desk.</p>
		</th>
		<td>
			<a href="https://support.vamtam.com/support/login" class="vamtam-box-button" target="_blank">
				<span class="vamtam-icon theme-icon"><?php vamtam_icon( 'theme-support' ) ?></span>
				<span class="label">Help Desk Login</span>
			</a>
		</td>
	</tr>
</tbody>
</table>

<br/>

<p>Please note that you have to sigh up to access the Help Desk. Next step is to verify your purchase.</p>

<p>Enter your purchase code in <strong>Appearence - <a href="<?php echo esc_url( $theme_setup ) ?>" target="_blank"> VamTam Theme Setup (Step 2)</a> - "Envato purchase key"</strong>.<br/>
We need this information for verification and testing purposes. You need this field filled in to receive theme and plugins' updates.<br/>
Sorry for any inconveniences!</p>

<p>If you have any difficulties finding the purchase data check out this guide: <a href="http://restaurant.support.vamtam.com/support/solutions/articles/219861-where-to-get-your-item-purchase-key-from-new" target="_blank">Purchase Data</a></p>

<p>If you have installed the theme on a localhost, please provide the Item Purchase Code in addition to entering the purchase data in <a href="<?php echo esc_url( $theme_setup ) ?>" target="_blank">VamTam Theme Setup Step 2</a>.</p>


<br/><br/>

<img src="<?php echo esc_url( VAMTAM_ADMIN_ASSETS_URI . 'images/logo-vamtam.svg' ) ?>"  alt="VamTam"/><br/>
Regards,<br>
<a href="https://vamtam.com">VamTam Team</a>

</div>
