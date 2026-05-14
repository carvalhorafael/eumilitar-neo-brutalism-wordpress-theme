<?php
/**
 * Title: Captação EuMilitar
 * Slug: eumilitar/capture
 * Categories: eumilitar
 * Description: Formulário de captação baseado no contrato do EuMilitar Design System.
 *
 * @package EuMilitar
 */

?>
<!-- wp:html -->
<section class="ds-capture ds-capture--lead">
	<p class="ds-capture__eyebrow">Receba orientação</p>
	<h2 class="ds-capture__title">Descubra qual trilha faz sentido para seu objetivo.</h2>
	<p class="ds-capture__body">Deixe seus dados para receber uma recomendação inicial.</p>
	<form class="ds-capture__form" action="#" method="post">
		<label class="ds-input__label" for="lead-name-pattern">Nome *</label>
		<input class="ds-input__field" id="lead-name-pattern" type="text" placeholder="Seu nome" required>
		<label class="ds-input__label" for="lead-email-pattern">E-mail *</label>
		<input class="ds-input__field" id="lead-email-pattern" type="email" placeholder="voce@email.com" required>
		<label class="ds-input__label" for="lead-force-pattern">Força de interesse *</label>
		<select class="ds-select__field" id="lead-force-pattern" required>
			<option value="exercito">Exército</option>
			<option value="marinha">Marinha</option>
			<option value="aeronautica">Aeronáutica</option>
		</select>
		<button class="ds-button ds-button--primary" type="submit">Receber recomendação</button>
	</form>
</section>
<!-- /wp:html -->
