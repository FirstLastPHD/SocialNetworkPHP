<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['settings'] = 'active';
$page['name'] = 'Settings';

if(!$auth->isLogged()) {
	header('Location: index.php');
	exit;
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$payments = $db->query("SELECT * FROM transactions WHERE user_id='".$user->id."' AND status='1' LIMIT 5");

if(isset($_POST['save'])) {

	$full_name = $system->secureField($_POST['full_name']);
	$email = $system->secureField($_POST['email']);
	$gender = $system->secureField($_POST['gender']);
	$country = $system->secureField($_POST['country']);
	$city = $system->secureField($_POST['city']);
	$age = $system->secureField($_POST['age']);
	$height = $system->secureField($_POST['height']);
	$weight = $system->secureField($_POST['weight']);
	$bio = $system->secureField($db->real_escape_string($_POST['bio']));
	$sexual_orientation = $system->secureField($_POST['sexual_orientation']);
	$interests = $system->secureField($_POST['interests']);
	$new_password = $system->secureField($_POST['new_password']);
	$confirm_new_password = $system->secureField($_POST['confirm_new_password']);
	$website_language = $system->secureField($_POST['website_language']);
	$instagram_username = $system->secureField($_POST['instagram_username']);

	$db->query("
		UPDATE users SET 
		full_name='".$full_name."',
		email='".$email."',
		gender='".$gender."',
		country='".$country."',
		city='".$city."',
		age='".$age."',
		bio='".$bio."',
		sexual_interest='".$sexual_orientation."',
		interests='".$interests."',
		language='".$website_language."',
		instagram_username='".$instagram_username."',
		updated_preferences='1',
		height='".$height."',
		weight='".$weight."'
		WHERE id='".$user->id."'");

	if(!empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) { 
		
	if($new_password === $confirm_new_password) {
		$new_password = $auth->hashPassword($new_password);

		$db->query("
			UPDATE users SET 
			password='".$new_password."'
			WHERE id='".$user->id."'");
	}

	}

	$_SESSION['language'] = $website_language;
	
	header('Location: settings.php');
	exit;

}

require('inc/top.php');
require('layout/settings.php');
require('inc/bottom.php');