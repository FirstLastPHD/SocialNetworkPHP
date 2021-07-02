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

$url = $db->real_escape_string($_GET['url']);
$profile_id = $_GET['profile_id'];

$comments = $db->query("SELECT * FROM instagram_photo_comments WHERE photo_url='".$url."' ORDER BY id DESC");

echo '<div class="list-group fbphotobox-image-content-comments" style="padding-left:10px;">';

while($comment = $comments->fetch_object()) { 
	$commenter = $db->query("SELECT id,profile_picture,full_name FROM users WHERE id='".$comment->commenter_id."'");
	$commenter = $commenter->fetch_object();
	echo '
	<a class="photo-comment list-group-item" style="background:none;">
	<a href="'.$system->getDomain().'/profile.php?id='.$commenter->id.'">
	<img src="'.$system->getProfilePicture($commenter).'" class="img-circle pull-left mr-10 thumb50">
	</a>
	<h4 class="photo-comment-poster list-group-item-heading text-special">'.$commenter->full_name.'</h4>
	<p class="emoticon list-group-item-text">
	'.$comment->comment.'
	</p>
	</a>
	';
}

echo '</div>';
