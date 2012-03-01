<?php 
/**
 * This file adds the Photos Page template to our Child Theme.
 *
 * @package Radio
 * @author Greg Rickaby
 * @since 1.0.0
 */

/*
Template Name: Photos
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' ); // Force Full-Width Layout
remove_action( 'genesis_loop', 'genesis_do_loop' ); 
add_action( 'genesis_loop', 'radio_loop_photos' ); 
/**
 * Remove default loop. Execute child loop instead.
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_loop_photos() { ?>
	<div <?php post_class( 'photos' ); ?>>

		<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="row-photos clear">
<?php $loop_1 = new WP_Query( 'category_name=photos&posts_per_page=512' );  while ( $loop_1->have_posts() ) : $loop_1->the_post(); $do_not_duplicate = $post->ID; ?>
				<div class="photo-info left">
					<h3 class="photo-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(200,200), array('class' => 'photo') ); ?></a>
				</div>
<?php endwhile; wp_reset_query(); ?>
			</div>

	</div><!-- end .post -->

<?php }

genesis();