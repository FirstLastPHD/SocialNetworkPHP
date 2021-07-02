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
$page['name'] = 'Edit Page';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$id = $_GET['id'];
$_page = $db->query("SELECT * FROM pages WHERE id='".$id."'");
$_page = $_page->fetch_object();

if(isset($_POST['save'])) {
	$page_title = $_POST['page_title'];
	$content = $db->real_escape_string($_POST['content']);
	$db->query("UPDATE pages SET page_title='".$page_title."',content='".$content."' WHERE id='".$id."'");
	header("Location: pages.php");
	exit;
}

require('../inc/admin/top.php');
require('../layout/admin/edit-page.php');
require('../inc/admin/bottom.php');