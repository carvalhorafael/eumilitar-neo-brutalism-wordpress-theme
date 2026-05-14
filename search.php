<?php
/**
 * Search results template.
 *
 * @package EuMilitar
 */

get_header();

$search_query     = get_search_query();
$has_blog_sidebar = is_active_sidebar( 'blog-sidebar' );
?>

<main id="primary" class="site-main site-main--search<?php echo $has_blog_sidebar ? ' site-main--with-sidebar' : ''; ?>">
	<header class="blog-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Busca', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="blog-header__title">
			<?php
			if ( $search_query ) {
				printf(
					/* translators: %s: search query. */
					esc_html__( 'Resultados para %s', 'eumilitar-neo-brutalism-wordpress-theme' ),
					esc_html( $search_query )
				);
			} else {
				esc_html_e( 'Busca', 'eumilitar-neo-brutalism-wordpress-theme' );
			}
			?>
		</h1>
		<p class="blog-header__description"><?php esc_html_e( 'Encontre artigos e orientações publicados no blog.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
		<?php get_search_form(); ?>
	</header>

	<div class="<?php echo $has_blog_sidebar ? 'content-sidebar-layout' : 'content-sidebar-layout content-sidebar-layout--single'; ?>">
		<div class="content-sidebar-layout__main">
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
						'description' => __( 'Tente buscar por outro termo ou navegue pelos artigos recentes.', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'title'       => __( 'Nenhum resultado encontrado', 'eumilitar-neo-brutalism-wordpress-theme' ),
					)
				);
				?>
			<?php endif; ?>
		</div>
		<?php
		eumilitar_render_widget_area(
			'blog-sidebar',
			array(
				'class' => 'content-sidebar-layout__sidebar',
			)
		);
		?>
	</div>
</main>

<?php
get_footer();
