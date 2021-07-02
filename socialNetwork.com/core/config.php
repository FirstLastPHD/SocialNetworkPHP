<?php
	$domain = 'http://lovexxxss.pt:9090';

	// Database Configuration
	$_db['host'] = 'localhost';
	$_db['user'] = 'root';
	$_db['pass'] = '';
	$_db['name'] = 'matchme';

	$site_name = 'Free online chat, social dating, smart Matching, conversation and networking';
	$meta['keywords'] = 'Global Social Dating Service, relationship, relationships, serious relationships, 2hearts relationships, flirt, chat rolette, dating, dating site, dating, dating chat, free dating, free dating site, dating for free, dating service, dating club, dating girls, dating guys, socialising, dating and socialising, dating, dating, internet dating, 2hearts dating, dating 2hearts, guys, girls, guys and girls, meet new people';
	$meta['description'] = '2hearts is one of biggest most popular free global social dating network. One of the best place to meet new interesting people, chat, play and flirt. We have more than 20 million users. Come join the fun!';

	// PayPal Configuration
	$paypal_email = 'LJSXPWEBZ842G'; // Email of PayPal Account to receive money

	// Fortumo Configuration (SMS Payments)
	$fortumo_service_id = '49f8137be747bc87fe7cdab00c81f9cc';

	// Stripe Configuration
	$secret_key = 'sk_live_LxSBFNbc9yM0rH2JbzU5mzKW'; // Stripe API Secret Key
	$publishable_key = 'pk_live_ptIoKcBkL6UWkDQO6aVUJRaP'; // Stripe API Publishable Key

	// Facebook Login Configuration
	$fb_app_id = '372022903251021'; 
	$fb_secret_key = 'b05b348babf5066dad490a84e33334ea'; 

	// Misc Configuration
	$minimum_age = '16'; 
	$email_sender = 'info@yourdomain.com'; 

	// Layout Settings
	$skin = 'light';

	// Units of Measurement
	$unit['height'] = 'cm';
	$unit['weight'] = 'kg';
	
	$db = new mysqli($_db['host'], $_db['user'], $_db['pass'], $_db['name']) or die('MySQL Error');

	error_reporting(0);
	