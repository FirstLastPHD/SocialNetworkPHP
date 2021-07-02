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

$notifications = $db->query("SELECT * FROM notifications WHERE receiver_id='".$id."' AND is_screen='0'");
$result = array();

while($notification = $notifications->fetch_object()) {
	
	if($notification->icon == 'fa fa-thumbs-up') {
		$result[] = array('id' => $notification->id, 'title' => 'New Profile Like', 'text' => strip_tags($notification->content), 'image' => $system->getDomain().'/img/icons/like-profile-notif.png', 'type' => 'like');
	} elseif($notification->icon == 'fa fa-user-plus') {
		$result[] = array('id' => $notification->id, 'title' => 'New Friend Request', 'text' => strip_tags($notification->content), 'image' => $system->getDomain().'/img/icons/add-friend-notif.png', 'type' => 'friend_request');
	} elseif($notification->icon == 'fa fa-comment') {
		$result[] = array('id' => $notification->id, 'title' => 'New Message', 'text' => strip_tags($notification->content), 'image' => $system->getDomain().'/img/icons/new-message-notif.png', 'type' => 'message');
	} elseif($notification->icon == 'fa fa-globe') {
		$result[] = array('id' => $notification->id, 'title' => 'New Notification', 'text' => strip_tags($notification->content), 'image' => $system->getDomain().'/img/icons/new-mass-notification.png', 'type' => 'mass');
	}

}

echo json_encode($result,JSON_PRETTY_PRINT);