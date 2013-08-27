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
		add_action( 'genesis_meta', array( $this, 'add_dns_pre_fetch' ), 1 );
		add_action( 'genesis_meta', array( $this, 'add_viewport_meta_tag' ), 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) ); // Yes, hook to wp_enqueue_scripts
		add_action( 'wp_print_styles', array( $this, 'radio_manage_scripts' ) );
		add_action( 'genesis_before', array ( $this, 'radio_fb_root' ) );
		add_action( 'genesis_before', array( $this, 'radio_live_toolbar' ) );
		add_filter( 'genesis_pre_load_favicon', 'radio_favicon_filter' );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}


	/**
	 * Add DNS Pre-fetching for outside scripts and styles.
	 *
	 * @author Greg Rickaby
	 * @since 1.3.1
	 */
	public function add_dns_pre_fetch() {
		echo '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">' . "\n";
		echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
		echo '<link rel="dns-prefetch" href="//themes.googleusercontent.com">' . "\n";
		echo '<link rel="dns-prefecth" href="//connect.facebook.net">' . "\n";
	}


	/**
	 * Add viewport meta-tag to <head> for responsive design in mobile browsers.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function add_viewport_meta_tag() {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">' . "\n";
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' . "\n";
	}


	/**
	 * Load theme scripts.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function scripts() {
		/** Reference Nivo */
		$nivo_toggle = genesis_get_option( 'nivo_show', 'child-settings' );
			if ( $nivo_toggle ) 
				wp_enqueue_script( 'nivo', '//cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.1/jquery.nivo.slider.pack.js', array( 'jquery' ), '3.1', true );

		/** Enqueue theme custom script */
		wp_enqueue_script( 'radio', CHILD_URL . '/lib/js/radio.js', array( 'jquery' ), '1.0', true );

		/** Pass value from PHP to JS */
		$params = array(
			'nivo_effect' => genesis_get_option( 'nivo_effect', $this->settings_field ),
			'nivo_speed' => genesis_get_option( 'nivo_speed', $this->settings_field ),
			'fb_app_id' => genesis_get_option( 'station_facebook_app_id', $this->settings_field )
		);
		wp_localize_script( 'radio', 'radioL10n', $params );
	}


	/**
	 * Check for and load custom.css immediately before the </head> tag.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function styles() {
		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) )
			wp_enqueue_style ( 'radio', CHILD_URL . '/custom/custom.css', false, '1.0.0', 'screen' );
	}


	/**
	 * Insert Facebook <div>
	 * This will allow Racebook social plug-ins to work correctly via HTML5.
	 *
	 * @author Greg Rickaby
	 * @since 1.2.0
	 */
	public function radio_fb_root() { ?>
		<div id="fb-root"></div>
	<?php }


	/**
	 * Create the Live Toolbar.
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function radio_live_toolbar() { 
		$toolbar = genesis_get_option( 'station_live_toolbar', $this->settings_field );
		$listen  = genesis_get_option( 'station_listen', $this->settings_field );
		$phone   = genesis_get_option( 'station_phone', $this->settings_field );
		$text    = genesis_get_option( 'station_text', $this->settings_field );
		$email   = genesis_get_option( 'station_email', $this->settings_field );

		if ( ! $toolbar )
			return; ?>
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
	<?php }


	/**
	 * Filters the <body> class to add "custom".
	 *
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function body_class( $classes ) {
		if ( $style = genesis_get_option( 'style_selection', $this->settings_field ) )
			$classes[] = esc_attr( sanitize_html_class( $style ) );
		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) )
			$classes[] = 'custom';
		return $classes;
		}


	/**
	 * Manage Scripts and CSS
	 * 
	 * @author Greg Rickaby
	 * @since 1.0.0
	 */
	public function radio_manage_scripts() {
		if ( is_front_page() ) {
			wp_dequeue_script( 'ngg-slideshow' );
			wp_deregister_script( 'jquery-cycle' );
			wp_deregister_script( 'thickbox' );
			wp_deregister_style( 'NextGEN' );
			wp_deregister_style( 'shutter' );
			wp_deregister_style( 'gforms_css' );
			wp_deregister_style( 'thickbox' );
		}
	}





} // -------------------------- end class Radio_Front_End_Customizations -------------------------- //


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
		'instagram'    => __( 'Instagram' ),
		'skype'    => __( 'Skype' )
	);
	return apply_filters( 'contactmethods',$contactmethods );
}