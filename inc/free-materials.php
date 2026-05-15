<?php
/**
 * Free material content type.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const EUMILITAR_FREE_MATERIAL_POST_TYPE = 'material_gratuito';
const EUMILITAR_FREE_MATERIAL_TAXONOMY  = 'material_categoria';
const EUMILITAR_FREE_MATERIAL_CTA_URL   = '_eumilitar_material_capture_url';
const EUMILITAR_FREE_MATERIAL_CTA_LABEL = '_eumilitar_material_capture_label';

/**
 * Register free material post type, taxonomy and metadata.
 *
 * @return void
 */
function eumilitar_register_free_material_content_type() {
	$core_registration_functions = array(
		'post_type' => 'register_post_type',
		'taxonomy'  => 'register_taxonomy',
	);
	$register_post_type          = $core_registration_functions['post_type'];
	$register_taxonomy           = $core_registration_functions['taxonomy'];

	$register_post_type(
		EUMILITAR_FREE_MATERIAL_POST_TYPE,
		array(
			'has_archive'        => 'materiais-gratuitos',
			'hierarchical'       => false,
			'labels'             => array(
				'name'                  => _x( 'Materiais gratuitos', 'Post type general name', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'singular_name'         => _x( 'Material gratuito', 'Post type singular name', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'menu_name'             => _x( 'Materiais gratuitos', 'Admin Menu text', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'name_admin_bar'        => _x( 'Material gratuito', 'Add New on Toolbar', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'add_new'               => __( 'Adicionar novo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'add_new_item'          => __( 'Adicionar material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'all_items'             => __( 'Todos os materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'archives'              => __( 'Materiais gratuitos', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'edit_item'             => __( 'Editar material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'featured_image'        => __( 'Imagem do material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'filter_items_list'     => __( 'Filtrar materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'items_list'            => __( 'Lista de materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'items_list_navigation' => __( 'Navegação da lista de materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'new_item'              => __( 'Novo material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'not_found'             => __( 'Nenhum material encontrado.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'not_found_in_trash'    => __( 'Nenhum material encontrado na lixeira.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'remove_featured_image' => __( 'Remover imagem do material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'search_items'          => __( 'Buscar materiais', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'set_featured_image'    => __( 'Definir imagem do material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'uploaded_to_this_item' => __( 'Enviado para este material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'use_featured_image'    => __( 'Usar como imagem do material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'view_item'             => __( 'Ver material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ),
			),
			'menu_icon'          => 'dashicons-download',
			'public'             => true,
			'publicly_queryable' => true,
			'query_var'          => true,
			'rewrite'            => array(
				'slug'       => 'materiais-gratuitos',
				'with_front' => false,
			),
			'show_in_rest'       => true,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);

	$register_taxonomy(
		EUMILITAR_FREE_MATERIAL_TAXONOMY,
		array( EUMILITAR_FREE_MATERIAL_POST_TYPE ),
		array(
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => _x( 'Categorias de materiais', 'taxonomy general name', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'singular_name'     => _x( 'Categoria de material', 'taxonomy singular name', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'add_new_item'      => __( 'Adicionar categoria de material', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'all_items'         => __( 'Todas as categorias', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'back_to_items'     => __( 'Voltar para categorias', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'edit_item'         => __( 'Editar categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'menu_name'         => __( 'Categorias', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'new_item_name'     => __( 'Nome da nova categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'not_found'         => __( 'Nenhuma categoria encontrada.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'parent_item'       => __( 'Categoria ascendente', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'parent_item_colon' => __( 'Categoria ascendente:', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'search_items'      => __( 'Buscar categorias', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'update_item'       => __( 'Atualizar categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'view_item'         => __( 'Ver categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
			),
			'public'            => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug'       => 'materiais-gratuitos/categoria',
				'with_front' => false,
			),
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'show_ui'           => true,
		)
	);

	register_post_meta(
		EUMILITAR_FREE_MATERIAL_POST_TYPE,
		EUMILITAR_FREE_MATERIAL_CTA_URL,
		array(
			'auth_callback'     => static function () {
				return current_user_can( 'edit_posts' );
			},
			'sanitize_callback' => 'esc_url_raw',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
		)
	);

	register_post_meta(
		EUMILITAR_FREE_MATERIAL_POST_TYPE,
		EUMILITAR_FREE_MATERIAL_CTA_LABEL,
		array(
			'auth_callback'     => static function () {
				return current_user_can( 'edit_posts' );
			},
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
		)
	);
}
add_action( 'init', 'eumilitar_register_free_material_content_type' );

/**
 * Register capture settings meta box.
 *
 * @return void
 */
function eumilitar_register_free_material_meta_box() {
	add_meta_box(
		'eumilitar-free-material-capture',
		__( 'Captura do material', 'eumilitar-neo-brutalism-wordpress-theme' ),
		'eumilitar_render_free_material_meta_box',
		EUMILITAR_FREE_MATERIAL_POST_TYPE,
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'eumilitar_register_free_material_meta_box' );

/**
 * Render capture settings meta box.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function eumilitar_render_free_material_meta_box( $post ) {
	$cta_url   = get_post_meta( $post->ID, EUMILITAR_FREE_MATERIAL_CTA_URL, true );
	$cta_label = get_post_meta( $post->ID, EUMILITAR_FREE_MATERIAL_CTA_LABEL, true );

	wp_nonce_field( 'eumilitar_save_free_material_capture', 'eumilitar_free_material_capture_nonce' );
	?>
	<p>
		<label for="eumilitar-free-material-cta-url"><?php esc_html_e( 'URL do botão', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></label>
		<input
			class="widefat"
			id="eumilitar-free-material-cta-url"
			name="eumilitar_free_material_cta_url"
			type="url"
			value="<?php echo esc_attr( $cta_url ); ?>"
			placeholder="https://"
		>
	</p>
	<p>
		<label for="eumilitar-free-material-cta-label"><?php esc_html_e( 'Texto do botão', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></label>
		<input
			class="widefat"
			id="eumilitar-free-material-cta-label"
			name="eumilitar_free_material_cta_label"
			type="text"
			value="<?php echo esc_attr( $cta_label ); ?>"
			placeholder="<?php esc_attr_e( 'Baixar material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>"
		>
	</p>
	<?php
}

/**
 * Save capture settings.
 *
 * @param int $post_id Current post ID.
 * @return void
 */
function eumilitar_save_free_material_meta( $post_id ) {
	$nonce = isset( $_POST['eumilitar_free_material_capture_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['eumilitar_free_material_capture_nonce'] ) ) : '';

	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'eumilitar_save_free_material_capture' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$cta_url   = isset( $_POST['eumilitar_free_material_cta_url'] ) ? esc_url_raw( wp_unslash( $_POST['eumilitar_free_material_cta_url'] ) ) : '';
	$cta_label = isset( $_POST['eumilitar_free_material_cta_label'] ) ? sanitize_text_field( wp_unslash( $_POST['eumilitar_free_material_cta_label'] ) ) : '';

	if ( $cta_url ) {
		update_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_URL, $cta_url );
	} else {
		delete_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_URL );
	}

	if ( $cta_label ) {
		update_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_LABEL, $cta_label );
	} else {
		delete_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_LABEL );
	}
}
add_action( 'save_post_' . EUMILITAR_FREE_MATERIAL_POST_TYPE, 'eumilitar_save_free_material_meta' );

/**
 * Get capture CTA data for a free material.
 *
 * @param int|null $post_id Post ID.
 * @return array{label:string,url:string}
 */
function eumilitar_get_free_material_cta( $post_id = null ) {
	$post_id   = $post_id ? $post_id : get_the_ID();
	$cta_url   = $post_id ? get_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_URL, true ) : '';
	$cta_label = $post_id ? get_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_LABEL, true ) : '';

	return array(
		'label' => $cta_label ? $cta_label : __( 'Baixar material gratuito', 'eumilitar-neo-brutalism-wordpress-theme' ),
		'url'   => $cta_url ? $cta_url : '#captura',
	);
}

/**
 * Render free material category links.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function eumilitar_render_free_material_terms( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$terms   = get_the_term_list(
		$post_id,
		EUMILITAR_FREE_MATERIAL_TAXONOMY,
		'',
		esc_html_x( ', ', 'free material category list separator', 'eumilitar-neo-brutalism-wordpress-theme' )
	);

	if ( ! $terms ) {
		return;
	}
	?>
	<div class="free-material-terms">
		<span class="free-material-terms__label"><?php esc_html_e( 'Categoria', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<span class="free-material-terms__links"><?php echo wp_kses_post( $terms ); ?></span>
	</div>
	<?php
}
