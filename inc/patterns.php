<?php
/**
 * Block pattern registration.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme pattern categories.
 */
function eumilitar_register_pattern_categories() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'eumilitar',
			array(
				'label' => esc_html__( 'EuMilitar', 'eumilitar' ),
			)
		);
	}
}
add_action( 'init', 'eumilitar_register_pattern_categories' );

