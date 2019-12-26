<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       mailto:artem.kashel@gmail.com
 * @since      1.0.0
 *
 * @package    Addendio_Sandbox_Management
 * @subpackage Addendio_Sandbox_Management/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Addendio_Sandbox_Management
 * @subpackage Addendio_Sandbox_Management/public
 * @author     Artsem Kashel <artem.kashel@gmail.com>
 */
class Addendio_Sandbox_Management_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Addendio_Sandbox_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Addendio_Sandbox_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'css-noty', plugin_dir_url( __FILE__ ) . 'css/noty.css', array(), '3.0.1', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addendio-sandbox-management-public.css', array( 'css-noty' ), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Addendio_Sandbox_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Addendio_Sandbox_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.js', array( 'jquery' ), '1.16.0', true );
		wp_enqueue_script( 'js-noty', plugin_dir_url( __FILE__ ) . 'js/noty.min.js', array(), '3.0.1', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addendio-sandbox-management-public.js', array(
			'jquery',
			'jquery-validate',
			'js-noty'
		), $this->version, true );
		wp_localize_script( $this->plugin_name, 'addendioPublicData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'messages' => Addendio_Sandbox_Management::$msg->get_messages_public(),
		) );

	}

	/**
	 * Register the Shortcodes for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		$shortcodes = array(
			new Addendio_Sandbox_Management_Shortcode_Login_Register(),
		);

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode::SHORTCODE, array( $shortcode, 'shortcode_html' ) );
		}
	}

}
