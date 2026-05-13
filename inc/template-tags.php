<?php
/**
 * Shared template helpers.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a design-system badge.
 *
 * @param array{label:string,variant?:string} $badge Badge data.
 * @return void
 */
function eumilitar_render_badge( $badge ) {
	$variant = ! empty( $badge['variant'] ) ? $badge['variant'] : 'default';
	?>
	<span class="ds-badge ds-badge--<?php echo esc_attr( $variant ); ?>"><?php echo esc_html( $badge['label'] ?? '' ); ?></span>
	<?php
}

/**
 * Render a design-system action link.
 *
 * @param array{label:string,href:string,variant?:string} $action Action data.
 * @return void
 */
function eumilitar_render_action( $action ) {
	$variant = ! empty( $action['variant'] ) ? $action['variant'] : 'primary';
	?>
	<a class="ds-button ds-button--<?php echo esc_attr( $variant ); ?>" href="<?php echo esc_url( $action['href'] ?? '#' ); ?>">
		<?php echo esc_html( $action['label'] ?? '' ); ?>
	</a>
	<?php
}

/**
 * Render a stat item for a design-system pattern.
 *
 * @param array{value:string,label:string} $stat Stat data.
 * @param string                           $block_class Base block class.
 * @return void
 */
function eumilitar_render_stat( $stat, $block_class ) {
	?>
	<div class="<?php echo esc_attr( $block_class ); ?>__stat">
		<strong class="<?php echo esc_attr( $block_class ); ?>__stat-value"><?php echo esc_html( $stat['value'] ?? '' ); ?></strong>
		<span class="<?php echo esc_attr( $block_class ); ?>__stat-label"><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
	</div>
	<?php
}

/**
 * Render a design-system form field.
 *
 * @param array<string, mixed> $field Field data.
 * @return void
 */
function eumilitar_render_form_field( $field ) {
	$id             = $field['id'] ?? '';
	$type           = $field['type'] ?? 'text';
	$required       = ! empty( $field['required'] );
	$required_label = $required ? ' *' : '';
	?>
	<label class="ds-input__label" for="<?php echo esc_attr( $id ); ?>">
		<?php echo esc_html( ( $field['label'] ?? '' ) . $required_label ); ?>
	</label>
	<?php if ( 'textarea' === $type ) : ?>
		<textarea class="ds-input__field" id="<?php echo esc_attr( $id ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>"<?php echo $required ? ' required' : ''; ?>></textarea>
	<?php elseif ( 'select' === $type ) : ?>
		<select class="ds-select__field" id="<?php echo esc_attr( $id ); ?>"<?php echo $required ? ' required' : ''; ?>>
			<?php foreach ( $field['options'] ?? array() as $option ) : ?>
				<option value="<?php echo esc_attr( $option['value'] ?? '' ); ?>"><?php echo esc_html( $option['label'] ?? '' ); ?></option>
			<?php endforeach; ?>
		</select>
	<?php else : ?>
		<input class="ds-input__field" id="<?php echo esc_attr( $id ); ?>" type="<?php echo esc_attr( $type ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>"<?php echo $required ? ' required' : ''; ?>>
	<?php endif; ?>
	<?php
}

