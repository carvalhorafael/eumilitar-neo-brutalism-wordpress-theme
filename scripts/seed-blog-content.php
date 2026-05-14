<?php
/**
 * Seed local blog content for visual development.
 *
 * This script is intended for wp-env/local development only. It is idempotent:
 * posts, terms, pages and comments are updated or reused by slug/email.
 *
 * @package EuMilitar
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get or create a term by slug.
 *
 * @param string $taxonomy Taxonomy name.
 * @param string $name Term name.
 * @param string $slug Term slug.
 * @return int
 */
function eumilitar_seed_term( $taxonomy, $name, $slug ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );

	if ( $term ) {
		return (int) $term->term_id;
	}

	$created = wp_insert_term(
		$name,
		$taxonomy,
		array(
			'slug' => $slug,
		)
	);

	if ( is_wp_error( $created ) ) {
		return 0;
	}

	return (int) $created['term_id'];
}

/**
 * Get or create the configured blog page.
 *
 * @return int
 */
function eumilitar_seed_blog_page() {
	$page_id = (int) get_option( 'page_for_posts' );

	if ( $page_id && 'page' === get_post_type( $page_id ) ) {
		return $page_id;
	}

	$page = get_page_by_path( 'artigos' );

	if ( $page ) {
		update_option( 'page_for_posts', (int) $page->ID );
		return (int) $page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_content' => 'Conteúdos e orientações para sua preparação militar.',
			'post_name'    => 'artigos',
			'post_status'  => 'publish',
			'post_title'   => 'Artigos',
			'post_type'    => 'page',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		return 0;
	}

	update_option( 'page_for_posts', (int) $page_id );

	return (int) $page_id;
}

/**
 * Build post content for the seeded articles.
 *
 * @param string $topic Article topic.
 * @return string
 */
function eumilitar_seed_post_content( $topic ) {
	return <<<HTML
<!-- wp:paragraph -->
<p>Este artigo de desenvolvimento ajuda a validar a leitura de um conteúdo editorial mais longo no tema EuMilitar.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>{$topic}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A ideia é simular um texto real de blog, com orientação prática, linguagem direta e blocos comuns do Gutenberg. Use este conteúdo para conferir ritmo, espaçamento, metadados, paginação e comentários.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Organize os pontos mais cobrados do edital.</li>
<li>Defina ciclos curtos de revisão e simulado.</li>
<li>Registre erros recorrentes para revisar antes da prova.</li>
</ul>
<!-- /wp:list -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><p>Preparação consistente nasce de rotina clara, revisão ativa e treino com questões.</p></blockquote>
<!-- /wp:quote -->

<!-- wp:paragraph -->
<p>Ao final da semana, revise o que foi feito e ajuste o próximo ciclo com base no desempenho. Esse fechamento ajuda a manter o estudo conectado ao objetivo principal.</p>
<!-- /wp:paragraph -->
HTML;
}

$blog_page_id = eumilitar_seed_blog_page();

update_option( 'posts_per_page', 4 );

$categories = array(
	'dev-rotina'            => eumilitar_seed_term( 'category', 'Rotina', 'dev-rotina' ),
	'dev-edital'            => eumilitar_seed_term( 'category', 'Edital', 'dev-edital' ),
	'dev-preparacao-fisica' => eumilitar_seed_term( 'category', 'Preparação física', 'dev-preparacao-fisica' ),
	'dev-simulados'         => eumilitar_seed_term( 'category', 'Simulados', 'dev-simulados' ),
);

$tags = array(
	'dev-edital'   => eumilitar_seed_term( 'post_tag', 'Edital', 'dev-edital' ),
	'dev-rotina'   => eumilitar_seed_term( 'post_tag', 'Rotina', 'dev-rotina' ),
	'dev-revisao'  => eumilitar_seed_term( 'post_tag', 'Revisão', 'dev-revisao' ),
	'dev-simulado' => eumilitar_seed_term( 'post_tag', 'Simulado', 'dev-simulado' ),
);

$posts = array(
	array(
		'category' => 'dev-rotina',
		'excerpt'  => 'Um roteiro prático para organizar a semana de estudos.',
		'slug'     => 'como-organizar-a-rotina-de-estudos',
		'tags'     => array( 'dev-rotina', 'dev-revisao' ),
		'title'    => 'Como organizar a rotina de estudos',
		'topic'    => 'Rotina semanal',
	),
	array(
		'category' => 'dev-simulados',
		'excerpt'  => 'Dicas para revisar sem perder o foco no edital.',
		'slug'     => 'como-revisar-antes-do-simulado',
		'tags'     => array( 'dev-simulado', 'dev-revisao' ),
		'title'    => 'Como revisar antes do simulado',
		'topic'    => 'Revisão antes do simulado',
	),
	array(
		'category' => 'dev-rotina',
		'excerpt'  => 'Um exemplo de ciclo para manter constância.',
		'slug'     => 'como-montar-um-ciclo-de-revisao',
		'tags'     => array( 'dev-rotina', 'dev-revisao' ),
		'title'    => 'Como montar um ciclo de revisão',
		'topic'    => 'Ciclo de revisão',
	),
	array(
		'category' => 'dev-edital',
		'excerpt'  => 'O que observar no edital antes de começar a estudar.',
		'slug'     => 'como-ler-o-edital-sem-perder-pontos-importantes',
		'tags'     => array( 'dev-edital' ),
		'title'    => 'Como ler o edital sem perder pontos importantes',
		'topic'    => 'Leitura do edital',
	),
	array(
		'category' => 'dev-preparacao-fisica',
		'excerpt'  => 'Como encaixar treino físico sem abandonar a teoria.',
		'slug'     => 'preparacao-fisica-dentro-da-rotina-de-estudos',
		'tags'     => array( 'dev-rotina' ),
		'title'    => 'Preparação física dentro da rotina de estudos',
		'topic'    => 'Preparação física',
	),
	array(
		'category' => 'dev-edital',
		'excerpt'  => 'Uma forma simples de separar prioridade alta, média e baixa.',
		'slug'     => 'como-priorizar-materias-do-edital',
		'tags'     => array( 'dev-edital', 'dev-rotina' ),
		'title'    => 'Como priorizar matérias do edital',
		'topic'    => 'Priorização por edital',
	),
	array(
		'category' => 'dev-simulados',
		'excerpt'  => 'Como transformar erros de simulado em revisão objetiva.',
		'slug'     => 'como-usar-erros-do-simulado-para-revisar',
		'tags'     => array( 'dev-simulado', 'dev-revisao' ),
		'title'    => 'Como usar erros do simulado para revisar',
		'topic'    => 'Correção de simulado',
	),
	array(
		'category' => 'dev-rotina',
		'excerpt'  => 'Critérios simples para ajustar o plano sem recomeçar do zero.',
		'slug'     => 'quando-ajustar-a-rotina-de-estudos',
		'tags'     => array( 'dev-rotina' ),
		'title'    => 'Quando ajustar a rotina de estudos',
		'topic'    => 'Ajuste de rotina',
	),
);

$created_or_updated = 0;
$first_post_id      = 0;

foreach ( $posts as $index => $seed_post ) {
	$existing = get_page_by_path( $seed_post['slug'], OBJECT, 'post' );
	$post_id  = $existing ? (int) $existing->ID : 0;

	$post_data = array(
		'comment_status' => 'open',
		'post_content'   => eumilitar_seed_post_content( $seed_post['topic'] ),
		'post_excerpt'   => $seed_post['excerpt'],
		'post_name'      => $seed_post['slug'],
		'post_status'    => 'publish',
		'post_title'     => $seed_post['title'],
		'post_type'      => 'post',
	);

	if ( $post_id ) {
		$post_data['ID'] = $post_id;
		$result          = wp_update_post( $post_data, true );
	} else {
		$post_data['post_date'] = gmdate( 'Y-m-d H:i:s', strtotime( '-' . $index . ' days' ) );
		$result                 = wp_insert_post( $post_data, true );
	}

	if ( is_wp_error( $result ) ) {
		continue;
	}

	$post_id = (int) $result;

	if ( 0 === $index ) {
		$first_post_id = $post_id;
		stick_post( $post_id );
	}

	if ( ! empty( $categories[ $seed_post['category'] ] ) ) {
		wp_set_post_terms( $post_id, array( $categories[ $seed_post['category'] ] ), 'category' );
	}

	$post_tag_ids = array();
	foreach ( $seed_post['tags'] as $tag_slug ) {
		if ( ! empty( $tags[ $tag_slug ] ) ) {
			$post_tag_ids[] = $tags[ $tag_slug ];
		}
	}
	wp_set_post_terms( $post_id, $post_tag_ids, 'post_tag' );

	if ( $index < 3 ) {
		$comment_email = 'comentario-demo-' . $index . '@example.com';
		$existing      = get_comments(
			array(
				'author_email' => $comment_email,
				'count'        => true,
				'post_id'      => $post_id,
			)
		);

		if ( ! $existing ) {
			wp_insert_comment(
				array(
					'comment_approved'     => 1,
					'comment_author'       => 'Aluno EuMilitar',
					'comment_author_email' => $comment_email,
					'comment_content'      => 'Esse conteúdo ajudou a transformar o plano de estudos em uma rotina mais clara.',
					'comment_post_ID'      => $post_id,
				)
			);
		}
	}

	$created_or_updated++;
}

printf(
	"Seed concluído: %d posts atualizados/criados, blog page ID %d, post principal ID %d.\n",
	(int) $created_or_updated,
	(int) $blog_page_id,
	(int) $first_post_id
);
