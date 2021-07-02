<?php
ini_set('display_errors', 1);
class System {

	public $domain;
	public $db;

	public function getDomain() {
		return $this->domain;
	}

	public function getProfilePicture($user) {
		
		if(filter_var($user->profile_picture,FILTER_VALIDATE_URL)) {
			return $user->profile_picture;
		} else {
			return $this->domain.'/uploads/'.$user->profile_picture;
		}
	}
	

	

	public function getUserInfo($id) {
		$user = $this->db->query("SELECT * FROM users WHERE id='".$id."'");
		$user = $user->fetch_object();
		return $user;
	}

	public function getFirstName($full_name) {
		$full_name = explode(' ',$full_name);
		return $full_name[0];
	}

	public function isOnline($last_active) {
		if(time()-$last_active <= 300) {
			return true;
		} else {
			return false;
		}
	}

	public function timeAgo($lang,$ptime) {
		$etime = time() - $ptime;
		if ($etime < 1)
		{
			return $lang['just_now'];
		}
		$a = array( 365 * 24 * 60 * 60  =>  $lang['year'],
			30 * 24 * 60 * 60  =>  $lang['month'],
			24 * 60 * 60  =>  $lang['day'],
			60 * 60  =>  $lang['hour'],
			60  =>  $lang['minute'],
			1  =>  $lang['second']
			);
		$a_plural = array( 'year'   => $lang['years'],
			'month'  => $lang['months'],
			'day'    => $lang['days'],
			'hour'   => $lang['hours'],
			'minute' => $lang['minutes'],
			'second' => $lang['seconds']
			);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str).' '.$lang['ago'];
			}
		}
	}

	public function secureField($value) {
		return htmlspecialchars(strip_tags($value));
	}

	public function smart_wordwrap($string) {
		return wordwrap($string, 44, "<br>");
	}

	public function truncate($str, $max) {
		if(strlen($str) > $max) {
			return substr($str,0,$max).'...';
		} else {
			return $str;	
		}
	}
	
	public function ifComma($var) {
		if(!empty($var)) {
			echo ',';
		}
	}
	
	public function setUserActive($id) {
		$this->db->query("UPDATE users SET last_active='".time()."' WHERE id='".$id."'");
	}
	
	public function isActivePlugin($dir,$name) {
		if(file_exists($dir.'/'.$name.'/'.'status.lock')) {
			return true;
		} else {
			return false;
		}
	}

	public function beenBlocked($user1,$user2) {
		$is_blocked = $this->db->query("SELECT * FROM blocked_users WHERE (user2='".$user1."' AND user1='".$user2."')");
		if($is_blocked->num_rows >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function hasBlocked($user1,$user2) {
		$is_blocked = $this->db->query("SELECT * FROM blocked_users WHERE (user2='".$user2."' AND user1='".$user1."')");
		if($is_blocked->num_rows >= 1) {
			return true;
		} else {
			return false;
		}
	}
	
	

}

// Multi-Language
if(!isset($_SESSION['language'])) {
	$language = 'english';
} else {
	$language = $_SESSION['language'];
}
if(defined('IS_AJAX')) {
	$path = '../languages/'.strtolower($language).'/language.php';
} else {
	$path = 'languages/'.strtolower($language).'/language.php';
}
require($path);