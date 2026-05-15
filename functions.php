<?php
/**
 * EuMilitar theme bootstrap.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EUMILITAR_THEME_DIR', get_template_directory() );
define( 'EUMILITAR_THEME_URI', get_template_directory_uri() );
define( 'EUMILITAR_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

require_once EUMILITAR_THEME_DIR . '/inc/setup.php';
require_once EUMILITAR_THEME_DIR . '/inc/vite.php';
require_once EUMILITAR_THEME_DIR . '/inc/assets.php';
require_once EUMILITAR_THEME_DIR . '/inc/patterns.php';
require_once EUMILITAR_THEME_DIR . '/inc/elementor.php';
require_once EUMILITAR_THEME_DIR . '/inc/template-tags.php';
require_once EUMILITAR_THEME_DIR . '/inc/widgets.php';
require_once EUMILITAR_THEME_DIR . '/inc/updater.php';
