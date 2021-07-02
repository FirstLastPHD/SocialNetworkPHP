<?php
require('../core/config.php');
require('../core/libs/src/IpnListener.php');

use wadeshuler\paypalipn\IpnListener;
$listener = new IpnListener();

// default options
$listener->use_sandbox = false;
$listener->use_curl = true;
$listener->follow_location = false;
$listener->timeout = 30;
$listener->verify_ssl = true;

$listener->processIpn();

$info = $_POST['custom'];
if(!empty($info)) {
	$info = explode('/',$info);
	$info['item'] = $info[0];
	$info['user_id'] = $info[2];
} else {
	die('Error');
}

if(strrpos($listener->getTextReport(),'Completed')) {

	if($info['item'] === 'credits') {
	$info['credits'] = $info[1];
	$db->query('UPDATE users SET credits=credits+'.$info['credits'].' WHERE id='.$info['user_id'].'');
	} elseif($info['item'] === 'vip') {
	$info['duration'] = $info[1];
	$start = time();
	$expiration = time()+$info['duration'];
	$db->query('UPDATE users SET is_vip=1 WHERE id='.$info['user_id'].'');
	$db->query('UPDATE users SET vip_expiration='.$expiration.' WHERE id='.$info['user_id'].'');
	$db->query("UPDATE users SET ghost_mode_start=".$start." WHERE id=".$user->id."");
	$db->query('UPDATE users SET ghost_mode_expiration='.$expiration.' WHERE id='.$info['user_id'].'');
	$db->query("UPDATE users SET verified_badge_start=".$start." WHERE id=".$user->id."");
	$db->query('UPDATE users SET verified_badge_expiration='.$expiration.' WHERE id='.$info['user_id'].'');
	$db->query("UPDATE users SET spotlight_start=".$start." WHERE id=".$user->id."");
	$db->query('UPDATE users SET spotlight_expiration='.$expiration.' WHERE id='.$user->id.'');
	$db->query("UPDATE users SET disable_ads_start=".$start." WHERE id=".$user->id."");
	$db->query('UPDATE users SET disable_ads_expiration='.$expiration.' WHERE id='.$info['user_id'].'');
	}

} else {
	// do nothing
}