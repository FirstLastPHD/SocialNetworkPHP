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

$id = $_SESSION['user_id'];

$unread = $db->query("SELECT * FROM notifications WHERE receiver_id='".$id."' AND is_read='0'");
$unread = $unread->num_rows;

echo $unread;