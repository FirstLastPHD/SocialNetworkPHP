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

$menu['users'] = 'active';
$page['name'] = 'Edit User';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$id = $_GET['id'];

$_user = $db->query("SELECT * FROM users WHERE id='".$id."'");
$_user = $_user->fetch_object();

if(isset($_POST['save'])) {

	$email = $_POST['email'];
	$full_name = $_POST['full_name'];
	$bio = $_POST['bio'];
	$password = $_POST['password'];
	$credits = $_POST['credits'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];

	switch ($_POST['is_admin']) {
		case 'true':
		$is_admin = 1;
		break;
		case 'false':
		$is_admin = 0;
		break;
		default:
		$is_admin = 0;
		break;
	}

	if(empty($password)) {
		$password = $user->password;
	} else {
		$password = $auth->hashPassword($password);	
	}	

	$db->query("
		UPDATE users SET 
		email='".$email."',
		full_name='".$full_name."',
		bio='".$bio."',
		password='".$password."',
		gender='".$gender."',
		credits='".$credits."',
		country='".$country."',
		city='".$city."',
		age='".$age."',
		is_admin='".$is_admin."'
		WHERE id='".$id."'"
		);

	header('Location: users.php?success');
	exit;

}

require('../inc/admin/top.php');
require('../layout/admin/edit-user.php');
require('../inc/admin/bottom.php');