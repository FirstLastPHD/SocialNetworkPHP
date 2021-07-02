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
$conversation_id = $db->real_escape_string($_GET['conversation_id']);

$stickers = $db->query("SELECT * FROM stickers WHERE pack_id='".$pack_id."' ORDER BY id ASC");
$pack = $db->query("SELECT name FROM sticker_packs WHERE id='".$pack_id."'");
$pack = $pack->fetch_object();
while($sticker = $stickers->fetch_object()) {
	echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" onclick="sendSticker('.$sticker->id.','.$conversation_id.')" class="sticker">';
}