<?php

class Geo {

	public function getContents($url) {

		if(function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_exec')){

			$curl = curl_init($url);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($curl, CURLOPT_TIMEOUT, 5);

			if(stripos($url,'https:') !== false){
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			}

			$content = @curl_exec($curl);
			curl_close($curl);

		} else {

			ini_set('default_socket_timeout',5);
			$content = @file_get_contents($url);

		}

		return $content;

	}

	public function getInfo($latitude,$longitude) {
		$user_info = $this->getContents('http://api.geonames.org/findNearbyPlaceNameJSON?lat='.$latitude.'&lng='.$longitude.'&username=demo');
		return json_decode($user_info,true);
	}

	public function coordsToKm($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {

		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
		pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return ($angle * $earthRadius)/1000;

	}

	public function getLocaleCodeForDisplayLanguage($name) {
		$languageCodes = array(
			"aa" => "Afar",
			"ab" => "Abkhazian",
			"ae" => "Avestan",
			"af" => "Afrikaans",
			"ak" => "Akan",
			"am" => "Amharic",
			"an" => "Aragonese",
			"ar" => "Arabic",
			"as" => "Assamese",
			"av" => "Avaric",
			"ay" => "Aymara",
			"az" => "Azerbaijani",
			"ba" => "Bashkir",
			"be" => "Belarusian",
			"bg" => "Bulgarian",
			"bh" => "Bihari",
			"bi" => "Bislama",
			"bm" => "Bambara",
			"bn" => "Bengali",
			"bo" => "Tibetan",
			"br" => "Breton",
			"bs" => "Bosnian",
			"ca" => "Catalan",
			"ce" => "Chechen",
			"ch" => "Chamorro",
			"co" => "Corsican",
			"cr" => "Cree",
			"cs" => "Czech",
			"cu" => "Church Slavic",
			"cv" => "Chuvash",
			"cy" => "Welsh",
			"da" => "Danish",
			"de" => "German",
			"dv" => "Divehi",
			"dz" => "Dzongkha",
			"ee" => "Ewe",
			"el" => "Greek",
			"en" => "English",
			"eo" => "Esperanto",
			"es" => "Spanish",
			"et" => "Estonian",
			"eu" => "Basque",
			"fa" => "Persian",
			"ff" => "Fulah",
			"fi" => "Finnish",
			"fj" => "Fijian",
			"fo" => "Faroese",
			"fr" => "French",
			"fy" => "Western Frisian",
			"ga" => "Irish",
			"gd" => "Scottish Gaelic",
			"gl" => "Galician",
			"gn" => "Guarani",
			"gu" => "Gujarati",
			"gv" => "Manx",
			"ha" => "Hausa",
			"he" => "Hebrew",
			"hi" => "Hindi",
			"ho" => "Hiri Motu",
			"hr" => "Croatian",
			"ht" => "Haitian",
			"hu" => "Hungarian",
			"hy" => "Armenian",
			"hz" => "Herero",
			"ia" => "Interlingua (International Auxiliary Language Association)",
			"id" => "Indonesian",
			"ie" => "Interlingue",
			"ig" => "Igbo",
			"ii" => "Sichuan Yi",
			"ik" => "Inupiaq",
			"io" => "Ido",
			"is" => "Icelandic",
			"it" => "Italian",
			"iu" => "Inuktitut",
			"ja" => "Japanese",
			"jv" => "Javanese",
			"ka" => "Georgian",
			"kg" => "Kongo",
			"ki" => "Kikuyu",
			"kj" => "Kwanyama",
			"kk" => "Kazakh",
			"kl" => "Kalaallisut",
			"km" => "Khmer",
			"kn" => "Kannada",
			"ko" => "Korean",
			"kr" => "Kanuri",
			"ks" => "Kashmiri",
			"ku" => "Kurdish",
			"kv" => "Komi",
			"kw" => "Cornish",
			"ky" => "Kirghiz",
			"la" => "Latin",
			"lb" => "Luxembourgish",
			"lg" => "Ganda",
			"li" => "Limburgish",
			"ln" => "Lingala",
			"lo" => "Lao",
			"lt" => "Lithuanian",
			"lu" => "Luba-Katanga",
			"lv" => "Latvian",
			"mg" => "Malagasy",
			"mh" => "Marshallese",
			"mi" => "Maori",
			"mk" => "Macedonian",
			"ml" => "Malayalam",
			"mn" => "Mongolian",
			"mr" => "Marathi",
			"ms" => "Malay",
			"mt" => "Maltese",
			"my" => "Burmese",
			"na" => "Nauru",
			"nb" => "Norwegian Bokmal",
			"nd" => "North Ndebele",
			"ne" => "Nepali",
			"ng" => "Ndonga",
			"nl" => "Dutch",
			"nn" => "Norwegian Nynorsk",
			"no" => "Norwegian",
			"nr" => "South Ndebele",
			"nv" => "Navajo",
			"ny" => "Chichewa",
			"oc" => "Occitan",
			"oj" => "Ojibwa",
			"om" => "Oromo",
			"or" => "Oriya",
			"os" => "Ossetian",
			"pa" => "Panjabi",
			"pi" => "Pali",
			"pl" => "Polish",
			"ps" => "Pashto",
			"pt" => "Portuguese",
			"qu" => "Quechua",
			"rm" => "Raeto-Romance",
			"rn" => "Kirundi",
			"ro" => "Romanian",
			"ru" => "Russian",
			"rw" => "Kinyarwanda",
			"sa" => "Sanskrit",
			"sc" => "Sardinian",
			"sd" => "Sindhi",
			"se" => "Northern Sami",
			"sg" => "Sango",
			"si" => "Sinhala",
			"sk" => "Slovak",
			"sl" => "Slovenian",
			"sm" => "Samoan",
			"sn" => "Shona",
			"so" => "Somali",
			"sq" => "Albanian",
			"sr" => "Serbian",
			"ss" => "Swati",
			"st" => "Southern Sotho",
			"su" => "Sundanese",
			"sv" => "Swedish",
			"sw" => "Swahili",
			"ta" => "Tamil",
			"te" => "Telugu",
			"tg" => "Tajik",
			"th" => "Thai",
			"ti" => "Tigrinya",
			"tk" => "Turkmen",
			"tl" => "Tagalog",
			"tn" => "Tswana",
			"to" => "Tonga",
			"tr" => "Turkish",
			"ts" => "Tsonga",
			"tt" => "Tatar",
			"tw" => "Twi",
			"ty" => "Tahitian",
			"ug" => "Uighur",
			"uk" => "Ukrainian",
			"ur" => "Urdu",
			"uz" => "Uzbek",
			"ve" => "Venda",
			"vi" => "Vietnamese",
			"vo" => "Volapuk",
			"wa" => "Walloon",
			"wo" => "Wolof",
			"xh" => "Xhosa",
			"yi" => "Yiddish",
			"yo" => "Yoruba",
			"za" => "Zhuang",
			"zh" => "Chinese",
			"zu" => "Zulu"
			);
		return array_search($name, $languageCodes);
	}
	
}

