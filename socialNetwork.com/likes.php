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

$menu['likes'] = 'active';
$page['name'] = 'Profile Likes';

if(!$auth->isLogged()) {
	header('Location: index.php');
	exit;
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$profile_likes = $db->query("SELECT * FROM profile_likes WHERE profile_id='".$user->id."' AND viewer_id != '".$user->id."' ORDER BY id DESC LIMIT 20");

// Photo Upload Prompt Modal
$chance = rand(0,2);
if($chance == 2 && $user->updated_preferences == 1 && $user->uploaded_photos < 1) {
	$page['js'] = '
	<script>
	setTimeout(function () {

		swal({ 
			title: "'.$lang['Upload_Photo_Window_Title'].'",
			text: "'.$lang['Upload_Photo_Window_Text'].'",
			imageUrl: "'.$system->getDomain().'/img/icons/upload-photo.png",
			showCancelButton: true,
			cancelButtonText: "'.$lang['Upload_Photo_Window_Cancel'].'",
			confirmButtonColor: "#e74c3c",
			confirmButtonText: "'.$lang['Upload'].'",
			closeOnConfirm: false,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
			window.location.href = "'.$system->getDomain().'/profile.php?id='.$user->id.'/photo_upload";
			} else {
			$.get("'.$system->getDomain().'/ajax/disableUploadPhotoPrompt.php");
			}
		});

}, 1000);
</script>
';
}

require('inc/top.php');
require('layout/likes.php');
require('inc/bottom.php');