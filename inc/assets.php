<?php
/**
 * Frontend and editor asset loading.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend assets.
 */
function eumilitar_enqueue_assets() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( eumilitar_vite_is_development() && eumilitar_vite_dev_server_is_running() ) {
		wp_enqueue_script( 'eumilitar-vite-client', EUMILITAR_VITE_DEV_SERVER . '/@vite/client', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_script( 'eumilitar-theme', EUMILITAR_VITE_DEV_SERVER . '/src/main.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_script_add_data( 'eumilitar-vite-client', 'type', 'module' );
		wp_script_add_data( 'eumilitar-theme', 'type', 'module' );
		return;
	}

	$entry = eumilitar_vite_manifest_entry( 'src/main.js' );

	if ( ! $entry || empty( $entry['file'] ) ) {
		return;
	}

	if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
		foreach ( $entry['css'] as $index => $css_file ) {
			wp_enqueue_style(
				'eumilitar-theme-' . $index,
				eumilitar_vite_asset_uri( $css_file ),
				array(),
				EUMILITAR_THEME_VERSION
			);
		}
	}

	wp_enqueue_script(
		'eumilitar-theme',
		eumilitar_vite_asset_uri( $entry['file'] ),
		array(),
		EUMILITAR_THEME_VERSION,
		true
	);
	wp_script_add_data( 'eumilitar-theme', 'type', 'module' );
}
add_action( 'wp_enqueue_scripts', 'eumilitar_enqueue_assets' );

/**
 * Enqueue block editor assets.
 */
function eumilitar_enqueue_editor_assets() {
	if ( eumilitar_vite_is_development() && eumilitar_vite_dev_server_is_running() ) {
		wp_enqueue_style( 'eumilitar-editor', EUMILITAR_VITE_DEV_SERVER . '/src/styles/editor.css', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		return;
	}

	$entry = eumilitar_vite_manifest_entry( 'src/editor.js' );

	if ( ! $entry || empty( $entry['file'] ) ) {
		return;
	}

	if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
		foreach ( $entry['css'] as $index => $css_file ) {
			wp_enqueue_style(
				'eumilitar-editor-' . $index,
				eumilitar_vite_asset_uri( $css_file ),
				array(),
				EUMILITAR_THEME_VERSION
			);
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'eumilitar_enqueue_editor_assets' );

/**
 * Determine if the current admin screen is the block-based widgets editor.
 *
 * @return bool
 */
function eumilitar_is_widgets_editor_screen() {
	if ( ! function_exists( 'get_current_screen' ) ) {
		return false;
	}

	$screen = get_current_screen();

	if ( ! $screen ) {
		return false;
	}

	return in_array( $screen->id, array( 'widgets', 'customize' ), true );
}

/**
 * Remove third-party block editor scripts that enqueue deprecated widget-editor dependencies.
 *
 * Elementor AI currently enqueues `wp-editor` through `elementor-ai-gutenberg`.
 * WordPress warns against loading that dependency in the block widgets editor.
 *
 * @return void
 */
function eumilitar_dequeue_widgets_editor_incompatible_scripts() {
	if ( ! eumilitar_is_widgets_editor_screen() ) {
		return;
	}

	wp_dequeue_script( 'elementor-ai-gutenberg' );
}
add_action( 'enqueue_block_editor_assets', 'eumilitar_dequeue_widgets_editor_incompatible_scripts', 100 );
