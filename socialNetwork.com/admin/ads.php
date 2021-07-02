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

$menu['ads'] = 'active';
$page['name'] = 'Ads';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$ads = $db->query("SELECT * FROM ads ORDER BY id DESC LIMIT 1");
$ads = $ads->fetch_object();

if(isset($_POST['save'])) {
	$ad_1 = $_POST['ad_1'];
	$ad_2 = $_POST['ad_2'];
	$db->query("UPDATE ads SET ad_1='".$ad_1."',ad_2='".$ad_2."'");
	header('Location: ads.php');
	exit;
}

require('../inc/admin/top.php');
require('../layout/admin/ads.php');
require('../inc/admin/bottom.php');