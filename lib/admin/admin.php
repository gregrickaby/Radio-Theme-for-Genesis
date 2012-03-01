<?php
/**
 * Admin
 * Requires Genesis 1.8 or later
 *
 * This file is the settings engine for the Radio Theme. It defines required parameters, registers 
 * all of this child theme's specific Theme Settings, accessible from Genesis --> Radio Settings,
 * and executes required functions. 
 *
 * @package      Radio
 * @since        1.0.0
 * @author       Greg Rickaby <greg@gregrickaby.com>
 * @copyright    Copyright (c) 2012
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @thanks       Gary J <garyjones.co.uk>, Bill Erickson <billerickson.net>, and Travis Smith <wpsmith.net> for code help
 *
 */ 
 
/** Define Theme Info Constants */
	define( 'CHILD_THEME_NAME', 'Radio Theme' );
	define( 'CHILD_THEME_URL', 'http://radio.gregrickaby.com' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );
	define( 'CHILD_THEME_RELEASE_DATE', date_i18n( 'F j, Y', '1330456505' ) ); # http://unixtimesta.mp
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Radio Settings page.
 *
 * @package Radio
 * @subpackage Admin
 *
 * @since 1.0.0
 */
class Radio_Theme_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 * 
	 * @since 1.0.0
	 */
	function __construct() {

		// Specify a unique page ID. 
		$page_id = 'radio-theme-settings';

		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title' => 'Radio Theme Settings',
				'menu_title' => 'Radio Settings',
			)
		);

		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);

		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'child-settings' );
		$settings_field = 'child-settings';

		// Set the default values
		$default_settings = array(
			'child_theme_version'	=> CHILD_THEME_VERSION,
			'nivo_speed'	=> '3000',
		);

		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

	}

	/**
	 * Sets up further aspects of the admin page.
	 *
	 * Handles the design settings being reset, hooks in standard metabox methods,
	 * and some other related dependencies and features.
	 */
	function settings_init() {

		/** Hook in scripts, columns, and  metaboxes registration */ 
	 	parent::settings_init();

		/** Hook in our customizations */
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	/** 
	 * Set up Sanitization Filters
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 *
	 * @since 1.0.0
	 */	
	function sanitization_filters() {

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'style_box',
				'custom_stylesheet',
				'nivo_category',
				'nivo_limit',
				'nivo_sort',
				'nivo_order',
				'nivo_speed',
			)
		);
	}

	/**
	 * Register metaboxes on Child Theme Settings page
	 *
	 * @since 1.0.0
	 *
	 * @see Child_Theme_Settings::style_box() Callback for style information
	 */
	function metaboxes() {

		add_meta_box( 'info-box', 'Radio Theme Information', array ($this, 'info_box' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'style-box', 'Color Style', array ($this, 'style_box' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'custom-stylesheet', 'Custom Stylesheet', array( $this, 'custom_stylesheet' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'live-toolbar', 'Live Toolbar', array( $this, 'show_live_toolbar' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'social-info', 'Social Info', array( $this, 'social_info' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'nivo-settings', 'Featured Content Slider', array( $this, 'nivo_settings' ), $this->pagehook, 'main', 'high' );

	}

	/**
	 * Callback for setting(s) metaboxes
	 *
	 * @since 1.0.0
	 *
	 * @see Child_Theme_Settings::metaboxes()
	 */
	function info_box() {

		echo '<p><strong>Version:</strong> ' . CHILD_THEME_VERSION . ' &middot; <strong>Released:</strong> ' . CHILD_THEME_RELEASE_DATE . '</p>';
	}

	function style_box() {

		$current_style = $this->get_field_value( 'style_selection' );
		$styles  = get_theme_support( 'child-style-selector' );

		echo '<p><label for="' . $this->get_field_id( 'style_selection' ) . '">Color Style: </label>';
		echo '<select name="' . $this->get_field_name( 'style_selection' ) . '" id="' . $this->get_field_id( 'style_selection' ) . '">';
		echo '<option value="">Default</option>';
			if ( ! empty( $styles ) ) {
				$styles = array_shift( $styles );
				foreach ( (array) $styles as $style => $title ) {
					echo '<option value="' . esc_attr( $style ) . '"' . selected( $current_style, $style ) . '>' . esc_html( $title ) . '</option>';
				}
			}
		echo '</select></p>';
		echo '<p><span class="description">Please select the color style from the drop down list and save your settings.</span></p>';
	}

	function custom_stylesheet() {

		echo '<input type="checkbox" name="' . $this->get_field_name( 'custom_stylesheet' ) . '" value="checked" '. esc_attr( $this->get_field_value( 'custom_stylesheet' ) ) . ' />';
		echo '<label> Load <span class="description"><code>custom.css</code></span>?</label>';
		echo '<p><span class="description">The use of this stylesheet will prevent your customizations from disappearing after a theme update.</span></p>';
	}
	
	function show_live_toolbar() {

		echo '<input type="checkbox" name="' . $this->get_field_name( 'station_live_toolbar' ) . '" value="checked" '. esc_attr( $this->get_field_value( 'station_live_toolbar' ) ) . ' />';
		echo '<label> Show Live Toolbar? </label>';
		echo '<p><span class="description">The Live Toolbar spans the top of the website with a link to Listen Live. It displays the request line, email, text message, etc...</span></p>';

		echo '<label>Request Line: </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_phone' ) .'" id="' . $this->get_field_id( 'station_phone' ) . '" value="' . esc_attr( $this->get_field_value( 'station_phone' ) ) . '" size="12" />';
		echo '<p><span class="description">(123) 456-7890</span></p>';

		echo '<label>Text Message: </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_text' ) .'" id="' . $this->get_field_id( 'station_text' ) . '" value="' . esc_attr( $this->get_field_value( 'station_text' ) ) . '" size="6" />';
		echo '<p><span class="description">12345</span></p>';

		echo '<label>Listen Live: </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_listen' ) .'" id="' . $this->get_field_id( 'station_listen' ) . '" value="' . esc_attr( $this->get_field_value( 'station_listen' ) ) . '" size="40" />';
		echo '<p><span class="description">http://radiostation.com/listen-live</span></p>';

		echo '<label>Email: </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_email' ) .'" id="' . $this->get_field_id( 'station_email' ) . '" value="' . esc_attr( $this->get_field_value( 'station_email' ) ) . '" size="40" />';
		echo '<p><span class="description">station-email@radiostation.com</span></p>';
	}

	function social_info() {
		
		echo '<input type="checkbox" name="' . $this->get_field_name( 'station_social_icons' ) . '" value="checked" '. esc_attr( $this->get_field_value( 'station_social_icons' ) ) . ' />';
		echo '<label> Show Social Media Icons? </label>';
		echo '<p><span class="description">Social media icons will be added to the bottom both posts and pages.</span></p>';

		echo '<label>Twitter Username: </label>';
		echo '<input type="text" name="' . $this->get_field_name( 'station_twitter' ) .'" id="' . $this->get_field_id( 'station_twitter' ) . '" value="' . esc_attr( $this->get_field_value( 'station_twitter' ) ) . '" size="40" />';
		echo '<p><span class="description">StationName</span></p>';

	}

	function nivo_settings() {
		
		$nivo_category = get_categories( 'type=post&orderby=name&hide_empty=0' ); 
		$nivo_current_category = $this->get_field_value( 'nivo_category' );
		$nivo_current_limit = $this->get_field_value( 'nivo_limit' );
		$nivo_current_sort = $this->get_field_value( 'nivo_sort' );
		$nivo_current_order = $this->get_field_value( 'nivo_order' );

		$nivo_post_limit = array(
			'10'	=> '10',
			'9'		=> '9',
			'8'		=> '8',
			'7'		=> '7',
			'6'		=> '6',
			'5'		=> '5',
			'4'		=> '4',
			'3'		=> '3',
			'2'		=> '2',
			'1'		=> '1',
		);

		$nivo_effect = apply_filters( 'nivo_display_effect', array(
			'random'		=> __( 'Random', 'child' ),
			'fade'		=> __( 'Fade', 'child' ),
			'fold'		=> __( 'Fold', 'child' ),
			'slideInLeft'		=> __( 'Slide In (Left)', 'child' ),
			'slideInRight'		=> __( 'Slide In (Right)', 'child' ),
			'sliceDown'			=> __( 'Slice Down', 'child' ),
			'sliceDownLeft'			=> __( 'Slice Down (Left)', 'child' ),
			'sliceUp'		=> __( 'Slice Up', 'child' ),
			'sliceUpLeft'			=> __( 'Slice Up (Left)', 'child' ),
			'sliceUpDown'			=> __( 'Slice Up (Down)', 'child' ),
			'sliceUpDownLeft'		=> __( 'Slice Up (Down Left)', 'child' ),
			'boxRandom'		=> __( 'Box Random', 'child' ),
			'boxRain'		=> __( 'Box Rain', 'child' ),
			'boxRainReverse'		=> __( 'Box Rain (Reverse)', 'child' ),
			'boxRainGrow'		=> __( 'Box Rain (Grow)', 'child' ),
			'boxRainGrowReverse'		=> __( 'Box Rain (Grow Reverse)', 'child' ),
		));

		$nivo_display_sort = apply_filters( 'child_display_sort', array(
			'date'			=> __( 'Date', 'child' ),
			'title'			=> __( 'Title', 'child' ),
			'author'		=> __( 'Author', 'child' ),
			'ID'			=> __( 'Post ID', 'child' ),
			'rand'			=> __( 'Random', 'child' ),
			'parent'		=> __( 'Parent ID', 'child' ),
			'menu_order'		=> __( 'Menu Order', 'child' ),
			'modified'		=> __( 'Date Modified', 'child' ),
			'comment_count'		=> __( 'Comment Count', 'child' ),
		));

		$nivo_display_order = apply_filters( 'child_display_order', array(
			'DESC'		=> __( 'Descending (Newer)', 'child' ),
			'ASC'		=> __( 'Ascending (Older)', 'child' ),
		));

		echo '<label>Category: </label>'; 
		echo '<select name="' . $this->get_field_name( 'nivo_category' ) . '" id="' . $this->get_field_id( 'nivo_category' ) . '">';
				foreach( $nivo_category as $nivo_cat ) {
					echo '<option value="' . $nivo_cat->cat_ID . '"' . selected( $nivo_current_category, $nivo_cat->cat_ID )  . '>' . $nivo_cat->cat_name. '</option>';
				}
		echo '</select></p>';
		echo '<p><span class="description">Select the featured category.</span></p>';

		echo '<label>Post Count: </label>';
		echo '<select name="' . $this->get_field_name( 'nivo_limit' ) . '" id="' . $this->get_field_id( 'nivo_limit' ) . '">';
				foreach ( $nivo_post_limit as $nivo_limit ) {
					echo '<option value="' . esc_attr( $nivo_limit ) . '"' . selected( $nivo_current_limit, $nivo_limit ) . '>' . esc_html( $nivo_limit ) . '</option>';
				}
		echo '</select>';
		echo '<p><span class="description">Select the number of posts to be displayed.</p>';

		echo '<label>Sort By: </label>';
		echo '<select name="' . $this->get_field_name( 'nivo_sort' ) . '" id="' . $this->get_field_id( 'nivo_sort' ) . '">';
				foreach ( $nivo_display_sort as $nivo_d_sort => $sort_label ) {
					printf( '<option value="%s" %s>%s</option>', $nivo_d_sort, selected( $nivo_d_sort, genesis_get_option( 'nivo_sort' , $this->settings_field ), 0 ), $sort_label );
				}
		echo '</select>';
		echo '<p><span class="description">Select how to sort posts.</span></p>';

		echo '<label>Sort Order: </label>';
		echo '<select name="' . $this->get_field_name( 'nivo_order' ) . '" id="' . $this->get_field_id( 'nivo_order' ) . '">';
				foreach ( $nivo_display_order as $nivo_d_order => $order_label ) {
					printf( '<option value="%s" %s>%s</option>', $nivo_d_order, selected( $nivo_d_order, genesis_get_option( 'nivo_order' , $this->settings_field ), 0 ), $order_label );
				}
		echo '</select>';
		echo '<p><span class="description">Select which posts to display first.</span></p>';
		
		echo '<label>Transition Effect: </label>';
		echo '<select name="' . $this->get_field_name( 'nivo_effect' ) . '" id="' . $this->get_field_id( 'nivo_effect' ) . '">';
				foreach ( $nivo_effect as $nivo_d_effect => $sort_label ) {
					printf( '<option value="%s" %s>%s</option>', $nivo_d_effect, selected( $nivo_d_effect, genesis_get_option( 'nivo_effect' , $this->settings_field ), 0 ), $sort_label );
				}
		echo '</select>';
		echo '<p><span class="description">Select a transition effect.</span></p>';

		echo '<label>Speed: </label><input type="text" name="' . $this->get_field_name( 'nivo_speed' ) . '" id="' . $this->get_field_id( 'nivo_speed' ) . '" value="' . esc_attr( $this->get_field_value( 'nivo_speed' ) ) . '" class="small-text" />';
		echo 'Default: <code class="description">3000</code>';
		echo '<p><span class="description">Set the transition speed of the featured content slider.</span></p>';
	}
	
	/**
	 * Register contextual help on Radio Theme Settings page
	 *
	 * @since 1.0.0
	 */
	function help( ) {
		global $my_admin_page;
		$screen = get_current_screen();

		if ( $screen->id != $this->pagehook )
			return;
 
		$tab1_help =
			'<h3>' . __( 'What Up' , CHILD_DOMAIN ) . '</h3>' .
			'<p>' . __( 'Yeah. So here is a help file.' , CHILD_DOMAIN ) . '</p>';

		$screen->add_help_tab(
			array(
				'id'    => $this->pagehook . '-tab1',
				'title' => __( 'Radio Theme Help' , CHILD_DOMAIN ),
				'content'   => $tab1_help,
			) );
	}

}

add_action( 'admin_menu', 'child_add_child_theme_settings', 2 );
/**
 * Add the Theme Settings Page
 *
 * @since 1.0.0
 * @required Genesis
 */
function child_add_child_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new Radio_Theme_Settings;	 	
}