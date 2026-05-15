<?php
/**
 * Elementor compatibility.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Elementor compatibility styles when Elementor is active.
 */
function eumilitar_enqueue_elementor_assets() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	if ( eumilitar_vite_is_development() && eumilitar_vite_dev_server_is_running() ) {
		wp_enqueue_script( 'eumilitar-elementor', EUMILITAR_VITE_DEV_SERVER . '/src/elementor.js', array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_script_add_data( 'eumilitar-elementor', 'type', 'module' );
		return;
	}

	$entry = eumilitar_vite_manifest_entry( 'src/elementor.js' );

	if ( $entry && ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
		foreach ( $entry['css'] as $index => $css_file ) {
			wp_enqueue_style(
				'eumilitar-elementor-' . $index,
				eumilitar_vite_asset_uri( $css_file ),
				array(),
				EUMILITAR_THEME_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'eumilitar_enqueue_elementor_assets', 20 );

/**
 * Register the EuMilitar widget category in Elementor.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
 * @return void
 */
function eumilitar_register_elementor_widget_category( $elements_manager ) {
	if ( ! method_exists( $elements_manager, 'add_category' ) ) {
		return;
	}

	$elements_manager->add_category(
		'eumilitar',
		array(
			'title' => esc_html__( 'EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'eumilitar_register_elementor_widget_category' );

/**
 * Render a design-system pattern partial for Elementor widgets.
 *
 * @param string               $slug Pattern partial slug.
 * @param array<string, mixed> $args Pattern arguments.
 * @return void
 */
function eumilitar_render_elementor_pattern_partial( $slug, $args ) {
	$allowed_partials = array(
		'benefits',
		'cta',
		'faq',
		'hero',
		'testimonials',
		'urgency',
	);

	if ( ! in_array( $slug, $allowed_partials, true ) ) {
		return;
	}

	get_template_part( 'template-parts/patterns/' . $slug, null, $args );
}

/**
 * Get WordPress menu options for Elementor select controls.
 *
 * @return array<string, string>
 */
function eumilitar_get_elementor_menu_options() {
	$options = array(
		'' => esc_html__( 'Selecione um menu', 'eumilitar-neo-brutalism-wordpress-theme' ),
	);
	$menus   = wp_get_nav_menus();

	foreach ( $menus as $menu ) {
		$options[ (string) $menu->term_id ] = $menu->name;
	}

	return $options;
}

/**
 * Render a WordPress menu with Elementor-safe EuMilitar markup.
 *
 * @param int|string $menu_id Menu term ID.
 * @param string     $alignment Menu alignment.
 * @return void
 */
function eumilitar_render_elementor_menu( $menu_id, $alignment = 'end' ) {
	$menu_id = absint( $menu_id );

	if ( ! $menu_id ) {
		return;
	}

	$allowed_alignments = array( 'start', 'center', 'end' );
	$alignment          = in_array( $alignment, $allowed_alignments, true ) ? $alignment : 'end';
	$menu_args          = array(
		'container'       => 'nav',
		'container_class' => 'em-menu em-menu--align-' . $alignment,
		'echo'            => false,
		'fallback_cb'     => false,
		'menu_class'      => 'em-menu__list',
		'menu_id'         => 'em-menu-' . $menu_id,
		'theme_location'  => 'primary',
	);
	$menu_args['menu']  = $menu_id;
	$menu               = wp_nav_menu( $menu_args );

	if ( ! $menu ) {
		return;
	}

	echo $menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_nav_menu returns WordPress-generated navigation markup.
}

/**
 * Register EuMilitar widgets for Elementor.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function eumilitar_register_elementor_widgets( $widgets_manager ) {
	if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
		return;
	}

	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-hero-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-cta-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-faq-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-course-card-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-courses-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-approved-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-why-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-trust-bar-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-benefits-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-urgency-widget.php';
	require_once EUMILITAR_THEME_DIR . '/inc/elementor/widgets/class-eumilitar-elementor-menu-widget.php';

	$widgets_manager->register( new \Eumilitar_Elementor_Hero_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Cta_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Faq_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Course_Card_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Courses_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Approved_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Why_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Trust_Bar_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Benefits_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Urgency_Widget() );
	$widgets_manager->register( new \Eumilitar_Elementor_Menu_Widget() );
}
add_action( 'elementor/widgets/register', 'eumilitar_register_elementor_widgets' );

/**
 * Parse textarea lines into a list of values.
 *
 * @param string $value Raw textarea value.
 * @return string[]
 */
function eumilitar_elementor_lines_to_list( $value ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $value );

	if ( ! is_array( $lines ) ) {
		return array();
	}

	return array_values(
		array_filter(
			array_map( 'trim', $lines ),
			static function ( $line ) {
				return '' !== $line;
			}
		)
	);
}

/**
 * Parse textarea lines into stat pairs.
 *
 * Expected format: label|value.
 *
 * @param string $value Raw textarea value.
 * @return array<int, array{label:string,value:string}>
 */
function eumilitar_elementor_lines_to_stats( $value ) {
	$stats = array();

	foreach ( eumilitar_elementor_lines_to_list( $value ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );

		$stats[] = array(
			'label' => $parts[0] ?? '',
			'value' => $parts[1] ?? '',
		);
	}

	return $stats;
}

/**
 * Render a local course offer card adapter for Elementor.
 *
 * @param array<string, mixed> $course Course data.
 * @return void
 */
function eumilitar_render_elementor_course_card( $course ) {
	$stats    = $course['stats'] ?? array();
	$includes = $course['includes'] ?? array();
	?>
	<article class="em-course-card ds-card">
		<?php if ( ! empty( $course['discount'] ) ) : ?>
			<span class="ds-badge ds-badge--urgent em-course-card__discount"><?php echo esc_html( $course['discount'] ); ?></span>
		<?php endif; ?>

		<div class="em-course-card__header">
			<?php if ( ! empty( $course['category'] ) ) : ?>
				<span class="ds-badge ds-badge--brand"><?php echo esc_html( $course['category'] ); ?></span>
			<?php endif; ?>
			<h3 class="em-course-card__title"><?php echo esc_html( $course['title'] ?? '' ); ?></h3>
			<?php if ( ! empty( $course['description'] ) ) : ?>
				<p class="em-course-card__description"><?php echo esc_html( $course['description'] ); ?></p>
			<?php endif; ?>
		</div>

		<div class="em-course-card__price">
			<?php if ( ! empty( $course['old_price'] ) ) : ?>
				<span class="em-course-card__old-price"><?php echo esc_html( $course['old_price'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $course['price'] ) ) : ?>
				<strong class="em-course-card__current-price"><?php echo esc_html( $course['price'] ); ?></strong>
			<?php endif; ?>
			<?php if ( ! empty( $course['installments'] ) ) : ?>
				<span class="em-course-card__installments"><?php echo esc_html( $course['installments'] ); ?></span>
			<?php endif; ?>
		</div>

		<?php if ( $stats ) : ?>
			<div class="em-course-card__stats" aria-label="<?php esc_attr_e( 'Informações do concurso', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="em-course-card__stat">
						<strong><?php echo esc_html( $stat['value'] ?? '' ); ?></strong>
						<span><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $includes ) : ?>
			<div class="em-course-card__includes">
				<h4><?php esc_html_e( 'O que está incluso', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></h4>
				<ul>
					<?php foreach ( $includes as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php
		eumilitar_render_action(
			array(
				'label'   => $course['button_label'] ?? __( 'Quero comprar', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'href'    => $course['button_url'] ?? '#',
				'variant' => 'primary',
			)
		);
		?>
	</article>
	<?php
}
