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

$sticker_id = $db->real_escape_string($_GET['sticker_id']);
$conversation_id = $db->real_escape_string($_GET['conversation_id']);
$sender_id = $_SESSION['user_id'];

// Update activity
$db->query("UPDATE conversations SET last_activity='".time()."',last_message='Sent a sticker' WHERE id='".$conversation_id."'");
$db->query("UPDATE users SET last_active='".time()."' WHERE id='".$sender_id."'");

// Send sticker
$db->query("INSERT INTO messages (convers_id,sender_id,message,is_sticker,sticker_id,time) VALUES ('".$conversation_id."','".$sender_id."','','1','".$sticker_id."','".time()."')");