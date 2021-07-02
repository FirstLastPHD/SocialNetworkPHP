<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/geo.php');
require('core/system.php');
require('core/dom.php');
require('core/instagram.php');
require('core/image.php');
$auth = new Auth;
$geo = new Geo;
$system = new System;
$instagram = new Instagram;

$system->domain = $domain;
$system->db = $db;

$menu['people'] = 'active';

if(!$auth->isLogged()) {
	header('Location: ../index.php');
	exit;
}

$id = $_GET['id'];

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);
$profile = $system->getUserInfo($id);

if($user->credits >= 50) {
	$send_gift = '';
} else {
	$send_gift = 'disabled';
}

if(isset($_GET['photo_upload'])) {
	if($user->id == $profile->id) {
		$page['js'] .= '
		<script>
		$("#photo-upload").modal("toggle");
		</script>
		';
	}
}

// Get dynamic profile content
$media = $db->query("SELECT * FROM uploaded_photos WHERE user_id='".$profile->id."' LIMIT 20");
$friends = $db->query("SELECT * FROM friend_requests WHERE accepted='1' AND (user1='".$id."' OR user2='".$id."') ORDER BY id DESC");
$gifts = $db->query("SELECT * FROM gifts WHERE user2='".$profile->id."'");

// Get profile stats
$profile_views = $db->query("SELECT id FROM profile_views WHERE profile_id='".$profile->id."'");
$profile_likes = $db->query("SELECT id FROM profile_likes WHERE profile_id='".$profile->id."'");

// Check Friend Status
$check = $db->query("SELECT id,user1 FROM friend_requests WHERE ((user1='".$user->id."' AND user2='".$profile->id."') OR (user1='".$profile->id."' AND user2='".$user->id."')) AND accepted='0' LIMIT 1");
if($check->num_rows == 0) {
	$sent_request = 0;
} else {
	$sent_request = 1;
}
$check = $check->fetch_object();
if($check->user1 == $user->id) {
	$is_sender = 1;
} else {
	$is_sender = 0;
}
$check = $db->query("SELECT id FROM friend_requests WHERE ((user1='".$user->id."' AND user2='".$profile->id."') OR (user1='".$profile->id."' AND user2='".$user->id."')) AND accepted='1' LIMIT 1");
if($check->num_rows == 0) {
	$is_friend = 0;
} else {
	$is_friend = 1;
}

$photos = array();

// Fetch photos
if($media->num_rows == 0) { 
	$uploaded_photos = 0;
} else {
	$uploaded_photos = array();
	while($photo = $media->fetch_object()) {
		$photos[] = array('type'=>'uploaded','id' => $photo->id, 'path' => $photo->path);
	}
} 

$instagram_photos = $instagram->getPhotos($profile->instagram_username);
if(!empty($profile->instagram_username) && count($instagram_photos) >= 1) {
	foreach($instagram_photos as $instagram_photo) {
		$photos[] =  array('type'=>'instagram','path'=>$instagram_photo);
	}
} 

// Photo Upload
if(isset($_POST['upload']) && !empty($_FILES)) {
	if($_FILES['photo_file']['name']) {
		$extension = strtolower(end(explode('.', $_FILES['photo_file']['name'])));
		if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
			if(!$_FILES['photo_file']['error']) {
				$new_file_name = md5(mt_rand()).$_FILES['photo_file']['name'];
				if($_FILES['photo_file']['size'] > (1024000)) {
					$valid_file = false;
					$error = 'Oops! One of the photos you uploaded is too large';
				} else {
					$valid_file = true;
				}
				if($valid_file) {
					move_uploaded_file($_FILES['photo_file']['tmp_name'], 'uploads/'.$new_file_name);
					$uploaded = true;
					$db->query("INSERT INTO uploaded_photos (user_id,path,time) VALUES ('".$user->id."','".$new_file_name."','".time()."')");
					$db->query("UPDATE users SET uploaded_photos=uploaded_photos+1 WHERE id='".$user->id."'");
				}
			}
			else {
				$error = 'Error occured:  '.$_FILES['photo_file']['error'];
			}
		}	
	}
	header('Location: '.$system->getDomain().'/profile.php?id='.$user->id);
	exit;
}

// Send Gift
if(isset($_POST['send_gift'])) { 
	$gift = $_POST['giftValue'];
	if(!empty($gift) && $user->credits >= 50) {
		$gift_path = $gift.'.png';
		$db->query("INSERT INTO gifts (user1,user2,path,time) VALUES ('".$user->id."','".$profile->id."','".$gift_path."','".time()."')");
		$db->query("UPDATE users SET credits=credits-50 WHERE id='".$user->id."'");
		header('Location: '.$system->getDomain().'/profile.php?id='.$profile->id);
		exit;
	}
}

// Record Profile View
if($user->is_incognito == 0 || $user->vip_expiration >= time()) {
	$check = $db->query("SELECT id FROM profile_views WHERE
		viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1");
	if($check->num_rows == 0) {
		$db->query("INSERT INTO profile_views (profile_id,viewer_id,time) VALUES ('".$profile->id."','".$user->id."','".time()."')");
	}
}

// Sexual Orientation
switch ($profile->sexual_interest) {
	case 1:
	$sexual_orientation = 'Straight';
	break;
	case 2: 
	$sexual_orientation = 'Gay';
	break;
	case 3:
	$sexual_orientation = 'Lesbian';
	break;
	case 4: 
	$sexual_orientation = 'Bisexual';
	break;
	default:
	$sexual_orientation = 'Straight';
	break;
}

// Private Profile
if($profile->private_profile == 1) {
if($user->id != $profile->id) {
	$private_profile = true;
} else {
	$private_profile = false;
}
} else {
	$private_profile = false;
}

// Calculate distance
if($user->country == $profile->country) {
	$distance = $geo->coordsToKm($user->latitude,$user->longitude,$profile->latitude,$profile->longitude);
} 

// Get Ads
$ads = $db->query("SELECT * FROM ads ORDER BY id DESC LIMIT 1");
$ads = $ads->fetch_object();

$page['name'] = $profile->full_name;

require('inc/top.php');
require('layout/profile.php');
require('inc/bottom.php');