<?php
/**
 * Radio Theme for Genesis
 * Requires Genesis 1.8 or later
 *
 * This file handles the customizations that need to appear on the front-end.
 *
 * @package      Radio
 * @since        1.0.0
 * @author       Greg Rickaby <greg@gregrickaby.com>
 * @copyright    Copyright (c) 2012
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @thanks       Gary J <garyjones.co.uk>, Bill Erickson <billerickson.net>, and Travis Smith <wpsmith.net> for code help
 */

/**
 * All of the front-end customizations for the Radio theme.
 * 
 * @package Radio
 * @subpackage Front
 */
class Radio_Front_End_Customizations {

	private $settings_field = 'child-settings';

	public function __construct() {

		add_action( 'genesis_meta', array( &$this, 'add_viewport_meta_tag' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'styles' ) ); // Yes, hook to wp_enqueue_scripts
		add_action( 'genesis_before', array( &$this, 'radio_live_toolbar' ) );
		add_action( 'genesis_after_post_content', array( &$this, 'radio_social_media_icons' ), 5 );
		add_filter( 'body_class', array( &$this, 'body_class' ) );

	}

	/**
	 * Add viewport meta-tag to <head> for responsive design in mobile browsers.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function add_viewport_meta_tag() {

		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' . "\n";

	}

	/**
	 * Load theme scripts.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function scripts() {

		/** Reference Nivo */
		wp_enqueue_script( 'nivo', CHILD_URL . '/lib/js/jquery.nivo.slider.pack.js', array( 'jquery' ), '1.0', true );

		/** Enqueue theme custom script */
		wp_enqueue_script( 'radio', CHILD_URL . '/lib/js/radio.js', array( 'jquery', 'nivo' ), '1.0', true );

		/** Pass value from PHP to JS */
		$params = array(
			'nivo_effect' => genesis_get_option( 'nivo_effect', $this->settings_field ),
			'nivo_speed' => genesis_get_option( 'nivo_speed', $this->settings_field ),
		);
		wp_localize_script( 'radio', 'radioL10n', $params );

	}

	/**
	 * Check for and load custom.css immediately before the </head> tag.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function styles() {

		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) )
			wp_enqueue_style ( 'radio', CHILD_URL . '/custom/custom.css', false, '1.0.0', 'screen' );

	}

	/**
	 * Create the Live Toolbar.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function radio_live_toolbar() { 

		$toolbar = genesis_get_option ( 'station_live_toolbar', $this->settings_field );
		$listen  = genesis_get_option( 'station_listen', $this->settings_field );
		$phone   = genesis_get_option( 'station_phone', $this->settings_field );
		$text    = genesis_get_option( 'station_text', $this->settings_field );
		$email   = genesis_get_option( 'station_email', $this->settings_field );

		if ( ! $toolbar )
			return;

		?>
		<div id="live-toolbar">
			<div class="live-toolbar-wrap">
			<?php
			if ( $listen )
				echo '<a href="' . esc_url( $listen ) . '" class="icon-listen">' . __( 'Listen Live', 'radio' ) . '</a>';

			if ( $phone )
				echo '<div class="live-toolbar-phone alignright"><span>' . __( 'Request Line: ', 'radio' ) . $phone . '</span></div>';

			if ( $text )
				echo '<div class="live-toolbar-text alignright"><span>' . __( 'Text Us: ', 'radio' ) . $text . '</span></div>';

			if ( $email )
				echo '<div class="live-toolbar-email alignright"><span>' . __( 'Email Us: ', 'radio' ) . '<a href="' .  esc_url( 'mailto:' . $email ) . '">' . $email . '</a></span></div>';
			?>
			</div>
		</div><!-- end #live-toolbar -->
		<?php
	}
	
	/**
	 * Create Social Media Icons
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function radio_social_media_icons() {
	$showsocialicons = genesis_get_option ( 'station_social_icons', $this->settings_field );
	$twittername  = genesis_get_option( 'station_twitter', $this->settings_field );
	
		if ( ! $showsocialicons )
			return;

			if ( !is_front_page() ) { ?>

	<div id="social-media-icons">
		<div class="facebook-button">
		<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div>
		<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=134944943249381";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
		</div>

		<div class="twitter-button">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-via="<?php echo $twittername ?>">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>

		<div class="gplus-button">
		<g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone>
			<script type="text/javascript">
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 				})();
			</script>
		</div>

		<div class="pinterest-button">
			<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo genesis_get_image( array( 'format' => 'url' ) ); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a><script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
		</div>

		<div class="stumbleupon-button">
			<su:badge layout="1"></su:badge>
				<script type="text/javascript">
					(function() {
						var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
						li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
					})();
				</script>
		</div>

		<div class="linkedin-button">
			<script src="http://platform.linkedin.com/in.js" type="text/javascript"> </script>
			<script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="right"> </script>
		</div>

	</div>
	<?php } }


	/**
	 * Filters the <body> class to add "custom".
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	function body_class( $classes ) {

		if ( $style = genesis_get_option( 'style_selection', $this->settings_field ) )
			$classes[] = esc_attr( sanitize_html_class( $style ) );

		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) )
			$classes[] = 'custom';

		return $classes;

	}

}

add_action( 'template_redirect', 'radio_customizations_init' );
/**
 * Add customizations to the front-end of the theme.
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_customizations_init() {

	global $_child_theme_customizations;
	$_child_theme_customizations = new Radio_Front_End_Customizations;

}

add_action( 'widgets_init', 'radio_load_widgets' );
/**
 * Replace Genesis Featured Post Widget with Radio Latest News Widget
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_load_widgets() {
	unregister_widget( 'Genesis_Featured_Post' );
	register_widget( 'Radio_Latest_News' );
}

add_filter( 'user_contactmethods', 'radio_user_contact_methods' );
/**
 * Customize Contact Methods
 *
 * @author Greg Rickaby
 * @since 1.0.0
 */
function radio_user_contact_methods( $contactmethods ) {
	$contactmethods = array(
		'twitter'  => __( 'Twitter' ),
		'facebook' => __( 'Facebook' ),
		'skype'    => __( 'Skype' )
	);
	return apply_filters( 'contactmethods',$contactmethods );
}

add_filter( 'http_request_args', 'radio_dont_update_theme', 5, 2 );
/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name, 
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */
function radio_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}