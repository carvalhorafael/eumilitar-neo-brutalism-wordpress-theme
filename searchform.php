<?php
/**
 * Search form template.
 *
 * @package EuMilitar
 */

$unique_id = wp_unique_id( 'search-field-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Pesquisar por:', 'label', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<input
			type="search"
			id="<?php echo esc_attr( $unique_id ); ?>"
			class="search-field"
			placeholder="<?php echo esc_attr_x( 'Pesquisar no blog', 'placeholder', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			name="s"
		>
	</label>
	<button type="submit" class="search-submit">
		<?php echo esc_html_x( 'Pesquisar', 'submit button', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
	</button>
</form>
