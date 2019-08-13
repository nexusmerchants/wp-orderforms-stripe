<?php
/*
 Plugin Name: OrderForms.com Stripe Manager 
 Description: A plugin connects stripe and Wordpress. Loggedin user can able to inactivate or activate own subscription and can add/update old Credit card.
 Version: 3.0
 Author: orderforms 
 Author URI: https://www.orderforms.com/
 License: GPLv2 or later
 */require_once('config.php');if ( ! defined( 'USERSWP_PATH' ) ) {    define('USERSWP_PATH', plugin_dir_path(__FILE__));}
register_activation_hook(__FILE__, 'SSM_install_memberList');add_filter('plugins_loaded', 'SSM_subecriptions_init' );function SSM_subecriptions_init() {      require_once('functions.php');}
function SSM_install_memberList()
{		add_option("SSM_stripe_api_key");
}
function plugin_add_settings_link( $links ) {  $settings_link = '<a href="admin.php?page=StripeManager">' . __( 'Settings' ) . '</a>';  array_push( $links, $settings_link );  return $links;}$plugin = plugin_basename( __FILE__ );add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );register_uninstall_hook(__FILE__,'SSM_uninstall_memberList');
function SSM_uninstall_memberList(){	
	delete_option('SSM_stripe_api_key');
}
/*
add_action('admin_print_styles','SMAddStyle');
add_action('wp_print_styles', 'SMAddStyle' );

function SMAddStyle(){
    wp_enqueue_style( 'CustomCss', plugins_url('/css/style.css',__FILE__) );
}
*/

?>