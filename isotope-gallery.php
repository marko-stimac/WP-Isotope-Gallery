<?php

/**
 * Plugin Name: Isotope gallery
 * Description: Isotope filtering with Fancybox gallery
 * Version: 1.0.0
 * Author: Marko Štimac
 * Author URI: https://marko-stimac.github.io/
 * Text Domain: isotope-gallery
 */

namespace ms\IsotopeGallery;

defined('ABSPATH') || exit;

require_once 'includes/class-backend.php';
require_once 'includes/class-frontend.php';

new IsotopeBackend();
$isotope_gallery = new IsotopeGallery();
add_shortcode('isotope-gallery', array($isotope_gallery, 'showComponent'));