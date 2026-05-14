<?php
/**
 * Blog posts index template.
 *
 * @package EuMilitar
 */

get_header();

$posts_page_id     = (int) get_option( 'page_for_posts' );
$posts_page_title  = $posts_page_id ? get_the_title( $posts_page_id ) : '';
$posts_index_title = $posts_page_title ? $posts_page_title : __( 'Artigos', 'eumilitar-neo-brutalism-wordpress-theme' );
$blog_description  = $posts_page_id ? get_the_excerpt( $posts_page_id ) : get_bloginfo( 'description' );
?>

<main id="primary" class="site-main site-main--blog">
	<header class="blog-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Blog EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="blog-header__title"><?php echo esc_html( $posts_index_title ); ?></h1>
		<?php if ( $blog_description ) : ?>
			<p class="blog-header__description"><?php echo esc_html( $blog_description ); ?></p>
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
		<?php
		eumilitar_render_editorial_empty_state(
			array(
				'description' => __( 'Quando novos conteúdos forem publicados, eles aparecerão nesta página.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'show_search' => false,
				'title'       => __( 'Nenhum artigo publicado ainda', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);
		?>
	<?php endif; ?>
</main>

<?php
get_footer();
