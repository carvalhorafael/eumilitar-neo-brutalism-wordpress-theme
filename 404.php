<?php
/**
 * 404 template.
 *
 * @package EuMilitar
 */

get_header();

$posts_page_id = (int) get_option( 'page_for_posts' );
$blog_url      = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
?>

<main id="primary" class="site-main site-main--error">
	<section class="error-page">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( '404', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="error-page__title"><?php esc_html_e( 'Página não encontrada', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h1>
		<p class="error-page__description"><?php esc_html_e( 'O endereço acessado não existe ou foi movido. Você pode buscar outro conteúdo ou voltar para os artigos.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>

		<div class="error-page__actions">
			<?php get_search_form(); ?>
			<a class="ds-button ds-button--primary" href="<?php echo esc_url( $blog_url ); ?>">
				<?php esc_html_e( 'Ver artigos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
			</a>
		</div>
	</section>
</main>

<?php
get_footer();
