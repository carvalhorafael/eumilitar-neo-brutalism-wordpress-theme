<?php
/**
 * Widget area integration tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies WordPress widget areas registered by the theme.
 *
 * @covers ::eumilitar_register_widget_areas
 * @covers ::eumilitar_render_widget_area
 */
final class WidgetAreasTest extends TestCase {
	/**
	 * Ensure widget areas are registered before assertions run.
	 */
	public static function setUpBeforeClass(): void {
		parent::setUpBeforeClass();

		global $wp_registered_sidebars;

		if ( empty( $wp_registered_sidebars['blog-sidebar'] ) ) {
			do_action( 'widgets_init' );
		}
	}

	/**
	 * Theme should register the editable areas planned for the first widgets pass.
	 */
	public function test_expected_widget_areas_are_registered(): void {
		global $wp_registered_sidebars;

		$expected = array(
			'blog-sidebar'       => 'Barra lateral do blog',
			'after-post-content' => 'Após o artigo',
			'site-footer'        => 'Rodapé do site',
		);

		foreach ( $expected as $id => $name ) {
			$this->assertArrayHasKey( $id, $wp_registered_sidebars );
			$this->assertSame( $name, $wp_registered_sidebars[ $id ]['name'] );
			$this->assertTrue( $wp_registered_sidebars[ $id ]['show_in_rest'] );
		}
	}

	/**
	 * Widget areas should use stable wrappers for theme styling.
	 */
	public function test_widget_areas_use_theme_wrappers(): void {
		global $wp_registered_sidebars;

		$sidebar = $wp_registered_sidebars['blog-sidebar'];

		$this->assertStringContainsString( 'class="widget-area widget-area--blog %2$s"', $sidebar['before_sidebar'] );
		$this->assertSame( '<section id="%1$s" class="widget %2$s">', $sidebar['before_widget'] );
		$this->assertSame( '</section>', $sidebar['after_widget'] );
		$this->assertSame( '<h2 class="widget__title">', $sidebar['before_title'] );
		$this->assertSame( '</h2>', $sidebar['after_title'] );
	}

	/**
	 * Rendering helper should not print markup for empty or unknown areas.
	 */
	public function test_render_widget_area_returns_false_without_active_widgets(): void {
		ob_start();
		$rendered = eumilitar_render_widget_area( 'unknown-widget-area' );
		$output   = ob_get_clean();

		$this->assertFalse( $rendered );
		$this->assertSame( '', $output );
	}
}
