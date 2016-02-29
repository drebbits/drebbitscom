<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package drebbits
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'drebbits' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		<div class="site-branding">
			<?php
			if ( dbx_is_home() ) : ?>
				<h1 class="site-title">
					<img src="<?php echo esc_url( wp_get_attachment_image_url( get_theme_mod( 'sitelogo' ) ) ); ?>" width="196" height="36" alt="<?php bloginfo( 'name' )?>">
				</h1>
			<?php else : ?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( wp_get_attachment_image_url( get_theme_mod( 'sitelogo' ) ) ); ?>" width="196" height="36" alt="<?php bloginfo( 'name' )?>">
				</a>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( ( $description || is_customize_preview() ) && dbx_is_home() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="-inner-wrap">
