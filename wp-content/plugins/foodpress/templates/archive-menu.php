<?php
	/*
	 *	The template for displaying menu on "/menu" url slug
	 *
	 *	Override this tempalte by coping it to ../yourtheme/foodpress/archive-menu.php
	 *
	 *	@Author: AJDE
	 *	@foodpress
	 *	@version: 0.1
	 */

	get_header();
	$menu_page_id = foodpress_get_menu_archive_page_id();

	// check whether archieve post id passed
	if($menu_page_id){
		$archive_page = get_page($menu_page_id);
		echo "<div class='wrapper'>";
		echo apply_filters('the_content', $archive_page->post_content);
		echo "</div>";
	}else{
		echo "<p>ERROR: Please select a menu archieve page in foodpress Settings</p>";
	}

	get_footer();