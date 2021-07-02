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
$page['name'] = 'Process Payment';

if(!$auth->isLogged()) {
	header('Location: index.php');
	exit;
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

// Get Transaction
$token = $_GET['t'];
$transaction = $db->query("SELECT * FROM transactions WHERE token='".$token."'");
if($transaction->num_rows >= 1) {
	$transaction = $transaction->fetch_object();
	if($transaction->status == 1) {
		header('Location: '.$system->getDomain().'/upgrades.php');
	} 
} else {
	header('Location: '.$system->getDomain().'/upgrades.php');
}

$_SESSION['tid'] = $transaction->token;

if($transaction->method == 1) {
	$page['js'] .= '<script src="//fortumo.com/javascripts/fortumopay.js" type="text/javascript"></script>';
} 

require('inc/top.php');
require('layout/process.php');
require('inc/bottom.php');