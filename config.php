<?php
ini_set('max_execution_time', 300);

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']))
{
    exit('Please don\'t access this file directly.');
}
error_reporting(0);
require_once plugin_dir_path(__FILE__).'lib/stripe/init.php';

//require_once (SSL_plugin_dir_path . 'lib/stripe/init.php');

$key_api = get_option('SSM_stripe_api_key');

Stripe\Stripe::setApiKey($key_api); 
