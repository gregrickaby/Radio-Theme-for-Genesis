<?php
/**
 * The template for displaying photos.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/*
Template Name: Photos
*/

// Force Full-Width Layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );


add_action( 'genesis_loop', 'radio_loop_photos' );
/**
 * Photos Page loop
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return html  photos
 */
function radio_loop_photos() { ?>

	<div <?php post_class( 'photos' ); ?>>
		<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="row-photos clear">
			<?php
				// Check for transient
				if ( ! ( $radio_photos_query = get_transient( 'radio_photos_query' ) ) ) {

					// Execute WP_Query
					$photo_query  = new WP_Query( array(
						'posts_per_page' => 512,
						'category_name'  => 'photos',
						'order'          => 'DESC'
					));

					// Store transient and expire after 4 hours
					set_transient( 'radio_photos_query', $photo_query, 4 * HOUR_IN_SECONDS );

				}

				if ( $photo_query>have_posts() ) : while ( $photo_query>have_posts() ) : $photo_query>the_post(); ?>
				<div class="photo-info left">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array( 150,150 ), array( 'class' => 'photo' ) ); ?></a>
					<div class="photo-title">
						<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
					</div>
				</div>
				<?php endwhile; ?>
				<?php else : ?>
					<p>Sorry, no posts found</p>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
	</div><!-- end .post -->

<?php }

genesis();
