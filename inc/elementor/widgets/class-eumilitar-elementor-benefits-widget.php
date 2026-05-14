<?php
/**
 * Elementor benefits widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flexible benefits section backed by the Design System partial.
 */
class Eumilitar_Elementor_Benefits_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_benefits';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Benefícios EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-bullet-list';
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
			'title',
			array(
				'label'   => esc_html__( 'Título do item', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Vídeo aulas completas', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Descrição', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Conteúdo objetivo para estudar sem perder tempo.', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
			'variant',
			array(
				'label'   => esc_html__( 'Variação', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon-grid',
				'options' => array(
					'icon-grid' => esc_html__( 'Grade', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'compact'   => esc_html__( 'Compacta', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Tudo que você precisa para estudar com foco.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Benefícios', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title'       => esc_html__( 'Vídeo aulas completas', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'description' => esc_html__( 'Aulas objetivas para estudar com clareza.', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
					array(
						'title'       => esc_html__( 'Cronograma de estudos', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'description' => esc_html__( 'Organização para manter constância até a prova.', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
					array(
						'title'       => esc_html__( 'Simulados e provas anteriores', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'description' => esc_html__( 'Treino direcionado para medir evolução.', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
				),
			)
		);

		$this->add_control(
			'stats',
			array(
				'description' => esc_html__( 'Opcional. Uma estatística por linha no formato: rótulo|valor.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Estatísticas', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
			)
		);

		$this->add_control(
			'button_label',
			array(
				'label' => esc_html__( 'CTA opcional', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Link do CTA', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => '#checkout',
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
		$settings   = $this->get_settings_for_display();
		$button_url = $settings['button_url']['url'] ?? '';

		eumilitar_render_elementor_pattern_partial(
			'benefits',
			array(
				'variant'     => $settings['variant'] ?? 'icon-grid',
				'headline'    => $settings['headline'] ?? '',
				'items'       => is_array( $settings['items'] ?? null ) ? $settings['items'] : array(),
				'stats'       => eumilitar_elementor_lines_to_stats( $settings['stats'] ?? '' ),
				'primary_cta' => ! empty( $settings['button_label'] ) && $button_url ? array(
					'label'   => $settings['button_label'],
					'href'    => $button_url,
					'variant' => 'primary',
				) : null,
			)
		);
	}
}
