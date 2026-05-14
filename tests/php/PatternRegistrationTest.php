<?php
/**
 * Pattern registration integration tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies design-system pattern registration in WordPress.
 *
 * @covers ::eumilitar_register_block_patterns
 * @covers ::eumilitar_register_pattern_categories
 */
final class PatternRegistrationTest extends TestCase {
	/**
	 * The theme should expose its pattern category to the editor.
	 */
	public function test_eumilitar_pattern_category_is_registered(): void {
		$registry = WP_Block_Pattern_Categories_Registry::get_instance();

		$this->assertTrue( $registry->is_registered( 'eumilitar-neo-brutalism-wordpress-theme' ) );
	}

	/**
	 * All expected EuMilitar design-system patterns should be registered.
	 */
	public function test_expected_design_system_patterns_are_registered(): void {
		$registry = WP_Block_Patterns_Registry::get_instance();
		$patterns = array(
			'eumilitar/hero',
			'eumilitar/urgency',
			'eumilitar/benefits',
			'eumilitar/testimonials',
			'eumilitar/capture',
			'eumilitar/faq',
			'eumilitar/cta',
			'eumilitar/landing-page',
			'eumilitar/sidebar-blog',
			'eumilitar/after-post-cta',
			'eumilitar/capture-compact',
		);

		foreach ( $patterns as $pattern ) {
			$this->assertTrue( $registry->is_registered( $pattern ), "{$pattern} should be registered." );
		}
	}

	/**
	 * The FAQ pattern should preserve the accordion data attributes.
	 */
	public function test_faq_pattern_content_contains_accordion_contract(): void {
		$content = eumilitar_get_pattern_content( EUMILITAR_THEME_DIR . '/patterns/faq.php' );

		$this->assertStringContainsString( 'data-accordion-root', $content );
		$this->assertStringContainsString( 'data-accordion-trigger', $content );
		$this->assertStringContainsString( 'data-accordion-panel', $content );
	}
}
