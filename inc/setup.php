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

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Menu principal', 'eumilitar-neo-brutalism-wordpress-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'eumilitar_theme_setup' );
