<?php
/**
 * Template helper tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies shared template helper output and detection behavior.
 *
 * @covers ::eumilitar_render_action
 * @covers ::eumilitar_render_badge
 * @covers ::eumilitar_post_uses_design_system_patterns
 */
final class TemplateTagsTest extends TestCase {
	/**
	 * Badge labels should be escaped before rendering.
	 */
	public function test_badge_output_is_escaped(): void {
		ob_start();
		eumilitar_render_badge(
			array(
				'label'   => '<script>alert("x")</script>',
				'variant' => 'brand danger',
			)
		);
		$output = ob_get_clean();

		$this->assertStringContainsString( 'ds-badge--brand danger', $output );
		$this->assertStringContainsString( '&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;', $output );
		$this->assertStringNotContainsString( '<script>', $output );
	}

	/**
	 * Action labels and URLs should be escaped before rendering.
	 */
	public function test_action_output_escapes_href_and_label(): void {
		ob_start();
		eumilitar_render_action(
			array(
				'label' => '<strong>Assinar</strong>',
				'href'  => 'javascript:alert(1)',
			)
		);
		$output = ob_get_clean();

		$this->assertStringContainsString( '&lt;strong&gt;Assinar&lt;/strong&gt;', $output );
		$this->assertStringNotContainsString( 'javascript:alert', $output );
	}

	/**
	 * Posts containing EuMilitar patterns should be detected.
	 */
	public function test_detects_posts_using_design_system_patterns(): void {
		$post_id = wp_insert_post(
			array(
				'post_title'   => 'Design system smoke post',
				'post_status'  => 'publish',
				'post_content' => '<!-- wp:pattern {"slug":"eumilitar/faq"} /-->',
			),
			true
		);

		$this->assertIsInt( $post_id );
		$this->assertTrue( eumilitar_post_uses_design_system_patterns( $post_id ) );

		wp_delete_post( $post_id, true );
	}
}
