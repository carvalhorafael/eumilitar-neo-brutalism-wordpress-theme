<?php
/**
 * Template part for a single free material capture page.
 *
 * @package EuMilitar
 */

$material_cta = eumilitar_get_free_material_cta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'free-material-single' ); ?>>
	<header class="free-material-single__hero">
		<div class="free-material-single__intro">
			<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
			<?php the_title( '<h1 class="free-material-single__title">', '</h1>' ); ?>
			<?php eumilitar_render_free_material_terms(); ?>

			<?php if ( has_excerpt() ) : ?>
				<p class="free-material-single__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<a class="ds-button ds-button--primary free-material-single__cta" href="<?php echo esc_url( $material_cta['url'] ); ?>">
				<?php echo esc_html( $material_cta['label'] ); ?>
			</a>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="free-material-single__media">
				<?php the_post_thumbnail( 'large', array( 'class' => 'free-material-single__image' ) ); ?>
			</figure>
		<?php endif; ?>
	</header>

	<div class="free-material-single__content">
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

	<section id="captura" class="free-material-capture" aria-labelledby="free-material-capture-title">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Próximo passo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h2 id="free-material-capture-title"><?php esc_html_e( 'Receba o material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h2>
		<p><?php esc_html_e( 'Acesse o conteúdo e continue sua preparação com um caminho mais objetivo.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
		<a class="ds-button ds-button--primary" href="<?php echo esc_url( $material_cta['url'] ); ?>">
			<?php echo esc_html( $material_cta['label'] ); ?>
		</a>
	</section>
</article>
