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

/**
 * Determine if a post contains EuMilitar design-system blocks or patterns.
 *
 * @param int|null $post_id Post ID.
 * @return bool
 */
function eumilitar_post_uses_design_system_patterns( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );

	if ( ! is_string( $content ) || '' === $content ) {
		return false;
	}

	return false !== strpos( $content, 'eumilitar/' ) || false !== strpos( $content, 'ds-' );
}

/**
 * Render post metadata for editorial templates.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function eumilitar_render_post_meta( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( ! $post_id ) {
		return;
	}

	$categories = get_the_category_list( esc_html_x( ', ', 'category list separator', 'eumilitar-neo-brutalism-wordpress-theme' ), '', $post_id );
	?>
	<ul class="entry-meta" aria-label="<?php esc_attr_e( 'Informações do artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
		<li class="entry-meta__item">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>">
				<?php echo esc_html( get_the_date( '', $post_id ) ); ?>
			</time>
		</li>
		<li class="entry-meta__item">
			<?php
			printf(
				/* translators: %s: post author name. */
				esc_html__( 'Por %s', 'eumilitar-neo-brutalism-wordpress-theme' ),
				esc_html( get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) ) )
			);
			?>
		</li>
		<?php if ( $categories ) : ?>
			<li class="entry-meta__item entry-meta__item--categories">
				<?php echo wp_kses_post( $categories ); ?>
			</li>
		<?php endif; ?>
	</ul>
	<?php
}

/**
 * Render category and tag links for the single post footer.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function eumilitar_render_post_taxonomy( $post_id = null ) {
	$post_id    = $post_id ? $post_id : get_the_ID();
	$categories = get_the_category_list( esc_html_x( ', ', 'category list separator', 'eumilitar-neo-brutalism-wordpress-theme' ), '', $post_id );
	$tags       = get_the_tag_list( '', esc_html_x( ', ', 'tag list separator', 'eumilitar-neo-brutalism-wordpress-theme' ), '', $post_id );

	if ( ! $categories && ! $tags ) {
		return;
	}
	?>
	<footer class="entry-taxonomy" aria-label="<?php esc_attr_e( 'Tópicos do artigo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
		<?php if ( $categories ) : ?>
			<div class="entry-taxonomy__group">
				<span class="entry-taxonomy__label"><?php esc_html_e( 'Categorias', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
				<span class="entry-taxonomy__links"><?php echo wp_kses_post( $categories ); ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $tags ) : ?>
			<div class="entry-taxonomy__group">
				<span class="entry-taxonomy__label"><?php esc_html_e( 'Tags', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
				<span class="entry-taxonomy__links"><?php echo wp_kses_post( $tags ); ?></span>
			</div>
		<?php endif; ?>
	</footer>
	<?php
}

/**
 * Render posts pagination using the design-system pagination primitive.
 *
 * @return void
 */
function eumilitar_render_posts_pagination() {
	global $wp_query;

	$total_pages  = isset( $wp_query->max_num_pages ) ? (int) $wp_query->max_num_pages : 1;
	$current_page = max( 1, (int) get_query_var( 'paged' ) );

	if ( $total_pages <= 1 ) {
		return;
	}
	?>
	<nav class="ds-pagination posts-pagination" aria-label="<?php esc_attr_e( 'Paginação de artigos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
		<?php if ( $current_page > 1 ) : ?>
			<a class="ds-pagination__item" href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Página anterior', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
				<?php esc_html_e( 'Anterior', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
			</a>
		<?php else : ?>
			<span class="ds-pagination__item" aria-disabled="true"><?php esc_html_e( 'Anterior', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<?php endif; ?>

		<div class="ds-pagination__pages">
			<?php for ( $page = 1; $page <= $total_pages; $page++ ) : ?>
				<?php if ( $page === $current_page ) : ?>
					<span class="ds-pagination__item" aria-current="page"><?php echo esc_html( (string) $page ); ?></span>
				<?php else : ?>
					<a class="ds-pagination__item" href="<?php echo esc_url( get_pagenum_link( $page ) ); ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Página', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
						<?php echo esc_html( (string) $page ); ?>
					</a>
				<?php endif; ?>
			<?php endfor; ?>
		</div>

		<?php if ( $current_page < $total_pages ) : ?>
			<a class="ds-pagination__item" href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>" aria-label="<?php esc_attr_e( 'Próxima página', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
				<?php esc_html_e( 'Próxima', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
			</a>
		<?php else : ?>
			<span class="ds-pagination__item" aria-disabled="true"><?php esc_html_e( 'Próxima', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<?php endif; ?>
	</nav>
	<?php
}
