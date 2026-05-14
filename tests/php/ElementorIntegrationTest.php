<?php
/**
 * Elementor integration tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies Elementor-facing integration points remain registered and safe.
 *
 * @covers ::eumilitar_register_elementor_widget_category
 * @covers ::eumilitar_register_elementor_widgets
 * @covers ::eumilitar_render_elementor_pattern_partial
 */
final class ElementorIntegrationTest extends TestCase {
	/**
	 * Elementor hooks should be registered even when Elementor is inactive.
	 */
	public function test_elementor_hooks_are_registered(): void {
		$this->assertNotFalse( has_action( 'elementor/elements/categories_registered', 'eumilitar_register_elementor_widget_category' ) );
		$this->assertNotFalse( has_action( 'elementor/widgets/register', 'eumilitar_register_elementor_widgets' ) );
	}

	/**
	 * Elementor widget registration should return safely without Elementor classes.
	 */
	public function test_widget_registration_is_safe_with_available_runtime(): void {
		$widgets_manager = new class() {
			/**
			 * Registered widgets.
			 *
			 * @var array<int, object>
			 */
			public array $widgets = array();

			/**
			 * Register a widget instance.
			 *
			 * @param object $widget Widget instance.
			 * @return void
			 */
			public function register( $widget ): void {
				$this->widgets[] = $widget;
			}
		};

		eumilitar_register_elementor_widgets( $widgets_manager );

		if ( class_exists( '\Elementor\Widget_Base' ) ) {
			$this->assertCount( 10, $widgets_manager->widgets );
			return;
		}

		$this->assertSame( array(), $widgets_manager->widgets );
	}

	/**
	 * Elementor pattern rendering should reuse the same FAQ contract as the theme.
	 */
	public function test_elementor_partial_renderer_preserves_design_system_contract(): void {
		ob_start();
		eumilitar_render_elementor_pattern_partial(
			'faq',
			array(
				'eyebrow'  => 'Dúvidas frequentes',
				'headline' => 'Perguntas e respostas',
				'items'    => array(
					array(
						'question' => 'Elementor pode ser usado?',
						'answer'   => 'Sim, com widgets EuMilitar.',
					),
				),
			)
		);
		$content = ob_get_clean();

		$this->assertStringContainsString( 'class="ds-faq"', $content );
		$this->assertStringContainsString( 'data-accordion-root', $content );
		$this->assertStringContainsString( 'data-accordion-trigger', $content );
		$this->assertStringContainsString( 'data-accordion-panel', $content );
	}

	/**
	 * Elementor should be allowed to render the urgency partial.
	 */
	public function test_elementor_partial_renderer_allows_urgency_contract(): void {
		ob_start();
		eumilitar_render_elementor_pattern_partial(
			'urgency',
			array(
				'headline'        => 'Últimos dias',
				'supporting_copy' => 'Condição especial por tempo limitado.',
				'primary_cta'     => array(
					'label'   => 'Garantir vaga',
					'href'    => '#checkout',
					'variant' => 'brand-inverse',
				),
			)
		);
		$content = ob_get_clean();

		$this->assertStringContainsString( 'class="ds-urgency ds-urgency--max-conversion-cta"', $content );
		$this->assertStringContainsString( 'Últimos dias', $content );
		$this->assertStringContainsString( 'Garantir vaga', $content );
	}

	/**
	 * The local course card adapter should preserve the commercial offer contract.
	 */
	public function test_course_card_renderer_outputs_offer_markup(): void {
		ob_start();
		eumilitar_render_elementor_course_card(
			array(
				'category'     => 'ESA',
				'discount'     => 'R$342,70 OFF',
				'title'        => 'ESA',
				'description'  => 'Preparatório para Sargento do Exército',
				'old_price'    => 'De R$547,00',
				'price'        => 'R$ 204,30',
				'installments' => 'ou em 12x de R$19,90',
				'stats'        => array(
					array(
						'label' => 'Vagas',
						'value' => '1.100 vagas',
					),
				),
				'includes'     => array( 'Vídeo aulas completas' ),
				'button_label' => 'Quero comprar',
				'button_url'   => '#checkout',
			)
		);
		$content = ob_get_clean();

		$this->assertStringContainsString( 'class="em-course-card ds-card"', $content );
		$this->assertStringContainsString( 'R$342,70 OFF', $content );
		$this->assertStringContainsString( '1.100 vagas', $content );
		$this->assertStringContainsString( 'Vídeo aulas completas', $content );
		$this->assertStringContainsString( 'Quero comprar', $content );
	}

	/**
	 * Textarea helpers should parse marketing-friendly line formats.
	 */
	public function test_elementor_textarea_parsers(): void {
		$this->assertSame(
			array( 'Aulas', 'Simulados' ),
			eumilitar_elementor_lines_to_list( "Aulas\n\nSimulados" )
		);

		$this->assertSame(
			array(
				array(
					'label' => 'Vagas',
					'value' => '1.100 vagas',
				),
				array(
					'label' => 'Salário',
					'value' => 'R$ 6.000',
				),
			),
			eumilitar_elementor_lines_to_stats( "Vagas|1.100 vagas\nSalário|R$ 6.000" )
		);
	}
}
