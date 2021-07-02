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

$menu['plugins'] = 'active';
$page['name'] = 'Plugins';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$plugins = scandir('../plugins');
$plugin_list = array();
foreach($plugins as $plugin) {
	if(file_exists('../plugins'.'/'.$plugin.'/'.'info.ini')) {
		$info = parse_ini_file('../plugins'.'/'.$plugin.'/'.'info.ini');
		if(file_exists('../plugins'.'/'.$plugin.'/'.'status.lock')) { $status = 1; } else { $status = 0; }
		if(file_exists('../plugins'.'/'.$plugin.'/'.'info.ini')) { $config = 1; } else { $config = 0; }
		$plugin_list[] = array('name' => $info['name'],'author' => $info['author'], 'version' => $info['version'], 'path' => $plugin, 'status' => $status, 'config' => $config);
	}
}

if(isset($_GET['activate'])) {
	$path = $_GET['path'];
	fopen('../plugins'.'/'.$path.'/'.'status.lock','w+');
	$db->query("DELETE FROM plugins WHERE path='".$path."'");
	$install = file_get_contents('../plugins'.'/'.$path.'/'.'install.php');
	$db->query(trim($install));
	header('Location: plugins.php');
	exit;
}

if(isset($_GET['deactivate'])) {
	$path = $_GET['path'];
	unlink('../plugins'.'/'.$path.'/'.'status.lock');
	$uninstall = file_get_contents('../plugins'.'/'.$path.'/'.'uninstall.php');
	$db->query(trim($uninstall));
	header('Location: plugins.php');
	exit;
}

require('../inc/admin/top.php');
require('../layout/admin/plugins.php');
require('../inc/admin/bottom.php');