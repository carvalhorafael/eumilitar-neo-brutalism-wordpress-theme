<?php
/**
 * Elementor menu widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WordPress menu widget for Elementor canvas pages.
 */
class Eumilitar_Elementor_Menu_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_menu';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Menu EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-nav-menu';
	}

	/**
	 * Get widget categories.
	 *
	 * @return string[]
	 */
	public function get_categories(): array {
		return array( 'eumilitar' );
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Menu', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'menu_id',
			array(
				'label'       => esc_html__( 'Menu do WordPress', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '',
				'options'     => eumilitar_get_elementor_menu_options(),
				'description' => esc_html__( 'Crie e edite os itens em Aparência > Menus.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'   => esc_html__( 'Alinhamento', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'end',
				'options' => array(
					'start'  => esc_html__( 'Esquerda', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'center' => esc_html__( 'Centro', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'end'    => esc_html__( 'Direita', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * @return void
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$menu_id  = $settings['menu_id'] ?? '';

		if ( empty( $menu_id ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				?>
				<div class="em-menu-placeholder">
					<?php esc_html_e( 'Selecione um menu do WordPress para exibir.', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>
				</div>
				<?php
			}

			return;
		}

		eumilitar_render_elementor_menu( $menu_id, $settings['alignment'] ?? 'end' );
	}
}
