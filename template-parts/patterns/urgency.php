<?php
/**
 * Urgency pattern partial.
 *
 * @package EuMilitar
 */

$variant         = $args['variant'] ?? 'max-conversion-cta';
$badge           = $args['badge'] ?? null;
$headline        = $args['headline'] ?? '';
$supporting_copy = $args['supporting_copy'] ?? '';
$primary_cta     = $args['primary_cta'] ?? array();
$secondary_cta   = $args['secondary_cta'] ?? null;
$stat            = $args['stat'] ?? null;
?>

<section class="ds-urgency ds-urgency--<?php echo esc_attr( $variant ); ?>">
	<?php
	if ( $badge ) {
		eumilitar_render_badge( $badge );
	}
	?>

	<h2 class="ds-urgency__title"><?php echo esc_html( $headline ); ?></h2>
	<p class="ds-urgency__body"><?php echo esc_html( $supporting_copy ); ?></p>

	<?php
	if ( $stat ) {
		eumilitar_render_stat( $stat, 'ds-urgency' );
	}
	?>

	<div class="ds-urgency__actions">
		<?php eumilitar_render_action( $primary_cta ); ?>
		<?php
		if ( $secondary_cta ) {
			eumilitar_render_action( $secondary_cta );
		}
		?>
	</div>
</section>

