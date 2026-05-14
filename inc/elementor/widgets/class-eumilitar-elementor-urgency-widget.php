<?php
/**
 * Elementor urgency widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Urgency and promotional condition section.
 */
class Eumilitar_Elementor_Urgency_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_urgency';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Urgência EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-countdown';
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
				'label' => esc_html__( 'Conteúdo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'variant',
			array(
				'label'   => esc_html__( 'Variação', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'max-conversion-cta',
				'options' => array(
					'max-conversion-cta' => esc_html__( 'Conversão máxima', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'compact'            => esc_html__( 'Compacta', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'badge_label',
			array(
				'label'   => esc_html__( 'Selo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Condição especial', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Últimos dias para garantir sua preparação.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'supporting_copy',
			array(
				'label'   => esc_html__( 'Texto de apoio', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Entre agora para começar a estudar com acesso imediato.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'stat_value',
			array(
				'label'   => esc_html__( 'Valor de destaque', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '72h',
			)
		);

		$this->add_control(
			'stat_label',
			array(
				'label'   => esc_html__( 'Rótulo do destaque', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'para garantir as condições atuais', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'primary_label',
			array(
				'label'   => esc_html__( 'CTA primário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Garantir vaga', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'primary_url',
			array(
				'label'       => esc_html__( 'Link primário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => '#checkout',
				'default'     => array(
					'url' => '#checkout',
				),
			)
		);

		$this->add_control(
			'secondary_label',
			array(
				'label' => esc_html__( 'CTA secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'secondary_url',
			array(
				'label'       => esc_html__( 'Link secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => '#faq',
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
		$settings      = $this->get_settings_for_display();
		$primary_url   = $settings['primary_url']['url'] ?? '#';
		$secondary_url = $settings['secondary_url']['url'] ?? '';

		eumilitar_render_elementor_pattern_partial(
			'urgency',
			array(
				'variant'         => $settings['variant'] ?? 'max-conversion-cta',
				'badge'           => ! empty( $settings['badge_label'] ) ? array(
					'label'   => $settings['badge_label'],
					'variant' => 'urgent',
				) : null,
				'headline'        => $settings['headline'] ?? '',
				'supporting_copy' => $settings['supporting_copy'] ?? '',
				'stat'            => ! empty( $settings['stat_value'] ) || ! empty( $settings['stat_label'] ) ? array(
					'value' => $settings['stat_value'] ?? '',
					'label' => $settings['stat_label'] ?? '',
				) : null,
				'primary_cta'     => array(
					'label'   => $settings['primary_label'] ?? '',
					'href'    => $primary_url ? $primary_url : '#',
					'variant' => 'brand-inverse',
				),
				'secondary_cta'   => ! empty( $settings['secondary_label'] ) && $secondary_url ? array(
					'label'   => $settings['secondary_label'],
					'href'    => $secondary_url,
					'variant' => 'ghost-inverse',
				) : null,
			)
		);
	}
}
