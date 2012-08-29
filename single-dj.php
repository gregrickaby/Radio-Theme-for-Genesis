<?php 
/**
 * This file displays the DJ details.
 *
 * @package Radio
 * @author Greg Rickaby
 * @since 1.3.0
 */


remove_action( 'genesis_loop', 'genesis_do_loop' ); 
add_action( 'genesis_loop', 'radio_loop_dj' ); 
/**
 * Remove default loop. Execute child loop instead.
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_loop_dj() { ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-content">
			<h1 class="entry-title"><?php the_title(); ?></h1>

				<div class="profile-image alignleft">
					<?php if ( genesis_get_custom_field( '_cmb_dj_profile_photo' ) ) { ?>
						<img class="dj-profile-photo" src="<?php echo genesis_get_custom_field( '_cmb_dj_profile_photo' ); ?>" />
					<?php } ?>
					<div class="social-info">
						<?php // Facebook
						if ( genesis_get_custom_field( '_cmb_dj_facebook_uri' ) ) { ?>
							<a href="<?php echo genesis_get_custom_field( '_cmb_dj_facebook_uri' ); ?>">Facebook</a> &middot 
						<?php } // Twitter
						if ( genesis_get_custom_field( '_cmb_dj_twitter_username' ) ) { ?>
							<a href="http://twitter.com/<?php echo genesis_get_custom_field( '_cmb_dj_twitter_username' ); ?>">Twitter</a> &middot;
						<?php } // Google+
						if ( genesis_get_custom_field( '_cmb_dj_googleplus_uri' ) ) { ?>
							<a href="<?php echo genesis_get_custom_field( '_cmb_dj_googleplus_uri' ); ?>">Google+</a> &middot 
						<?php } // Email
						if ( genesis_get_custom_field( '_cmb_dj_email' ) ) { ?>
							<a href="mailto:<?php echo genesis_get_custom_field( '_cmb_dj_email' ); ?>">Email</a>
						<?php } ?>
					</div>
				</div>

				<div class="dj-bio">
					<?php echo wpautop( genesis_get_custom_field( '_cmb_dj_biography' ) ); ?>
				</div>

				<div class="dj-navigation">
					<div class="previous left"><?php previous_post('%', 'Previous', 'no'); ?></div>
					<div class="next right"><?php next_post('%', 'Next', 'no'); ?></div>
				</div>

		</div><!-- end .entry-content -->

	</div><!-- end #post -->

<?php }
genesis();