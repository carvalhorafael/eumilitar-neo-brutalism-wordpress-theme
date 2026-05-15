<?php
/**
 * Free material archive template.
 *
 * @package EuMilitar
 */

get_header();

$free_material_categories          = get_terms(
	array(
		'hide_empty' => true,
		'taxonomy'   => EUMILITAR_FREE_MATERIAL_TAXONOMY,
	)
);
$selected_free_material_categories = eumilitar_get_selected_free_material_category_slugs();
$has_free_material_categories      = ! is_wp_error( $free_material_categories ) && ! empty( $free_material_categories );
$has_free_material_posts           = have_posts();
?>

<main id="primary" class="site-main site-main--free-materials">
	<header class="free-materials-header">
		<span class="ds-badge ds-badge--brand"><?php esc_html_e( 'Materiais gratuitos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
		<h1 class="free-materials-header__title"><?php esc_html_e( 'Materiais gratuitos', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h1>
		<p class="free-materials-header__description"><?php esc_html_e( 'Guias, checklists e conteúdos de apoio para organizar sua preparação.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
	</header>

	<?php if ( $has_free_material_posts || $has_free_material_categories ) : ?>
		<div class="free-materials-layout" data-free-material-filters>
			<aside class="free-material-filters" aria-labelledby="free-material-filters-title">
				<h2 id="free-material-filters-title" class="free-material-filters__title"><?php esc_html_e( 'Filtros', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h2>

				<?php if ( $has_free_material_categories ) : ?>
					<form class="free-material-filters__form" action="<?php echo esc_url( get_post_type_archive_link( EUMILITAR_FREE_MATERIAL_POST_TYPE ) ); ?>" method="get">
						<?php if ( ! get_option( 'permalink_structure' ) ) : ?>
							<input type="hidden" name="post_type" value="<?php echo esc_attr( EUMILITAR_FREE_MATERIAL_POST_TYPE ); ?>">
						<?php endif; ?>
						<fieldset class="free-material-filters__fieldset">
							<legend><?php esc_html_e( 'Categorias', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></legend>
							<?php foreach ( $free_material_categories as $free_material_category ) : ?>
								<label class="free-material-filters__option">
									<input
										type="checkbox"
										name="material_categories[]"
										value="<?php echo esc_attr( $free_material_category->slug ); ?>"
										<?php checked( in_array( $free_material_category->slug, $selected_free_material_categories, true ) ); ?>
										data-free-material-filter
									>
									<span><?php echo esc_html( $free_material_category->name ); ?></span>
								</label>
							<?php endforeach; ?>
						</fieldset>

						<div class="free-material-filters__actions">
							<button class="ds-button ds-button--primary free-material-filters__apply" type="submit">
								<?php esc_html_e( 'Aplicar filtros', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
							</button>
							<a class="ds-button ds-button--secondary free-material-filters__clear" href="<?php echo esc_url( get_post_type_archive_link( EUMILITAR_FREE_MATERIAL_POST_TYPE ) ); ?>">
								<?php esc_html_e( 'Limpar filtros', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
							</a>
						</div>
					</form>
				<?php else : ?>
					<p class="free-material-filters__empty"><?php esc_html_e( 'Nenhuma categoria cadastrada.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></p>
				<?php endif; ?>
			</aside>

			<div class="free-materials-layout__content">
				<?php if ( $has_free_material_posts ) : ?>
					<div class="free-material-grid" data-free-material-grid>
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'free-material-card' );
						endwhile;
						?>
					</div>

					<p class="free-material-grid__empty" hidden data-free-material-empty>
						<?php esc_html_e( 'Nenhum material encontrado para os filtros selecionados.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
					</p>
				<?php else : ?>
					<p class="free-material-grid__empty">
						<?php esc_html_e( 'Nenhum material encontrado para os filtros selecionados.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $has_free_material_posts ) : ?>
			<?php eumilitar_render_posts_pagination(); ?>
		<?php endif; ?>
	<?php else : ?>
		<?php
		eumilitar_render_editorial_empty_state(
			array(
				'description'   => __( 'Novos materiais serão publicados em breve.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_label' => __( 'Voltar para o início', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'primary_url'   => home_url( '/' ),
				'show_search'   => false,
				'title'         => __( 'Nenhum material gratuito encontrado', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);
		?>
	<?php endif; ?>
</main>

<?php
get_footer();
