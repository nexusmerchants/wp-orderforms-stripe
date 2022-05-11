<?php

namespace WPCustomerPortalForStripe;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/public
 */
class Customer_Portal_For_Stripe_Public {
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
	 * @param  string  $plugin_name  The name of the plugin.
	 * @param  string  $version  The version of this plugin.
	 *
	 * @since    1.0.0
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
		 * defined in Customer_Portal_For_Stripe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Customer_Portal_For_Stripe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/customer-portal-for-stripe-public.css',
			array(), $this->version, 'all' );
		$this->cpfs_enqueue_shortcode_styles();
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
		 * defined in Customer_Portal_For_Stripe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Customer_Portal_For_Stripe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/customer-portal-for-stripe-public.js',
			array( 'jquery' ), $this->version, false );
		$this->cpfs_enqueue_shortcode_scripts();
	}

	/**
	 * Enqueue CSS required by shortcodes
	 */
	protected function cpfs_enqueue_shortcode_styles() {
		global $post;
		foreach ( Customer_Portal_For_Stripe_Shortcodes::$shortcodes as $shortcode ) {
			if ( ! empty( $post ) && has_shortcode( $post->post_content, $shortcode ) ) {
				wp_enqueue_style( $this->plugin_name . '_shortcodes',
					plugin_dir_url( __FILE__ ) . 'css/customer-portal-for-stripe-shortcodes.css', array(),
					$this->version, 'all' );
			}
		}
	}

	/**
	 * Enqueue scripts required by shortcodes
	 */
	protected function cpfs_enqueue_shortcode_scripts() {
		global $post;
		if ( ! empty( $post ) && has_shortcode( $post->post_content, 'cpfs_add_card' ) ) {
			wp_enqueue_script( 'stripejs_v3', 'https://js.stripe.com/v3/', array( 'jquery' ), null, false );
		}
	}

	/**
	 * Add custom CSS to wp_head
	 */
	public function cpfs_enqueue_custom_css() {
		$cpfsCustomCSS = get_option( 'cpfs_custom_css' );
		$cpfsCustomCSS = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cpfsCustomCSS );
		$cpfsCustomCSS = str_replace( ': ', ':', $cpfsCustomCSS );
		$cpfsCustomCSS = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $cpfsCustomCSS );
		echo '<style id="cpfs_custom_css">' . esc_textarea($cpfsCustomCSS) . '</style>';
	}
}
