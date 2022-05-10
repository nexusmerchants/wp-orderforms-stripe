<?php
/**
 * @author Peter Harlacher
 * @license GPL-2.0+
 * @copyright 2021 Peter Harlacher
 * @since 24/5/21 09:41
 */

/**
 * Class Wp_Stripe_Customer_Portal_Shortcodes
 */
class Wp_Stripe_Customer_Portal_Shortcodes
{
    public static $shortcodes = [
        'wpscp_list_cards',
        'wpscp_add_card',
        'wpscp_list_subscriptions',
        'wpscp_list_invoices',
    ];

    /**
     * Init
     */
    public function init_shortcodes()
    {
        foreach (self::$shortcodes as $shortcode) {
            add_shortcode($shortcode, [$this, $shortcode]);
        }
    }

    /**
     * @param $atts
     * @param string $content
     *
     * @return string
     */
    public function wpscp_list_cards($atts, $content = "")
    {
        if (!is_user_logged_in()) {
            return __("Please sign in to view this content.", WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN);
        }

        global $wpscpStripe;
        $customer = $wpscpStripe->getOrCreateCustomer();
        $items = $wpscpStripe->getCards($customer);

        ob_start();
        require_once WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH . 'public/partials/wp-stripe-customer-portal-cards.php';
        return ob_get_clean();
    }

    public function wpscp_add_card($atts, $content = "")
    {
        if (!is_user_logged_in()) {
            return __("Please sign in to view this content.", WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN);
        }

        global $wpscpStripe;
        $customer = $wpscpStripe->getOrCreateCustomer();
        $setupIntent = $wpscpStripe->createSetupIntent($customer);

        ob_start();
        require_once WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH . 'public/partials/wp-stripe-customer-portal-add-card.php';
        return ob_get_clean();
    }

    public function wpscp_list_subscriptions($atts, $content = "")
    {
        if (!is_user_logged_in()) {
            return __("Please sign in to view this content.", WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN);
        }

        extract(shortcode_atts(array(
            'include-cancelled' => false,
            'allow-cancel' => false,
        ), $atts));

        global $wpscpStripe;
        $customer = $wpscpStripe->getOrCreateCustomer();
        $items = $wpscpStripe->getSubscriptions($customer);

        ob_start();
        require_once WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH . 'public/partials/wp-stripe-customer-portal-subscriptions.php';
        return ob_get_clean();
    }

    public function wpscp_list_invoices($atts, $content = "")
    {
        if (!is_user_logged_in()) {
            return __("Please sign in to view this content.", WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN);
        }

        extract(shortcode_atts(array(
            'limit' => 25,
        ), $atts));

        global $wpscpStripe;
        $customer = $wpscpStripe->getOrCreateCustomer();
        $items = $wpscpStripe->getInvoices($customer);

        ob_start();
        require_once WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_PATH . 'public/partials/wp-stripe-customer-portal-invoices.php';
        return ob_get_clean();
    }
}
