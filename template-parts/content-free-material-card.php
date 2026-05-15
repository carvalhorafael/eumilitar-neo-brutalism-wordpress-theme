<?php
/**
 * Template part for free material cards.
 *
 * @package EuMilitar
 */

$material_excerpt = eumilitar_get_listing_excerpt();
$material_terms   = get_the_terms( get_the_ID(), EUMILITAR_FREE_MATERIAL_TAXONOMY );
$material_slugs   = array();

if ( is_array( $material_terms ) ) {
	$material_slugs = wp_list_pluck( $material_terms, 'slug' );
}
?>

<article
	id="post-<?php the_ID(); ?>"
	<?php post_class( 'free-material-card ds-card' ); ?>
	data-free-material-card
	data-categories="<?php echo esc_attr( implode( ' ', $material_slugs ) ); ?>"
>
	<a class="free-material-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'class' => 'free-material-card__image' ) ); ?>
		<?php else : ?>
			<span class="free-material-card__placeholder">
				<span class="free-material-card__placeholder-kicker"><?php esc_html_e( 'Material', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
				<span class="free-material-card__placeholder-title"><?php esc_html_e( 'Gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
			</span>
		<?php endif; ?>
	</a>

	<div class="free-material-card__body">
		<?php eumilitar_render_free_material_terms(); ?>

		<h2 class="free-material-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php if ( $material_excerpt ) : ?>
			<p class="free-material-card__excerpt"><?php echo esc_html( $material_excerpt ); ?></p>
		<?php endif; ?>

		<a class="ds-button ds-button--secondary free-material-card__link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Ver material', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
		</a>
	</div>
</article>
