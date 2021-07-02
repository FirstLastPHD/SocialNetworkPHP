<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['settings'] = 'active';
$page['name'] = 'Website Settings';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$site_name = $_POST['site_name'];
	$fb_app_id = $_POST['fb_app_id'];
	$fb_secret_key = $_POST['fb_secret_key'];
	$meta['keywords'] = $_POST['meta_keywords'];
	$meta['description'] = $_POST['meta_description'];
	$minimum_age = $_POST['minimum_age'];
	$email_sender = $_POST['email_sender'];
	$unit['height'] = $_POST['unit_height'];
	$unit['weight'] = $_POST['unit_weight'];
	$newConfig = "<?php
	\$domain = '".$domain."';

	// Database Configuration
	\$_db['host'] = '".$_db['host']."';
	\$_db['user'] = '".$_db['user']."';
	\$_db['pass'] = '".$_db['pass']."';
	\$_db['name'] = '".$_db['name']."';

	\$site_name = '".$site_name."';
	\$meta['keywords'] = '".$meta['keywords']."';
	\$meta['description'] = '".$meta['description']."';

	// PayPal Configuration
	\$paypal_email = '".$paypal_email."'; // Email of PayPal Account to receive money

	// Fortumo Configuration (SMS Payments)
	\$fortumo_service_id = '".$fortumo_service_id."';

	// Stripe Configuration
	\$secret_key = '".$secret_key."'; // Stripe API Secret Key
	\$publishable_key = '".$publishable_key."'; // Stripe API Publishable Key

	// Facebook Login Configuration
	\$fb_app_id = '".$fb_app_id."'; 
	\$fb_secret_key = '".$fb_secret_key."'; 

	// Misc Configuration
	\$minimum_age = '".$minimum_age."'; 
	\$email_sender = '".$email_sender."'; 

	// Layout Settings
	\$skin = '".$skin."';

	// Units of Measurement
	\$unit['height'] = '".$unit['height']."';
	\$unit['weight'] = '".$unit['weight']."';
	
	\$db = new mysqli(\$_db['host'], \$_db['user'], \$_db['pass'], \$_db['name']) or die('MySQL Error');

	error_reporting(0);
	";
	file_put_contents('../core/config.php',$newConfig);
	header('Location: settings.php');
	exit;
}


require('../inc/admin/top.php');
require('../layout/admin/settings.php');
require('../inc/admin/bottom.php');