<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
require('../core/emojione/lib/php/autoload.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);

$user1 = $user->id;
$user2 = $db->real_escape_string($_GET['id']);
$message = $db->real_escape_string($_GET['msg']);

// Record message
$check = $db->query("SELECT id FROM conversations WHERE (user1='".$user1."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user1."')");
if($check->num_rows == 1) {
	$convers = $check->fetch_array();
	$db->query("INSERT INTO messages (convers_id,message,sender_id,time) VALUES ('".$convers['id']."','".$message."','".$user1."','".time()."')");
	$convers_id = $convers['id'];

} else {
	$db->query("INSERT INTO conversations (user1,user2,time) VALUES ('".$user1."','".$user2."','".time()."')");
	$convers_id = $db->insert_id;
	$db->query("INSERT INTO messages (convers_id,message,sender_id,time) VALUES ('".$convers_id."','".$message."','".$user1."','".time()."')");
}

// Update activity
$db->query("UPDATE conversations SET last_activity='".time()."',last_message='".$message."' WHERE id='".$convers_id."'");
$db->query("UPDATE users SET last_active='".time()."' WHERE id='".$user->id."'");

// Get messages
$messages = $db->query("SELECT * FROM messages WHERE convers_id='".$convers_id."' AND (sender_id = '".$user1."' OR sender_id='".$user2."') ORDER BY id ASC");
$db->query("INSERT INTO notifications (receiver_id,url,content,icon,time) VALUES ('".$user2."','messages.php?id=".$user1."','<b>".$system->getFirstName($user->full_name)."</b> messaged you','fa fa-comment', '".time()."')");

echo '<div class="conversation-content">';
while($message = $messages->fetch_object()) {
	$sender = $db->query("SELECT id,profile_picture,full_name FROM users WHERE id='".$message->sender_id."'");
	$sender = $sender->fetch_object();
	?>
	<div class="row">
		<div class="conversation-message pull-left">
			<div class="pull-left">
				<img src="<?=$system->getProfilePicture($sender)?>" class="img-circle pull-left" style="height:50px;width:50px;">
			</div>
			<div class="well bg-grey pull-left emoticon-small">
				<?php
				if($message->is_sticker == 1) {
					$sticker = $db->query("SELECT * FROM stickers WHERE id='".$message->sticker_id."'");
					$sticker = $sticker->fetch_object();
					echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" style="height:80px;width:80px">';
				} elseif($message->is_photo == 1) {
					echo '
					<a href="#">
					<img fbphotobox-src="'.$system->getDomain().'/uploads/'.$message->photo_path.'" src="'.$system->getDomain().'/uploads/'.$message->photo_path.'" class="img-responsive photo" style="max-height250px;max-width:250px;">
					</a>
					';
				} else {
					$message->message = $system->secureField($system->smart_wordwrap($message->message));
					echo Emojione\Emojione::shortnameToImage($message->message);
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
echo '</div>';
