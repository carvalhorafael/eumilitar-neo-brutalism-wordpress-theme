<?php
/**
 * Free material category archive template.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main site-main--free-materials">
	<header class="free-materials-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Categoria', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="free-materials-header__title"><?php single_term_title(); ?></h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="free-materials-header__description"><?php the_archive_description(); ?></div>
		<?php endif; ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="free-material-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'free-material-card' );
			endwhile;
			?>
		</div>

		<?php eumilitar_render_posts_pagination(); ?>
	<?php else : ?>
		<?php
		eumilitar_render_editorial_empty_state(
			array(
				'description'   => __( 'Tente navegar por outra categoria de material gratuito.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_label' => __( 'Ver todos os materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_url'   => get_post_type_archive_link( EUMILITAR_FREE_MATERIAL_POST_TYPE ),
				'show_search'   => false,
				'title'         => __( 'Nenhum material encontrado nesta categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);
		?>
	<?php endif; ?>
</main>

<?php
get_footer();
