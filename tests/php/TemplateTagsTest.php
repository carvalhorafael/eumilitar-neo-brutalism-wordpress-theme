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
 * @covers ::eumilitar_get_listing_excerpt
 * @covers ::eumilitar_render_post_meta
 * @covers ::eumilitar_render_post_taxonomy
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

	/**
	 * Listing excerpts should stay compact even when editors write long manual excerpts.
	 */
	public function test_listing_excerpt_is_trimmed_for_blog_cards(): void {
		$post_id = wp_insert_post(
			array(
				'post_title'   => 'Artigo com resumo longo',
				'post_status'  => 'publish',
				'post_content' => 'Conteúdo do artigo.',
				'post_excerpt' => 'Este resumo editorial foi escrito com muitas palavras para simular um artigo real importado do site em produção e precisa ser reduzido na listagem.',
			),
			true
		);

		$this->assertIsInt( $post_id );

		$excerpt = eumilitar_get_listing_excerpt( $post_id, 10 );

		$this->assertSame( 'Este resumo editorial foi escrito com muitas palavras para simular [...]', $excerpt );

		wp_delete_post( $post_id, true );
	}

	/**
	 * Post metadata should expose date, author and categories.
	 */
	public function test_post_meta_renders_editorial_context(): void {
		$category = wp_insert_term(
			'Estratégia',
			'category',
			array(
				'slug' => 'estrategia-meta-test',
			)
		);

		$this->assertIsArray( $category );

		$category_id = (int) $category['term_id'];
		$post_id     = wp_insert_post(
			array(
				'post_title'    => 'Artigo com meta',
				'post_status'   => 'publish',
				'post_content'  => 'Conteúdo do artigo.',
				'post_category' => array( $category_id ),
			),
			true
		);

		$this->assertIsInt( $post_id );

		ob_start();
		eumilitar_render_post_meta( $post_id );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'entry-meta', $output );
		$this->assertStringContainsString( 'Informações do artigo', $output );
		$this->assertStringContainsString( 'Por', $output );
		$this->assertStringContainsString( 'Estratégia', $output );

		wp_delete_post( $post_id, true );
		wp_delete_term( $category_id, 'category' );
	}

	/**
	 * Post taxonomy should expose category and tag links.
	 */
	public function test_post_taxonomy_renders_categories_and_tags(): void {
		$category = wp_insert_term(
			'Carreira militar',
			'category',
			array(
				'slug' => 'carreira-militar-taxonomy-test',
			)
		);
		$tag      = wp_insert_term(
			'Edital taxonomy test',
			'post_tag',
			array(
				'slug' => 'edital-taxonomy-test',
			)
		);

		$this->assertIsArray( $category );
		$this->assertIsArray( $tag );

		$post_id = wp_insert_post(
			array(
				'post_title'    => 'Artigo com taxonomia',
				'post_status'   => 'publish',
				'post_content'  => 'Conteúdo do artigo.',
				'post_category' => array( (int) $category['term_id'] ),
				'tags_input'    => array( 'Edital taxonomy test' ),
			),
			true
		);

		$this->assertIsInt( $post_id );

		ob_start();
		eumilitar_render_post_taxonomy( $post_id );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'entry-taxonomy', $output );
		$this->assertStringContainsString( 'Categorias', $output );
		$this->assertStringContainsString( 'Tags', $output );
		$this->assertStringContainsString( 'Carreira militar', $output );
		$this->assertStringContainsString( 'Edital taxonomy test', $output );

		wp_delete_post( $post_id, true );
		wp_delete_term( (int) $category['term_id'], 'category' );
		wp_delete_term( (int) $tag['term_id'], 'post_tag' );
	}
}
