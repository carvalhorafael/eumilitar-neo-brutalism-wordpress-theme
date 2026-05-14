<?php
/**
 * Template part for compact post cards.
 *
 * @package EuMilitar
 */

$compact_post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();

if ( ! $compact_post_id ) {
	return;
}

?>

<article id="post-<?php echo esc_attr( (string) $compact_post_id ); ?>" <?php post_class( 'post-card-compact ds-card', $compact_post_id ); ?>>
	<?php eumilitar_render_post_meta( $compact_post_id ); ?>

	<h3 class="post-card-compact__title">
		<a href="<?php echo esc_url( get_permalink( $compact_post_id ) ); ?>"><?php echo esc_html( get_the_title( $compact_post_id ) ); ?></a>
	</h3>

	<a class="post-card-compact__link" href="<?php echo esc_url( get_permalink( $compact_post_id ) ); ?>">
		<?php esc_html_e( 'Ler artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
	</a>
</article>
