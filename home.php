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


add_action( 'genesis_after_header', 'radio_featured_content_slider' );
/**
 * Build the Nivo featured content slider.
 * 
 * @author Greg Rickaby
 * @since 1.0.0
 */ 
function radio_featured_content_slider() { 

$nivo_category = genesis_get_option( 'nivo_category', 'child-settings' );
$nivo_order = genesis_get_option( 'nivo_order', 'child-settings' );
$nivo_limit = genesis_get_option( 'nivo_limit', 'child-settings');
$nivo_sort = genesis_get_option( 'nivo_sort', 'child-settings');

?>
	<div class="slider-wrapper theme-default">
		<div class="ribbon"></div>
		<div id="slider" class="nivoSlider">
			<?php $loop_1 = new WP_Query( 'cat='.$nivo_category.'&orderby='.$nivo_sort.'&order='.$nivo_order.'&posts_per_page='.$nivo_limit.'' ); while ($loop_1->have_posts()) : $loop_1->the_post(); ?>
			<a href="<?php the_permalink(); ?>" /><img src="<?php echo CHILD_URL; ?>/lib/scripts/timthumb.php?src=<?php echo child_grab_image(); ?>&amp;h=300&amp;w=960" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a>
			<?php wp_reset_query(); ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php }


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

/** Finish loading the page */
genesis();