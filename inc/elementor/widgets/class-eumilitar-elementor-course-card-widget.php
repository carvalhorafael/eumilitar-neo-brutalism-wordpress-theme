<?php
/**
 * Elementor course card widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single commercial course card.
 */
class Eumilitar_Elementor_Course_Card_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_course_card';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Card de Curso EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-price-table';
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
				'label' => esc_html__( 'Oferta', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'category',
			array(
				'label'   => esc_html__( 'Categoria', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'ESA',
			)
		);

		$this->add_control(
			'discount',
			array(
				'label'   => esc_html__( 'Selo de desconto', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'R$342,70 OFF',
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Nome do curso', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'ESA',
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Descrição', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Preparatório para Sargento do Exército',
			)
		);

		$this->add_control(
			'old_price',
			array(
				'label'   => esc_html__( 'Preço antigo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'De R$547,00',
			)
		);

		$this->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Preço atual', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'R$ 204,30',
			)
		);

		$this->add_control(
			'installments',
			array(
				'label'   => esc_html__( 'Parcelamento', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'ou em 12x de R$19,90',
			)
		);

		$this->add_control(
			'stats',
			array(
				'description' => esc_html__( 'Uma informação por linha no formato: rótulo|valor.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Informações do concurso', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => "Vagas|1.100 vagas\nSalário|R$ 6.000\nEscolaridade|Ensino Médio\nIdade|17 a 23 anos",
			)
		);

		$this->add_control(
			'includes',
			array(
				'description' => esc_html__( 'Um item por linha.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Inclusos', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => "Vídeo aulas completas\nMaterial em PDF abaixo de cada aula\nCronograma de estudos\nSimulados\nProvas anteriores",
			)
		);

		$this->add_control(
			'button_label',
			array(
				'label'   => esc_html__( 'Texto do botão', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Quero comprar',
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Link do botão', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => '#checkout',
				'default'     => array(
					'url' => '#checkout',
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

		eumilitar_render_elementor_course_card(
			array(
				'category'     => $settings['category'] ?? '',
				'discount'     => $settings['discount'] ?? '',
				'title'        => $settings['title'] ?? '',
				'description'  => $settings['description'] ?? '',
				'old_price'    => $settings['old_price'] ?? '',
				'price'        => $settings['price'] ?? '',
				'installments' => $settings['installments'] ?? '',
				'stats'        => eumilitar_elementor_lines_to_stats( $settings['stats'] ?? '' ),
				'includes'     => eumilitar_elementor_lines_to_list( $settings['includes'] ?? '' ),
				'button_label' => $settings['button_label'] ?? '',
				'button_url'   => $settings['button_url']['url'] ?? '#',
			)
		);
	}
}
