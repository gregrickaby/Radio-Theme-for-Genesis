<?php
/**
 * The template for displaying the homepage.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */


/**
 * Helper function
 *
 * Get first image in a post.
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return $first_image first image from a post
 */
function radio_grab_image() {

	global $post, $posts;

	$first_img = '';

	ob_start();
	ob_end_clean();

	// Find the first <img>
	$output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
	$first_img = $matches [1] [0];

	return $first_img;
}


/**
 * Helper function
 *
 * Set the excerpt limit.
 *
 * @author Bavotasan
 * @link   http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 * @since  1.3.0
 * @return $excerpt liminted excerpt
 */
function excerpt( $limit ) {

		// Get current excerpt
		$excerpt = explode( ' ', get_the_excerpt(), $limit );

		// If excerpt is greater than the limit
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );

			// Limit the excerpt and add ...
			$excerpt = implode( ' ', $excerpt ) . '...';

		} else {
			$excerpt = implode( ' ', $excerpt );
		}

		// Finally, remove shortcodes
		$excerpt = preg_replace( '`\[[^\]]*\]`','', $excerpt );

		return $excerpt;
}


/**
 * Helper function
 *
 * Set the content limit.
 *
 * @author Bavotasan
 * @link   http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 * @since  1.3.0
 * @return $content limited content
 */
function content( $limit ) {

	// Get the content
	$content = explode( ' ', get_the_content(), $limit );

	// If content is greater than the limit
	if ( count( $content ) >= $limit ) {
		array_pop( $content );

		// Limit the content
		$content = implode( ' ', $content ) . '...';
	} else {
		$content = implode( " ",$content );
	}

	// $content = preg_replace('/\[.+\]/','', $content); un-comment to remove shortcodes
	$content = apply_filters( 'the_content', $content );
	// $content = str_replace(']]>', ']]&gt;', $content); un-comment to remove shortcodes

	return $content;
}


add_action( 'genesis_after_header', 'radio_featured_content_slider' );
/**
 * Build the featured content slider area
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return html  featured content slider
 */
function radio_featured_content_slider() {

	// Get settings
	$solil_id = genesis_get_option( 'solil_id', 'child-settings' ); ?>

	<?php if ( ( ! $nivo_toggle ) && function_exists( 'soliloquy_slider' ) ) : ?>
		<div class="slider-wrapper radio-soliloquy">
			<?php soliloquy_slider( absint( $solil_id ) ); ?>
		</div>
	<?php endif; ?>

<?php }


// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );


add_action( 'genesis_loop', 'radio_home_loop' );
/**
 * Homepage loop
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return html  three column layout via widget areas
 */
function radio_home_loop() { ?>

	<div id="home-column-1" class="sidebar widget-area">
		<div class="widget-wrap">
			<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Home Left' ) ) {} ?>
		</div>
	</div>

	<div id="home-column-2" class="sidebar widget-area">
		<div class="widget-wrap">
			<?php if ( !function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Home Middle' ) ) {} ?>
		</div>
	</div>

	<?php // the third column is the Primary Sidebar ?>

<?php }

genesis();
