<?php


include "/lib/vendor/autoload.php";
\Stripe\Stripe::setApiKey("sk_test_D2NYosypp4cCSpVI80iKHchu");
$appname = 'eh663';
$apikey = 'sk_test_D2NYosypp4cCSpVI80iKHchu';

//retrieve the request's body and parse it as JSON
$body = @file_get_contents('php://input');
$event_json = json_decode($body);
//for extra security, retrieve from the Stripe API
// $event_id = $event_json->id;
// $event = Stripe_Event::retrieve($event_id);
// $event_type = $event->type;

include "./lib/infusionsoft/vendor/autoload.php";
$infusionsoft = new \Infusionsoft\Infusionsoft(array(
'clientId' => 'cymrc853wye7rg42524bpb9f',
'clientSecret' => 'HPQWyF2G75',
'redirectUri' => 'https://www.stripecontrol.com/wp-content/plugins/orderforms-stripe/webhook.php'
));

$_GET['code'] = '535h74pmufbgq5bsaw6furzy';

//$infusionsoft->refreshAccessToken();
// If the serialized token is available in the session storage, we tell the SDK
// to use that token for subsequent requests.
if (isset($_SESSION['token'])) {
	$infusionsoft->setToken(unserialize($_SESSION['token']));
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getToken()) {
	$_SESSION['token'] = serialize($infusionsoft->requestAccessToken($_GET['code']));
}

if ($infusionsoft->getToken()) {
	// Save the serialized token to the current session for subsequent requests
	$_SESSION['token'] = serialize($infusionsoft->getToken());

	// MAKE INFUSIONSOFT REQUEST
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}

$res = $infusionsoft->funnels()->achieveGoal( 'eh663' , 'ofcstripechargefailed', '377');

echo '<pre>';
print_r($res);

?>
