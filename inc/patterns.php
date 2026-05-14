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
			'eumilitar-neo-brutalism-wordpress-theme',
			array(
				'label' => esc_html__( 'EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
		'hero'            => array(
			'title'       => __( 'Hero EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Hero canônico baseado no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'urgency'         => array(
			'title'       => __( 'Urgência EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Bloco de urgência baseado no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'benefits'        => array(
			'title'       => __( 'Benefícios EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Grade de benefícios baseada no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'testimonials'    => array(
			'title'       => __( 'Depoimentos EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Depoimentos baseados no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'capture'         => array(
			'title'       => __( 'Captação EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Formulário de captação baseado no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'faq'             => array(
			'title'       => __( 'FAQ EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'FAQ com accordion progressivo do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'cta'             => array(
			'title'       => __( 'CTA EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'CTA final baseado no contrato do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'landing-page'    => array(
			'title'       => __( 'Landing Page EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Composição inicial com todos os blocos do EuMilitar Design System.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'sidebar-blog'    => array(
			'title'       => __( 'Sidebar do blog EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Composição inicial para a barra lateral editorial do blog.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'after-post-cta'  => array(
			'title'       => __( 'CTA após artigo EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Chamada horizontal para uso após o conteúdo de artigos.', 'eumilitar-neo-brutalism-wordpress-theme' ),
		),
		'capture-compact' => array(
			'title'       => __( 'Captação compacta EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'description' => __( 'Formulário compacto para widgets e áreas estreitas.', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
				'categories'  => array( 'eumilitar-neo-brutalism-wordpress-theme' ),
				'content'     => $content,
			)
		);
	}
}
add_action( 'init', 'eumilitar_register_block_patterns', 20 );
