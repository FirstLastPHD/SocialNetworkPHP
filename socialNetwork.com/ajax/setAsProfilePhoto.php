<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

if(isset($_GET['photo_id'])) {
	$id = $db->real_escape_string($_GET['photo_id']);
	$photo = $db->query("SELECT * FROM uploaded_photos WHERE id='".$id."'");
	$photo = $photo->fetch_object();
	$db->query("UPDATE users SET profile_picture='".$photo->path."' WHERE id='".$_SESSION['user_id']."'");
} else {
	$url = $db->real_escape_string($_GET['photo_url']);
	$db->query("UPDATE users SET profile_picture='".$url."' WHERE id='".$_SESSION['user_id']."'");	
}