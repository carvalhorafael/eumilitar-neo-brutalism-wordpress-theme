<?php
/**
 * Template part for single posts.
 *
 * @package EuMilitar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-entry' ); ?>>
	<header class="single-post-entry__header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<?php the_title( '<h1 class="single-post-entry__title">', '</h1>' ); ?>
		<?php eumilitar_render_post_meta(); ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="single-post-entry__media">
			<?php the_post_thumbnail( 'large', array( 'class' => 'single-post-entry__image' ) ); ?>
		</figure>
	<?php endif; ?>

	<div class="single-post-entry__content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links">' . esc_html__( 'Páginas:', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'after'  => '</nav>',
			)
		);
		?>
	</div>
</article>

<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegação entre artigos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
	<div class="post-navigation__item post-navigation__item--previous">
		<?php
		previous_post_link(
			'%link',
			'<span class="post-navigation__label">' . esc_html__( 'Artigo anterior', 'eumilitar-neo-brutalism-wordpress-theme' ) . '</span><span class="post-navigation__title">%title</span>',
			false,
			'',
			'category'
		);
		?>
	</div>
	<div class="post-navigation__item post-navigation__item--next">
		<?php
		next_post_link(
			'%link',
			'<span class="post-navigation__label">' . esc_html__( 'Próximo artigo', 'eumilitar-neo-brutalism-wordpress-theme' ) . '</span><span class="post-navigation__title">%title</span>',
			false,
			'',
			'category'
		);
		?>
	</div>
</nav>
