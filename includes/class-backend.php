<?php

/**
 * Register image sizes for gallery
 */

namespace ms\IsotopeGallery;

defined('ABSPATH') || exit;

class IsotopeBackend
{
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'themeSetup'));
		add_filter('plugin_row_meta', array($this, 'modify_plugin_meta'), 10, 4);
	}

	// Register image sizes, generally this isn't such a good idea on bigger websites so adjust accordingly
	public function themeSetup()
	{
		add_image_size('isotope-horizontal', 400, 200, true);
		add_image_size('isotope-vertical', 200, 400, true);
	}

	// Add link to readme file on installed plugin listing
	public function modify_plugin_meta( $links_array, $file)
	{
		if(strpos( $file, 'isotope-gallery/isotope-gallery.php' ) !== false) {
			// you can still use array_unshift() to add links at the beginning
			$links_array[] = '<a href="' . plugins_url('readme.md', __DIR__) . '" target="_blank">How to use</a>';
		}
		return $links_array;
	}
}