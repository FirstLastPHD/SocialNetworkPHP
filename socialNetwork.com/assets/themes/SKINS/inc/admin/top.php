<?php
$menu_plugins = $db->query("SELECT * FROM plugins ORDER BY id ASC");
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

<!-- START @FONT STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
<!--/ END FONT STYLES -->

<!-- START @GLOBAL MANDATORY STYLES -->
<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery.gritter/css/jquery.gritter.css" rel="stylesheet">
<!--/ END GLOBAL MANDATORY STYLES -->

<!-- START @THEME STYLES -->
<link href="<?=$system->getDomain()?>/assets/themes/default/css/reset.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/themes/default/css/layout.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/themes/default/css/components.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/themes/default/css/plugins.css" rel="stylesheet">
<link href="<?=$system->getDomain()?>/assets/themes/default/css/misc.css" rel="stylesheet" id="theme">
<!--/ END THEME STYLES -->

<!-- START @PLUGIN STYLES -->
<link href="<?=$system->getDomain()?>/assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet">
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
<a class="navbar-brand" href="dashboard.php">
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
<div class="navbar navbar-toolbar navbar-light">

<!-- Start left navigation -->
<ul class="nav navbar-nav navbar-left">

<!-- Start form search -->
<li class="navbar-search">
<!-- Just view on mobile screen-->
<a href="#" class="trigger-search"><i class="fa fa-search"></i></a>
<form action="<?=$system->getDomain()?>/admin/users.php" method="POST" class="navbar-form">
<div class="form-group has-feedback">
<input type="text" name="query" class="form-control typeahead rounded" placeholder="Search for people" value="<?=$query?>">
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
<a href="<?=$system->getDomain()?>/people.php" style="background:none;"> <b> <i class="fa fa-fw fa-chevron-left"></i> Back </b> </a>
</li>

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
<li class="dropdown-header">Account</li>
<li><a href="<?=$system->getDomain()?>/profile.php<?=$user->id?>"><i class="fa fa-user"></i>My Profile</a></li>
<li><a href="<?=$system->getDomain()?>/settings.php"><i class="fa fa-cog"></i>Settings</a></li>
<li class="divider"></li> 
<li><a href="<?=$system->getDomain()?>/logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
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
<aside id="sidebar-left" class="sidebar-circle sidebar-light">

<!-- Start left navigation - profile shortcut -->
<div class="sidebar-content">
<div class="media">
<a class="pull-left has-notif avatar" href="<?=$system->getDomain()?>/profile.phpid=?<?=$user->id?>">
<img src="<?=$system->getProfilePicture($user)?>" style="width:50px;height:50px;">
</a>
<div class="media-body">
<h4 class="media-heading">Hello, <span><?=$system->getFirstName($user->full_name)?></span></h4>
<small>Logged in</small>
</div>
</div>
</div><!-- /.sidebar-content -->
<!--/ End left navigation -  profile shortcut -->

<!-- Start left navigation - menu -->
<ul class="sidebar-menu">

<li class="<?=$menu['dashboard']?>">
<a href="<?=$system->getDomain()?>/admin/dashboard.php">
<span class="icon"><i class="fa fa-dashboard"></i></span>
<span class="text">Dashboard</span>
</a>
</li>

<li class="<?=$menu['users']?>">
<a href="<?=$system->getDomain()?>/admin/users.php">
<span class="icon"><i class="fa fa-users"></i></span>
<span class="text">Users</span>
</a>
</li>

<li class="<?=$menu['pages']?>">
<a href="<?=$system->getDomain()?>/admin/pages.php">
<span class="icon"><i class="fa fa-th-large"></i></span>
<span class="text">Pages</span>
</a>
</li>

<li class="<?=$menu['ads']?>">
<a href="<?=$system->getDomain()?>/admin/ads.php">
<span class="icon"><i class="fa fa-eye"></i></span>
<span class="text">Ads</span>
</a>
</li>

<li class="<?=$menu['user_generator']?>">
<a href="<?=$system->getDomain()?>/admin/user_generator.php">
<span class="icon"><i class="fa fa-magic"></i></span>
<span class="text">User Generator</span>
</a>
</li>

<li class="<?=$menu['payments']?>">
<a href="<?=$system->getDomain()?>/admin/payments.php">
<span class="icon"><i class="fa fa-credit-card"></i></span>
<span class="text">Payments</span>
</a>
</li>

<li class="<?=$menu['mass_notification']?>">
<a href="<?=$system->getDomain()?>/admin/mass_notification.php">
<span class="icon"><i class="fa fa-globe"></i></span>
<span class="text">Mass Notification</span>
</a>
</li>

<li class="<?=$menu['plugins']?>">
<a href="<?=$system->getDomain()?>/admin/plugins.php">
<span class="icon"><i class="fa fa-plug"></i></span>
<span class="text">Plugins</span>
</a>
</li>

<li class="<?=$menu['settings']?>">
<a href="<?=$system->getDomain()?>/admin/settings.php">
<span class="icon"><i class="fa fa-cog"></i></span>
<span class="text">Website Settings</span>
</a>
</li>

<li class="sidebar-category">
<span>Plugins</span>
</li>

<?php
while($menu_plugin = $menu_plugins->fetch_object()) {

echo '
<li class="'.$menu[$menu_plugin->id].'">
<a href="'.$system->getDomain().'/admin/plugin.php?id='.$menu_plugin->id.'">
<span class="icon"><i class="fa '.$menu_plugin->icon.'"></i></span>
<span class="text">'.$menu_plugin->name.'</span>
</a>
</li>
';

}
?>

</ul><!-- /.sidebar-menu -->
<!--/ End left navigation - menu -->

</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->
