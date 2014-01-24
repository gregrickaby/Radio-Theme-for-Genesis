<?php
/**
 * This file handles the theme setup and intialization.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

// Start the engine
require_once( TEMPLATEPATH . '/lib/init.php' );
if ( version_compare( PARENT_THEME_VERSION, '1.7.9', '>' ) ) {
		include_once( CHILD_DIR . '/lib/admin/admin.php' );
		include_once( CHILD_DIR . '/lib/admin/front.php' );
		include_once( CHILD_DIR . '/lib/widgets/radio-featured-video-widget.php' );
		include_once( CHILD_DIR . '/custom/custom_functions.php' );
}


add_action( 'after_setup_theme', 'radio_theme_setup' );
/**
 * Setup theme defaults
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return mxied  default theme functions
 */
function radio_theme_setup() {

	// Set oEmbed width
	if ( ! isset( $content_width ) ) {
		$content_width = 600;
	}

	// Image Sizes
	add_theme_support( 'post-thumbnails' );
	add_image_size ( 'featured', 370, 116, true );
	add_image_size ( 'soliloquy', 960, 300, true );
	add_image_size ( 'soliloquy-retina', 1920, 600, true );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Menus
	add_theme_support( 'genesis-menus', array(
		'primary' => 'Primary Navigation'
	));

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color' => '000000'
	));

	// Custom post editor styles
	add_editor_style( 'editor-style.css' );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'width' => 220,
		'height' => 100
	));

	// Remove Genesis Defaults
	genesis_unregister_layout( 'sidebar-content' );
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	unregister_sidebar( 'sidebar-alt' );

	// Add support for 3-column footer widgets
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Remove the edit link
	add_filter ( 'genesis_edit_post_link' , '__return_false' );

	// Sidebars
	genesis_register_sidebar( array(
		'name'          => 'Home Left',
		'id'            => 'homepage-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'description'   => 'This is the first column of the homepage.',
		'before_title'  => '<h4 class="widgettitle">','after_title' => '</h4>'
	));

	genesis_register_sidebar( array(
		'name'          => 'Home Middle',
		'id'            => 'homepage-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'description'   => 'This is the second column of the homepage.',
		'before_title'  => '<h4 class="widgettitle">','after_title' => '</h4>'
	));

	// Create additional color style options
	add_theme_support( 'child-style-selector', array(
		'radio-red'        => 'Red',
		'radio-orange'     => 'Orange',
		'radio-green'      => 'Green',
		'radio-blue'       => 'Blue',
		'radio-light-blue' => 'Light Blue',
		'radio-indigo'     => 'Indigo',
		'radio-violet'     => 'Violet',
		'radio-brown'      => 'Brown',
		'radio-black'      => 'Black',
	));


	// Remove NextGen Gallery from <head>
	remove_action( 'wp_head', array( 'nggGallery', 'nextgen_version' ) );

}
