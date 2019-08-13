<?php
session_start();

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
//require_once( $parse_uri[0] . '/wp-content/plugins/orderforms-stripe/lib/vendor/autoload.php' );

include "autoload.php";

$key_api = get_option('SSM_stripe_api_key');
$appname = get_option('SSM_inf_app');
$access_token = get_option('SSM_access_token');
$refresh_token = get_option('SSM_refresh_token');
$clientId = get_option('SSM_clientId');
$clientSecret = get_option('SSM_clientSecret');

\Stripe\Stripe::setApiKey($key_api);

// $appname = 'eh663';
// $access_token = 'erdzt2zyhpu347rhvd4jwukj';
// $refresh_token = 'a3pr4j52cb9mraz3t8x3e2x7';
// $clientId = 'cymrc853wye7rg42524bpb9f';
// $clientSecret = 'HPQWyF2G75';
//$apikey = 'efa8127f58dfdb94efcb0e417b6188bf';

//retrieve the request's body and parse it as JSON
$body = @file_get_contents('php://input');
$event_json = json_decode($body);

//for extra security, retrieve from the Stripe API
	$event_id = $event_json->id;
	$event = Stripe_Event::retrieve($event_id);
	$event_type = $event->type;
	$event_customer = $event->customer;
	$customer_info = \Stripe\Customer::retrieve($event_customer);
	$customer_email = $customer_info->email;

include "../infusionsoft/vendor/autoload.php";
global $infusionsoft;
	$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId' => $clientId,
	'clientSecret' => $clientSecret,
	'redirectUri' => plugin_dir_url( __FILE__ ) . 'lib/vendor/webhook.php'
	));

$token_data = [
'access_token' => $access_token,
'refresh_token' => $refresh_token,
'expires_in' => '8640000000000000000000'
];
$token = new Infusionsoft\Token($token_data);
$infusionsoft->setToken($token);
//print"<pre>";
//print_r($token);

function add($infusionsoft, $email)
{
    $email1 = new \stdClass;
    $email1->field = 'EMAIL1';
    $email1->email = $email;
    $contact = ['given_name' => '', 'family_name' => '', 'email_addresses' => [$email1]];
    return $infusionsoft->contacts()->create($contact);
}
if ($infusionsoft->getToken()) {
    try {
        $email = $customer_email;
        try {
            $cid = $infusionsoft->contacts()->where('email', $email)->first();
        } catch (\Infusionsoft\InfusionsoftException $e) {
            $cid = add($infusionsoft, $email);
        }
    } catch (\Infusionsoft\TokenExpiredException $e) {
        // If the request fails due to an expired access token, we can refresh
        // the token and then do the request again.
        $infusionsoft->refreshAccessToken();
        $cid = add($infusionsoft);
    }
    $contact = $infusionsoft->contacts()->with('custom_fields')->find($cid->id);
	//print_r($conatct_info);
	$contact_info = $contact->toArray();
	
	//echo '<pre>';
	//print_r($contact_info);
	$contact_id =  $contact_info['id'];
	if($event_type == "charge.succeeded"){
	 $res = $infusionsoft->funnels()->achieveGoal( $appname , 'ofcstripechargesucceeded', $contact_id);
	}
	elseif($event_type == "charge.failed"){
	 $res = $infusionsoft->funnels()->achieveGoal( $appname , 'ofcstripechargefailed', $contact_id);
	}else{
		echo '';
	}
	//echo '<pre>';
	print_r($res);
    //var_dump($contact->toArray());
	
	
    // Save the serialized token to the current session for subsequent requests
    $_SESSION['token'] = serialize($infusionsoft->getToken());
} else {
    echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}
?>
