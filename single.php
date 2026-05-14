<?php
/**
 * Single post template.
 *
 * @package EuMilitar
 */

get_header();
?>

<main id="primary" class="site-main site-main--single">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'single' );

		eumilitar_render_widget_area( 'after-post-content' );

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>

<?php
get_footer();
