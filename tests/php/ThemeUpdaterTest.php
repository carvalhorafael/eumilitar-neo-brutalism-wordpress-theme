<?php
/**
 * Theme updater tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies GitHub release payloads are converted into WordPress update data.
 *
 * @covers ::eumilitar_theme_update_from_release
 * @covers ::eumilitar_normalize_github_release_version
 * @covers ::eumilitar_find_github_release_asset_url
 */
final class ThemeUpdaterTest extends TestCase {
	/**
	 * Clean cached release payloads after each test.
	 */
	protected function tearDown(): void {
		delete_site_transient( EUMILITAR_THEME_RELEASE_CACHE_KEY );

		parent::tearDown();
	}

	/**
	 * The GitHub hostname updater hook should be registered for WordPress update checks.
	 */
	public function test_github_update_hook_is_registered(): void {
		$this->assertSame( 10, has_filter( 'update_themes_github.com', 'eumilitar_filter_github_theme_update' ) );
	}

	/**
	 * A newer GitHub release with the packaged ZIP should produce update data.
	 */
	public function test_github_release_produces_theme_update(): void {
		$release = array(
			'tag_name' => 'v0.3.1',
			'html_url' => 'https://github.com/carvalhorafael/eumilitar-neo-brutalism-wordpress-theme/releases/tag/v0.3.1',
			'assets'   => array(
				array(
					'name'                 => EUMILITAR_THEME_RELEASE_ASSET,
					'browser_download_url' => 'https://github.com/carvalhorafael/eumilitar-neo-brutalism-wordpress-theme/releases/download/v0.3.1/eumilitar-neo-brutalism-wordpress-theme.zip',
				),
			),
		);

		$update = eumilitar_theme_update_from_release( $release, '0.3.0' );

		$this->assertIsArray( $update );
		$this->assertSame( EUMILITAR_THEME_SLUG, $update['theme'] );
		$this->assertSame( '0.3.1', $update['version'] );
		$this->assertSame( '0.3.1', $update['new_version'] );
		$this->assertSame( $release['html_url'], $update['url'] );
		$this->assertSame( $release['assets'][0]['browser_download_url'], $update['package'] );
	}

	/**
	 * Current or older releases should not be offered as updates.
	 */
	public function test_current_release_does_not_produce_theme_update(): void {
		$release = array(
			'tag_name' => 'v0.3.0',
			'assets'   => array(
				array(
					'name'                 => EUMILITAR_THEME_RELEASE_ASSET,
					'browser_download_url' => 'https://github.com/carvalhorafael/eumilitar-neo-brutalism-wordpress-theme/releases/download/v0.3.0/eumilitar-neo-brutalism-wordpress-theme.zip',
				),
			),
		);

		$this->assertFalse( eumilitar_theme_update_from_release( $release, '0.3.0' ) );
	}

	/**
	 * A release without the expected ZIP asset should not be offered to WordPress.
	 */
	public function test_release_without_theme_zip_does_not_produce_theme_update(): void {
		$release = array(
			'tag_name' => 'v0.3.1',
			'assets'   => array(
				array(
					'name'                 => 'source.zip',
					'browser_download_url' => 'https://github.com/example/source.zip',
				),
			),
		);

		$this->assertFalse( eumilitar_theme_update_from_release( $release, '0.3.0' ) );
	}

	/**
	 * The WordPress update filter should use the cached GitHub release for this theme.
	 */
	public function test_update_filter_returns_cached_github_release_for_this_theme(): void {
		set_site_transient(
			EUMILITAR_THEME_RELEASE_CACHE_KEY,
			array(
				'tag_name' => 'v0.3.1',
				'html_url' => 'https://github.com/carvalhorafael/eumilitar-neo-brutalism-wordpress-theme/releases/tag/v0.3.1',
				'assets'   => array(
					array(
						'name'                 => EUMILITAR_THEME_RELEASE_ASSET,
						'browser_download_url' => 'https://github.com/carvalhorafael/eumilitar-neo-brutalism-wordpress-theme/releases/download/v0.3.1/eumilitar-neo-brutalism-wordpress-theme.zip',
					),
				),
			)
		);

		$update = eumilitar_filter_github_theme_update(
			false,
			array(
				'UpdateURI' => EUMILITAR_THEME_UPDATE_URI,
			),
			EUMILITAR_THEME_SLUG,
			array()
		);

		$this->assertIsArray( $update );
		$this->assertSame( '0.3.1', $update['new_version'] );
	}

	/**
	 * The WordPress update filter should leave unrelated GitHub themes untouched.
	 */
	public function test_update_filter_ignores_other_themes(): void {
		$existing_update = array(
			'theme' => 'other-theme',
		);

		$this->assertSame(
			$existing_update,
			eumilitar_filter_github_theme_update(
				$existing_update,
				array(
					'UpdateURI' => EUMILITAR_THEME_UPDATE_URI,
				),
				'other-theme',
				array()
			)
		);
	}
}
