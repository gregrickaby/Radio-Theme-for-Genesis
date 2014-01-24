<?php
/**
 * This file is the settings engine for the Radio Theme. It defines required parameters, registers
 * all of this child theme's specific Theme Settings, accessible from Genesis --> Radio Settings,
 * and executes required functions.
 *
 * @package    Radio
 * @since      1.0.0
 * @author     Greg Rickaby greg@gregrickaby.com
 * @copyright  Copyright (c) 2012-2014
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

// Define Theme Info Constants
define( 'CHILD_THEME_NAME', 'Radio Theme' );
define( 'CHILD_THEME_URL', 'http://radio.gregrickaby.com' );
define( 'CHILD_THEME_VERSION', '1.4' );
define( 'CHILD_THEME_RELEASE_DATE', date_i18n( 'F j, Y', '1390530887' ) ); // http://unixtimestamp.com


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Radio Settings page.
 *
 * @package     Radio
 * @subpackage  Admin
 * @since       1.0.0
 */
class Radio_Theme_Settings extends Genesis_Admin_Boxes {


	/**
	 * Create an admin menu item and settings page
	 */
	public function __construct() {

		// Specify a unique page ID.
		$page_id = 'radio-theme-settings';

		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => 'Radio Theme Settings',
				'menu_title'  => 'Radio Settings',
			)
		);

		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
			'screen_icon' => 'options-general',
		);

		// Give it a unique settings field.
		// You'll access them from genesis_get_option( 'option_name', 'child-settings' );
		$settings_field = 'child-settings';

		// Set the default values
		$default_settings = array(
			'child_theme_version' => CHILD_THEME_VERSION,
		);

		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
	}


	/**
	 * Sets up further aspects of the admin page
	 *
	 * Handles the design settings being reset, hooks in standard metabox methods,
	 * and some other related dependencies and features.
	 */
	public function settings_init() {

		// Hook in scripts, columns, and  metaboxes registration
	 	parent::settings_init();

		// Hook in our customizations
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}


	/**
	 * Set up Sanitization Filters
	 */
	public function sanitization_filters() {
		genesis_add_option_filter( 'no_html', $this->settings_field, array( 'style_box', 'custom_stylesheet' ) );
	}


	/**
	 * Register metaboxes on Child Theme Settings page
	 */
	public function metaboxes() {

		add_meta_box( 'info-box', 'Radio Theme Information', array ($this, 'info_box' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'style-box', 'Color Style', array ($this, 'style_box' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'custom-stylesheet', 'Custom Stylesheet', array( $this, 'custom_stylesheet' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'live-toolbar', 'Live Toolbar', array( $this, 'show_live_toolbar' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'slider-settings', 'Soliloquy ID', array( $this, 'slider_settings' ), $this->pagehook, 'main', 'high' );

	}


	/**
	 * Callback: Radio Theme Details
	 */
	public function info_box() {
		echo '<p><strong>' . __( 'Version', 'radio' ) . '</strong> ' . CHILD_THEME_VERSION . ' &middot; <strong>' . __( 'Updated', 'radio' ) . '</strong> ' . CHILD_THEME_RELEASE_DATE . ' &middot; <a href="' . CHILD_URL . '/README.txt">' . __( 'Changelog', 'radio' ) . '</a></p>';
	}


	/**
	 * Callback: Custom Style Settings
	 */
	public function style_box() {

		// Get settings
		$styles        = get_theme_support( 'child-style-selector' );
		$current_style = $this->get_field_value( 'style_selection' );

		echo '<p><label for="' . $this->get_field_id( 'style_selection' ) . '">' . __( 'Color Style:', 'radio' ) . ' </label>';
		echo '<select name="' . $this->get_field_name( 'style_selection' ) . '" id="' . $this->get_field_id( 'style_selection' ) . '">';
		echo '<option value="">' . __( 'Default', 'radio' ) . '</option>';
		if ( ! empty( $styles ) ) {
			$styles = array_shift( $styles );
			foreach ( (array) $styles as $style => $title ) {
				echo '<option value="' . esc_attr( $style ) . '"' . selected( $current_style, $style ) . '>' . esc_html( $title ) . '</option>';
			}
		}
		echo '</select></p>';
		echo '<p><span class="description">' . __( 'Select a theme color style.', 'radio' ) . '</span></p>';
	}


	/**
	 * Callback: Custom Stylesheet Settings
	 */
	public function custom_stylesheet() {
		echo '<label>' . __( 'Load', 'radio' ) . ' <span class="description"><code>custom.css</code></span>? </label>';
		echo '<input type="checkbox" name="' . $this->get_field_name( 'custom_stylesheet' ) . '" value="checked" '. esc_attr( $this->get_field_value( 'custom_stylesheet' ) ) . ' />';
		echo '<p><span class="description">' . __( 'The use of this stylesheet will prevent your customizations from disappearing after a theme update.', 'radio' ) . '</span></p>';
	}


	/**
	 * Callback: Live Toolbar Settings
	 */
	public function show_live_toolbar() {
		echo '<label>' . __( 'Show Live Toolbar?', 'radio' )  . ' </label>';
		echo '<input type="checkbox" name="' . $this->get_field_name( 'station_live_toolbar' ) . '" value="checked" '. esc_attr( $this->get_field_value( 'station_live_toolbar' ) ) . ' />';
		echo '<p><span class="description">' . __( 'The Live Toolbar spans the top of the website with a link to Listen Live. It displays the request line, email, text message, etc...', 'radio' ) . '</span></p>';

		echo '<label>' . __( 'Request Line:', 'radio' )  . ' </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_phone' ) .'" id="' . $this->get_field_id( 'station_phone' ) . '" value="' . esc_attr( $this->get_field_value( 'station_phone' ) ) . '" size="12" />';
		echo '<p><span class="description">(123) 456-7890</span></p>';

		echo '<label>' . __( 'Text Message:', 'radio' )  . ' </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_text' ) .'" id="' . $this->get_field_id( 'station_text' ) . '" value="' . esc_attr( $this->get_field_value( 'station_text' ) ) . '" size="6" />';
		echo '<p><span class="description">12345</span></p>';

		echo '<label>' . __( 'Listen Live:', 'radio' )  . ' </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_listen' ) .'" id="' . $this->get_field_id( 'station_listen' ) . '" value="' . esc_attr( $this->get_field_value( 'station_listen' ) ) . '" size="40" />';
		echo '<p><span class="description">http://radiostation.com/listen-live</span></p>';

		echo '<label>' . __( 'Email:', 'radio' )  . ' </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_email' ) .'" id="' . $this->get_field_id( 'station_email' ) . '" value="' . esc_attr( $this->get_field_value( 'station_email' ) ) . '" size="40" />';
		echo '<p><span class="description">station-email@radiostation.com</span></p>';
	}


	/**
	 * Callback: Slider Settings
	 */
	public function slider_settings() {
		echo '<label>Soliloquy ID: </label><input type="text" name="' . $this->get_field_name( 'solil_id' ) . '" id="' . $this->get_field_id( 'solil_id' ) . '" value="' . esc_attr( $this->get_field_value( 'solil_id' ) ) . '" class="small-text" />';
		echo '<p><span class="description">' . __( 'Enter the ID of the Soliloquy Slider you want displayed on the homepage.', 'radio' ) . '</span></p>';
	}

} // end Radio_Theme_Settings


add_action( 'admin_menu', 'child_add_child_theme_settings', 2 );
/**
 * Instanciate theme settings
 *
 * @author Greg Rickaby
 * @since  1.0.0
 * @return $_child_theme_settings  starts the admin engine baby
 */
function child_add_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new Radio_Theme_Settings;
}


add_action( 'admin_notices', 'radio_errors' );
/**
 * Error check
 *
 * @author Greg Rickaby
 * @since  1.3.0
 * @return echo  error message
 */
function radio_errors() {

	// Check to to see /custom/ exsists and is writeable
	if ( ! is_writable( CHILD_DIR . '/custom/custom.css' ) ) {
		echo '<div class="error"><p><strong>' . __( 'Warning!', 'radio' ) . '</strong> ' . __( 'You must rename', 'radio' ) . ' <strong>/custom-sample/</strong> ' . __( 'to', 'radio' ) . ' <strong>/custom/</strong> ' . __( 'and set permissions to', 'radio' ) . ' <strong>755</strong></p></div>';
	}

}
