<?php
/**
 * Template part for post excerpts in blog listings.
 *
 * @package EuMilitar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card ds-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'large', array( 'class' => 'post-card__image' ) ); ?>
		</a>
	<?php endif; ?>

	<div class="post-card__body">
		<?php eumilitar_render_post_meta(); ?>

		<h2 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<div class="post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a class="ds-button ds-button--secondary post-card__link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Ler artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
		</a>
	</div>
</article>
