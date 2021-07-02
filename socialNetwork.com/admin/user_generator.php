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

$menu['user_generator'] = 'active';
$page['name'] = 'User Generator';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['generate'])) {
	
	$first_male = array('Stephen','Joe','Mustafa','Martin','Ali','Steve','Hakan','Juan', 'Edward', 'Luiz', 'Anis','James','Mark','Brandon','Campos','Jordan','Alexander','Mateus','Breno');
	$last_male = array('Ali','Muhammad','Jones','Bektas','Johnson', 'Allen','Cavalcanti','Gomez','Khoury','Ray','Bohon','Rasmussen','Friedman','Achen','Hoffmann','Schweizer','Bohm');

	$first_female = array('Giovanna','Larissa','Yasmeen','Salwa','Sarah','Jane','Mia','Lena','Sara','Gabriele','Cordelia','Miranda','Olivie','Annette','Zuhur','Zehra','Haifa');
	$last_female = array('Santos','Castro','Haik','Antar','Hallen','Leslie','Adler','Konig','Lorenzo','Rizzo','Savard','Chabot','Saliba','Amari','Reno','Rhodes');

	$country = $_POST['country'];
	$gender = $_POST['gender'];
	$sexual_orientation = $_POST['sexual_orientation'];

	if($gender == 'female') {
		for($i = 1; $i <= 16; $i++) {
			$full_name = $first_female[array_rand($first_female)].' '.$last_female[array_rand($last_female)];
			$time = time();
			$profile_picture = $domain.'/img/ug/female/'.$i.'.png';
			$age = mt_rand(20,35);
			$email = 'fake@fake.com';
			$gender = 'Female';
			$city = '';
			$db->query("INSERT INTO users(profile_picture,full_name,email,password,registered,country,city,credits,age,gender,ip,last_active,sexual_interest) VALUES ('$profile_picture','$full_name','$email','".$auth->hashPassword('123456')."','".time()."','$country','$city','10','$age','$gender','','".time()."','$sexual_orientation')");
		}
	}
	if($gender == 'male') {
		for($i = 1; $i <= 16; $i++) {
			$full_name = $first_male[array_rand($first_male)].' '.$last_male[array_rand($last_male)];
			$time = time();
			$profile_picture = $system->getDomain().'/img/ug/male/'.$i.'.png';
			$age = mt_rand(20,35);
			$email = 'fake@fake.com';
			$gender = 'Male';
			$city = '';
			$db->query("INSERT INTO users(profile_picture,full_name,email,password,registered,country,city,credits,age,gender,ip,last_active,sexual_interest) VALUES ('$profile_picture','$full_name','$email','".$auth->hashPassword('123456')."','".time()."','$country','$city','10','$age','$gender','','".time()."','$sexual_orientation')");
		}
	}
	if($gender == 'all') {
		for($i = 1; $i <= 16; $i++) {
			$full_name = $first_female[array_rand($first_female)].' '.$last_female[array_rand($last_female)];
			$time = time();
			$profile_picture = $system->getDomain().'/img/ug/female/'.$i.'.png';
			$age = mt_rand(20,35);
			$email = 'fake@fake.com';
			$gender = 'Female';
			$city = '';
			$db->query("INSERT INTO users(profile_picture,full_name,email,password,registered,country,city,credits,age,gender,ip,last_active,sexual_interest) VALUES ('$profile_picture','$full_name','$email','".$auth->hashPassword('123456')."','".time()."','$country','$city','10','$age','$gender','','".time()."','$sexual_orientation')");
		}
		for($i = 1; $i <= 16; $i++) {
			$full_name = $first_male[array_rand($first_male)].' '.$last_male[array_rand($last_male)];
			$time = time();
			$profile_picture = $system->getDomain().'/img/ug/male/'.$i.'.png';
			$age = mt_rand(20,35);
			$email = 'fake@fake.com';
			$gender = 'Male';
			$city = '';
			$db->query("INSERT INTO users(profile_picture,full_name,email,password,registered,country,city,credits,age,gender,ip,last_active,sexual_interest) VALUES ('$profile_picture','$full_name','$email','".$auth->hashPassword('123456')."','".time()."','$country','$city','10','$age','$gender','','".time()."','$sexual_orientation')");
		}
	}

	$success = true;

}
require('../inc/admin/top.php');
require('../layout/admin/user_generator.php');
require('../inc/admin/bottom.php');