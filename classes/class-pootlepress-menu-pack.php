<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Pootlepress_Menu_Pack Class
 *
 * Base class for the Pootlepress Menu Pack.
 *
 * @package WordPress
 * @subpackage Pootlepress_Menu_Pack
 * @category Core
 * @author Pootlepress
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * public $token
 * public $version
 * private $_menu_style
 * 
 * - __construct()
 * - add_theme_options()
 * - get_menu_styles()
 * - load_style_specific_method()
 * - load_style_specific_stylesheet()
 * - load_localisation()
 * - check_plugin()
 * - load_plugin_textdomain()
 * - activation()
 * - register_plugin_version()
 * - get()
 * - style_hooks_top_tabs()
 * - style_hooks_header()
 * - style_hooks_beautiful_type()
 * - style_hooks_top_align()
 * - style_hooks_centred()
 * - move_nav_inside_header()
 */
class Pootlepress_Menu_Pack {
	public $token = 'pootlepress-menu-pack';
	public $version;
	private $file;
	private $_menu_style;

	/**
	 * Constructor.
	 * @param string $file The base file of the plugin.
	 * @access public
	 * @since  1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
		$this->file = $file;
		$this->load_plugin_textdomain();
		add_action( 'init', 'check_main_heading', 0 );
		add_action( 'init', array( &$this, 'load_localisation' ), 0 );

		// Run this on activation.
		register_activation_hook( $file, array( &$this, 'activation' ) );

		// Add the custom theme options.
		add_filter( 'option_woo_template', array( &$this, 'add_theme_options' ) );

		// Lood for a method/function for the selected style and load it.
		add_action( 'get_header', array( &$this, 'load_style_specific_method' ) );

		// Lood for a stylesheet for the selected style and load it.
		add_action( 'wp_enqueue_scripts', array( &$this, 'load_style_specific_stylesheet' ) );
	} // End __construct()

	/**
	 * Add theme options to the WooFramework.
	 * @access public
	 * @since  1.0.0
	 * @param array $o The array of options, as stored in the database.
	 */
	public function add_theme_options ( $o ) {
		//If the Canvas Extensions is not installed
		$styles = array();
		
		foreach ( (array)$GLOBALS['pootlepress_menu_pack']->get_menu_styles() as $k => $v ) {
			if ( isset( $v['name'] ) ) {
				$styles[$k] = $v['name'];
			}
		}
		
		$o[] = array(
				'name' => __( 'Pootlepress Menus', 'pootlepress-menu-pack' ),
				'type' => 'subheading'
				);
		$o[] = array(
				'id' => 'pootlepress-menu-pack-menu-style', 
				'name' => __( 'Menu Style', 'pootlepress-menu-pack' ), 
				'desc' => __( 'Select your preferred menu look and feel.', 'pootlepress-menu-pack' ), 
				'type' => 'select2', 
				'options' => $styles
				);
		return $o;
	} // End add_theme_options()

	/**
	 * Get the supported menu types available.
	 * @access public
	 * @since  1.0.0
	 * @return array Supported menu styles.
	 */
	public function get_menu_styles () {
		$styles = array(
						'none' => array(
									'name' => __( 'None', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core'
									), 
						'top_tabs' => array(
									'name' => __( 'Top Tabs', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core'
									), 
						'header' => array( 
									'name' => __( 'Header', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core'
									), 
						'beautiful_type' => array(
									'name' => __( 'Beautiful Type', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core'
									), 
						'top_align' => array(
									'name' => __( 'Top Align', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core'
									), 
						'centred' => array( 
									'name' => __( 'Centred', 'pootlepress-menu-pack' ), 
									'callback' => 'method', 
									'stylesheet' => 'core' 
									)
					);
		return (array) apply_filters( 'pootlepress-menu-pack-menu-styles', $styles );
	} // End get_menu_styles()

	/**
	 * Load any specific custom logic required for the style, if has any.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function load_style_specific_method () {
		$style = $this->get( 'menu_style' );
		$supported_styles = $this->get_menu_styles();

		if ( 'none' != $style ) {
			if (
				isset( $supported_styles[$style]['callback'] ) && 
				'method' == $supported_styles[$style]['callback'] && 
				method_exists( $this, 'style_hooks_' . esc_attr( $style ) )
			) {
				call_user_func( array( $this, 'style_hooks_' . esc_attr( $style ) ) );
			} else {
				if ( isset( $supported_styles[$style]['callback'] ) ) {
					if ( is_callable( $supported_styles[$style]['callback'] ) ) {
						call_user_func( $supported_styles[$style]['callback'] );
					}
				}
			}
		}
	} // End load_style_specific_method()

	/**
	 * Load any specific custom stylesheet required for the style, if has any.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function load_style_specific_stylesheet () {
		$style = $this->get( 'menu_style' );
		$supported_styles = $this->get_menu_styles();

		if ( 'none' != $style ) {
			if (
				isset( $supported_styles[$style]['stylesheet'] ) && 
				'core' == $supported_styles[$style]['stylesheet']
			) {
				wp_enqueue_style( $this->token . '-' . esc_attr( $style ), esc_url( plugins_url( 'styles/' . esc_attr( $style ) . '.css', $this->file ) ) );
			} else {
				if ( isset( $supported_styles[$style]['stylesheet'] ) && '' != $supported_styles[$style]['stylesheet'] ) {
					wp_enqueue_style( $this->token . '-' . esc_attr( $style ), esc_url( $supported_styles[$style]['stylesheet'] ) );
				}
			}
		}
	} // End load_style_specific_stylesheet()

	/**
	 * Load the plugin's localisation file.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_localisation () {
		load_plugin_textdomain( $this->token, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation()

	/**
	 * Load the plugin textdomain from the main WordPress "languages" folder.
	 * @access public
	 * @since  1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = $this->token;
	    // The "plugin_locale" filter is also used in load_plugin_textdomain()
	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	 
	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain()

	/**
	 * Run on activation.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();
	} // End activation()

	/**
	 * Register the plugin's version.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	private function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( $this->token . '-version', $this->version );
		}
	} // End register_plugin_version()

	/**
	 * Get private variables.
	 * @param   string $var The token for the variable to retrieve.
	 * @access  public
	 * @since   1.0.0
	 * @return  string      The value of the variable retrieved.
	 */
	public function get ( $var ) {
		switch ( $var ) {
			case 'woo_background_image':
				$response = '';
				$bg_image = get_option( 'woo_header_bg_image' );
				if ( '' != $bg_image ) {
					$response = 'background: url(' . esc_url( get_option( 'woo_header_bg_image' ) ) . ');';
					$response .= ' background-color: ' . esc_attr( get_option( 'woo_header_bg' ) ) . ';';
				}
				return $response;
			break;

			case 'woo_header_before':
				return '<div id="header-container" style="' . esc_attr( $this->get( 'woo_background_image' ) ) . '">';
			break;

			case 'woo_header_after':
				return '</div><!--/#header-container-->';
			break;

			case 'woo_nav_before':
				return '<div id="nav-container" style="' . esc_attr( $this->get( 'woo_background_image' ) ) . '">';
			break;

			case 'woo_nav_after':
				return '</div><!--/#nav-container-->';
			break;

			case 'woo_footer_top':
				return '<div id="footer-widgets-container">';
			break;

			case 'woo_footer_before':
				return '</div><!--/#footer-widgets-container-->' . "\n" . '<div id="footer-container">';
			break;

			case 'woo_footer_after':
				return '</div><!--/#footer-container-->';
			break;

			case 'menu_style':
				if ( '' == $this->_menu_style ) $this->_menu_style = get_option( 'pootlepress-menu-pack-menu-style', 'none' );
				if ( ! in_array( $this->_menu_style, array_keys( $this->get_menu_styles() ) ) ) $this->_menu_style = 'none';
				return $this->_menu_style;
			break;

			default:
				return false;
			break;
		}
	} // End get()

	/**
	 * Load hooks for the "top tabs" style.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function style_hooks_top_tabs () {
		$this->move_nav_inside_header();
	} // End style_hooks_top_tabs()

	/**
	 * Load hooks for the "header" style.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function style_hooks_header () {
		add_action( 'woo_header_before', array( &$this, 'filter_getter' ) );
		add_action( 'woo_header_after', array( &$this, 'filter_getter' ) );

		add_action( 'woo_nav_before', array( &$this, 'filter_getter' ) );
		add_action( 'woo_nav_after', array( &$this, 'filter_getter' ) );

		add_action( 'woo_footer_top', array( &$this, 'filter_getter' ) );
		add_action( 'woo_footer_before', array( &$this, 'filter_getter' ) );
		add_action( 'woo_footer_after', array( &$this, 'filter_getter' ) );
		
		remove_action( 'woo_header_after','woo_nav', 10 ); 
		add_action( 'woo_header_after', 'woo_nav_custom', 10 );
	
	} // End style_hooks_header()

	/**
	 * Load hooks for the "beautiful type" style.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function style_hooks_beautiful_type () {
		//$this->move_nav_inside_header();
		// Remove main nav from the woo_header_after hook 
		remove_action( 'woo_header_after','woo_nav', 10 ); 
		// Add main nav to the woo_header_inside hook 
		add_action( 'woo_header_after','woo_nav_beautiful_type', 10 ); 		
		
		
	} // End style_hooks_beautiful_type()

	/**
	 * Load hooks for the "top align" style.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function style_hooks_top_align () {
		$this->move_nav_inside_header();
	} // End style_hooks_top_align()

	/**
	 * Load hooks for the "centred" style.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function style_hooks_centred () {
		add_action( 'woo_header_before', array( &$this, 'filter_getter' ) );
		add_action( 'woo_header_after', array( &$this, 'filter_getter' ) );
		
		remove_action( 'woo_header_after','woo_nav', 10 ); 
		add_action( 'woo_header_after', 'woo_nav_custom', 10 );
	} // End style_hooks_centred()

	/**
	 * Move the navigation inside the header section.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function move_nav_inside_header () {
		// Remove main nav from the woo_header_after hook 
		remove_action( 'woo_header_after', 'woo_nav', 10 ); 
		// Add main nav to the woo_header_inside hook 
		add_action( 'woo_header_inside', 'woo_nav_custom', 10 );
	} // End move_nav_inside_header()

	/**
	 * Getter for the various get() actions hooks we need.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function filter_getter () {
		echo $this->get( current_filter() );
	} // End filter_getter()
} // End Class


