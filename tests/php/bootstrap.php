<?php
/**
 * PHPUnit bootstrap for wp-env integration tests.
 *
 * @package EuMilitar
 */

$wp_load = '/var/www/html/wp-load.php';

if ( ! file_exists( $wp_load ) ) {
	echo "WordPress bootstrap not found at {$wp_load}. Run npm run wp:start first.\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

require_once $wp_load;

if ( ! defined( 'EUMILITAR_THEME_DIR' ) ) {
	$theme = wp_get_theme( 'eumilitar-neo-brutalism-wordpress-theme' );

	if ( ! $theme->exists() ) {
		echo "Theme eumilitar-neo-brutalism-wordpress-theme is not installed in wp-env.\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit( 1 );
	}

	switch_theme( 'eumilitar-neo-brutalism-wordpress-theme' );
	require_once get_theme_root() . '/eumilitar-neo-brutalism-wordpress-theme/functions.php';
}

if ( ! did_action( 'after_setup_theme' ) ) {
	do_action( 'after_setup_theme' );
}

if (
	function_exists( 'eumilitar_register_pattern_categories' )
	&& ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( 'eumilitar-neo-brutalism-wordpress-theme' )
) {
	eumilitar_register_pattern_categories();
}

if (
	function_exists( 'eumilitar_register_block_patterns' )
	&& ! WP_Block_Patterns_Registry::get_instance()->is_registered( 'eumilitar/hero' )
) {
	eumilitar_register_block_patterns();
}
