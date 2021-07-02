<?php

$ucount = $db->query("SELECT id FROM notifications WHERE receiver_id='".$user->id."' AND is_read='0'");
$ucount = $ucount->num_rows;
$custom_pages = $db->query("SELECT * FROM pages ORDER BY id DESC");
$spotlight_users = $db->query("SELECT * FROM users WHERE is_increased_exposure='1' OR vip_expiration >= UNIX_TIMESTAMP() ORDER BY RAND() LIMIT 12");

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
	<title><?=$page['name']?></title>
	<!--/ END META SECTION -->

	<!-- START @FAVICONS -->
	<link rel="shortcut icon" type="image/png" href="<?=$system->getDomain()?>/img/favicon.png"/>
	<!--/ END FAVICONS -->

	<!-- START @FONT STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
	<!--/ END FONT STYLES -->

	<!-- START @GLOBAL MANDATORY STYLES -->
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery.gritter/css/jquery.gritter.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/sweet-alert/css/sweet-alert.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap-slider/css/bootstrap-slider.min.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bxslider/css/bxslider.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/fbphotobox/css/fbphotobox.css" rel="stylesheet" type="text/css">
	<!--/ END GLOBAL MANDATORY STYLES -->

	<!-- START @THEME STYLES -->
	<link href="<?=$system->getDomain()?>/assets/themes/default/css/reset.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/themes/default/css/layout.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/themes/default/css/components.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/themes/default/css/plugins.css" rel="stylesheet">
	<link href="<?=$system->getDomain()?>/assets/themes/default/css/misc.css" rel="stylesheet" id="theme">
	<!--/ END THEME STYLES -->

	<!-- START @PLUGIN STYLES -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/emojione/2.0.0/assets/css/emojione.min.css"/>
	<!--/ END PLUGIN STYLES -->

	<!-- CSS PREPROCESSOR -->
	<?=$page['css']?>
	<!-- CSS PREPROCESSOR -->

	<!-- START @IE SUPPORT -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/global/plugins/bower_components/html5shiv/dist/html5shiv.min.js"></script>
	<script src="assets/global/plugins/bower_components/respond-minmax/dest/respond.min.js"></script>
	<![endif]-->
	<!--/ END IE SUPPORT -->

	<script>
	var base = '<?=$system->getDomain()?>';
	var showControls = <?php if(empty($photos)) { echo 'false'; } else { echo 'true'; } ?>;
	var profile_picture = '<?=$system->getProfilePicture($user)?>';
	<?php if(isset($profile)) { echo 'var gallery_desc = \''.sprintf($lang['Gallery_Description'],$system->getFirstName($profile->full_name)).'\';'; } else { echo 'var gallery_desc = \''.$lang['Chat_Photos'].'\';'; } ?>
	<?php if(isset($profile)) { ?>
		var gallery_right_content = '<div class="fbphotobox-container-right">'
		'<div class="fbphotobox-close-btn">'
		'<a title="Close" href="" style="float:right;margin:8px">'
		'<img src="'+base+'/assets/global/plugins/bower_components/fbphotobox/images/close.png" style="height:10px;width:10px"/>'
		'</a>'
		'<div style="clear:both"></div>'
		'</div>';
		<? } else { ?>
			var gallery_right_content = '';
			<? } ?>

			</script>

		</head>
		<!--/ END HEAD -->

		<body>

<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- START @WRAPPER -->
<section id="wrapper">

	<!-- START @HEADER -->
	<header id="header">

		<!-- Start header left -->
		<div class="header-left">
			<!-- Start offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
			<div class="navbar-minimize-mobile left">
				<i class="fa fa-bars" style="color:#fff;"></i>
			</div>
			<!--/ End offcanvas left -->

			<!-- Start navbar header -->
			<div class="navbar-header">

				<!-- Start brand -->
				<a class="navbar-brand" href="<?=$system->getDomain()?>/people.php">
					<img class="logo" src="<?=$system->getDomain()?>/img/logo-small.png">
				</a><!-- /.navbar-brand -->
				<!--/ End brand -->

			</div><!-- /.navbar-header -->
			<!--/ End navbar header -->

			<div class="clearfix"></div>
		</div><!-- /.header-left -->
		<!--/ End header left -->

		<!-- Start header right -->
		<div class="header-right">
			<!-- Start navbar toolbar -->
			<div class="navbar navbar-toolbar navbar-<?=$skin?>">

				<!-- Start left navigation -->
				<ul class="nav navbar-nav navbar-left">

					<!-- Start sidebar shrink -->
					<li class="navbar-minimize visible-sm">
						<a href="javascript:void(0);">
							<i class="fa fa-bars text-white"></i>
						</a>
					</li>
					<!--/ End sidebar shrink -->

					<!-- Start form search -->
					<li class="navbar-search">
						<!-- Just view on mobile screen-->
						<a href="#" class="trigger-search"><i class="fa fa-search"></i></a>
						<form action="<?=$system->getDomain()?>/people.php" method="post" class="navbar-form">
							<div class="form-group has-feedback">
								<input type="text" name="query" class="form-control typeahead rounded" placeholder="<?=$lang['Search_For_People']?>" value="<?=$query?>">
								<button type="submit" name="search" class="btn btn-theme fa fa-search form-control-feedback rounded"></button>
							</div>
						</form>
					</li>
					<!--/ End form search -->

				</ul><!-- /.nav navbar-nav navbar-left -->
				<!--/ End left navigation -->

				<!-- Start right navigation -->
				<ul class="nav navbar-nav navbar-right"><!-- /.nav navbar-nav navbar-right -->

					<li> 
						<a href="<?=$system->getDomain()?>/upgrades.php" style="background:none;color:#777;"> <b> <i class="fa fa-fw fa-diamond"></i> <?=number_format($user->credits)?> </b> </a>
					</li>

					<!-- Start notifications -->
					<li class="dropdown navbar-notification">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="getNotifications()"><i class="fa fa-globe"></i><span class="count label label-danger rounded" id="notification-count" style="animation:none;"><?=$ucount?></span></a>

						<!-- Start dropdown menu -->
						<div class="dropdown-menu animated flipInX">
							<div class="dropdown-header">
								<span class="title"><?=$lang['Notifications']?></span>
							</div>
							<div class="dropdown-body niceScroll">

								<!-- Start notification list -->
								<div class="media-list small" id="notification-list"></div>
								<!--/ End notification list -->

							</div>
							<div class="dropdown-footer">
								<a href="#" data-toggle="modal" data-target="#all-notifications" onclick="loadAllNotifications()"><?=$lang['See_All']?></a>
							</div>
						</div>
						<!--/ End dropdown menu -->

					</li><!-- /.dropdown navbar-notification -->
					<!--/ End notifications -->

					<!-- Start profile -->
					<li class="dropdown navbar-profile">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="meta">
								<span class="avatar"><img src="<?=$system->getProfilePicture($user)?>" class="img-circle" style="width:35px;height:35px;"></span>
								<span class="text hidden-xs hidden-sm text-muted"><?=$system->getFirstName($user->full_name)?></span>
								<span class="caret"></span>
							</span>
						</a>
						<!-- Start dropdown menu -->
						<ul class="dropdown-menu animated flipInX">
							<li class="dropdown-header"><?=$lang['Account']?></li>
							<li><a href="<?=$system->getDomain()?>/profile.php?id=<?=$user->id?>"><i class="fa fa-user"></i><?=$lang['My_Profile']?></a></li>
							<?php if($user->is_admin == 1) { ?> <li><a href="<?=$system->getDomain()?>/admin"><i class="fa fa-dashboard"></i><?=$lang['Admin']?></a></li> <? } ?>
							<li><a href="<?=$system->getDomain()?>/settings.php"><i class="fa fa-cog"></i><?=$lang['Settings']?></a></li>
							<li class="divider"></li> 
							<li><a href="<?=$system->getDomain()?>/logout.php"><i class="fa fa-sign-out"></i><?=$lang['Logout']?></a></li>
						</ul>
						<!--/ End dropdown menu -->
					</li><!-- /.dropdown navbar-profile -->
					<!--/ End profile -->


				</ul>
				<!--/ End right navigation -->

			</div><!-- /.navbar-toolbar -->
			<!--/ End navbar toolbar -->
		</div><!-- /.header-right -->
		<!--/ End header left -->

	</header> <!-- /#header -->
	<!--/ END HEADER -->

<!--

START @SIDEBAR LEFT

-->
<aside id="sidebar-left" class="sidebar-circle sidebar-<?=$skin?>">

	<!-- Start left navigation - profile shortcut -->
	<div class="sidebar-content">
		<div class="media">
			<a class="pull-left has-notif avatar" href="<?=$system->getDomain()?>/profile.php?id=<?=$user->id?>">
				<img src="<?=$system->getProfilePicture($user)?>" style="width:50px;height:50px;">
			</a>
			<div class="media-body">
				<h4 class="media-heading"><?=$lang['Hello']?>, <span><?=$system->getFirstName($user->full_name)?></span></h4>
				<small><?=$lang['Logged_In']?></small>
			</div>
		</div>
	</div><!-- /.sidebar-content -->
	<!--/ End left navigation -  profile shortcut -->

	<!-- Start left navigation - menu -->
	<ul class="sidebar-menu">

		<li class="<?=$menu['people.php']?>">
			<a href="<?=$system->getDomain()?>/people.php">
				<span class="icon"><i class="fa fa-user-plus"></i></span>
				<span class="text"><?=$lang['People']?></span>
			</a>
		</li>


		<li class="<?=$menu['messages']?>">
			<a href="<?=$system->getDomain()?>/messages.php">
				<span class="icon"><i class="fa fa-comments"></i></span>
				<span class="text"><?=$lang['Messages']?></span>
			</a>
		</li>

		<li class="<?=$menu['visitors']?>">
			<a href="<?=$system->getDomain()?>/visitors.php">
				<span class="icon"><i class="fa fa-eye"></i></span>
				<span class="text"><?=$lang['Profile_Visitors']?></span>
			</a>
		</li>

		<li class="<?=$menu['likes']?>">
			<a href="<?=$system->getDomain()?>/likes.php">
				<span class="icon"><i class="fa fa-heart"></i></span>
				<span class="text"><?=$lang['Profile_Likes']?></span>
			</a>
		</li>

		<li class="<?=$menu['upgrades']?>">
			<a href="<?=$system->getDomain()?>/upgrades.php">
				<span class="icon"><i class="fa fa-star text-warning"></i></span>
				<span class="text"><?=$lang['Upgrades']?></span>
			</a>
		</li>

		<li class="<?=$menu['settings']?>">
			<a href="<?=$system->getDomain()?>/settings.php">
				<span class="icon"><i class="fa fa-cog"></i></span>
				<span class="text"><?=$lang['Settings']?></span>
			</a>
		</li>

		<li class="sidebar-category">
			<span><?=$lang['Pages']?></span>
		</li>

		<?php 
		while($custom_page = $custom_pages->fetch_object()) { ?>
		<li class="<?=$menu['custom_page'][$custom_page->id]?>">
			<a href="<?=$system->getDomain()?>/page.php/<?=$custom_page->id?>">
				<span class="icon"><i class="fa fa-info-circle"></i></span>
				<span class="text"><?=$custom_page->page_title?></span>
			</a>
		</li>
		<? } ?>

		
		<div class="visible-lg visible-md hidden" id="spotlightArea">
			<li class="sidebar-category">
				<span><?=$lang['Increased_Exposure']?></span>
				<span class="pull-right"><a href="<?=$system->getDomain()?>/upgrades.php" style="color:#7f7f7f;text-decoration:none;"><i class="fa fa-plus"></i></a></span>
			</li>
			<div style="padding-left:20px;padding-right:20px;padding-top:10px;">
				<?php
				while($spotlight_user = $spotlight_users->fetch_object()) {
					echo '<a href="'.$system->getDomain().'/profile.php?id='.$spotlight_user->id.'">';
					echo '<img src="'.$system->getProfilePicture($spotlight_user).'" class="img-circle pull-left" style="height:45px;width:45px;padding:5px;" data-toggle="tooltip" data-placement="bottom" data-title="'.$system->getFirstName($spotlight_user->full_name).'" placeholder="" data-original-title="" title="">';
					echo '</a>';
				}
				?>
			</div>
		</div>

	</ul><!-- /.sidebar-menu -->
	<!--/ End left navigation - menu -->

</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->
