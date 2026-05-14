<?php
/**
 * Title: Sidebar do blog EuMilitar
 * Slug: eumilitar/sidebar-blog
 * Categories: eumilitar
 * Description: Composição inicial para a barra lateral editorial do blog.
 *
 * @package EuMilitar
 */

?>
<!-- wp:group {"className":"widget-stack widget-stack--blog-sidebar"} -->
<div class="wp-block-group widget-stack widget-stack--blog-sidebar">
	<!-- wp:search {"label":"Buscar no blog","buttonText":"Buscar"} /-->

	<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true} /-->

	<!-- wp:categories /-->

	<!-- wp:tag-cloud {"taxonomy":"post_tag"} /-->

	<!-- wp:group {"className":"widget-cta widget-cta--compact"} -->
	<div class="wp-block-group widget-cta widget-cta--compact">
		<!-- wp:paragraph {"className":"ds-badge ds-badge--brand"} -->
		<p class="ds-badge ds-badge--brand">Preparação EuMilitar</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading">Continue sua preparação</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>Use os artigos como ponto de partida e avance para uma trilha organizada por edital.</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"ds-button ds-button--primary"} -->
			<div class="wp-block-button ds-button ds-button--primary"><a class="wp-block-button__link wp-element-button" href="/">Ver trilhas</a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
