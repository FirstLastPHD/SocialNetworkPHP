<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<h2 class="text-special mb-20 mt-5" style="font-size:25px;"> <?=$lang['Upgrades']?> </h2>
				<?php if(isset($error)) { ?> <div class="alert alert-danger"> <i class="fa fa-fw fa-warning"></i> <?=$lang['Not_Enough_Credits']?> </div> <?php } ?>
				<div class="panel rounded shadow">
					<div class="panel-heading">
						<div class="pull-left">
							<h5 class="panel-title text-special"><?=$lang['Credits']?> (<?=number_format($user->credits)?>)</h5>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body" style="font-size:14px;">
						<?=$lang['Credits_Explanation']?>
						<br>
						<a href="#" data-toggle="modal" data-target="#buy-credits" class="btn btn-theme btn-sm mt-10"><?=$lang['Buy_Credits']?></a>
					</div>
				</div>
				<div class="panel rounded shadow">
					<div class="panel-body">
						<form action="" method="post">
							<div class="list-group no-margin">
								<a class="list-group-item" style="background:none;overflow:auto;">
									<img src="<?=$system->getDomain()?>/img/icons/ghost.png" class="pull-left mr-10" style="height:50px;width:50px;">
									<h4 class="list-group-item-heading text-special" style="font-size:18px;padding-top:7px;">
										<?=$lang['Ghost_Mode']?>
										<?php if($user->is_incognito == 0) {
											echo '<button name="enable_1" class="btn btn-theme pull-right" style="color:#fff!important;">'.$lang['Enable'].' (150)</button>';
										} else {
											echo '<button class="btn btn-theme pull-right" style="color:#fff!important;" disabled> <i class="fa fa-fw fa-check-circle" style="color:#fff!important;"></i> '.$lang['Active'].'</button>';
										}
										?> 
									</h4>
									<div class="progress progress-striped progress-xs active" style="width:200px;margin-bottom:10px;" data-toggle="tooltip" data-placement="bottom" data-title="<?=$ghost_mode_time?>" placeholder="" data-original-title="" title="">
										<div class="progress-bar progress-bar-danger hidden-ie" role="progressbar" aria-valuenow="<?=$ghost_mode_percent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$ghost_mode_percent?>%">
											<span class="sr-only"><?=$ghost_mode_percent?>%<span>
											</div>
										</div>
										<p class="list-group-item-text">
											<?=$lang['Ghost_Mode_Explanation']?>
										</p>

									</a>

									<a class="list-group-item" style="background:none;overflow:auto;">
										<img src="<?=$system->getDomain()?>/img/icons/verified.png" class="pull-left mr-10" style="height:50px;width:50px;">
										<h4 class="list-group-item-heading text-special" style="font-size:18px;padding-top:7px;">
											<?=$lang['Verified_Badge']?>
											<?php if($user->is_verified == 0) {
												echo '<button name="enable_2" class="btn btn-theme pull-right" style="color:#fff!important;">'.$lang['Enable'].' (200)</button>';
											} else {
												echo '<button class="btn btn-theme pull-right" style="color:#fff!important;" disabled> <i class="fa fa-fw fa-check-circle" style="color:#fff!important;"></i> '.$lang['Active'].'</button>';
											}
											?>
										</h4>
										<div class="progress progress-striped progress-xs active" style="width:200px;margin-bottom:10px;" data-toggle="tooltip" data-placement="bottom" data-title="<?=$verified_badge_time?>" placeholder="" data-original-title="" title="">
											<div class="progress-bar progress-bar-danger hidden-ie" role="progressbar" aria-valuenow="<?=$verified_badge_percent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$verified_badge_percent?>%">
												<span class="sr-only"><?=$verified_badge_percent?>%<span>
												</div>
											</div>
											<p class="list-group-item-text">
												<?=$lang['Verified_Badge_Explanation']?>
											</p>
										</a>

										<a class="list-group-item" style="background:none;overflow:auto;">
											<img src="<?=$system->getDomain()?>/img/icons/spotlight.png" class="pull-left mr-10" style="height:50px;width:50px;">
											<h4 class="list-group-item-heading text-special" style="font-size:18px;padding-top:7px;">
												<?=$lang['Increased_Exposure']?>
												<?php if($user->is_increased_exposure == 0) {
													echo '<button name="enable_3" class="btn btn-theme pull-right" style="color:#fff!important;">'.$lang['Enable'].' (250)</button>';
												} else {
													echo '<button class="btn btn-theme pull-right" style="color:#fff!important;" disabled> <i class="fa fa-fw fa-check-circle" style="color:#fff!important;"></i> '.$lang['Active'].'</button>';
												}
												?>
											</h4>
											<div class="progress progress-striped progress-xs active" style="width:200px;margin-bottom:10px;" data-toggle="tooltip" data-placement="bottom" data-title="<?=$spotlight_time?>" placeholder="" data-original-title="" title="">
											<div class="progress-bar progress-bar-danger hidden-ie" role="progressbar" aria-valuenow="<?=$spotlight_percent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$spotlight_percent?>%">
												<span class="sr-only"><?=$spotlight_percent?>%<span>
												</div>
											</div>
											<p class="list-group-item-text">
												<?=$lang['Increased_Exposure_Explanation']?>
											</p>
										</a>

										<a class="list-group-item" style="background:none;overflow:auto;">
											<img src="<?=$system->getDomain()?>/img/icons/no-ads.png" class="pull-left mr-10" style="height:50px;width:50px;">
											<h4 class="list-group-item-heading text-special" style="font-size:18px;padding-top:7px;">
												<?=$lang['Disable_Ads']?>
												<?php if($user->has_disabled_ads == 0) {
													echo '<button name="enable_4" class="btn btn-theme pull-right" style="color:#fff!important;">'.$lang['Enable'].' (300)</button>';
												} else {
													echo '<button class="btn btn-theme pull-right" style="color:#fff!important;" disabled> <i class="fa fa-fw fa-check-circle" style="color:#fff!important;"></i> '.$lang['Active'].'</button>';
												}
												?>
											</h4>
											<div class="progress progress-striped progress-xs active" style="width:200px;margin-bottom:10px;" data-toggle="tooltip" data-placement="bottom" data-title="<?=$disable_ads_time?>" placeholder="" data-original-title="" title="">
											<div class="progress-bar progress-bar-danger hidden-ie" role="progressbar" aria-valuenow="<?=$disable_ads_percent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$disable_ads_percent?>%">
												<span class="sr-only"><?=$disable_ads_percent?>%<span>
												</div>
											</div>
											<p class="list-group-item-text">
												<?=$lang['Disable_Ads_Explanation']?>
											</p>
										</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!--/ End body content -->

		</section>

		<!-- Buy Credits Modal -->
		<div class="modal fade" id="buy-credits" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Buy Credits / Upgrade Account</h4>
					</div>
					<div class="modal-body overflow-auto" style="overflow-y:hidden;">

						<div class="col-md-6 pull-left">
							<form action="" method="post">
								<h4 class="text-center"><?=$lang['Buy_Credits']?></h4>
								<hr>
								<div class="form-group">
									<label style="font-size:14px;"><?=$lang['Payment_Method']?></label>
									<select name="payment_method" class="chosen" id="payment_method" onchange="changePaymentMethod()">
										<option value="3"> <?=$lang["Credit_Card"]?> </option>
										<option value="2"> PayPal </option>
										<option value="1"> SMS </option>
									</select>
								</div>
								<div class="form-group" id="credit_select">
									<label style="font-size:14px;"><?=$lang['Credits']?></label>
									<select name="credit_amount" class="form-control">
										<option value="100"> 100 </option>
										<option value="200"> 200 </option>
										<option value="300"> 300 </option>
										<option value="400"> 400 </option>
										<option value="500"> 500 </option>
										<option value="600"> 600 </option>
										<option value="700"> 800 </option>
										<option value="800"> 800 </option>
										<option value="900"> 900 </option>
										<option value="1000"> 1000 </option>
									</select>
								</div>
								<button type="submit" name="continue" class="btn btn-block btn-theme"><?=$lang['Continue']?></button>
							</form>
						</div>

						<div class="col-md-5 pull-right">
							<form action="" method="post">
								<h4 class="text-center"><?=$lang['VIP_Account']?></h4>
								<hr>
								<ul style="list-style:none;">
									<li> <i class="fa fa-check-circle fa-fw"></i> <?=$lang['Ghost_Mode']?> </li>
									<li> <i class="fa fa-check-circle fa-fw"></i> <?=$lang['Verified_Badge']?> </li>
									<li> <i class="fa fa-check-circle fa-fw"></i> <?=$lang['Increased_Exposure']?> </li>
									<li> <i class="fa fa-check-circle fa-fw"></i> <?=$lang['Disable_Ads']?> </li>
								</ul>
								<hr>
								<button type="submit" name="vip_1" class="btn btn-block btn-inverse" value=" " <?php if($user->is_vip == 1) { echo 'disabled'; } ?>><?=$lang['Buy_For_1_Month']?></button>
								<button type="submit" name="vip_3" class="btn btn-block btn-inverse" value=" " <?php if($user->is_vip == 1) { echo 'disabled'; } ?>><?=$lang['Buy_For_3_Months']?></button>
							</form>
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>