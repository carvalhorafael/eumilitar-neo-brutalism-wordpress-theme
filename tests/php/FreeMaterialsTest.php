<?php
/**
 * Free material content type tests.
 *
 * @package EuMilitar
 */

use PHPUnit\Framework\TestCase;

/**
 * Verifies the free material content contract.
 *
 * @covers ::eumilitar_get_free_material_cta
 * @covers ::eumilitar_register_free_material_content_type
 * @covers ::eumilitar_render_free_material_terms
 */
final class FreeMaterialsTest extends TestCase {
	/**
	 * Free material post type should be public and editor friendly.
	 */
	public function test_free_material_post_type_is_registered(): void {
		$post_type = get_post_type_object( EUMILITAR_FREE_MATERIAL_POST_TYPE );

		$this->assertNotNull( $post_type );
		$this->assertTrue( $post_type->public );
		$this->assertSame( 'materiais-gratuitos', $post_type->has_archive );
		$this->assertTrue( $post_type->show_in_rest );
		$this->assertTrue( post_type_supports( EUMILITAR_FREE_MATERIAL_POST_TYPE, 'title' ) );
		$this->assertTrue( post_type_supports( EUMILITAR_FREE_MATERIAL_POST_TYPE, 'editor' ) );
		$this->assertTrue( post_type_supports( EUMILITAR_FREE_MATERIAL_POST_TYPE, 'thumbnail' ) );
		$this->assertTrue( post_type_supports( EUMILITAR_FREE_MATERIAL_POST_TYPE, 'excerpt' ) );
	}

	/**
	 * Free material categories should be isolated from blog categories.
	 */
	public function test_free_material_taxonomy_is_registered(): void {
		$taxonomy = get_taxonomy( EUMILITAR_FREE_MATERIAL_TAXONOMY );

		$this->assertNotFalse( $taxonomy );
		$this->assertTrue( $taxonomy->hierarchical );
		$this->assertTrue( $taxonomy->show_in_rest );
		$this->assertContains( EUMILITAR_FREE_MATERIAL_POST_TYPE, $taxonomy->object_type );
		$this->assertSame( 'materiais-gratuitos/categoria', $taxonomy->rewrite['slug'] );
	}

	/**
	 * Capture CTA should use explicit metadata with a safe fallback.
	 */
	public function test_free_material_cta_uses_metadata_and_fallback(): void {
		$post_id = wp_insert_post(
			array(
				'post_title'  => 'Checklist gratuito',
				'post_status' => 'publish',
				'post_type'   => EUMILITAR_FREE_MATERIAL_POST_TYPE,
			),
			true
		);

		$this->assertIsInt( $post_id );

		$fallback = eumilitar_get_free_material_cta( $post_id );

		$this->assertSame( 'Baixar material gratuito', $fallback['label'] );
		$this->assertSame( '#captura', $fallback['url'] );

		update_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_URL, 'https://example.com/captura' );
		update_post_meta( $post_id, EUMILITAR_FREE_MATERIAL_CTA_LABEL, 'Receber checklist' );

		$cta = eumilitar_get_free_material_cta( $post_id );

		$this->assertSame( 'Receber checklist', $cta['label'] );
		$this->assertSame( 'https://example.com/captura', $cta['url'] );

		wp_delete_post( $post_id, true );
	}

	/**
	 * Term renderer should output the dedicated free material taxonomy.
	 */
	public function test_free_material_terms_render_category_links(): void {
		$term = wp_insert_term(
			'Planejamento',
			EUMILITAR_FREE_MATERIAL_TAXONOMY,
			array(
				'slug' => 'planejamento-material-test',
			)
		);

		$this->assertIsArray( $term );

		$post_id = wp_insert_post(
			array(
				'post_title'  => 'Guia de estudos',
				'post_status' => 'publish',
				'post_type'   => EUMILITAR_FREE_MATERIAL_POST_TYPE,
			),
			true
		);

		$this->assertIsInt( $post_id );
		wp_set_object_terms( $post_id, (int) $term['term_id'], EUMILITAR_FREE_MATERIAL_TAXONOMY );

		ob_start();
		eumilitar_render_free_material_terms( $post_id );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'free-material-terms', $output );
		$this->assertStringContainsString( 'Categoria', $output );
		$this->assertStringContainsString( 'Planejamento', $output );

		wp_delete_post( $post_id, true );
		wp_delete_term( (int) $term['term_id'], EUMILITAR_FREE_MATERIAL_TAXONOMY );
	}
}
