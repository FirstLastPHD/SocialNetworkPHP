<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
require('core/emojione/lib/php/autoload.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['messages'] = 'active';
$page['name'] = 'Messages';

if(!$auth->isLogged()) {
	header('Location: index.php');
	exit;
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$conversations = $db->query("SELECT * FROM conversations WHERE (user1='".$user->id."' OR user2='".$user->id."') AND last_activity != '' ORDER BY last_activity DESC");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$last_convers = $db->query("SELECT id,user1,user2 FROM conversations WHERE (user1='".$user->id."' OR user2='".$user->id."') AND last_activity != '' ORDER BY last_activity DESC LIMIT 1");
	if($last_convers->num_rows >= 1) {
		$last_convers = $last_convers->fetch_object();
		if($last_convers->user1 == $user->id) {
			$id = $last_convers->user2;
		} else {
			$id = $last_convers->user1;
		}
	} 
}

if($user->credits >= 50) {
	$send_gift = '';
} else {
	$send_gift = 'disabled';
}

$second_user = $system->getUserInfo($id);
$user1 = $user->id;
$user2 = $second_user->id;

// Fetch messages & sticker packs
$convers = $db->query("SELECT id FROM conversations WHERE (user1='".$user1."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user1."')");

if($convers->num_rows < 1) {
	$db->query("INSERT INTO conversations (user1,user2,time) VALUES ('".$user1."','".$user2."','".time()."')");
	$convers_id = $db->insert_id;
} else {
	$convers = $convers->fetch_array();
	$convers_id = $convers['id'];
}

$messages = $db->query("SELECT * FROM messages WHERE convers_id='".$convers_id."' AND (sender_id = '".$user1."' OR sender_id='".$user2."') ORDER BY id ASC");
$owned_sticker_packs = $db->query("SELECT * FROM owned_sticker_packs WHERE user_id='".$user->id."'");
$sticker_packs = $db->query("SELECT * FROM sticker_packs ORDER BY id DESC");

// Mark conversation as read
$db->query("UPDATE conversations SET is_read='1' WHERE id='".$convers_id."' LIMIT 1");

// Check block status
if($system->hasBlocked($user->id,$second_user->id)) {
	$blocked_msg = $lang['Has_Blocked'];
	$has_blocked = true;
} elseif($system->beenBlocked($user->id,$second_user->id)) {
	$blocked_msg = $lang['Been_Blocked'];
	$been_blocked = true;
}

if(!isset($blocked_msg)) {
	$page['js'] = '
	<script>
	function refreshChat() {
		var id = "'.$convers_id.'";
		var receiver = "'.$system->getFirstName($second_user->full_name).'";
		$.get("'.$system->getDomain().'/ajax/refreshChat.php?id="+id+"&receiver="+receiver, function(data) {
			$(".conversation-content").html(data);
		});
		$(".conversation-message-list").getNiceScroll(0).doScrollTop($(".conversation-content").height(),-1); 
		}
		window.setInterval(function(){
			refreshChat();
		}, 9999999);

		function sendMessage() {
			var user2 = "'.$user2.'";
			var message = $("#message");
			if(message.val() != "" && message.val() != " ") {
				$.get("'.$system->getDomain().'/ajax/sendMessage.php?id="+user2+"&msg="+encodeURIComponent(message.val()), function(data) {
					$(".conversation-content").html(data);
					message.val("");
				});
		}
		}
		$(document).keypress(function(e) {
			if(e.which == 13) {
				sendMessage();
			}
		});
	</script>
';
}		

// Delete Conversation
if(isset($_GET['delete'])) {
	$db->query("DELETE FROM conversations WHERE id='".$convers_id."'");
	header('Location: '.$system->getDomain().'/messages.php');
	exit;
}

// Unblock User
if(isset($_GET['unblock_user'])) {
	if(isset($has_blocked)) {
		$db->query("DELETE FROM blocked_users WHERE user1='".$user->id."'");
	}  
	header('Location: '.$system->getDomain().'/messages.php?id='.$second_user->id);
	exit;
}

// Block User
if(isset($_POST['block_user'])) {
	$db->query("INSERT INTO blocked_users (user1,user2,time) VALUES ('".$user1."','".$user2."','".time()."')");
	header('Location: '.$system->getDomain().'/messages.php?id='.$second_user->id);
	exit;
}

// Send Gift
if(isset($_POST['send_gift'])) { 
	$gift = $_POST['giftValue'];
	if(!empty($gift) && $user->credits >= 50) {
		$gift_path = $gift.'.png';
		$db->query("INSERT INTO gifts (user1,user2,path,time) VALUES ('".$user->id."','".$id."','".$gift_path."','".time()."')");
		$db->query("UPDATE users SET credits=credits-50 WHERE id='".$user->id."'");
		header('Location: '.$system->getDomain().'/messages.php?id='.$id);
		exit;
	}
}

// Send Photo
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
					$db->query("INSERT INTO messages (convers_id,sender_id,message,is_photo,photo_path,time) VALUES ('".$convers_id."','".$user->id."','','1','".$new_file_name."','".time()."')");
					$db->query("UPDATE conversations SET last_activity='".time()."',last_message='Sent a photo' WHERE id='".$convers_id."'");
				}
			}
			else {
				$error = 'Error occured:  '.$_FILES['photo_file']['error'];
			}
		}	
	}
	header('Location: '.$system->getDomain().'/messages.php?id='.$second_user->id);
	exit;
}

require('inc/top.php');
require('layout/messages.php');
require('inc/bottom.php');