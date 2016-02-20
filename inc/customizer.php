<?php
/**
 * Theme Customizer - drebbits
 *
 * @package drebbits
 */

/**
 * Register new fields for site tagline
 *
 * @param object $wp_customize     Theme Customizer object.
 */
function drebbits_paper_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'sitelogo', array(
		'type'       => 'theme_mod',
		'capability' => 'manage_options',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'sitelogo', array(
		'label'     => __( 'Logo', 'drebbits' ),
		'section'   => 'title_tagline',
		'mime_type' => 'image',
	) ) );
}
add_action( 'customize_register', 'drebbits_paper_customize_register' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function dbx_paper_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'sitelogo' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'dbx_paper_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dbx_paper_customize_preview_js() {
	wp_enqueue_script( 'dbx_paper_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'dbx_paper_customize_preview_js' );
