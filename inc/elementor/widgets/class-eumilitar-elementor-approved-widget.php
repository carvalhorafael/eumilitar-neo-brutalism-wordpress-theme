<?php
/**
 * Elementor approved students widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Approved students proof widget for landing pages.
 */
class Eumilitar_Elementor_Approved_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_approved';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Aprovados EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-gallery-grid';
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
			'image',
			array(
				'label'   => esc_html__( 'Imagem', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'alt',
			array(
				'label'   => esc_html__( 'Texto alternativo', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Aluno aprovado', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
				'default' => esc_html__( 'Prova social', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Mais de 6000 aprovados', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'supporting_copy',
			array(
				'label'   => esc_html__( 'Texto de apoio', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Milhares de alunos já conquistaram seus sonhos nas Forças Armadas.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid' => esc_html__( 'Grade', 'eumilitar-neo-brutalism-wordpress-theme' ),
					'row'  => esc_html__( 'Faixa horizontal', 'eumilitar-neo-brutalism-wordpress-theme' ),
				),
			)
		);

		$this->add_control(
			'images',
			array(
				'label'       => esc_html__( 'Imagens', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ alt }}}',
				'default'     => array(
					array(
						'alt'   => esc_html__( 'Aluno aprovado 1', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'image' => array(
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
					),
					array(
						'alt'   => esc_html__( 'Aluno aprovado 2', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'image' => array(
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						),
					),
					array(
						'alt'   => esc_html__( 'Aluno aprovado 3', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'image' => array(
							'url' => \Elementor\Utils::get_placeholder_image_src(),
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
		$images   = is_array( $settings['images'] ?? null ) ? $settings['images'] : array();
		$layout   = $settings['layout'] ?? 'grid';
		?>
		<section class="em-approved em-approved--<?php echo esc_attr( $layout ); ?>">
			<header class="em-section-header">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<p class="em-section-header__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $settings['headline'] ?? '' ); ?></h2>
				<?php if ( ! empty( $settings['supporting_copy'] ) ) : ?>
					<p><?php echo esc_html( $settings['supporting_copy'] ); ?></p>
				<?php endif; ?>
			</header>

			<div class="em-approved__grid">
				<?php foreach ( $images as $image ) : ?>
					<?php $url = $image['image']['url'] ?? ''; ?>
					<?php if ( $url ) : ?>
						<figure class="em-approved__item">
							<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>">
						</figure>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
