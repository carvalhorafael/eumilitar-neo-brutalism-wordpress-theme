<?php
/**
 * Capture pattern partial.
 *
 * @package EuMilitar
 */

$variant         = $args['variant'] ?? 'lead';
$eyebrow         = $args['eyebrow'] ?? '';
$headline        = $args['headline'] ?? '';
$supporting_copy = $args['supporting_copy'] ?? '';
$fields          = $args['fields'] ?? array();
$submit_label    = $args['submit_label'] ?? __( 'Enviar', 'eumilitar-neo-brutalism-wordpress-theme' );
?>

<section class="ds-capture ds-capture--<?php echo esc_attr( $variant ); ?>">
	<?php if ( $eyebrow ) : ?>
		<p class="ds-capture__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>

	<h2 class="ds-capture__title"><?php echo esc_html( $headline ); ?></h2>

	<?php if ( $supporting_copy ) : ?>
		<p class="ds-capture__body"><?php echo esc_html( $supporting_copy ); ?></p>
	<?php endif; ?>

	<form class="ds-capture__form" action="#" method="post">
		<?php
		foreach ( $fields as $field ) {
			eumilitar_render_form_field( $field );
		}
		?>
		<button class="ds-button ds-button--primary" type="submit"><?php echo esc_html( $submit_label ); ?></button>
	</form>
</section>

