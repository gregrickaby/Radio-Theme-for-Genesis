<?php
/**
 * Radio Theme for Genesis
 *
 * Requires Genesis 1.8 or later
 *
 * This file handles the customizations that need to appear on the front-end.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * All of the front-end customizations for the Radio theme.
 *
 * @package     Radio
 * @subpackage  Theme
 * @since       1.0.0
 */
class Radio_Front_End_Customizations {

	// Child Settings
	private $settings_field = 'child-settings';

	/**
	 * Construct the customizations class
	 */
	public function __construct() {
		add_action( 'genesis_meta', array( $this, 'viewport_meta_tag' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) ); // Yes, hook to wp_enqueue_scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'garbage_collection' ) );
		add_action( 'genesis_before', array( $this, 'live_toolbar' ) );
		add_filter( 'genesis_pre_load_favicon', 'radio_favicon_filter' );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}


	/**
	 * Setup responsive
	 */
	public function viewport_meta_tag() {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n";
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' . "\n";
	}


	/**
	 * Theme scripts
	 */
	public function scripts() {

	}


	/**
	 * Theme stylesheets
	 */
	public function styles() {

		// Setup Google Font
		$protocol = is_ssl() ? 'https' : 'http'; $query_args = array(
			'family' => 'Open+Sans:400,700'
		);

		// Enqueue Google Font
		wp_enqueue_style( 'google-font', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );


		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) ) {
			wp_enqueue_style ( 'radio', CHILD_URL . '/custom/custom.css', false, '1.4.0', 'screen' );
		}

	}


	/**
	 * Live Toolbar
	 */
	public function live_toolbar() {

		// Get options
		$toolbar = genesis_get_option( 'station_live_toolbar', $this->settings_field );
		$listen  = genesis_get_option( 'station_listen', $this->settings_field );
		$phone   = genesis_get_option( 'station_phone', $this->settings_field );
		$text    = genesis_get_option( 'station_text', $this->settings_field );
		$email   = genesis_get_option( 'station_email', $this->settings_field );

		if ( $toolbar ) : ?>
			<div id="live-toolbar">
				<div class="live-toolbar-wrap">
				<?php
					if ( isset( $listen ) ) {
						echo '<a href="' . esc_url( $listen ) . '" class="icon-listen">' . __( 'Listen Live', 'radio' ) . '</a>';
					}

					if ( isset( $phone ) ) {
						echo '<div class="live-toolbar-phone alignright"><span>' . __( 'Request Line: ', 'radio' ) . esc_attr( $phone ) . '</span></div>';
					}

					if ( isset( $text ) ) {
						echo '<div class="live-toolbar-text alignright"><span>' . __( 'Text Us: ', 'radio' ) . esc_attr( $text ) . '</span></div>';
					}

					if ( isset( $email ) ) {
						echo '<div class="live-toolbar-email alignright"><span>' . __( 'Email Us: ', 'radio' ) . '<a href="' .  esc_url( 'mailto:' . $email ) . '">' . esc_attr( $email ) . '</a></span></div>';
					}
				?>
				</div>
			</div><!-- end #live-toolbar -->
		<?php endif; ?>

	<?php }


	/**
	 * Add custom body classes
	 */
	public function body_class( $classes ) {

		if ( $style = genesis_get_option( 'style_selection', $this->settings_field ) ) {
			$classes[] = esc_attr( sanitize_html_class( $style ) );
		}

		if ( genesis_get_option( 'custom_stylesheet', $this->settings_field ) ) {
			$classes[] = 'custom';
		}

		return $classes;
	}


	/**
	 * Manage 3rd party styles and scripts on the homepage
	 */
	public function garbage_collection() {
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

} // end class Radio_Front_End_Customizations


add_action( 'template_redirect', 'radio_customizations_init' );
/**
 * Add customizations to the front-end of the theme.
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return   [description]
 */
function radio_customizations_init() {
	global $_child_theme_customizations;
	$_child_theme_customizations = new Radio_Front_End_Customizations;
}


add_filter( 'user_contactmethods', 'radio_user_contact_methods' );
/**
 * Contact Methods
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return $contactmethos  changes default user contact methods
 */
function radio_user_contact_methods( $contactmethods ) {

	// Create an array of new contact methods
	$contactmethods = array(
		'twitter'    => __( 'Twitter', 'radio' ),
		'facebook'   => __( 'Facebook', 'radio' ),
		'googleplus' => __( 'Google+', 'radio' ),
		'instagram'  => __( 'Instagram', 'radio' ),
	);

	return apply_filters( 'contactmethods', $contactmethods );
}


/**
 * Change the location of the favicon reference
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return ico  new favicon
 */
function radio_favicon_filter( $favicon_url ) {
	return  get_stylesheet_directory_uri() . '/custom/favicon.ico';
}
