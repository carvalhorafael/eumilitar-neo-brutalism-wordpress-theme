<?php
/**
 * Run Theme Check against the development theme.
 *
 * @package EuMilitar
 */

require_once WP_PLUGIN_DIR . '/theme-check/checkbase.php';
require_once WP_PLUGIN_DIR . '/theme-check/main.php';

add_filter( 'tc_skip_development_directories', '__return_true' );
add_filter(
	'tc_common_dev_directories',
	static function ( $directories ) {
		return array_merge(
			$directories,
			array(
				'assets/dist',
				'coverage',
				'dist',
				'docs',
				'scripts',
				'src',
			)
		);
	}
);

$theme_slug = basename( dirname( __DIR__ ) );
$theme      = wp_get_theme( $theme_slug );
$success    = run_themechecks_against_theme( $theme, $theme_slug );
$results    = wp_strip_all_tags( display_themechecks() );

echo esc_html( trim( $results ) ) . PHP_EOL;

if ( false !== strpos( $results, 'REQUIRED' ) ) {
	exit( 1 );
}
