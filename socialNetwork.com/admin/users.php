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

$menu['users'] = 'active';
$page['name'] = 'Users';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(!isset($_POST['search'])) {
	$query = '';
	$users = $db->query("SELECT * FROM users ORDER BY id DESC");
} else {
	$query = ucfirst(strtolower($system->secureField($_POST['query'])));
	$users = $db->query("SELECT * FROM users WHERE full_name LIKE '%".$query."%' ORDER BY id DESC");	
}

if(isset($_GET['delete']) && isset($_GET['delid'])) {
	$delid = $_GET['delid'];
	$db->query("DELETE FROM users WHERE id='".$delid."'");
	$db->query("DELETE FROM profile_likes WHERE profile_id='".$delid."'");
	$db->query("DELETE FROM profile_views WHERE profile_id='".$delid."'");
	$db->query("DELETE FROM conversations WHERE user1='".$delid."' OR user2='".$delid."'");
	$db->query("DELETE FROM friend_requests WHERE user1='".$delid."' OR user2='".$delid."'");
	header('Location: users.php');
	exit;
}

if(isset($_GET['quick_actions'])) {
	$action = $_GET['action'];
	if($action == 1) {
		$db->query("DELETE FROM users WHERE email='fake@fake.com'");
	} elseif($action == 2) {
		$db->query("UPDATE users SET last_active='".time()."'");
	} elseif($action == 3) {
		$db->query("UPDATE users SET last_active='".time()."' WHERE email='fake@fake.com'");
	} elseif($action == 4) {
		$db->query("DELETE FROM users WHERE profile_picture='default_avatar.png'");
	}	header('Location: users.php');
	exit;
}

require('../inc/admin/top.php');
require('../layout/admin/users.php');
require('../inc/admin/bottom.php');