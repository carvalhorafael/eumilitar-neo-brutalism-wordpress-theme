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
 * Get the configured blog index URL.
 *
 * @return string
 */
function eumilitar_get_blog_url() {
	$posts_page_id = (int) get_option( 'page_for_posts' );

	if ( $posts_page_id ) {
		return get_permalink( $posts_page_id );
	}

	return home_url( '/' );
}

/**
 * Render fallback navigation when no WordPress menu is assigned.
 *
 * @return void
 */
function eumilitar_render_fallback_navigation() {
	?>
	<nav id="primary-menu-panel" class="site-navigation ds-navbar__panel site-navigation--fallback" aria-label="<?php esc_attr_e( 'Menu principal', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
		<ul id="primary-menu" class="menu">
			<li class="menu-item">
				<a class="ds-navbar__link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Início', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></a>
			</li>
			<li class="menu-item">
				<a class="ds-navbar__link" href="<?php echo esc_url( eumilitar_get_blog_url() ); ?>"><?php esc_html_e( 'Artigos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></a>
			</li>
		</ul>
	</nav>
	<?php
}

/**
 * Add the design-system navbar link class to primary menu anchors.
 *
 * @param array<string, string> $atts Anchor attributes.
 * @param WP_Post               $menu_item Menu item object.
 * @param stdClass              $args Menu arguments.
 * @return array<string, string>
 */
function eumilitar_primary_menu_link_attributes( $atts, $menu_item, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $atts;
	}

	$classes       = empty( $atts['class'] ) ? array() : explode( ' ', $atts['class'] );
	$classes[]     = 'ds-navbar__link';
	$atts['class'] = trim( implode( ' ', array_unique( array_filter( $classes ) ) ) );

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'eumilitar_primary_menu_link_attributes', 10, 3 );

/**
 * Render a reusable empty state for editorial templates.
 *
 * @param array{title:string,description:string,show_search?:bool,primary_label?:string,primary_url?:string} $args Empty state arguments.
 * @return void
 */
function eumilitar_render_editorial_empty_state( $args ) {
	$show_search   = isset( $args['show_search'] ) ? (bool) $args['show_search'] : true;
	$primary_label = ! empty( $args['primary_label'] ) ? $args['primary_label'] : __( 'Ver todos os artigos', 'eumilitar-neo-brutalism-wordpress-theme' );
	$primary_url   = ! empty( $args['primary_url'] ) ? $args['primary_url'] : eumilitar_get_blog_url();
	?>
	<section class="site-empty" aria-labelledby="site-empty-title">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Sem resultados', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h2 id="site-empty-title"><?php echo esc_html( $args['title'] ?? '' ); ?></h2>
		<p><?php echo esc_html( $args['description'] ?? '' ); ?></p>
		<div class="site-empty__actions">
			<a class="ds-button ds-button--secondary" href="<?php echo esc_url( $primary_url ); ?>">
				<?php echo esc_html( $primary_label ); ?>
			</a>
		</div>
		<?php if ( $show_search ) : ?>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</section>
	<?php
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

	$links = paginate_links(
		array(
			'current'   => $current_page,
			'mid_size'  => 1,
			'next_text' => esc_html__( 'Próxima', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'prev_text' => esc_html__( 'Anterior', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'total'     => $total_pages,
			'type'      => 'array',
		)
	);

	if ( ! $links ) {
		return;
	}
	?>
	<nav class="ds-pagination posts-pagination" aria-label="<?php esc_attr_e( 'Paginação de artigos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
		<?php foreach ( $links as $link ) : ?>
			<?php echo wp_kses_post( str_replace( 'page-numbers', 'ds-pagination__item page-numbers', $link ) ); ?>
		<?php endforeach; ?>
	</nav>
	<?php
}
