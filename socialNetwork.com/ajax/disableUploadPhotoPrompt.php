<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
require('../core/emojione/lib/php/autoload.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);

$db->query("UPDATE users SET uploaded_photos='1' WHERE id='".$user->id."'");