<?php
/**
 * CTA pattern partial.
 *
 * Expected $args:
 * - variant
 * - badge
 * - headline
 * - supporting_copy
 * - primary_cta
 * - secondary_cta
 *
 * @package EuMilitar
 */

$variant         = $args['variant'] ?? 'brand-dark';
$badge           = $args['badge'] ?? null;
$headline        = $args['headline'] ?? '';
$supporting_copy = $args['supporting_copy'] ?? '';
$primary_cta     = $args['primary_cta'] ?? array();
$secondary_cta   = $args['secondary_cta'] ?? null;
?>

<section class="ds-cta ds-cta--<?php echo esc_attr( $variant ); ?>">
	<?php
	if ( $badge ) {
		eumilitar_render_badge( $badge );
	}
	?>

	<h2 class="ds-cta__title"><?php echo esc_html( $headline ); ?></h2>

	<?php if ( $supporting_copy ) : ?>
		<p class="ds-cta__body"><?php echo esc_html( $supporting_copy ); ?></p>
	<?php endif; ?>

	<div class="ds-cta__actions">
		<?php eumilitar_render_action( $primary_cta ); ?>
		<?php
		if ( $secondary_cta ) {
			eumilitar_render_action( $secondary_cta );
		}
		?>
	</div>
</section>

