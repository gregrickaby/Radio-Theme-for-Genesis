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
		include_once( CHILD_DIR . '/lib/admin/update.php' );
		include_once( CHILD_DIR . '/lib/widgets/radio-latest-news-widget.php' );
}

/** Image Sizes */
add_image_size ( 'featured', 370, 150, true );
add_image_size ( 'nivoslider', 960, 300, true );

/** Menus */
add_theme_support( 'genesis-menus', array( 'primary' => 'Primary Navigation' ) );

/** Add support for custom background */
add_custom_background();

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 220, 'height' => 100 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Add default posts and comments RSS feed links to head */
add_theme_support( 'automatic-feed-links' );

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

remove_action( 'wp_head', array( 'nggGallery', 'nextgen_version' ) );
add_action( 'wp_print_styles', 'radio_manage_scripts', 100 );
/**
 * Remove unwanted scripts css from the homepage
 * 
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_manage_scripts() {
	if ( is_front_page() ) {
		wp_dequeue_script( 'ngg-slideshow' );
		wp_deregister_script( 'jquery-cycle' );
		wp_deregister_script( 'thickbox' );
		wp_deregister_style( 'NextGEN' );
		wp_deregister_style( 'shutter' );
		wp_deregister_style( 'gforms_css' );
		wp_deregister_style( 'thickbox' );
	}
}