<?php

namespace WPCustomerPortalForStripe;

/**
 * Fired during plugin activation
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/includes
 */
class Customer_Portal_For_Stripe_Activator
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
        if (version_compare(phpversion(), CUSTOMER_PORTAL_FOR_STRIPE_REQUIRED_PHP_VERSION, '<')) {
            exit(sprintf(
                "<p>Customer Portal for Stripe requires PHP %s or higher. You're on %s.</p>",
                CUSTOMER_PORTAL_FOR_STRIPE_REQUIRED_PHP_VERSION,
                PHP_VERSION
            ));
        }

        if (false === get_option('cpfs_custom_css')) {
            // self::populate_default_custom_css();
        }
    }

    /**
     * Load & store default CSS
     */
    private static function populate_default_custom_css()
    {
        $defaultCss = file_get_contents(
            CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'public/css/customer-portal-for-stripe-shortcodes.css'
        );
        update_option('cpfs_custom_css', $defaultCss);
    }
}
