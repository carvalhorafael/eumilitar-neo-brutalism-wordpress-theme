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

/**
 * Capture the HTML output of a pattern PHP file.
 *
 * @param string $file Pattern file path.
 * @return string
 */
function eumilitar_get_pattern_content( $file ) {
	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;
	return trim( ob_get_clean() );
}

/**
 * Register EuMilitar block patterns explicitly for classic theme compatibility.
 */
function eumilitar_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	$patterns = array(
		'hero'         => array(
			'title'       => __( 'Hero EuMilitar', 'eumilitar' ),
			'description' => __( 'Hero canônico baseado no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'urgency'      => array(
			'title'       => __( 'Urgência EuMilitar', 'eumilitar' ),
			'description' => __( 'Bloco de urgência baseado no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'benefits'     => array(
			'title'       => __( 'Benefícios EuMilitar', 'eumilitar' ),
			'description' => __( 'Grade de benefícios baseada no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'testimonials' => array(
			'title'       => __( 'Depoimentos EuMilitar', 'eumilitar' ),
			'description' => __( 'Depoimentos baseados no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'capture'      => array(
			'title'       => __( 'Captação EuMilitar', 'eumilitar' ),
			'description' => __( 'Formulário de captação baseado no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'faq'          => array(
			'title'       => __( 'FAQ EuMilitar', 'eumilitar' ),
			'description' => __( 'FAQ com accordion progressivo do EuMilitar Design System.', 'eumilitar' ),
		),
		'cta'          => array(
			'title'       => __( 'CTA EuMilitar', 'eumilitar' ),
			'description' => __( 'CTA final baseado no contrato do EuMilitar Design System.', 'eumilitar' ),
		),
		'landing-page' => array(
			'title'       => __( 'Landing Page EuMilitar', 'eumilitar' ),
			'description' => __( 'Composição inicial com todos os blocos do EuMilitar Design System.', 'eumilitar' ),
		),
	);

	foreach ( $patterns as $slug => $metadata ) {
		$content = eumilitar_get_pattern_content( EUMILITAR_THEME_DIR . '/patterns/' . $slug . '.php' );

		if ( '' === $content ) {
			continue;
		}

		register_block_pattern(
			'eumilitar/' . $slug,
			array(
				'title'       => $metadata['title'],
				'description' => $metadata['description'],
				'categories'  => array( 'eumilitar' ),
				'content'     => $content,
			)
		);
	}
}
add_action( 'init', 'eumilitar_register_block_patterns', 20 );
