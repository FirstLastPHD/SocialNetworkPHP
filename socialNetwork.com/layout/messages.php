<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<?php if(($conversations->num_rows == 0 && isset($_GET['id'])) || ($conversations->num_rows >= 1 && !isset($_GET['id'])) || ($conversations->num_rows >= 1 && isset($_GET['id']))) { ?>
				<div class="panel rounded shadow">
					<div class="panel-body no-padding" style="background:#fff;">
						<?php if($conversations->num_rows >= 1) { ?>
						<div class="col-lg-3 col-md-4 col-sm-4" style="padding:0px">
							<div class="list-group no-margin list-messages">
								<?php 
								while($convers = $conversations->fetch_object()) {
									if($convers->user1 != $user->id) { $other_user = $system->getUserInfo($convers->user1); } 
									elseif($convers->user2 != $user->id) { $other_user = $system->getUserInfo($convers->user2); } 
									?>
									<a href="<?=$system->getDomain()?>/messages.php?id=<?=$other_user->id?>" class="list-group-item <?php if($other_user->id == $id) { echo 'message-tab-active'; } ?>" style="overflow:auto;">
										<img src="<?=$system->getProfilePicture($other_user)?>" class="img-circle pull-left mr-10" style="height:50px;width:50px;">
										<h4 class="list-group-item-heading text-special font600" style="font-size:16px;padding-top:7px;"><?=$system->getFirstName($other_user->full_name)?></h4>
										<p class="emoticon emoticon-small list-group-item-text text-muted">
											<?=$system->truncate($system->secureField($convers->last_message),90)?>
										</p>
									</a>
									<? } ?>
								</div>
							</div>
							<?php
							echo '<div class="col-lg-9 col-md-7 col-sm-8 pull-left" style="border-left:1px solid #eee;">';	
						} else {
							echo '<div class="col-lg-12 col-md-12 col-sm-12" style="border-left:1px solid #eee;">';	
						}
						?>
						<div class="row">
							<div class="well bg-white overflow-auto" style="border-bottom:1px solid #eee;">
								<a href="<?=$system->getDomain()?>/profile.php?id=<?=$second_user->id?>" class="pull-left">
									<img src="<?=$system->getProfilePicture($second_user)?>" class="img-circle pull-left mr-15" style="height:55px;width:55px;">
								</a>
								<div class="pull-left">
									<div class="conversation-widget-name">
										<?php if($system->isOnline($second_user->last_active)) { ?> 
										<span class="badge badge-success badge-circle hand-cursor mb-5" data-toggle="tooltip" data-placement="bottom" data-title="<?=$lang['Online']?>" placeholder="" data-original-title="" title="" style="display:inline-block;">&nbsp</span> 
										<?php } else { ?> 
										<span class="badge badge-danger badge-circle hand-cursor mb-5" data-toggle="tooltip" data-placement="bottom" data-title="<?=sprintf($lang['Last_Active'],$system->timeAgo($lang,$second_user->last_active))?>" placeholder="" data-original-title="" title="" style="display:inline-block;">&nbsp</span> 
										<?php } ?>
										<span class="text-special font600"> <?=$system->getFirstName($second_user->full_name)?> </span>
									</div>
									<p class="conversation-widget-info text-muted mb-0"> <?=$second_user->age?> • <?=$second_user->city?><?=$system->ifComma($second_user->city)?> <?=$second_user->country?> </p>
								</div>
								<div class="pull-right">
									<button class="btn btn-circle btn-default btn-stroke" data-toggle="modal" data-target="#conversation-actions"><i class="fa fa-ellipsis-h"></i></button>
								</div>
								<br>
							</div>
							<?php
							if(isset($blocked_msg)) {
								echo '<div class="alert alert-danger" style="border-radius:0px;"> <i class="fa fa-fw fa-times-circle"></i> '.$blocked_msg.'</div>';
							}
							?>
							<div class="conversation-message-list fbphotobox" onclick="hideEmoticons()">
								<div class="conversation-content">
									<?php
									if($messages->num_rows >= 1) { 
										while($message = $messages->fetch_object()) { 
											$sender = $system->getUserInfo($message->sender_id);
											?>
											<div class="row">
												<div class="conversation-message pull-left">
													<div class="pull-left">
														<img src="<?=$system->getProfilePicture($sender)?>" class="img-circle pull-left" style="height:50px;width:50px;">
													</div>
													<div class="well bg-grey pull-left emoticon-small fbphotobox">
														<?php
														if($message->is_sticker == 1) {
															$sticker = $db->query("SELECT * FROM stickers WHERE id='".$message->sticker_id."'");
															$sticker = $sticker->fetch_object();
															echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" style="height:80px;width:80px">';
														} elseif($message->is_photo == 1) {
															echo '
															<a href="#">
															<img fbphotobox-src="'.$system->getDomain().'/uploads/'.$message->photo_path.'" src="'.$system->getDomain().'/uploads/'.$message->photo_path.'" class="img-responsive photo" style="max-height250px;max-width:250px;">
															</a>
															';
														} else {
															$message->message = $system->secureField($system->smart_wordwrap($message->message));
															echo Emojione\Emojione::shortnameToImage($message->message);
														}
														?>
													</div>
												</div>
											</div>
											<? 
										} 
									}
									?>
								</div>
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="conversation-input">
									<div class="row">
										<div class="input-group">
											<input type="text" id="message" placeholder="<?=$lang["Enter_Message"]?>" class="form-control input-lg message-input no-border" required>
											<span class="input-group-btn">
												<a href="#" class="btn btn-default btn-lg no-border" onclick="toggleEmoticons()"><img src="<?=$system->getDomain()?>/img/icons/emoticon-icon.png" style="width:15px;height:15px;"></a>
												<a href="#" class="btn btn-default btn-lg no-border" data-toggle="modal" data-target="#photo-upload"><img src="<?=$system->getDomain()?>/img/icons/image-icon.png" style="width:15px;height:15px;"></a>
												<a href="#" class="btn btn-default btn-lg no-border" data-toggle="modal" data-target="#send-gift"><i class="fa fa-fw fa-gift"></i></a>
											</span>
										</div>
									</div>
								</div>
							</div>

							<br>

							<!-- Stickers & Emoticons -->
							<div class="emoticon-box">
								<div class="panel rounded shadow">
									<div class="emoticon-scroll panel-body no-padding emoticon-big">
									</div>	
									<div class="panel-footer no-padding">
										<a href="#" class="emoticon-box-control emoticon-toggle active" onclick="loadEmoticons()"><img src="<?=$system->getDomain()?>/img/icons/emoticon-icon.png" style="width:15px;height:15px;"></a>
										<?php
										while($owned_sticker_pack = $owned_sticker_packs->fetch_object()) {
											$sticker_pack = $db->query("SELECT * FROM sticker_packs WHERE id='".$owned_sticker_pack->pack_id."'");
											$sticker_pack = $sticker_pack->fetch_object();	
											?>
											<a href="#" class="emoticon-box-control sticker-pack-<?=$sticker_pack->id?>" onclick="loadStickers(<?=$sticker_pack->id?>)"><img src="<?=$system->getDomain()?>/img/stickers/<?=$sticker_pack->id?>/<?=$sticker_pack->cover?>" style="width:25px;height:25px;"></a>
											<? } ?>
											<a href="#" class="emoticon-box-control" onclick="toggleStore()"><img src="<?=$system->getDomain()?>/img/icons/shopping-cart-icon.png" style="width:15px;height:15px;"></a>
										</div>
									</div>
								</div>

								<input type="hidden" id="conversation_id" value="<?=$convers_id?>">

							</div>
						</div>
					</div>
					<? } else { ?>
					<h2 class="text-special mb-20 mt-5" style="font-size:25px;"> <?=$lang['Messages']?> </h2>
					<div class="panel rounded">
						<div class="panel-body">
							<?=$lang['No_New_Messages']?>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
			
		</div>

	</div>
	<!--/ End body content -->

</section>

<!-- Sticker Store -->
<div class="modal fade" id="sticker-store" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?=$lang['Sticker_Store']?></h4>
				</div>
				<div class="modal-body">
					<div class="sticker-store-content"> 
						<?php 
						while($sticker_pack = $sticker_packs->fetch_object()) { 
							?>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<div class="sticker-store-item panel rounded shadow">
									<div class="panel-body text-center">
										<img src="<?=$system->getDomain()?>/img/stickers/<?=$sticker_pack->id?>/<?=$sticker_pack->cover?>" style="width:70px;height:70px;" class="centered-block mb-5">
										<div class="clearfix"></div>
										<span style="font-size:12px;font-weight:600;"><?=$sticker_pack->name?></span>
									</div>
									<div class="panel-footer">
										<div class="add-sticker-pack-<?=$sticker_pack->id?>">
											<?php
											$check = $db->query("SELECT * FROM owned_sticker_packs WHERE pack_id='".$sticker_pack->id."' AND user_id='".$user->id."'");
											if($check->num_rows >= 1) {
												echo '<a href="#" class="btn btn-theme btn-xs btn-block" onclick="addStickerPack('.$sticker_pack->id.','.$user->id.')"> '.$lang['Remove'].' </a>';
											} else {
												echo '<a href="#" class="btn btn-theme btn-xs btn-block" onclick="addStickerPack('.$sticker_pack->id.','.$user->id.')"> '.$lang['Add'].' </a>';
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<? } ?>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Block User Modal -->
	<div class="modal fade" id="block-user" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?=$lang['Block']?></h4>
					</div>
					<div class="modal-body text-center">
						<img src="<?=$system->getProfilePicture($second_user)?>" class="img-circle center-block mb-10" style="height:70px;width:70px;">
						<?=sprintf($lang['Block_Confirm'],$system->getFirstName($second_user->full_name))?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
						<button type="submit" name="block_user" class="btn btn-theme"><?=$lang['Continue']?></button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Send Gift Modal -->  
	<div class="modal fade" id="send-gift" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Send Gift</h4>
					</div>
					<div class="modal-body overflow-auto">
						<?php if($send_gift == 'disabled') { ?> 
						<div class="alert alert-danger"> <i class="fa fa-warning fa-fw"></i> <a href="<?=$system->getDomain()?>/upgrades" style="color:#fff;"> You need at least <b>50 Credits</b> to send a gift </a> </div> 
						<?php } else { ?>
						<div class="alert alert-warning"> <i class="fa fa-info-circle fa-fw"></i> <a href="<?=$system->getDomain()?>/upgrades" style="color:#fff;"> Each gift costs <b>50 Credits</b> </a> </div>
						<? } ?>
						<div class="gift-selection">
							<img src="<?=$system->getDomain()?>/img/gifts/1.png" id="gift1" class="gift-image img-responsive pull-left" onclick="selectGift(1)">
							<img src="<?=$system->getDomain()?>/img/gifts/2.png" id="gift2" class="gift-image img-responsive pull-left" onclick="selectGift(2)">
							<img src="<?=$system->getDomain()?>/img/gifts/3.png" id="gift3" class="gift-image img-responsive pull-left" onclick="selectGift(3)">
							<img src="<?=$system->getDomain()?>/img/gifts/4.png" id="gift4" class="gift-image img-responsive pull-left" onclick="selectGift(4)">
							<img src="<?=$system->getDomain()?>/img/gifts/5.png" id="gift5" class="gift-image img-responsive pull-left" onclick="selectGift(5)">
							<img src="<?=$system->getDomain()?>/img/gifts/6.png" id="gift6" class="gift-image img-responsive pull-left" onclick="selectGift(6)">
							<img src="<?=$system->getDomain()?>/img/gifts/7.png" id="gift7" class="gift-image img-responsive pull-left" onclick="selectGift(7)">
							<img src="<?=$system->getDomain()?>/img/gifts/8.png" id="gift8" class="gift-image img-responsive pull-left" onclick="selectGift(8)">
							<img src="<?=$system->getDomain()?>/img/gifts/9.png" id="gift9" class="gift-image img-responsive pull-left" onclick="selectGift(9)">
							<img src="<?=$system->getDomain()?>/img/gifts/10.png" id="gift10" class="gift-image img-responsive pull-left" onclick="selectGift(10)">
							<img src="<?=$system->getDomain()?>/img/gifts/11.png" id="gift11" class="gift-image img-responsive pull-left" onclick="selectGift(11)">
							<img src="<?=$system->getDomain()?>/img/gifts/12.png" id="gift12" class="gift-image img-responsive pull-left" onclick="selectGift(12)">
							<img src="<?=$system->getDomain()?>/img/gifts/13.png" id="gift13" class="gift-image img-responsive pull-left" onclick="selectGift(13)">
							<img src="<?=$system->getDomain()?>/img/gifts/14.png" id="gift14" class="gift-image img-responsive pull-left" onclick="selectGift(14)">
							<img src="<?=$system->getDomain()?>/img/gifts/15.png" id="gift15" class="gift-image img-responsive pull-left" onclick="selectGift(15)">
							<img src="<?=$system->getDomain()?>/img/gifts/16.png" id="gift16" class="gift-image img-responsive pull-left" onclick="selectGift(16)">
							<img src="<?=$system->getDomain()?>/img/gifts/17.png" id="gift17" class="gift-image img-responsive pull-left" onclick="selectGift(17)">
							<img src="<?=$system->getDomain()?>/img/gifts/18.png" id="gift18" class="gift-image img-responsive pull-left" onclick="selectGift(18)">
							<img src="<?=$system->getDomain()?>/img/gifts/19.png" id="gift19" class="gift-image img-responsive pull-left" onclick="selectGift(19)">
							<img src="<?=$system->getDomain()?>/img/gifts/20.png" id="gift20" class="gift-image img-responsive pull-left" onclick="selectGift(20)">
							<img src="<?=$system->getDomain()?>/img/gifts/21.png" id="gift21" class="gift-image img-responsive pull-left" onclick="selectGift(21)">
							<img src="<?=$system->getDomain()?>/img/gifts/22.png" id="gift22" class="gift-image img-responsive pull-left" onclick="selectGift(22)">
							<img src="<?=$system->getDomain()?>/img/gifts/23.png" id="gift23" class="gift-image img-responsive pull-left" onclick="selectGift(23)">
							<img src="<?=$system->getDomain()?>/img/gifts/24.png" id="gift24" class="gift-image img-responsive pull-left" onclick="selectGift(24)">
							<img src="<?=$system->getDomain()?>/img/gifts/25.png" id="gift25" class="gift-image img-responsive pull-left" onclick="selectGift(25)">
							<img src="<?=$system->getDomain()?>/img/gifts/26.png" id="gift26" class="gift-image img-responsive pull-left" onclick="selectGift(26)">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
						<button type="submit" name="send_gift" class="btn btn-danger" <?=$send_gift?>><?=$lang['Continue']?></button>
					</div>
				</div>
				<input type="hidden" id="giftValue" name="giftValue">
			</form>
		</div>
	</div>

	<!-- Conversation Actions Modal -->  
	<div class="modal fade" id="conversation-actions" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<form action="" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?=$lang['Actions']?></h4>
					</div>
					<div class="modal-body overflow-auto no-padding">
						<ul class="list-group no-margin" onclick="closeConvActionMenu()">
							<a href="<?=$system->getDomain()?>/messages.php?id=<?=$second_user->id?>/delete" class="list-group-item"> <?=$lang['Delete_Conversation']?> </a>
							<?php
							if(!isset($has_blocked)) {
								echo '<a href="#" data-toggle="modal" data-target="#block-user" class="list-group-item">'.$lang['Block'].'</a>';
							} else {
								echo '<a href="'.$system->getDomain.'/messages.php?id='.$second_user->id.'/unblock" class="list-group-item">'.$lang['Unblock'].'</a>';	
							}
							?>
						</ul>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Send Photo -->
	<div class="modal fade" id="photo-upload" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<form action="" enctype="multipart/form-data" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Send Photo</h4>
					</div>
					<div class="modal-body text-center">
						<div class="alert alert-danger" id="photo-upload-error" style="display:none;"></div>
						<a href="#" class="photo-upload-select no-underline text-muted" onclick="selectPhoto()"> <i class="fa fa-fw fa-image"></i> <?=$lang['Select_Photo']?> </a>
						<div class="clearfix"></div>
						<img src="" class="photo-upload-preview img-rounded" style="display:none;margin-top:15px !important;max-width:312px;max-height:312px;">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
						<button type="submit" name="upload" class="btn btn-theme" id="upload-btn">Send</button>
					</div>
				</div>
				<input type="file" id="photo_file" name="photo_file" onchange="photoChange(this)">
			</form>
		</div>
	</div>