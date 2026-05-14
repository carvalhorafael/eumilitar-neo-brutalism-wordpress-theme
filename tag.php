<?php
/**
 * Tag archive template.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main site-main--archive">
	<header class="blog-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Tag', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="blog-header__title"><?php single_tag_title(); ?></h1>
		<?php if ( tag_description() ) : ?>
			<div class="blog-header__description"><?php echo wp_kses_post( tag_description() ); ?></div>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="post-list">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'excerpt' );
			endwhile;
			?>
		</div>

		<?php eumilitar_render_posts_pagination(); ?>
	<?php else : ?>
		<section class="site-empty">
			<h2><?php esc_html_e( 'Nenhum artigo com esta tag', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h2>
			<p><?php esc_html_e( 'Quando novos conteúdos forem publicados, eles aparecerão aqui.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
		</section>
	<?php endif; ?>
</main>

<?php
get_footer();
