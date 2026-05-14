<?php
/**
 * Page template.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main site-main--page">
	<?php
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
		<?php
	endwhile;
	?>
</main>

<?php
get_footer();
