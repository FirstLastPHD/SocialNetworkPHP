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

$id = $db->real_escape_string($_GET['id']);
$receiver = $db->real_escape_string($_GET['receiver']);
$convers = $db->query("SELECT * FROM conversations WHERE id='".$id."'");

$convers = $convers->fetch_array();
$messages = $db->query("SELECT * FROM messages WHERE convers_id='".$id."' ORDER BY id ASC"); 
echo '<div class="conversation-content">';
if($messages->num_rows >= 1) {
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
} 
