<?php
/**
 * Elementor courses section widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Course offer grid for landing pages.
 */
class Eumilitar_Elementor_Courses_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_courses';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Cursos EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-posts-grid';
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

		foreach (
			array(
				'category'     => array( 'Categoria', 'ESA' ),
				'discount'     => array( 'Selo de desconto', 'R$342,70 OFF' ),
				'title'        => array( 'Nome do curso', 'ESA' ),
				'description'  => array( 'Descrição', 'Preparatório para Sargento do Exército' ),
				'old_price'    => array( 'Preço antigo', 'De R$547,00' ),
				'price'        => array( 'Preço atual', 'R$ 204,30' ),
				'installments' => array( 'Parcelamento', 'ou em 12x de R$19,90' ),
				'button_label' => array( 'Texto do botão', 'Quero comprar' ),
			) as $name => $control
		) {
			$repeater->add_control(
				$name,
				array(
					'label'   => esc_html( $control[0] ),
					'type'    => in_array( $name, array( 'description' ), true ) ? \Elementor\Controls_Manager::TEXTAREA : \Elementor\Controls_Manager::TEXT,
					'default' => $control[1],
				)
			);
		}

		$repeater->add_control(
			'stats',
			array(
				'description' => esc_html__( 'Uma informação por linha no formato: rótulo|valor.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Informações do concurso', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => "Vagas|1.100 vagas\nSalário|R$ 6.000\nEscolaridade|Ensino Médio\nIdade|17 a 23 anos",
			)
		);

		$repeater->add_control(
			'includes',
			array(
				'description' => esc_html__( 'Um item por linha.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Inclusos', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => "Vídeo aulas completas\nMaterial em PDF abaixo de cada aula\nCronograma de estudos\nSimulados\nProvas anteriores",
			)
		);

		$repeater->add_control(
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
				'default' => 'Nossos cursos',
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Escolha o seu curso preparatório',
			)
		);

		$this->add_control(
			'supporting_copy',
			array(
				'label'   => esc_html__( 'Texto de apoio', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Conteúdo completo • Acesso imediato • Suporte dedicado',
			)
		);

		$this->add_control(
			'courses',
			array(
				'label'       => esc_html__( 'Cursos', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'category'     => 'ESA',
						'discount'     => 'R$342,70 OFF',
						'title'        => 'ESA',
						'description'  => 'Preparatório para Sargento do Exército',
						'old_price'    => 'De R$547,00',
						'price'        => 'R$ 204,30',
						'installments' => 'ou em 12x de R$19,90',
						'stats'        => "Vagas|1.100 vagas\nSalário|R$ 6.000\nEscolaridade|Ensino Médio\nIdade|17 a 23 anos",
						'includes'     => "Vídeo aulas completas\nMaterial em PDF abaixo de cada aula\nCronograma de estudos\nSimulados\nProvas anteriores",
						'button_label' => 'Quero comprar',
						'button_url'   => array(
							'url' => '#checkout',
						),
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
		$courses  = is_array( $settings['courses'] ?? null ) ? $settings['courses'] : array();
		?>
		<section class="em-courses">
			<header class="em-section-header">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<p class="em-section-header__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $settings['headline'] ?? '' ); ?></h2>
				<?php if ( ! empty( $settings['supporting_copy'] ) ) : ?>
					<p><?php echo esc_html( $settings['supporting_copy'] ); ?></p>
				<?php endif; ?>
			</header>

			<div class="em-courses__grid">
				<?php
				foreach ( $courses as $course ) {
					eumilitar_render_elementor_course_card(
						array(
							'category'     => $course['category'] ?? '',
							'discount'     => $course['discount'] ?? '',
							'title'        => $course['title'] ?? '',
							'description'  => $course['description'] ?? '',
							'old_price'    => $course['old_price'] ?? '',
							'price'        => $course['price'] ?? '',
							'installments' => $course['installments'] ?? '',
							'stats'        => eumilitar_elementor_lines_to_stats( $course['stats'] ?? '' ),
							'includes'     => eumilitar_elementor_lines_to_list( $course['includes'] ?? '' ),
							'button_label' => $course['button_label'] ?? '',
							'button_url'   => $course['button_url']['url'] ?? '#',
						)
					);
				}
				?>
			</div>
		</section>
		<?php
	}
}
