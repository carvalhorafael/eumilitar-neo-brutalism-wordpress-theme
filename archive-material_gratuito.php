<?php
/**
 * Free material archive template.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main site-main--free-materials">
	<header class="free-materials-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Materiais gratuitos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="free-materials-header__title"><?php esc_html_e( 'Materiais gratuitos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h1>
		<p class="free-materials-header__description"><?php esc_html_e( 'Guias, checklists e conteúdos de apoio para organizar sua preparação.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
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
				'description'   => __( 'Novos materiais serão publicados em breve.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_label' => __( 'Voltar para o início', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_url'   => home_url( '/' ),
				'show_search'   => false,
				'title'         => __( 'Nenhum material gratuito encontrado', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);
		?>
	<?php endif; ?>
</main>

<?php
get_footer();
