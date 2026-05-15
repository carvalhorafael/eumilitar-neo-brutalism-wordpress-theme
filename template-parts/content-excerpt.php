<?php
/**
 * Template part for post excerpts in blog listings.
 *
 * @package EuMilitar
 */

$listing_excerpt = eumilitar_get_listing_excerpt();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card ds-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'large', array( 'class' => 'post-card__image' ) ); ?>
		</a>
	<?php else : ?>
		<a
			class="post-card__media post-card__media--placeholder"
			href="<?php the_permalink(); ?>"
			aria-label="<?php echo esc_attr( sprintf( /* translators: %s: post title. */ __( 'Abrir artigo: %s', 'eumilitar-neo-brutalism-wordpress-theme' ), the_title_attribute( array( 'echo' => false ) ) ) ); ?>"
		>
			<span class="post-card__placeholder-kicker"><?php esc_html_e( 'EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
			<span class="post-card__placeholder-title"><?php esc_html_e( 'Artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		</a>
	<?php endif; ?>

	<div class="post-card__body">
		<?php eumilitar_render_post_meta(); ?>

		<h2 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<?php if ( $listing_excerpt ) : ?>
			<div class="post-card__excerpt">
				<p><?php echo esc_html( $listing_excerpt ); ?></p>
			</div>
		<?php endif; ?>

		<a class="ds-button ds-button--secondary post-card__link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Ler artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
		</a>
	</div>
</article>
