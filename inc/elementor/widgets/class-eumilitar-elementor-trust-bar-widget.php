<?php
/**
 * Elementor trust bar widget.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Compact trust proof bar.
 */
class Eumilitar_Elementor_Trust_Bar_Widget extends \Elementor\Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'eumilitar_trust_bar';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Barra de Confiança EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-shield';
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
			'label',
			array(
				'label'   => esc_html__( 'Texto', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Pagamento seguro', 'eumilitar-neo-brutalism-wordpress-theme' ),
			)
		);

		$repeater->add_control(
			'value',
			array(
				'label' => esc_html__( 'Valor/destaque', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
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
			'items',
			array(
				'label'       => esc_html__( 'Itens', 'eumilitar-neo-brutalism-wordpress-theme' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ value || label }}}',
				'default'     => array(
					array(
						'label' => esc_html__( 'Alunos aprovados', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'value' => '+6000',
					),
					array(
						'label' => esc_html__( 'Avaliação dos alunos', 'eumilitar-neo-brutalism-wordpress-theme' ),
						'value' => '4.9/5',
					),
					array(
						'label' => esc_html__( 'Pagamento seguro', 'eumilitar-neo-brutalism-wordpress-theme' ),
					),
					array(
						'label' => esc_html__( 'Garantia 7 dias', 'eumilitar-neo-brutalism-wordpress-theme' ),
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
		$items    = is_array( $settings['items'] ?? null ) ? $settings['items'] : array();
		?>
		<div class="em-trust-bar" aria-label="<?php esc_attr_e( 'Sinais de confiança', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<div class="em-trust-bar__item">
					<?php if ( ! empty( $item['value'] ) ) : ?>
						<strong><?php echo esc_html( $item['value'] ); ?></strong>
					<?php endif; ?>
					<span><?php echo esc_html( $item['label'] ?? '' ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
