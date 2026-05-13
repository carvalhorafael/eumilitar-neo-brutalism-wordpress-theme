<?php
/**
 * FAQ pattern partial.
 *
 * Expected $args:
 * - eyebrow
 * - headline
 * - items
 *
 * @package EuMilitar
 */

$eyebrow  = $args['eyebrow'] ?? '';
$headline = $args['headline'] ?? '';
$items    = $args['items'] ?? array();
?>

<section class="ds-faq">
	<?php if ( $eyebrow ) : ?>
		<p class="ds-faq__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>

	<h2 class="ds-faq__title"><?php echo esc_html( $headline ); ?></h2>

	<div class="ds-accordion" data-accordion-root>
		<?php foreach ( $items as $index => $item ) : ?>
			<?php $panel_id = 'ds-faq-panel-' . ( $index + 1 ); ?>
			<div class="ds-accordion__item" data-accordion-item>
				<button class="ds-accordion__trigger" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>" data-accordion-trigger>
					<?php echo esc_html( $item['question'] ?? '' ); ?>
				</button>
				<div class="ds-accordion__panel" id="<?php echo esc_attr( $panel_id ); ?>" hidden data-accordion-panel>
					<div class="ds-accordion__content"><?php echo esc_html( $item['answer'] ?? '' ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

