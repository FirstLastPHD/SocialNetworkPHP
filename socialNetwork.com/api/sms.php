<?php
require('../core/config.php');

if(isset($_GET['status'])) {

$user = $_GET['cuid'];
$credits = $_GET['amount'];

$db->query("UPDATE users SET credits=credits+".$credits." WHERE id='".$user."'");

}