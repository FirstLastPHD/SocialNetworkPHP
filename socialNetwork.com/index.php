<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
require('core/geo.php');
require('core/dom.php');
require('core/instagram.php');
//require('functions/functions.php');
$auth = new Auth;
$geo = new Geo;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['register'])) {
  $full_name = ucwords($_POST['full_name']);
  $email = $_POST['email'];
  $password = trim($_POST['password']);
  $time = time();
  $age = $_POST['age'];
  $gender = $_POST['gender'];

  // Geolocation
  $longitude = $_SESSION['longitude'];
  $latitude = $_SESSION['latitude'];

  $geo_info = $geo->getInfo($latitude,$longitude);
  $city = $geo_info['geonames'][0]['name'];
  $country = $geo_info['geonames'][0]['countryName'];

  $check_d = $db->query("SELECT id FROM users WHERE email='".$email."'");
  $check_d = $check_d->num_rows;
  if($check_d == 0) {
    $db->query("INSERT INTO users (profile_picture,full_name,email,password,registered,credits,age,gender,ip,country,city,longitude,latitude) VALUES ('default_avatar.png','$full_name','$email','".$auth->hashPassword($password)."','$time','100','$age','$gender','$ip','".$country."','".$city."','".$longitude."','".$latitude."')");
    setcookie('justRegistered', 'true', time()+6);
    setcookie('mm-email',$email,time()+60*60*24*30,'/');
    header('Location: '.$domain.'/login.php');
    exit;
  }
}

if($auth->isLogged()) {
  $first_name = $system->getFirstName($_SESSION['full_name']);
}

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$users = $db->query("SELECT * FROM users ORDER BY RAND() LIMIT 1000000");
$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

//$people = "SELECT * FROM users WHERE profile_picture like '%default_avatar.png%' IN(SELECT * FROM users WHERE id ORDER BY RAND())";
    $people = "SELECT * FROM users WHERE profile_picture NOT like '%default_avatar.png%' AND id ORDER BY RAND()";	
 

// Pagination
$per_page = 25;
$count = $db->query($people)->num_rows;
$last_page = ceil($count/$per_page);
if(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if($p < 1) { $p = 1; } elseif($p > $last_page) { $p = $last_page; }
$limit = 'LIMIT ' .($p - 1) * $per_page .',' .$per_page;
$people .= " $limit";


// Finalize Query
$people = $db->query($people);

?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]><html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 ie-lt10 ie-lt9 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 ie-lt10 no-js" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta charset="utf-8">
  <title><?php echo $site_name?> - Online Dating Community</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700' rel='stylesheet'>
  <link href="<?=$system->getDomain()?>/assets/landing/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?=$system->getDomain()?>/assets/landing/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=$system->getDomain()?>/assets/landing/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?=$system->getDomain()?>/assets/landing/styles.css">
  <link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
</head>
<body>
  <header class="header header3" role="banner" id="header" style="background-image: url('<?=$system->getDomain()?>/assets/landing/bg-header.jpg')">
    <div class="container">
     <div style="float:left;position:relative;z-index:2;"> <p><img src="<?=$system->getDomain()?>/img/logo-small.png"></p> </div>
     <div class="cnt">
      <h4>It’s quick &amp; easy to</h4>
      <h1 style="font-size:40px;" class="theme-color">Meet new people online</h1>
      <p><?php echo $site_name?> is great for chatting, making friends, sharing interests, and even dating! Did we mention it's free?</p>
    </div>
    <div class="reg-form has-feedback">
      <?php if(!$auth->isLogged()) { ?>
      <a href="<?=$system->getDomain()?>/login.php" style="color:#fff;font-size:17px;float:right;"> <i class="fa fa-sign-in fa-fw"></i> Log In </a>
      <br><br>
      <h3>Register in one easy step</h3>
      <!--<form action="fb-login.php" method="POST">
        <button type="submit" name="fb-login" class="btn btn-subsection btn-social btn-lg btn-facebook" style="text-align:left;"><i class="fa fa-facebook"></i>Log In with Facebook</button> <br>
      </form>-->
      <br>
      <form action="" method="post" id="registration">
        <input type="text" name="full_name" placeholder="Full name" required/>
        <input type="text" name="email" placeholder="Email" required/>
        <input type="password" name="password" placeholder="Password" required/>
        <select name="age" autocomplete="off" required class="form-control">
          <option value="" disabled selected>Age</option>
          <?php for($i = $minimum_age; $i <= 100; $i++) { ?>
          <option value="<?php echo $i?>"> <?php echo $i?> </option>
          <?php } ?>
        </select>
        <select name="gender" autocomplete="off" required class="form-control">
          <option value="" disabled selected>Gender</option>
          <option value="Male"> Male </option>
          <option value="Female"> Female </option>
        </select>
        <button type="submit" name="register" class="btn-red">Register today!</button>
      </form>
      <? } else { ?>
      <div style="text-align:center;padding-top:50px;">
        <h3>Welcome, <b><?=$first_name?></b> </h3>
        <form action="<?=$system->getDomain()?>/people.php" method="GET">
         <button type="submit" class="btn-red">Log In</button>
       </form>
     </div>
     <? } ?>
   </div>
 </div>
</header>
<main class="front-page main" role="main">
  <section class="profiles">
    <div class="container">
      <h3>Meet our community members</h3>
      <div class="flexslider carousel">
        <ul class="slides">

          <?php while($user = $users->fetch_object()) { ?>
          <li>
            <div class="thumb">
              <a href="#" class="open-popup"><img src="<?=$system->getProfilePicture($user)?>" style="border-radius:5px;"></a>
            </div>
            <p><a href="#" class="open-popup"><?=$system->getFirstName($user->full_name)?></a></p>
            <span><?=$user->age?>, <?=$user->country?></span>
          </li>
          <?php } ?>
		  
		  <?php while($user = $users->fetch_object()) { ?>
          <li>
            <div class="thumb">
              <a href="#" class="open-popup"><img src="<?=$system->getProfilePicture($user)?>" style="border-radius:5px;"></a>
            </div>
            <p><a href="#" class="open-popup"><?=$system->getFirstName($user->full_name)?></a></p>
            <span><?=$user->age?>, <?=$user->country?></span>
          </li>
          <?php } ?>

        </ul>
      </div>
    </div>
  </section>
  
  <section id="page-content">
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<?php 
				
					while($person = $people->fetch_object()) { 
						?>
						<div class="col-lg-3 col-md-3 col-sm-4">
							<div class="panel rounded shadow">
								<div class="panel-body">
									<div class="inner-all">
										<ul class="list-unstyled">
											<li class="text-center">
												<a href="<?=$system->getDomain()?>/profile.php?id=<?=$person->id?>">
													<img class="img-circle" src="<?=$system->getProfilePicture($person)?>" alt="<?=$person->full_name?>" style="height:100px;width:100px;">
												</a>
											</li>
											<li class="text-center">
												<h4 class="font600" style="margin-bottom:5px;"> 
													<?php if($system->isOnline($person->last_active)) { ?> 
													<span class="badge badge-success badge-circle hand-cursor" data-toggle="tooltip" data-placement="bottom" data-title="<?=$lang['Online']?>" placeholder="" data-original-title="" title="">&nbsp</span> 
													<?php } else { ?> 
													<span class="badge badge-danger badge-circle hand-cursor"  data-toggle="tooltip" data-placement="bottom" data-title="<?=sprintf($lang['Last_Active'],$system->timeAgo($lang,$person->last_active))?>" placeholder="" data-original-title="" title="">&nbsp</span> 
													<?php } ?> 
													<?=$system->getFirstName($person->full_name)?>, <?=$person->age?>
												</h4>
												<p class="text-muted"> <?=$person->city?><?=$system->ifComma($person->city)?> <?=$person->country?></p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<?php
					} 
				?>
				
					<div class="col-lg-12 col-md-12 col-sm-12">
					<ul class="pagination pagination-lg">
						<?php
						if(($last_page >= $p) && $last_page > 1) {
							for($i=1; $i<=$last_page; $i++) {
								if($i == $p) {
									echo '<li class="active"> <a href="'.$system->getDomain().'/index.php?p='.$i.'"> '.$i.' </a> </li>';
								} else {
									echo '<li> <a href="'.$system->getDomain().'/index.php?p='.$i.'"> '.$i.' </a> </li>';
								}
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>

	</div>
	<!--/ End body content -->

</section>
  <section class="feature-section">
    <h2><?php echo $site_name?> revolutionizes online dating <br/> <a href="#" class="back-to-top theme-color"> Give it a try, it’s free to join. </a> </h2>
    <div class="container">
      <div class="block">
        <i class="fa fa-smile-o theme-color"></i>
        <h3>It's Free</h3>
        <p>
          Signing up takes two
          minutes and is totally free. What do you have to loose?
        </p>
      </div>
      <div class="block">
        <i class="fa fa-check theme-color"></i>
        <h3>Smart Matching</h3>
        <p>
          Our matching algorithm helps
          you find the right people.
        </p>
      </div>
      <div class="block">
        <i class="fa fa-map-marker theme-color"></i>
        <h3>It's Localized</h3>
        <p>Connect with the singles from your local <br> town or city.</p>
      </div>
    </div>
  </section>
</main>
<script src="<?=$system->getDomain()?>/assets/landing/scripts/modernizr.js"></script>
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery-1.11.0.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery.flexslider-min.js"></script>
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery.parallax-1.1.3.js"></script> 
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery.localscroll-1.2.7-min.js"></script> 
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery.scrollTo-1.4.2-min.js"></script> 
<script src="<?=$system->getDomain()?>/assets/landing/scripts/jquery.inview.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/landing/scripts/theme.js"></script>
<script>
navigator.geolocation.getCurrentPosition(getPosition);
function getPosition(position) {
  $.get('<?=$system->getDomain()?>/ajax/setPosition.php?longitude='+position.coords.longitude+'&latitude='+position.coords.latitude);
}
</script>
</body>
</html>