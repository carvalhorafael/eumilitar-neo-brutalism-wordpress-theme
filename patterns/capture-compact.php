<?php
/**
 * Title: Captação compacta EuMilitar
 * Slug: eumilitar/capture-compact
 * Categories: eumilitar
 * Description: Formulário compacto para widgets e áreas estreitas.
 *
 * @package EuMilitar
 */

?>
<!-- wp:html -->
<section class="ds-card widget-capture-compact">
	<span class="ds-badge ds-badge--brand">Receba orientação</span>
	<h2 class="widget-capture-compact__title">Qual trilha combina com seu objetivo?</h2>
	<p>Deixe seu e-mail para receber uma recomendação inicial de preparação.</p>
	<form class="widget-capture-compact__form" action="#" method="post">
		<label class="ds-input__label" for="lead-name-compact-pattern">Nome *</label>
		<input class="ds-input__field" id="lead-name-compact-pattern" type="text" placeholder="Seu nome" required>
		<label class="ds-input__label" for="lead-email-compact-pattern">E-mail *</label>
		<input class="ds-input__field" id="lead-email-compact-pattern" type="email" placeholder="voce@email.com" required>
		<button class="ds-button ds-button--primary" type="submit">Receber recomendação</button>
	</form>
</section>
<!-- /wp:html -->
