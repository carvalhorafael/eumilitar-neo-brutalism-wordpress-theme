<?php
/**
 * Elementor why EuMilitar widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Institutional proof section for landing pages.
 */
class Eumilitar_Elementor_Why_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_why';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Por Que Escolher EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-check-circle';
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
			'eyebrow',
			array(
				'label'   => esc_html__( 'Eyebrow', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Por que escolher o Eu Militar?', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'headline',
			array(
				'label'   => esc_html__( 'Título', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Transformando o acesso à educação militar no Brasil', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'body',
			array(
				'label'   => esc_html__( 'Texto', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Há 7 anos, o Eu Militar vem transformando a vida de milhares de alunos em todo o Brasil.', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$this->add_control(
			'checklist',
			array(
				'description' => esc_html__( 'Um item por linha.', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'label'       => esc_html__( 'Checklist', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => "Metodologia focada em aprovação rápida\nProfessores militares experientes\nAulas dinâmicas e sem enrolação\nConteúdo atualizado\nSuporte exclusivo para alunos",
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Imagem', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'image_alt',
			array(
				'label'   => esc_html__( 'Texto alternativo da imagem', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Instrutor do Eu Militar', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
		$settings  = $this->get_settings_for_display();
		$checklist = eumilitar_elementor_lines_to_list( $settings['checklist'] ?? '' );
		$image_url = $settings['image']['url'] ?? '';
		?>
		<section class="em-why">
			<div class="em-why__content">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<p class="em-section-header__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $settings['headline'] ?? '' ); ?></h2>
				<?php if ( ! empty( $settings['body'] ) ) : ?>
					<p><?php echo esc_html( $settings['body'] ); ?></p>
				<?php endif; ?>

				<?php if ( $checklist ) : ?>
					<ul class="em-checklist">
						<?php foreach ( $checklist as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( $image_url ) : ?>
				<figure class="em-why__media">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $settings['image_alt'] ?? '' ); ?>">
				</figure>
			<?php endif; ?>
		</section>
		<?php
	}
}
