<?php
/**
 * Custom template functions for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
* Widget 
 */



/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 * @return string Compiled HTML based on our arguments.
 */

function cias_widgets(){
	register_sidebar(
		array(
			'name' => __('Page sidebar', 'cias-lounge'),
			'id' => 'page_sidebar',
			'description' => __('Page sidebar', 'cias-lounge'),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);

}
add_action('widgets_init', 'cias_widgets');
