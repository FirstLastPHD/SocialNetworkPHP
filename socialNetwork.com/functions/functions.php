<?php
public bool function getBoolProfilePicture($user) {
		$logika;
		if(filter_var($user->profile_picture,FILTER_VALIDATE_URL)) {
			return $user->profile_picture;
			$logika =true;
		} else {
			return $this->domain.'/uploads/'.$user->profile_picture;
			$logika=false;
		}
		return $logika;
	}
