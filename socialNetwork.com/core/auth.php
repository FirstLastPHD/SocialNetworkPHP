<?php

class Auth {

	public function isLogged() {
		if(!empty($_SESSION)) {
			if(isset($_SESSION['auth'])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function logOut() {
		session_destroy();
		header('Location: index.php');
		exit;
	}

	public function hashPassword($password) {
		return md5($password);
	}

	public function isAdmin() {
		if(isset($_SESSION['is_admin'])) {
			return true;
		} else {
			return false;
		}
	}

}

