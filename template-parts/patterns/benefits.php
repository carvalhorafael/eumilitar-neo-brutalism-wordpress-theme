<?php
/**
 * Benefits pattern partial.
 *
 * @package EuMilitar
 */

$variant     = $args['variant'] ?? 'icon-grid';
$headline    = $args['headline'] ?? '';
$items       = $args['items'] ?? array();
$primary_cta = $args['primary_cta'] ?? null;
$stats       = $args['stats'] ?? array();
?>

<section class="ds-benefits ds-benefits--<?php echo esc_attr( $variant ); ?>">
	<h2 class="ds-benefits__title"><?php echo esc_html( $headline ); ?></h2>

	<div class="ds-benefits__grid">
		<?php foreach ( $items as $item ) : ?>
			<article class="ds-benefits__item">
				<h3 class="ds-benefits__item-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
				<p class="ds-benefits__item-body"><?php echo esc_html( $item['description'] ?? '' ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( $stats ) : ?>
		<div class="ds-benefits__stats">
			<?php
			foreach ( $stats as $stat ) {
				eumilitar_render_stat( $stat, 'ds-benefits' );
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

