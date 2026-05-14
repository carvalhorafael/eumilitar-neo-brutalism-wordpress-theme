<?php
/**
 * Theme header.
 *
 * @package EuMilitar
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Pular para o conteúdo', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></a>

	<header class="site-header">
		<div class="site-header__inner" data-open="false" data-navbar-root>
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-brand__eyebrow"><?php esc_html_e( 'EuMilitar', 'eumilitar-neo-brutalism-wordpress-theme' ); ?></span>
					<span class="site-brand__name"><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>

			<button
				class="ds-navbar__menu-button site-navigation__toggle"
				type="button"
				aria-expanded="false"
				aria-controls="primary-menu-panel"
				aria-label="<?php esc_attr_e( 'Abrir menu', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>"
				data-navbar-trigger
				data-menu-label="<?php esc_attr_e( 'Abrir menu', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>"
				data-close-label="<?php esc_attr_e( 'Fechar menu', 'eumilitar-neo-brutalism-wordpress-theme' ); ?>"
			>
				<span class="ds-navbar__menu-icon" aria-hidden="true" data-open="false">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</button>

			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'menu_id'         => 'primary-menu',
					'container'       => 'nav',
					'container_id'    => 'primary-menu-panel',
					'container_class' => 'site-navigation ds-navbar__panel',
					'fallback_cb'     => 'eumilitar_render_fallback_navigation',
				)
			);
			?>
		</div>
	</header>
