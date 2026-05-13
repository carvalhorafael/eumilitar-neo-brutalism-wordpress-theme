<?php
/**
 * Hero pattern partial.
 *
 * Expected $args:
 * - variant
 * - eyebrow
 * - badges
 * - headline
 * - supporting_copy
 * - primary_cta
 * - secondary_cta
 * - urgency_alert
 *
 * @package EuMilitar
 */

$variant         = $args['variant'] ?? 'light';
$eyebrow         = $args['eyebrow'] ?? '';
$badges          = $args['badges'] ?? array();
$headline        = $args['headline'] ?? '';
$supporting_copy = $args['supporting_copy'] ?? '';
$primary_cta     = $args['primary_cta'] ?? array();
$secondary_cta   = $args['secondary_cta'] ?? null;
$urgency_alert   = $args['urgency_alert'] ?? '';
?>

<section class="ds-hero ds-hero--<?php echo esc_attr( $variant ); ?>">
	<?php if ( $eyebrow ) : ?>
		<p class="ds-hero__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>

	<?php if ( $badges ) : ?>
		<div class="ds-hero__badges">
			<?php
			foreach ( $badges as $badge ) {
				eumilitar_render_badge( $badge );
			}
			?>
		</div>
	<?php endif; ?>

	<h1 class="ds-hero__title"><?php echo esc_html( $headline ); ?></h1>
	<p class="ds-hero__body"><?php echo esc_html( $supporting_copy ); ?></p>

	<div class="ds-hero__actions">
		<?php eumilitar_render_action( $primary_cta ); ?>
		<?php
		if ( $secondary_cta ) {
			eumilitar_render_action( $secondary_cta );
		}
		?>
	</div>

	<?php if ( $urgency_alert ) : ?>
		<div class="ds-alert ds-alert--urgent ds-hero__alert"><?php echo esc_html( $urgency_alert ); ?></div>
	<?php endif; ?>
</section>

