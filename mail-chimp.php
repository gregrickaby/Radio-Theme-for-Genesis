<?php
/**
 * The template for displaying Mail Chimp forms.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/*
Template Name: Mail Chimp
*/

// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Remove automatic paragraph generation
remove_filter( 'the_content', 'wpautop' );


add_filter( 'body_class', 'radio_body_class' );
/**
 * Add body class
 *
 * @author Greg Rickaby
 * @since  1.3.0
 * @param  array $classes  exsisting body class
 * @return array           new body class
 */
function radio_body_class( $classes ) {
	$classes[] = 'mail-chimp';
		return $classes;
}


add_action( 'genesis_loop', 'radio_loop_mail_chimp' );
/**
 * Mail Chimp page loop
 *
 * @author Greg Rickaby
 * @since  1.3.0
 * @return function  return unmangled mail chimp forms
 */
function radio_loop_mail_chimp() {
	the_content();
}

genesis();
