<?php

namespace WPCustomerPortalForStripe;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/includes
 */
class Customer_Portal_For_Stripe {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Customer_Portal_For_Stripe_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CUSTOMER_PORTAL_FOR_STRIPE_VERSION' ) ) {
			$this->version = CUSTOMER_PORTAL_FOR_STRIPE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'customer-portal-for-stripe';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_filters();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Customer_Portal_For_Stripe_Loader. Orchestrates the hooks of the plugin.
	 * - Customer_Portal_For_Stripe_i18n. Defines internationalization functionality.
	 * - Customer_Portal_For_Stripe_Admin. Defines all hooks for the admin area.
	 * - Customer_Portal_For_Stripe_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-customer-portal-for-stripe-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-customer-portal-for-stripe-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-customer-portal-for-stripe-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-customer-portal-for-stripe-public.php';

		/**
		 * The class responsible for defining all shortcodes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-customer-portal-for-stripe-shortcodes.php';

		/**
		 * Stripe god class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-customer-portal-for-stripe-stripe.php';

		$this->loader = new Customer_Portal_For_Stripe_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Customer_Portal_For_Stripe_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Customer_Portal_For_Stripe_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all plugin filters
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_filters() {
		$plugin_admin = new Customer_Portal_For_Stripe_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_filter( 'plugin_action_links_customer-portal-for-stripe/customer-portal-for-stripe.php',
			$plugin_admin, 'plugin_settings_link' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Customer_Portal_For_Stripe_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_settings_sections' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_settings_fields' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
		$this->loader->add_action( 'edit_user_profile', $plugin_admin, 'stripe_customer_id_user_profile_field' );
		$this->loader->add_action( 'show_user_profile', $plugin_admin, 'stripe_customer_id_user_profile_field' );
		$this->loader->add_action( 'personal_options_update', $plugin_admin, 'save_stripe_customer_id_user_profile_field' );
		$this->loader->add_action( 'edit_user_profile_update', $plugin_admin, 'save_stripe_customer_id_user_profile_field' );
		$this->loader->add_action( 'user_profile_update_errors', $plugin_admin, 'stripe_customer_id_user_profile_field_errors', 10, 3 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		global $cpfsStripe;

		$cpfsStripe        = new Customer_Portal_For_Stripe_Stripe();
		$plugin_public     = new Customer_Portal_For_Stripe_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_shortcodes = new Customer_Portal_For_Stripe_Shortcodes();

		$this->loader->add_action( 'init', $plugin_shortcodes, 'init_shortcodes' );
		$this->loader->add_action( 'profile_update', $cpfsStripe, 'updateCustomerEmailAddress', 10, 2 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'cpfs_enqueue_custom_css' );
		$this->loader->add_action( 'wp_ajax_cpfs_cancelSubscription', $cpfsStripe, 'cancelSubscription' );
		$this->loader->add_action( 'wp_ajax_cpfs_setDefaultPaymentMethod', $cpfsStripe, 'setDefaultPaymentMethod' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Customer_Portal_For_Stripe_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}
}
