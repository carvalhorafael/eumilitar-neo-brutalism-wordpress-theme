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
	endwhile;
	?>
</main>

<?php
get_footer();
