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

$pack_id = $db->real_escape_string($_GET['pack_id']);
$receiver_id = $db->real_escape_string($_GET['receiver_id']);

$check = $db->query("SELECT * FROM owned_sticker_packs WHERE pack_id='".$pack_id."' AND user_id='".$receiver_id."'");

if($check->num_rows >= 1) {
	$db->query("DELETE FROM owned_sticker_packs WHERE pack_id='".$pack_id."' AND user_id='".$receiver_id."'");
	echo '<a href="#" class="btn btn-theme btn-xs btn-block" onclick="addStickerPack('.$pack_id.','.$receiver_id.')"> '.$lang['Add'].' </a>';
} else {
	$db->query("INSERT INTO owned_sticker_packs (pack_id,user_id) VALUES ('".$pack_id."','".$receiver_id."')");
	echo '<a href="#" class="btn btn-theme btn-xs btn-block" onclick="addStickerPack('.$pack_id.','.$receiver_id.')"> '.$lang['Remove'].' </a>';
}