<?php
/**
 * Testimonials pattern partial.
 *
 * @package EuMilitar
 */

$variant     = $args['variant'] ?? 'grid';
$eyebrow     = $args['eyebrow'] ?? '';
$headline    = $args['headline'] ?? '';
$items       = $args['items'] ?? array();
$primary_cta = $args['primary_cta'] ?? null;
$stats       = $args['stats'] ?? array();
?>

<section class="ds-testimonials ds-testimonials--<?php echo esc_attr( $variant ); ?>">
	<?php if ( $eyebrow ) : ?>
		<p class="ds-testimonials__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>

	<h2 class="ds-testimonials__title"><?php echo esc_html( $headline ); ?></h2>

	<div class="ds-testimonials__grid">
		<?php foreach ( $items as $item ) : ?>
			<article class="ds-testimonials__item">
				<blockquote class="ds-testimonials__quote"><?php echo esc_html( $item['quote'] ?? '' ); ?></blockquote>
				<p class="ds-testimonials__author"><?php echo esc_html( $item['author'] ?? '' ); ?></p>
				<?php if ( ! empty( $item['meta'] ) ) : ?>
					<p class="ds-testimonials__meta"><?php echo esc_html( $item['meta'] ); ?></p>
				<?php endif; ?>
				<?php
				if ( ! empty( $item['badge'] ) ) {
					eumilitar_render_badge( $item['badge'] );
				}
				?>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( $stats ) : ?>
		<div class="ds-testimonials__stats">
			<?php
			foreach ( $stats as $stat ) {
				eumilitar_render_stat( $stat, 'ds-testimonials' );
			}
			?>
		</div>
	<?php endif; ?>

	<?php
	if ( $primary_cta ) {
		eumilitar_render_action( $primary_cta );
	}
	?>
</section>

