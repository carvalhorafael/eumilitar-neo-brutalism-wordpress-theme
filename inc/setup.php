<?php
/**
 * Theme setup.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and menus.
 */
function eumilitar_theme_setup() {
	load_theme_textdomain( 'eumilitar-neo-brutalism-wordpress-theme', EUMILITAR_THEME_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		)
	);
	add_editor_style( eumilitar_get_editor_stylesheets() );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Menu principal', 'eumilitar-neo-brutalism-wordpress-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'eumilitar_theme_setup' );

/**
 * Get stylesheets that should be loaded inside the block editor canvas.
 *
 * @return string[]
 */
function eumilitar_get_editor_stylesheets() {
	if ( function_exists( 'eumilitar_vite_manifest_entry' ) && function_exists( 'eumilitar_vite_asset_uri' ) ) {
		$entry = eumilitar_vite_manifest_entry( 'src/editor.js' );

		if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
			return array_map( 'eumilitar_vite_asset_uri', $entry['css'] );
		}
	}

	return array( get_stylesheet_uri() );
}
