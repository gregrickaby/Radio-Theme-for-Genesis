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
			<?php 
				$args = array(
					'category_name' => 'photos',
					'posts_per_page' => 512,
					'order' => 'DESC'
				);

			$query = new WP_Query( $args ); 
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$do_not_duplicate = $post->ID; ?>
				<div class="photo-info <?php $even_odd = (++$j % 5 == 0) ? 'clear' : 'left'; echo $even_odd; ?>">
					<div class="photo-title"><p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p></div>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array( 150,150 ), array( 'class' => 'photo' ) ); ?></a>
				</div>
			<?php endwhile; else : ?>
				<p>Sorry, no posts found</p>
			<?php endif; wp_reset_query(); ?>
			</div>

	</div><!-- end .post -->

<?php }

genesis();