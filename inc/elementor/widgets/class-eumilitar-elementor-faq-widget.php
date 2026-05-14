<?php
/**
 * Elementor FAQ widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FAQ widget backed by the EuMilitar Design System partial.
 */
class Eumilitar_Elementor_Faq_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_faq';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'FAQ EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-help-o';
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
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'question',
			array(
				'label'   => esc_html__( 'Pergunta', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'O tema recria o design system?', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$repeater->add_control(
			'answer',
			array(
				'label'   => esc_html__( 'Resposta', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Não. Ele consome tokens, CSS e contratos publicados pela biblioteca EuMilitar.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Conteúdo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'   => esc_html__( 'Eyebrow', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Dúvidas frequentes', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Perguntas e respostas', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Perguntas', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ question }}}',
				'default'     => array(
					array(
						'question' => esc_html__( 'O tema recria o design system?', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'answer'   => esc_html__( 'Não. Ele consome tokens, CSS e contratos publicados pela biblioteca EuMilitar.', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
					array(
						'question' => esc_html__( 'Elementor pode ser usado?', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'answer'   => esc_html__( 'Sim, desde que opere sobre a base visual do tema e use os widgets EuMilitar quando possível.', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
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

		eumilitar_render_elementor_pattern_partial(
			'faq',
			array(
				'eyebrow'  => $settings['eyebrow'] ?? '',
				'headline' => $settings['headline'] ?? '',
				'items'    => is_array( $settings['items'] ?? null ) ? $settings['items'] : array(),
			)
		);
	}
}
