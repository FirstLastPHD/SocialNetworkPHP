<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

if(isset($_POST['reset'])) {
	$email = $_POST['email'];
	$user = $db->query("SELECT id FROM users WHERE email='".$email."'");
	if($user->num_rows >= 1) {
		$pass = substr($auth->hashPassword(time()),0,5);
		$db->query("UPDATE users SET password='".$auth->hashPassword($pass)."' WHERE email='".$email."'");
		//mail($email,'fdsf','fdsfds',$pass,'From: info@matchmescript.com','-f info@matchmescript.com');
		mail($email,$lang['Password_Reset'],sprintf($lang['Password_Reset_Instructions'],$pass));
		$success = true;
	} else {
		$error = true;	
	}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- START @HEAD -->
<head>
	<!-- START @META SECTION -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?=$site_name?> - <?=$lang['Password_Reset']?></title>
    <!--/ END META SECTION -->

    <!-- START @FAVICONS -->
    <link href="<?=$system->getDomain()?>/img/ico/html/apple-touch-icon-144x144-precomposed.png" rel="apple-touch-icon-precomposed" sizes="144x144">
    <link href="<?=$system->getDomain()?>/img/ico/html/apple-touch-icon-114x114-precomposed.png" rel="apple-touch-icon-precomposed" sizes="114x114">
    <link href="<?=$system->getDomain()?>/img/ico/html/apple-touch-icon-72x72-precomposed.png" rel="apple-touch-icon-precomposed" sizes="72x72">
    <link href="<?=$system->getDomain()?>/img/ico/html/apple-touch-icon-57x57-precomposed.png" rel="apple-touch-icon-precomposed">
    <link href="<?=$system->getDomain()?>/img/ico/html/apple-touch-icon.png" rel="shortcut icon">
    <!--/ END FAVICONS -->

    <!-- START @FONT STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <!--/ END FONT STYLES -->

    <!-- START @GLOBAL MANDATORY STYLES -->
    <link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--/ END GLOBAL MANDATORY STYLES -->

    <!-- START @PAGE LEVEL STYLES -->
    <link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <!--/ END PAGE LEVEL STYLES -->

    <!-- START @THEME STYLES -->
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/reset.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/layout.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/components.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/plugins.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/pages/sign.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/themes/default/css/misc.css" rel="stylesheet" id="theme">
    <!--/ END THEME STYLES -->

    <!-- START @IE SUPPORT -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/global/plugins/bower_components/html5shiv/dist/html5shiv.min.js"></script>
        <script src="assets/global/plugins/bower_components/respond-minmax/dest/respond.min.js"></script>
        <![endif]-->
        <!--/ END IE SUPPORT -->
    </head>
    <!--/ END HEAD -->

    <body class="page-sound">

        <!--[if lt IE 9]>
        <p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- START @SIGN WRAPPER -->
        <div id="sign-wrapper">

        	<!-- Brand -->
        	<div class="brand">
        		<img src="<?=$system->getDomain()?>/img/logo.png"/>
        	</div>
        	<!--/ Brand -->

        	<!-- Login form -->
        	<form class="sign-in form-horizontal shadow rounded no-overflow" action="" method="post">
        		<div class="sign-header">
        			<div class="form-group">
        				<div class="sign-text">
        					<span><?=$lang['Password_Reset']?></span>
        				</div>
        			</div><!-- /.form-group -->
        		</div><!-- /.sign-header -->
        		<div class="sign-body">
        			<?php if(isset($success)) { ?> <div class="alert alert-success" style="border-radius:0px;"> <i class="fa fa-check-circle fa-fw"></i> Successfully sent password reset instructions to <?=$email?>  </div> <?php } ?>
        			<?php if(isset($error)) { ?> <div class="alert alert-danger" style="border-radius:0px;"> <i class="fa fa-warning fa-fw"></i> User doesn't exist </div> <?php } ?>
        			<div class="form-group">
        				<div class="input-group input-group-lg rounded no-overflow">
        					<input type="email" name="email" class="form-control input-sm" placeholder="Email" value="<?=$email?>">
        					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        				</div>
        			</div><!-- /.form-group -->
        		</div><!-- /.sign-body -->
        		<div class="sign-footer">
        			<div class="form-group">
        				<button type="submit" name="reset" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn"><?=$lang['Reset']?></button>
        			</div><!-- /.form-group -->
        		</div><!-- /.sign-footer -->
        	</form><!-- /.form-horizontal -->
        	<!--/ Login form -->

        </div><!-- /#sign-wrapper -->
        <!--/ END SIGN WRAPPER -->

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- START @CORE PLUGINS -->
        <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js"></script>
        <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js"></script>
        <!--/ END CORE PLUGINS -->
        <!--/ END JAVASCRIPT SECTION -->

    </body>
    <!-- END BODY -->

    </html>
<!-- Localized -->