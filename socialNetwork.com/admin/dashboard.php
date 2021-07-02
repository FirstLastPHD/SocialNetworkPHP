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

$menu['dashboard'] = 'active';
$page['name'] = 'Dashboard';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$user_count = $db->query("SELECT id FROM users");
$user_count = $user_count->num_rows;

$purchase_count = $db->query("SELECT id FROM transactions WHERE status='Completed'");
$purchase_count = $purchase_count->num_rows;

require('../inc/admin/top.php');
require('../layout/admin/dashboard.php');
require('../inc/admin/bottom.php');