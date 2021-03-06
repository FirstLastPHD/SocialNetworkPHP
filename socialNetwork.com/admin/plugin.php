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

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

$plugin = $db->query("SELECT * FROM plugins WHERE id='".$id."'");
$plugin = $plugin->fetch_object();

$menu[$id] = 'active';
$page['name'] = $plugin->name;

require('../inc/admin/top.php');
require('../plugins/'.$plugin->path.'/plugin.php');
require('../inc/admin/bottom.php');