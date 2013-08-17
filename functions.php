<?php
/**
 * Functions
 * 
 * This file handles the theme setup and intialization. 
 *
 * @package      Radio
 * @since        1.0.0
 * @author       Greg Rickaby <greg@gregrickaby.com>
 * @copyright    Copyright (c) 2012
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @thanks       Gary J <garyjones.co.uk>, Bill Erickson <billerickson.net>, and Travis Smith <wpsmith.net> for code help
 *
 */

/** Start the engine */
require_once( TEMPLATEPATH.'/lib/init.php' );
if ( version_compare( PARENT_THEME_VERSION, '1.7.9', '>' ) ) {
		include_once( CHILD_DIR . '/lib/admin/admin.php' );
		include_once( CHILD_DIR . '/lib/admin/front.php' );
		include_once( CHILD_DIR . '/lib/scripts/opengraph-meta.php' );
		include_once( CHILD_DIR . '/lib/widgets/radio-featured-video-widget.php' );
		include_once( CHILD_DIR . '/custom/custom_functions.php' );
}

/** Image Sizes */
add_image_size ( 'featured', 370, 116, true );
add_image_size ( 'nivoslider', 960, 300, true );

/** Add support for oEmbeds */
if ( ! isset( $content_width ) )
	$content_width = 600;

/** Menus */
add_theme_support( 'genesis-menus', array( 'primary' => 'Primary Navigation' ) );

/** Add support for custom background */
add_theme_support( 'custom-background', array( 'default-color' => '000000',) );

/** This theme styles the visual editor with editor-style.css to match the theme style. */
add_editor_style();

/** Add support for custom header */
add_theme_support( 'custom-header', array( 'width' => 220, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Add default posts and comments RSS feed links to head */
add_theme_support( 'automatic-feed-links' );

/** Remove the edit link */
add_filter ( 'genesis_edit_post_link' , '__return_false' );

/** Create additional color style options */
add_theme_support( 'child-style-selector', array( 
	'radio-red' => 'Red',
	'radio-orange' => 'Orange',
	'radio-green' => 'Green',
	'radio-blue' => 'Blue',
	'radio-light-blue' => 'Light Blue',
	'radio-indigo' => 'Indigo',
	'radio-violet' => 'Violet',
	'radio-brown' => 'Brown',
	'radio-black' => 'Black',
));

/** Sidebars */
unregister_sidebar( 'sidebar-alt' );
genesis_register_sidebar(array(
	'name'=>'Home Left',
	'id' => 'homepage-left',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'description' => 'This is the first column of the homepage.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

genesis_register_sidebar(array(
	'name'=>'Home Middle',
	'id' => 'homepage-right',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'description' => 'This is the second column of the homepage.',
	'before_title'=>'<h4 class="widgettitle">','after_title'=>'</h4>'
));

/** Remove Unused Page Layouts */
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/** Remove NextGen Gallery Version from <head>*/
remove_action( 'wp_head', array( 'nggGallery', 'nextgen_version' ) );

add_action( 'wp_enqueue_scripts', 'radio_google_fonts' );
/**
 * Load Google Fonts
 *
 * @since 1.0.0
 */
function radio_google_fonts() {

	wp_register_style( 'googlefont-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:700,400', array(), false, 'all' );

	if ( !is_admin() )
	wp_enqueue_style( 'googlefont-open-sans' );

}


/**
 * Change the location of the favicon reference.
 *
 * @author Greg Rickaby
 * @since 1.3.0
 */
function radio_favicon_filter( $favicon_url ) {

	return  get_stylesheet_directory_uri() . '/custom/favicon.ico';

}