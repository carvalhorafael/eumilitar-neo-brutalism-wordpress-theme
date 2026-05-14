<?php
/**
 * Archive template.
 *
 * @package EuMilitar
 */

get_header();

$has_blog_sidebar = is_active_sidebar( 'blog-sidebar' );
?>

<main id="primary" class="site-main site-main--archive<?php echo $has_blog_sidebar ? ' site-main--with-sidebar' : ''; ?>">
	<header class="blog-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Arquivo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="blog-header__title"><?php the_archive_title(); ?></h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="blog-header__description"><?php the_archive_description(); ?></div>
		<?php endif; ?>
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
						'description' => __( 'Tente navegar por outra categoria ou fazer uma busca.', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'title'       => __( 'Nenhum artigo encontrado', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
