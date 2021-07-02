<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
require('core/geo.php');
$auth = new Auth;
$geo = new Geo;
$system = new System;

$system->domain = $domain;

if(isset($_POST['register'])) {

    $full_name = $system->secureField(ucwords($_POST['full_name']));
    $email = $system->secureField($_POST['email']);
    $password = $system->secureField(trim($_POST['password']));
    $time = time();
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Geolocation
    $longitude = $_SESSION['longitude'];
    $latitude = $_SESSION['latitude'];

    $geo_info = $geo->getInfo($latitude,$longitude);
    $city = $geo_info['geonames'][0]['name'];
    $country = $geo_info['geonames'][0]['countryName'];

    $check_d = $db->query("SELECT id FROM users WHERE email='".$email."'")->num_rows;
    if($check_d == 0) {
        $db->query("INSERT INTO users (profile_picture,full_name,email,password,registered,credits,age,gender,ip,country,city,longitude,latitude) VALUES ('default_avatar.png','$full_name','$email','".$auth->hashPassword($password)."','$time','100','$age','$gender','$ip','".$country."','".$city."','".$longitude."','".$latitude."')");
        setcookie('justRegistered', 'true', time()+6);
        setcookie('mm-email',$email,time()+60*60*24*30,'/');
        header('Location: '.$system->getDomain().'/login.php');
        exit;
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
    <title><?=$site_name?> - <?=$lang['Register']?></title>
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
    <link href="assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <body>

        <!--[if lt IE 9]>
        <p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- START @SIGN WRAPPER -->
        <div id="sign-wrapper">

            <!-- Brand -->
            <div class="brand">
                <img src="img/logo.png"/>
            </div>
            <!--/ Brand -->

            <!-- Register form -->
            <form class="form-horizontal rounded shadow no-overflow" action="" method="post">
                <div class="sign-header">
                    <div class="form-group">
                        <div class="sign-text">
                            <span><?=$lang["Register_To_Get_Instant_Access"]?></span>
                        </div>
                    </div>
                </div>
                <div class="sign-body">
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            <input type="text" name="full_name" class="form-control" placeholder="<?=$lang['Full_Name']?>" required>
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            <input type="password" name="password" class="form-control" placeholder="<?=$lang['Password']?>" required>
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            <input type="email" name="email" class="form-control" placeholder="<?=$lang['Email']?>" required>
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="gender" class="form-control" required>
                            <option value="" disabled selected><?=$lang['Gender']?></option>
                            <option value="Male"> <?=$lang['Male']?> </option>
                            <option value="Female"> <?=$lang['Female']?> </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="age" class="form-control" required>
                            <option value="" disabled selected><?=$lang['Age']?></option>
                            <?php for($i = $minimum_age; $i <= 100; $i++) { ?>
                            <option value="<?php echo $i?>"> <?php echo $i?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="sign-footer">
                    <!-- 
                    <div class="form-group">
                        <div class="callout callout-info no-margin">
                            <p class="text-muted">To confirm and activate your new account, we will need to send the activation code to your e-mail.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="ckbox ckbox-theme">
                            <input id="term-of-service" value="1" type="checkbox" required>
                            <label for="term-of-service" class="rounded">I agree with <a href="#">Term Of Service</a></label>
                        </div>
                    </div>
                -->
                <div class="form-group">
                    <button type="submit" name="register" class="btn btn-theme btn-lg btn-block no-margin rounded"><?=$lang['Register']?></button>
                </div>
            </div> 
        </form>
        <!--/ Register form -->

        <!-- Content text -->
        <p class="text-muted text-center sign-link"><?=$lang['Have_Account']?> <a href="<?=$system->getDomain()?>/login.php"> <?=$lang['Login']?></a></p>
        <!--/ Content text -->

    </div><!-- /#sign-wrapper -->
    <!--/ END SIGN WRAPPER -->

    <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
    <!-- START @CORE PLUGINS -->
    <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js"></script>
    <script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js"></script>
    <!--/ END CORE PLUGINS -->
    <script>
    navigator.geolocation.getCurrentPosition(getPosition);
    function getPosition(position) {
      $.get('<?=$system->getDomain()?>/ajax/setPosition.php?longitude='+position.coords.longitude+'&latitude='+position.coords.latitude);
  }
  </script>
  <!--/ END JAVASCRIPT SECTION -->

</body>
<!-- END Body -->

</html>
<!-- Localized -->