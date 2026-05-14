<?php
/**
 * Theme setup integration tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies WordPress-facing setup registered by the theme.
 *
 * @covers ::eumilitar_theme_setup
 */
final class ThemeSetupTest extends TestCase {
	/**
	 * Theme setup should enable the expected WordPress supports.
	 */
	public function test_expected_theme_supports_are_registered(): void {
		$supports = array(
			'automatic-feed-links',
			'title-tag',
			'post-thumbnails',
			'custom-logo',
			'align-wide',
			'editor-styles',
			'responsive-embeds',
			'wp-block-styles',
			'html5',
		);

		foreach ( $supports as $support ) {
			$this->assertTrue( current_theme_supports( $support ), "{$support} support should be registered." );
		}
	}

	/**
	 * The primary menu location should be available to WordPress.
	 */
	public function test_primary_menu_is_registered(): void {
		$menus = get_registered_nav_menus();

		$this->assertArrayHasKey( 'primary', $menus );
		$this->assertSame( 'Menu principal', $menus['primary'] );
	}

	/**
	 * HTML5 support should include native comment and search markup.
	 */
	public function test_html5_support_includes_comment_markup(): void {
		$this->assertTrue( current_theme_supports( 'html5', 'comment-form' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'comment-list' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'search-form' ) );
	}
}
