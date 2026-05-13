<?php
/**
 * Front page smoke template for the design system consumer.
 *
 * @package EuMilitar
 */

get_header();
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
				'label'   => 'Começar agora',
				'href'    => '#planos',
				'variant' => 'primary',
			),
			'secondary_cta'   => array(
				'label'   => 'Ver dúvidas',
				'href'    => '#faq',
				'variant' => 'secondary',
			),
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

