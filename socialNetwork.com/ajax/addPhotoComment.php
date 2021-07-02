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

$id = $db->real_escape_string($_GET['photo_id']);
$comment = $db->real_escape_string($_GET['comment']);

$commenter = $_SESSION['user_id'];

$db->query("INSERT INTO uploaded_photo_comments (photo_id,commenter_id,comment) VALUES ('".$id."','".$commenter."','".$comment."')");

$comments = $db->query("SELECT * FROM uploaded_photo_comments WHERE photo_id='".$id."' ORDER BY id DESC");

while($comment = $comments->fetch_object()) { 
	$commenter = $db->query("SELECT id,profile_picture,full_name FROM users WHERE id='".$comment->commenter_id."'");
	$commenter = $commenter->fetch_object();
	?>
	<div class="list-group no-margin">
		<a class="photo-comment list-group-item" style="background:none;">
			<a href="<?=$system->getDomain()?>/profile.php?id=<?=$commenter->id?>">
				<img src="<?=$system->getProfilePicture($commenter)?>" class="img-circle pull-left mr-10 thumb50">
			</a>
			<h4 class="photo-comment-poster list-group-item-heading text-special"><?=$commenter->full_name?></h4>
			<p class="emoticon list-group-item-text">
				<?=$comment->comment?>
			</p>
		</a>
	</div>
	<? } ?>
