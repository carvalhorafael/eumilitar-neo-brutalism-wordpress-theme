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

