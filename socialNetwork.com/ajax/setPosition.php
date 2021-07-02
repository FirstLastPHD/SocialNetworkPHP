<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/system.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

$_SESSION['longitude'] = $_GET['longitude'];
$_SESSION['latitude'] = $_GET['latitude'];