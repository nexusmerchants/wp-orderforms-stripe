<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.nexusmerchants.com
 * @since             1.0.0
 * @package           Wp_Stripe_Customer_Portal
 *
 * @wordpress-plugin
 * Plugin Name:       WP Stripe Customer Portal
 * Plugin URI:        https://www.orderforms.com
 * Description:       Provides shortcodes for Stripe Invoices, Subscriptions & Cards.
 * Version:           4.0.0
 * Author:            Nexus Merchants
 * Author URI:        https://www.nexusmerchants.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-stripe-customer-portal
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Path to plugin
 */
define( 'WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Textdomain
 */
define( 'WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN', 'wp-stripe-customer-portal' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_STRIPE_CUSTOMER_PORTAL_VERSION', '1.2.0' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_STRIPE_CUSTOMER_PORTAL_REQUIRED_PHP_VERSION', '7.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-stripe-customer-portal-activator.php
 */
function activate_wp_stripe_customer_portal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-stripe-customer-portal-activator.php';
	Wp_Stripe_Customer_Portal_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-stripe-customer-portal-deactivator.php
 */
function deactivate_wp_stripe_customer_portal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-stripe-customer-portal-deactivator.php';
	Wp_Stripe_Customer_Portal_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_stripe_customer_portal' );
register_deactivation_hook( __FILE__, 'deactivate_wp_stripe_customer_portal' );

/**
 * Load vendor specific classes
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-stripe-customer-portal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_stripe_customer_portal() {
	$plugin = new Wp_Stripe_Customer_Portal();
	$plugin->run();
}

run_wp_stripe_customer_portal();
