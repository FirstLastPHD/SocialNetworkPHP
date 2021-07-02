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

$notifications = $db->query("SELECT * FROM notifications WHERE receiver_id='".$id."' ORDER BY is_read ASC, id DESC LIMIT 5");

if($notifications->num_rows >= 1) {
while($notification = $notifications->fetch_object()) {
$db->query("UPDATE notifications SET is_read='1' WHERE id='".$notification->id."'");
?>
<a href="<?php if($notification->url != '#') { echo $system->getDomain().'/'.$notification->url; } else { echo '#'; } ?>" class="media">
<div class="media-object pull-left"><i class="<?=$notification->icon?> fg-success" style="font-size:26px;"></i></div>
<div class="media-body">
<span class="media-text"><?=$notification->content?></span>
<span class="media-meta"><?=$system->timeAgo($lang,$notification->time)?></span>
</div>
</a>
<?php
}
} else {
echo '<p style="text-align:center;font-size:13px;padding-top:50px">No new notifications</p>';	
}
