<?php
/**
 * Elementor CTA widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CTA widget backed by the EuMilitar Design System partial.
 */
class Eumilitar_Elementor_Cta_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_cta';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'CTA EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-call-to-action';
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
				'default' => 'brand-dark',
				'options' => array(
					'brand-dark' => esc_html__( 'Marca escura', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'light'      => esc_html__( 'Clara', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'badge_label',
			array(
				'label'   => esc_html__( 'Selo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Plano completo', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Comece sua preparação hoje', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'supporting_copy',
			array(
				'label'   => esc_html__( 'Texto de apoio', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Acesso imediato ao curso completo.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'primary_label',
			array(
				'label'   => esc_html__( 'CTA primário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Assinar agora', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
				'label'   => esc_html__( 'CTA secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Saiba mais', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'secondary_url',
			array(
				'label'       => esc_html__( 'Link secundário', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => '#faq',
				'default'     => array(
					'url' => '#faq',
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
		$settings      = $this->get_settings_for_display();
		$primary_url   = $settings['primary_url']['url'] ?? '#';
		$secondary_url = $settings['secondary_url']['url'] ?? '';

		eumilitar_render_elementor_pattern_partial(
			'cta',
			array(
				'variant'         => $settings['variant'] ?? 'brand-dark',
				'badge'           => ! empty( $settings['badge_label'] ) ? array(
					'label'   => $settings['badge_label'],
					'variant' => 'brand',
				) : null,
				'headline'        => $settings['headline'] ?? '',
				'supporting_copy' => $settings['supporting_copy'] ?? '',
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
