<?php
/**
 * Front page smoke template for the design system consumer.
 *
 * @package EuMilitar
 */

get_header();

$posts_page_id   = (int) get_option( 'page_for_posts' );
$blog_url        = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
$latest_posts    = get_posts(
	array(
		'numberposts' => 1,
		'post_status' => 'publish',
	)
);
$latest_post_url = $latest_posts ? get_permalink( $latest_posts[0] ) : $blog_url;
?>

<main id="primary" class="site-main site-main--landing">
	<?php
	get_template_part(
		'template-parts/patterns/hero',
		null,
		array(
			'variant'         => 'light',
			'eyebrow'         => 'Preparação militar',
			'badges'          => array(
				array(
					'label'   => 'Exército',
					'variant' => 'ex',
				),
				array(
					'label'   => 'Marinha',
					'variant' => 'mb',
				),
			),
			'headline'        => 'Prepare-se para as Forças Armadas com uma trilha por edital.',
			'supporting_copy' => 'Questões, simulados e acompanhamento para acelerar a aprovação.',
			'primary_cta'     => array(
				'label'   => 'Ver artigos',
				'href'    => $blog_url,
				'variant' => 'primary',
			),
			'secondary_cta'   => array(
				'label'   => 'Ler artigo recente',
				'href'    => $latest_post_url,
				'variant' => 'secondary',
			),
		)
	);

	get_template_part(
		'template-parts/patterns/urgency',
		null,
		array(
			'variant'         => 'max-conversion-cta',
			'badge'           => array(
				'label'   => 'Inscrições abertas',
				'variant' => 'urgent',
			),
			'headline'        => 'Últimos dias para entrar na turma de preparação.',
			'supporting_copy' => 'Organize sua rotina antes da próxima rodada de simulados.',
			'stat'            => array(
				'value' => '72h',
				'label' => 'para garantir as condições atuais',
			),
			'primary_cta'     => array(
				'label'   => 'Garantir vaga',
				'href'    => '#checkout',
				'variant' => 'brand-inverse',
			),
			'secondary_cta'   => array(
				'label'   => 'Ver detalhes',
				'href'    => '#faq',
				'variant' => 'ghost-inverse',
			),
		)
	);

	get_template_part(
		'template-parts/patterns/benefits',
		null,
		array(
			'variant'     => 'icon-grid',
			'headline'    => 'Uma base de estudos pronta para o edital.',
			'items'       => array(
				array(
					'title'       => 'Trilha guiada',
					'description' => 'Sequência de aulas e questões organizada por objetivo.',
				),
				array(
					'title'       => 'Simulados',
					'description' => 'Treinos periódicos para medir evolução e ajustar foco.',
				),
				array(
					'title'       => 'Revisão ativa',
					'description' => 'Rotina de retomada para fixar os assuntos mais cobrados.',
				),
			),
			'stats'       => array(
				array(
					'value' => '3x',
					'label' => 'mais clareza na rotina semanal',
				),
				array(
					'value' => '100%',
					'label' => 'foco no edital militar',
				),
			),
			'primary_cta' => array(
				'label'   => 'Ver plano',
				'href'    => '#planos',
				'variant' => 'primary',
			),
		)
	);

	get_template_part(
		'template-parts/patterns/testimonials',
		null,
		array(
			'variant'  => 'grid',
			'eyebrow'  => 'Prova social',
			'headline' => 'Histórias de quem saiu da rotina solta.',
			'items'    => array(
				array(
					'quote'  => 'Eu parei de estudar no improviso e comecei a entender o que precisava revisar.',
					'author' => 'Aluno EuMilitar',
					'meta'   => 'Preparação para carreira militar',
					'badge'  => array(
						'label'   => 'Rotina',
						'variant' => 'brand',
					),
				),
				array(
					'quote'  => 'Os simulados ajudaram a enxergar onde eu estava perdendo pontos.',
					'author' => 'Aluna EuMilitar',
					'meta'   => 'Foco em edital',
					'badge'  => array(
						'label'   => 'Simulado',
						'variant' => 'default',
					),
				),
			),
		)
	);

	get_template_part(
		'template-parts/patterns/capture',
		null,
		array(
			'variant'         => 'lead',
			'eyebrow'         => 'Receba orientação',
			'headline'        => 'Descubra qual trilha faz sentido para seu objetivo.',
			'supporting_copy' => 'Deixe seus dados para receber uma recomendação inicial.',
			'fields'          => array(
				array(
					'id'          => 'lead-name',
					'label'       => 'Nome',
					'type'        => 'text',
					'placeholder' => 'Seu nome',
					'required'    => true,
				),
				array(
					'id'          => 'lead-email',
					'label'       => 'E-mail',
					'type'        => 'email',
					'placeholder' => 'voce@email.com',
					'required'    => true,
				),
				array(
					'id'       => 'lead-force',
					'label'    => 'Força de interesse',
					'type'     => 'select',
					'required' => true,
					'options'  => array(
						array(
							'label' => 'Exército',
							'value' => 'exercito',
						),
						array(
							'label' => 'Marinha',
							'value' => 'marinha',
						),
						array(
							'label' => 'Aeronáutica',
							'value' => 'aeronautica',
						),
					),
				),
			),
			'submit_label'    => 'Receber recomendação',
		)
	);

	get_template_part(
		'template-parts/patterns/faq',
		null,
		array(
			'eyebrow'  => 'Dúvidas frequentes',
			'headline' => 'Perguntas e respostas',
			'items'    => array(
				array(
					'question' => 'O tema recria o design system?',
					'answer'   => 'Não. Ele consome tokens, CSS e contratos publicados pela biblioteca EuMilitar.',
				),
				array(
					'question' => 'Elementor pode ser usado?',
					'answer'   => 'Sim, desde que opere sobre a base visual do tema e use as classes do design system quando possível.',
				),
			),
		)
	);

	get_template_part(
		'template-parts/patterns/cta',
		null,
		array(
			'variant'         => 'brand-dark',
			'badge'           => array(
				'label'   => 'Plano completo',
				'variant' => 'brand',
			),
			'headline'        => 'Comece sua preparação hoje',
			'supporting_copy' => 'Acesso imediato ao curso completo.',
			'primary_cta'     => array(
				'label'   => 'Assinar agora',
				'href'    => '#checkout',
				'variant' => 'brand-inverse',
			),
			'secondary_cta'   => array(
				'label'   => 'Saiba mais',
				'href'    => '#faq',
				'variant' => 'ghost-inverse',
			),
		)
	);
	?>
</main>

<?php
get_footer();
