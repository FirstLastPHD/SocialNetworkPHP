<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<h2 class="text-special mb-20 mt-5" style="font-size:25px;"> <?=$lang['Profile_Visitors']?> </h2>
				<?php if($profile_visitors->num_rows >= 1) { ?>
				<div class="panel rounded shadow">
					<div class="panel-body">
						<?=$lang['Last_20_Visitors']?>
					</div>
				</div>
				<?php 
				while($profile_visitor = $profile_visitors->fetch_object()) { 
					$profile = $system->getUserInfo($profile_visitor->viewer_id);
					?>
					<div class="col-lg-2 col-md-3 col-sm-4" style="padding:0px!important;margin-right:10px;">
						<div class="panel rounded shadow" style="padding:0px!important;">
							<div class="panel-body">
								<div class="inner-all">
									<ul class="list-unstyled">
										<li class="text-center">
											<a href="<?=$system->getDomain()?>/profile.php?id=<?=$profile->id?>">
												<img class="img-circle" src="<?=$system->getProfilePicture($profile)?>" alt="<?=$profile->full_name?>" style="height:100px;width:100px;">
											</a>
										</li>
										<li class="text-center">
											<h4 class="text-capitalize font600"><?=$system->getFirstName($profile->full_name)?></h4>
											<p class="text-muted"><?=$system->timeAgo($lang,$profile_visitor->time)?></p>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?
				}
			} else {
				echo '<div class="panel rounded"> <div class="panel-body"> '.$lang['None_Visited_Profile'].' </div> </div>'; 
			}
			?>
		</div>
	</div>

</div>
<!--/ End body content -->

</section>