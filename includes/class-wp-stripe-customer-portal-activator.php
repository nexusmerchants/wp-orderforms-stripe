<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/includes
 */
class Wp_Stripe_Customer_Portal_Activator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        if (version_compare(phpversion(), WP_STRIPE_CUSTOMER_PORTAL_REQUIRED_PHP_VERSION, '<')) {
            exit( sprintf( "<p>WP Stripe Customer Portal requires PHP %s or higher. You're on %s.</p>", WP_STRIPE_CUSTOMER_PORTAL_REQUIRED_PHP_VERSION, PHP_VERSION ) );
        }

        if (false === get_option('wpscp_custom_css')) {
            // self::populate_default_custom_css();
        }
    }

    /**
     * Load & store default CSS
     */
    private static function populate_default_custom_css()
    {
        $defaultCss = file_get_contents(WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH . 'public/css/wp-stripe-customer-portal-shortcodes.css');
        update_option('wpscp_custom_css', $defaultCss);
    }
}
