<?php

class Instagram {

	public function getPhotos($username) {

		$images = array();
		$html = file_get_html('http://instaliga.com/'.$username);
		if($html) {
			foreach($html->find('a[class=element__image-wrapper]') as $element) {
				$elm = $element->innertext;
				preg_match('!https?://[\w+&@#/%?=~|\!\:,.;-]*[\w+&@#/%=~|-]!', $elm, $url);
				$url[0] = str_replace('/s320x320/', '/', $url[0]);
				$images[] = trim($url[0]);
			}
		}
		return $images;

	}

	public function countPhotos($username) {

		$images = array();
		$html = file_get_html('http://instaliga.com/'.$username);
		$c=0;
		if($html) {
			foreach($html->find('a[class=element__image-wrapper]') as $element) {
				$c++;
			}
		}

		return $c;

	}

}
