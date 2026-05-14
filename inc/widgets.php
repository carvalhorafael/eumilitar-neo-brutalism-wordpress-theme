<?php
/**
 * Widget areas and rendering helpers.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register editable widget areas for the theme.
 *
 * @return void
 */
function eumilitar_register_widget_areas() {
	$shared_args = array(
		'after_sidebar' => '</aside>',
		'after_title'   => '</h2>',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget__title">',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'show_in_rest'  => true,
	);

	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'before_sidebar' => '<aside id="%1$s" class="widget-area widget-area--blog %2$s" aria-label="' . esc_attr__( 'Barra lateral do blog', 'eumilitar-neo-brutalism-wordpress-theme' ) . '">',
				'description'    => esc_html__( 'Widgets exibidos nas listagens do blog, arquivos, categorias, tags e busca.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'id'             => 'blog-sidebar',
				'name'           => esc_html__( 'Barra lateral do blog', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		)
	);

	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'before_sidebar' => '<aside id="%1$s" class="widget-area widget-area--after-post %2$s" aria-label="' . esc_attr__( 'Após o artigo', 'eumilitar-neo-brutalism-wordpress-theme' ) . '">',
				'description'    => esc_html__( 'Widgets exibidos após o conteúdo do artigo e antes dos comentários.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'id'             => 'after-post-content',
				'name'           => esc_html__( 'Após o artigo', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		)
	);

	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'before_sidebar' => '<aside id="%1$s" class="widget-area widget-area--footer %2$s" aria-label="' . esc_attr__( 'Rodapé do site', 'eumilitar-neo-brutalism-wordpress-theme' ) . '">',
				'description'    => esc_html__( 'Widgets exibidos no rodapé do site.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'id'             => 'site-footer',
				'name'           => esc_html__( 'Rodapé do site', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		)
	);
}
add_action( 'widgets_init', 'eumilitar_register_widget_areas' );

/**
 * Render a widget area only when it has assigned widgets.
 *
 * @param string               $id Widget area ID.
 * @param array<string,string> $args Optional wrapper arguments.
 * @return bool True when the area rendered.
 */
function eumilitar_render_widget_area( $id, $args = array() ) {
	if ( ! is_active_sidebar( $id ) ) {
		return false;
	}

	$classes = array( 'widget-area-shell' );

	if ( ! empty( $args['class'] ) ) {
		$classes[] = $args['class'];
	}

	?>
	<div class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>">
		<?php dynamic_sidebar( $id ); ?>
	</div>
	<?php

	return true;
}
