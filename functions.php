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
		include_once( CHILD_DIR . '/custom/custom_functions.php' );
}

/** Image Sizes */
add_image_size ( 'featured', 370, 116, true );
add_image_size ( 'nivoslider', 960, 300, true );
add_image_size ( 'djprofile', 240, 220, true );

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
add_theme_support( 'genesis-custom-header', array( 'width' => 220, 'height' => 100 ) );

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


add_action( 'init', 'child_reg_post_type' );
/**
 * Register new post type
 *
 * @author Greg Rickaby
 * @since 1.3.0
 */
function child_reg_post_type() {
	$labels = array(
		'name' => _x( 'DJs', 'post type general name' ),
		'singular_name' => _x( 'DJ', 'post type singular name' ),
		'add_new' => _x( 'Add New', 'DJ' ),
		'add_new_item' => __( 'Add New DJ' ),
		'edit_item' => __( 'Edit DJ' ),
		'new_item' => __( 'New DJ' ),
		'all_items' => __( 'All DJs' ),
		'view_item' => __( 'View DJ' ),
		'search_items' => __( 'Search DJs' ),
		'not_found' =>  __( 'No DJs found' ),
		'not_found_in_trash' => __( 'No DJs found in Trash' ), 
		'parent_item_colon' => '',
		'menu_name' => 'DJs'
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false, 
		'hierarchical' => true,
		'menu_position' => null,
		'supports' => array( 'title' )
	); 

	register_post_type( 'DJ', $args );

}


add_filter( 'cmb_meta_boxes', 'child_metaboxes' );
/**
 * Define DJ metabox constants.
 *
 * @author Jared Atchison
 * @since 1.3.0
 * @requires Custom Metabox and Fields for WordPress
 * @link: https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 *
 */
function child_metaboxes( array $meta_boxes ) {
	$prefix = '_cmb_';

	$meta_boxes[] = array(
		'id'         => 'dj_metabox',
		'title'      => 'DJs Details',
		'pages'      => array( 'dj', ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(

			array(
				'name' => 'Name',
				'desc' => 'Rick Dees',
				'id'   => $prefix . 'dj_name',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Airshift Time',
				'desc' => 'Middays 10a-3p',
				'id'   => $prefix . 'dj_airshift',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Profile Photo',
				'desc' => 'Upload an image',
				'id'   => $prefix . 'dj_profile_photo',
				'type' => 'file',
			),
			array(
				'name' => 'Biography',
				'desc' => '',
				'id'   => $prefix . 'dj_biography',
				'type' => 'wysiwyg',
				'options' => array( 'textarea_rows' => 5, ),
			),
			array(
				'name' => 'Gallery ID',
				'desc' => 'The NexGen Gallery ID',
				'id'   => $prefix . 'dj_gallery',
				'type' => 'text_small',
			),
			array(
				'name' => 'Post Tag',
				'desc' => 'The Post Tag slug e.g., aimee-fuller',
				'id'   => $prefix . 'dj_tags',
				'type' => 'text_small',
			),
			array(
				'name' => 'Facebook URI',
				'desc' => 'https://www.facebook.com/RickDees',
				'id'   => $prefix . 'dj_facebook_uri,',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Twitter Username',
				'desc' => 'rickdees',
				'id'   => $prefix . 'dj_twitter_username',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Google+ URI',
				'desc' => 'https://plus.google.com/u/0/115960795578445596136/posts',
				'id'   => $prefix . 'dj_googleplus_uri,',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Email Address',
				'desc' => 'rickdees@rick.com',
				'id'   => $prefix . 'dj_email,',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Instagram Username',
				'desc' => 'aimee_fuller',
				'id'   => $prefix . 'dj_instagram_username',
				'type' => 'text_medium',
			),
		),
	);
	return $meta_boxes;
}


add_action( 'init', 'child_initialize_cmb_meta_boxes', 9999 );
 /**
 * Initialize the metabox class.
 * 
 * @author Greg Rickaby
 * @since 1.3.0
 */
function child_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metaboxes/init.php' );
	}
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