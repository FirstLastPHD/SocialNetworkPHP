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

$menu['pages'] = 'active';
$page['name'] = 'Add Page';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['add'])) {
	$page_title = $_POST['page_title'];
	$content = $db->real_escape_string(nl2br($_POST['content']));
	$db->query("INSERT INTO pages(page_title,content) VALUES ('".$page_title."','".$content."')");
	header('Location: pages.php');
	exit;
}

require('../inc/admin/top.php');
require('../layout/admin/add-page.php');
require('../inc/admin/bottom.php');