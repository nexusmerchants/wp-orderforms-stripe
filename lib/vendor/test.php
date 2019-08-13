<?php
include "autoload.php";

\Stripe\Stripe::setApiKey("sk_test_D2NYosypp4cCSpVI80iKHchu");

$part = \Stripe\WebhookEndpoint::create([
  "url" => "https://example.com/my/webhook/endpoint123",
  "enabled_events" => ["*"]
]);
echo '<pre>';
print_r($part); 