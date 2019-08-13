<?php  
	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );
	include "./lib/vendor/autoload.php";
	$key_api = get_option('SSM_stripe_api_key');
	\Stripe\Stripe::setApiKey($key_api);
	$list_all1 = \Stripe\WebhookEndpoint::create([
		"url" => plugin_dir_url( __FILE__ ) . '/lib/vendor/webhook.php',
		"enabled_events" => ["*"]
	]);

	
	//$list_all2 = \Stripe\WebhookEndpoint::all(["limit" => 10]);
	//$list_all3 = \Stripe\Event::all(["limit" => 1]);
	//$list_all31 = \Stripe\Customer::retrieve("cus_CPmNDlXv6xmIcc");
	//echo $list_all31->email;
	
	echo '<pre>';
	print_r($list_all1);
	echo '<pre>';