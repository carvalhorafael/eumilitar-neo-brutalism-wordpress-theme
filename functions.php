<?php
/**
 * EuMilitar theme bootstrap.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EUMILITAR_THEME_VERSION', '0.1.0' );
define( 'EUMILITAR_THEME_DIR', get_template_directory() );
define( 'EUMILITAR_THEME_URI', get_template_directory_uri() );

require_once EUMILITAR_THEME_DIR . '/inc/setup.php';
require_once EUMILITAR_THEME_DIR . '/inc/vite.php';
require_once EUMILITAR_THEME_DIR . '/inc/assets.php';
require_once EUMILITAR_THEME_DIR . '/inc/patterns.php';
require_once EUMILITAR_THEME_DIR . '/inc/elementor.php';
require_once EUMILITAR_THEME_DIR . '/inc/template-tags.php';

