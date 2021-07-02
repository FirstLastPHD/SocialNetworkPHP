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

$menu['mass_notification'] = 'active';
$page['name'] = 'Mass Notification';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['create'])) {
	$content = $_POST['notification_content'];
	$users = $db->query("SELECT id FROM users");
	while($_user = $users->fetch_object()) {
		$db->query("INSERT INTO notifications (receiver_id,url,content,icon,time,is_read) VALUES ('".$_user->id."','#','".$content."','fa fa-globe', '".time()."', '0')");
		$success = true;
	}
}

require('../inc/admin/top.php');
require('../layout/admin/mass_notification.php');
require('../inc/admin/bottom.php');