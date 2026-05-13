<?php
/**
 * Main template file.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$entry_classes = array( 'site-entry' );

			if ( eumilitar_post_uses_design_system_patterns() ) {
				$entry_classes[] = 'site-entry--design-system';
			}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( $entry_classes ); ?>>
				<header class="site-entry__header">
					<?php the_title( '<h1 class="site-entry__title">', '</h1>' ); ?>
				</header>

				<div class="site-entry__content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
	else :
		?>
		<section class="site-empty">
			<h1><?php esc_html_e( 'Conteúdo não encontrado', 'eumilitar' ); ?></h1>
		</section>
		<?php
	endif;
	?>
</main>

<?php
get_footer();
