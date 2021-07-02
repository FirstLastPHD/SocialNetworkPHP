<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['upgrades'] = 'active';
$page['name'] = 'Upgrades';

if(!$auth->isLogged()) {
	header('Location: index.php');
	exit;
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

// Process Payment
if(isset($_POST['continue'])) {

	$payment_method = $_POST['payment_method'];

	switch ($_POST['credit_amount']) {
		case 50:
		$price = 1;
		break;
		case 100:
		$price = 2;
		break;
		case 200:
		$price = 4;
		break;
		case 300:
		$price = 6;
		break;
		case 400:
		$price = 8;
		break;
		case 500:
		$price = 10;
		break;
		case 600:
		$price = 12;
		break;
		case 700:
		$price = 14;
		break;
		case 800:
		$price = 16;
		break;
		case 900:
		$price = 18;
		break;
		case 1000:
		$price = 20;
		break;
		default:
		$price = 1;
		break;
	}

	if($payment_method == 2) {

		$query = array();
		$query['notify_url'] = $system->getDomain().'/api/paypal.php';
		$query['cmd'] = '_xclick';
		$query['business'] = $paypal_email;
		$query['currency_code'] = 'USD';
		$query['custom'] = 'credits/'.$_POST['credit_amount'].'/'.$user->id;
		$query['return'] = $system->getDomain().'/upgrades.php';
		$query['item_name'] = $_POST['credit_amount'].' Credits';
		$query['quantity'] = 1;
		$query['amount'] = $price;

		$query_string = http_build_query($query);
		header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);


	} elseif($payment_method == 3) {

		$token = md5(time());
		$name = $_POST['credit_amount'].' Credits';
		$db->query("INSERT INTO transactions (transaction_amount,transaction_name,status,user_id,token,credits_to_add,method) VALUES ('".$price."','".$name."','0','".$user->id."','".$token."','".$_POST['credit_amount']."','3')");
		header('Location: process.php?t='.$token);

	} elseif($payment_method == 1) {

		$token = md5(time());
		$name = $_POST['credit_amount'].' Credits';
		$db->query("INSERT INTO transactions (transaction_amount,transaction_name,status,user_id,token,credits_to_add,method) VALUES ('".$price."','".$name."','0','".$user->id."','".$token."','".$_POST['credit_amount']."','1')");
		header('Location: process.php?t='.$token);

	}

}

	if($_POST['vip_1']) {

		$query = array();
		$query['notify_url'] = $system->getDomain().'/api/paypal.php';
		$query['cmd'] = '_xclick';
		$query['business'] = $paypal_email;
		$query['currency_code'] = 'USD';
		$query['custom'] = 'vip/2629743/'.$user->id;
		$query['return'] = $system->getDomain().'/upgrades.php';
		$query['item_name'] = 'VIP Account - 1 Month';
		$query['quantity'] = 1;
		$query['amount'] = 5;

		$query_string = http_build_query($query);
		header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);

	} elseif($_POST['vip_3']) {

		$query = array();
		$query['notify_url'] = $system->getDomain().'/api/paypal.php';
		$query['cmd'] = '_xclick';
		$query['business'] = $paypal_email;
		$query['currency_code'] = 'USD';
		$query['custom'] = 'vip/7889231/'.$user->id;
		$query['return'] = $system->getDomain().'/upgrades.php';
		$query['item_name'] = 'VIP Account - 3 Months';
		$query['quantity'] = 1;
		$query['amount'] = 15;

		$query_string = http_build_query($query);
		header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);

	}

if(isset($_POST['enable_1'])) {
	if($user->credits >= 150) {
		$start = time();
		$expiration = time()+2629743;
		$db->query("UPDATE users SET is_incognito='1' WHERE id='".$user->id."'");
		$db->query("UPDATE users SET ghost_mode_start=".$start." WHERE id=".$user->id."");
		$db->query("UPDATE users SET ghost_mode_expiration=".$expiration." WHERE id=".$user->id."");
		$db->query("UPDATE users SET credits=credits-150 WHERE id='".$user->id."'");
		header('Location: '.$system->getDomain().'/upgrades.php');
		exit;
	} else {
		$error = true;
	}
}

if(isset($_POST['enable_2'])) {
	if($user->credits >= 200) {
		$start = time();
		$expiration = time()+2629743;
		$db->query("UPDATE users SET is_verified='1' WHERE id='".$user->id."'");
		$db->query("UPDATE users SET verified_badge_start=".$start." WHERE id=".$user->id."");
		$db->query("UPDATE users SET verified_badge_expiration=".$expiration." WHERE id=".$user->id."");
		$db->query("UPDATE users SET credits=credits-200 WHERE id='".$user->id."'");	
		header('Location: '.$system->getDomain().'/upgrades.php');
		exit;
	} else {
		$error = true;
	}
}

if(isset($_POST['enable_3'])) {
	if($user->credits >= 250) {
		$start = time();
		$expiration = time()+2629743;
		$db->query("UPDATE users SET is_increased_exposure='1' WHERE id='".$user->id."'");
		$db->query("UPDATE users SET spotlight_start=".$start." WHERE id=".$user->id."");
		$db->query("UPDATE users SET spotlight_expiration=".$expiration." WHERE id=".$user->id."");
		$db->query("UPDATE users SET credits=credits-250 WHERE id='".$user->id."'");    
		header('Location: '.$system->getDomain().'/upgrades.php');
		exit;
	} else {
		$error = true;
	}
}

if(isset($_POST['enable_4'])) {
	if($user->credits >= 300) {
		$start = time();
		$expiration = time()+2629743;
		$db->query("UPDATE users SET has_disabled_ads='1' WHERE id='".$user->id."'");  
		$db->query("UPDATE users SET disable_ads_start=".$start." WHERE id=".$user->id."");
		$db->query("UPDATE users SET disable_ads_expiration=".$expiration." WHERE id=".$user->id."");
		$db->query("UPDATE users SET credits=credits-300 WHERE id='".$user->id."'");    
		header('Location: '.$system->getDomain().'/upgrades.php');
		exit;
	} else {
		$error = true;
	}
}

// Calculate duration left of upgrades (percentage & time)
$now = time();

$ghost_mode_start = $user->ghost_mode_start;
$ghost_mode_end = $user->ghost_mode_expiration;
$ghost_mode_percent = ceil(($now-$ghost_mode_start)/($ghost_mode_end-$ghost_mode_start)*100);
if($user->is_incognito == 1) {
$ghost_mode_time = date('d \d\a\y\s \l\e\f\t',$user->ghost_mode_end-$ghost_mode_start);
}

$verified_badge_start = $user->verified_badge_start;
$verified_badge_end = $user->verified_badge_expiration;
$verified_badge_percent = ceil(($now-$verified_badge_start)/($verified_badge_end-$verified_badge_start)*100);
if($user->is_verified == 1) {
$verified_badge_time = date('d \d\a\y\s \l\e\f\t',$user->$verified_badge_end-$verified_badge_start);
}

$spotlight_start = $user->spotlight_start;
$spotlight_end = $user->spotlight_expiration;
$spotlight_percent = ceil(($now-$spotlight_start)/($spotlight_end-$spotlight_start)*100);
if($user->is_increased_exposure == 1) {
$spotlight_time = date('d \d\a\y\s \l\e\f\t',$user->$spotlight_end-$spotlight_start);
}

$disable_ads_start = $user->disable_ads_start;
$disable_ads_end = $user->disable_ads_expiration;
$disable_ads_percent = ceil(($now-$disable_ads_start)/($disable_ads_end-$disable_ads_start)*100);
if($user->has_disabled_ads == 1) {
$disable_ads_time = date('d \d\a\y\s \l\e\f\t',$user->$disable_ads_end-$disable_ads_start);
}

require('inc/top.php');
require('layout/upgrades.php');
require('inc/bottom.php');