<?php
/**
 * Elementor Hero widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hero widget backed by the EuMilitar Design System partial.
 */
class Eumilitar_Elementor_Hero_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_hero';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Hero EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-banner';
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
				'default' => 'light',
				'options' => array(
					'light' => esc_html__( 'Clara', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'dark'  => esc_html__( 'Escura', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'eyebrow',
			array(
				'label'   => esc_html__( 'Eyebrow', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Preparação militar', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Prepare-se para as Forças Armadas com uma trilha por edital.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'supporting_copy',
			array(
				'label'   => esc_html__( 'Texto de apoio', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Questões, simulados e acompanhamento para acelerar a aprovação.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'badge_label',
			array(
				'label'   => esc_html__( 'Selo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Exército', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'badge_variant',
			array(
				'label'   => esc_html__( 'Variação do selo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'ex',
				'options' => array(
					'default' => esc_html__( 'Padrão', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'brand'   => esc_html__( 'Marca', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'ex'      => esc_html__( 'Exército', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'mb'      => esc_html__( 'Marinha', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'urgent'  => esc_html__( 'Urgente', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'primary_label',
			array(
				'label'   => esc_html__( 'CTA primário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ver artigos', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'primary_url',
			array(
				'label'       => esc_html__( 'Link primário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => home_url( '/' ),
				'default'     => array(
					'url' => home_url( '/' ),
				),
			)
		);

		$this->add_control(
			'secondary_label',
			array(
				'label'   => esc_html__( 'CTA secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ler artigo recente', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'secondary_url',
			array(
				'label'       => esc_html__( 'Link secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => home_url( '/' ),
			)
		);

		$this->add_control(
			'urgency_alert',
			array(
				'label' => esc_html__( 'Alerta de urgência', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
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
		$badges        = array();

		if ( ! empty( $settings['badge_label'] ) ) {
			$badges[] = array(
				'label'   => $settings['badge_label'],
				'variant' => $settings['badge_variant'] ?? 'default',
			);
		}

		eumilitar_render_elementor_pattern_partial(
			'hero',
			array(
				'variant'         => $settings['variant'] ?? 'light',
				'eyebrow'         => $settings['eyebrow'] ?? '',
				'badges'          => $badges,
				'headline'        => $settings['headline'] ?? '',
				'supporting_copy' => $settings['supporting_copy'] ?? '',
				'primary_cta'     => array(
					'label'   => $settings['primary_label'] ?? '',
					'href'    => $primary_url ? $primary_url : '#',
					'variant' => 'primary',
				),
				'secondary_cta'   => ! empty( $settings['secondary_label'] ) && $secondary_url ? array(
					'label'   => $settings['secondary_label'],
					'href'    => $secondary_url,
					'variant' => 'secondary',
				) : null,
				'urgency_alert'   => $settings['urgency_alert'] ?? '',
			)
		);
	}
}
