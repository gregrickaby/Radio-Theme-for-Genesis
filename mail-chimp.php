<?php 
/**
 * This file prevents WordPress from garbling up Mail Chimp forms.
 *
 * @package Radio
 * @author Greg Rickaby
 * @since 1.3.0
 */

/*
Template Name: Mail Chimp
*/

add_filter( 'body_class', 'radio_body_class' );
/**
 * Add mail-chimp class to <body> classes.
 *
 * @author Greg Rickaby
 * @since 1.3.0
 */
function radio_body_class( $classes ) {
	$classes[] = 'mail-chimp';
		return $classes;
}

remove_action( 'genesis_loop', 'genesis_do_loop' ); 
remove_filter( 'the_content', 'wpautop' );
add_action( 'genesis_loop', 'radio_loop_mail_chimp' ); 
/**
 * Remove default loop. Execute child loop instead.
 *
 * @author Greg Rickaby
 * @since 1.3.0
 */
function radio_loop_mail_chimp() { 
	the_content();
}

genesis();