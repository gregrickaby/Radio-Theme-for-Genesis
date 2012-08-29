<?php
/**
 * Grab the first image of the featured posts.
 * 
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_grab_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	return $first_img;
}

/**
 * Set the excerpt limit
 * 
 * @author Bavotasan
 * @lin http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 * @since 1.3.0
 */
function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
		if ( count($excerpt)>=$limit ) {
		array_pop( $excerpt );
	$excerpt = implode( " ",$excerpt ).'...';
		} else {
	$excerpt = implode( " ",$excerpt );
		}	
	$excerpt = preg_replace( '`\[[^\]]*\]`','',$excerpt );
		return $excerpt;
}


/**
 * Set the content limit
 * 
 * @author Bavotasan
 * @lin http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 * @since 1.3.0
 */
function content( $limit ) {
	$content = explode( ' ', get_the_content(), $limit );
		if ( count( $content)>=$limit ) {
			array_pop( $content );
			$content = implode( " ",$content ).'...';
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
 * Build the Nivo featured content slider.
 * 
 * @author Greg Rickaby
 * @since 1.0.0
 */ 
function radio_featured_content_slider() { 
$nivo_toggle = genesis_get_option( 'nivo_show', 'child-settings' );
$nivo_category = genesis_get_option( 'nivo_category', 'child-settings' );
$nivo_order = genesis_get_option( 'nivo_order', 'child-settings' );
$nivo_limit = genesis_get_option( 'nivo_limit', 'child-settings' );
$nivo_sort = genesis_get_option( 'nivo_sort', 'child-settings' );
$solil_id = genesis_get_option( 'solil_id', 'child-settings' );

if ( $nivo_toggle ) { ?>

	<div class="slider-wrapper theme-default">
		<div class="ribbon"></div>
		<div id="slider" class="nivoSlider">
			<?php 
				$args = array(
					'cat' => $nivo_category,
					'orderby' => $nivo_sort,
					'posts_per_page' => $nivo_limit,
					'order' => $nivo_order
				);

			$query = new WP_Query( $args ); 
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$do_not_duplicate = $post->ID; ?>
			<a href="<?php the_permalink(); ?>" /><img src="<?php echo CHILD_URL; ?>/lib/scripts/timthumb.php?src=<?php echo radio_grab_image(); ?>&amp;h=300&amp;w=960" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a>
			<?php endwhile; else : ?>
				<p>Sorry, no posts found</p>
			<?php endif; wp_reset_query(); ?>
		</div>
	</div>
<?php } ?>
	<?php // Check for Soliloquy Slider, if found, display it
	if ( ( ! $nivo_toggle ) && function_exists( 'soliloquy_slider' ) ) { ?>
	<div class="slider-wrapper radio-soliloquy">
		<?php soliloquy_slider( $solil_id ); ?>
	</div>
<?php } }


remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'radio_home_loop' );
/**
 * Build three column widgit area.
 * 
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_home_loop() { ?>
<div id="home-column-1" class="sidebar widget-area">
	<div class="widget-wrap">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Home Left' ) ){ ?><?php } ?> 
	</div>
</div>

<div id="home-column-2" class="sidebar widget-area">
	<div class="widget-wrap">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Home Middle' ) ){ ?><?php } ?> 
	</div>
</div>


<?php }

genesis();