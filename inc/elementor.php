<?php
/**
 * Elementor compatibility.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Elementor compatibility styles when Elementor is active.
 */
function eumilitar_enqueue_elementor_assets() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	if ( eumilitar_vite_is_development() && eumilitar_vite_dev_server_is_running() ) {
		wp_enqueue_script( 'eumilitar-elementor', EUMILITAR_VITE_DEV_SERVER . '/src/elementor.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_script_add_data( 'eumilitar-elementor', 'type', 'module' );
		return;
	}

	$entry = eumilitar_vite_manifest_entry( 'src/elementor.js' );

	if ( $entry && ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
		foreach ( $entry['css'] as $index => $css_file ) {
			wp_enqueue_style(
				'eumilitar-elementor-' . $index,
				eumilitar_vite_asset_uri( $css_file ),
				array(),
				EUMILITAR_THEME_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'eumilitar_enqueue_elementor_assets', 20 );
