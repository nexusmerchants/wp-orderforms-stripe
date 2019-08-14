<?php
/*
Plugin Name: OrderForms.com Stripe Manager
Plugin URI: https://wordpress.org/plugins/orderforms-stripe
Description: List Stripe subscriptions inside WordPress. Users can deactivate/activate own subscription(s) and add/update credit card data.
Version: 3.1.0
Author: orderforms
Author URI: https://www.orderforms.com
Text Domain: orderforms-stripe
License: GPL2 or later
 */
require_once('config.php');

if (!defined('USERSWP_PATH')) {
    define('USERSWP_PATH', plugin_dir_path(__FILE__));
}

register_activation_hook(__FILE__, 'SSM_install_memberList');
add_filter('plugins_loaded', 'SSM_subecriptions_init');

function SSM_subecriptions_init()
{
    require_once('functions.php');
}

function SSM_install_memberList()
{
    add_option("SSM_stripe_api_key");
}

function plugin_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=StripeManager">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'plugin_add_settings_link');
register_uninstall_hook(__FILE__, 'SSM_uninstall_memberList');

function SSM_uninstall_memberList()
{
    delete_option('SSM_stripe_api_key');
}
