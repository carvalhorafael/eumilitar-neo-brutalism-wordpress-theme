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
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Pular para o conteúdo', 'eumilitar' ); ?></a>

	<header class="site-header">
		<div class="site-header__inner">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="site-brand__eyebrow"><?php esc_html_e( 'EuMilitar', 'eumilitar' ); ?></span>
					<span class="site-brand__name"><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => 'nav',
					'container_class'=> 'site-navigation',
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</header>

