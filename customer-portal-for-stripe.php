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
 * @package           Customer_Portal_For_Stripe
 *
 * @wordpress-plugin
 * Plugin Name:       Customer Portal for Stripe
 * Plugin URI:        https://www.orderforms.com
 * Description:       Provides shortcodes for Stripe Invoices, Subscriptions & Cards.
 * Version:           4.1.0
 * Author:            Nexus Merchants
 * Author URI:        https://www.nexusmerchants.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       customer-portal-for-stripe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Path to plugin
 */
define( 'CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Textdomain
 */
define( 'CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN', 'customer-portal-for-stripe' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOMER_PORTAL_FOR_STRIPE_VERSION', '4.1.0' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOMER_PORTAL_FOR_STRIPE_REQUIRED_PHP_VERSION', '7.4' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-customer-portal-for-stripe-activator.php
 */
function activate_customer_portal_for_stripe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-customer-portal-for-stripe-activator.php';
	WPCustomerPortalForStripe\Customer_Portal_For_Stripe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-customer-portal-for-stripe-deactivator.php
 */
function deactivate_customer_portal_for_stripe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-customer-portal-for-stripe-deactivator.php';
	WPCustomerPortalForStripe\Customer_Portal_For_Stripe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_customer_portal_for_stripe' );
register_deactivation_hook( __FILE__, 'deactivate_customer_portal_for_stripe' );

/**
 * Load vendor specific classes
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-customer-portal-for-stripe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_customer_portal_for_stripe() {
	$plugin = new WPCustomerPortalForStripe\Customer_Portal_For_Stripe();
	$plugin->run();
}

run_customer_portal_for_stripe();
