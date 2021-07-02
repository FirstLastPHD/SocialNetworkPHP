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

$user1 = $db->real_escape_string($_GET['user1']);
$user2 = $db->real_escape_string($_GET['user2']);
$action = $_GET['action'];

$user = $system->getUserInfo($_GET['user1']);

switch ($action) {
	case 'send_request':
	$db->query("INSERT INTO friend_requests (user1,user2,time,accepted) VALUES ('".$user1."','".$user2."','".time()."','0')");
	$db->query("INSERT INTO notifications (receiver_id,url,content,icon,time,is_read) VALUES ('".$user2."','profile.php?id=".$user1."','<b>".$system->getFirstName($user->full_name)."</b> sent you a friend request','fa fa-user-plus', '".time()."', '0')");
	echo '<a href="#" class="btn btn-theme btn-block text-center mb-5"><i class="fa fa-user-times pull-right" style="line-height:20px;"></i>Cancel Friend Request</a>';
	break;
	case 'unfriend':
	$db->query("DELETE FROM friend_requests WHERE ((user1='".$user1."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user1."'))");
	echo '<a href="#" class="btn btn-theme btn-block text-center mb-5"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i>'.$lang['Add_As_Friend'].'</a>';
	break;
	case 'accept_request':
	$db->query("UPDATE friend_requests SET accepted='1' WHERE ((user1='".$user1."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user1."'))");
	echo '<a href="#" class="btn btn-theme btn-block text-center mb-5"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i>'.$lang['Unfriend'].'</a>';
	break;
	case 'cancel_request':
	$db->query("DELETE FROM friend_requests WHERE ((user1='".$user1."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user1."'))");
	echo '<a href="#" class="btn btn-theme btn-block text-center mb-5"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i>'.$lang['Add_As_Friend'].'</a>';
	break;
	default:
		#none
	break;
}