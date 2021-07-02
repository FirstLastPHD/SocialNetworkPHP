<?php
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/stripe/init.php');

$stripe_token = $_GET['t'];
$transaction_token = $_SESSION['tid'];
$user_id = $_SESSION['user_id'];

$transaction = $db->query("SELECT * FROM transactions WHERE token='".$transaction_token."' LIMIT 1");
$transaction = $transaction->fetch_object();

\Stripe\Stripe::setApiKey($secret_key);

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = \Stripe\Charge::create(array(
  	"amount" => $transaction->transaction_amount*100, // amount in cents, again
  	"currency" => "usd",
  	"source" => $stripe_token,
  	"description" => $transaction->transaction_name)
	);
	echo '<div class="alert alert-success"><i class="fa fa-fw fa-check"></i> Payment Successful</div>';
} catch(\Stripe\Error\Card $e) {
	echo '<div class="alert alert-danger"><i class="fa fa-fw fa-times"></i> Payment Failed</div>';
}

$db->query("UPDATE transactions SET status='1' WHERE id='".$transaction->id."'");
$db->query("UPDATE users SET credits=credits+".$transaction->credits_to_add." WHERE id='".$user_id."'");


