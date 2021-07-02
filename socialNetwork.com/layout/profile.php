<section id="page-content">

  <!-- Start body content -->
  <div class="body-content animated fadeIn">

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="well bg-white overflow-auto mb-0" style="border-bottom:1px solid #eee;">
          <a href="<?=$system->getDomain()?>/profile.php?id=<?=$profile->id?>" class="pull-left">
            <img src="<?=$system->getProfilePicture($profile)?>" class="img-circle pull-left mr-15" style="height:60px;width:60px;">
          </a>
          <div class="pull-left">
            <div class="conversation-widget-name">
              <?php if($system->isOnline($profile->last_active)) { ?> 
              <span class="badge badge-success badge-circle hand-cursor mb-5" data-toggle="tooltip" data-placement="bottom" data-title="<?=$lang['Online']?>" placeholder="" data-original-title="" title="" style="display:inline-block;">&nbsp</span> 
              <?php } else { ?> 
              <span class="badge badge-danger badge-circle hand-cursor mb-5" data-toggle="tooltip" data-placement="bottom" data-title="<?=sprintf($lang['Last_Active'],$system->timeAgo($lang,$profile->last_active))?>" placeholder="" data-original-title="" title="" style="display:inline-block;">&nbsp</span> 
              <?php } ?>
              <span style="font-size:19px;"> 
                <span class="text-special font600"><?=$system->getFirstName($profile->full_name)?>, <?=$profile->age?></span>
                <?php if($profile->is_verified == 1 || $profile->vip_expiration >= time()) { 
                  echo '<i class="fa fa-check text-info" data-toggle="tooltip" data-placement="bottom" data-title="'.$lang['Verified_User'].'" placeholder="" data-original-title="" title=""></i>'; 
                } ?>
              </span>
            </div>
            <p class="conversation-widget-info text-muted mb-0"> <?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?></p>
          </div>
          <div class="pull-right">
            <div id="heart-<?=$profile->id?>" onclick="likeProfile(<?=$profile->id?>)" class="pull-left">
              <?php 
              $check = $db->query("SELECT id FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
              <?php if($check->num_rows == 0) { ?>
              <button class="btn btn-circle btn-danger btn-stroke mr-5"><i class="fa fa-heart"></i></button>
              <?php } else { ?>
              <button class="btn btn-circle btn-danger btn-stroke mr-5" style="color:#fff;background-color:#e9573f;"><i class="fa fa-heart"></i></button>
              <?php } ?>
            </div>
          </div>
          <br>
        </div>
      </div>
    </div>

  <div class="row">
    <?php if($private_profile == true) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="well bg-white overflow-auto text-center">
        <br>
        <big class="font600">
          <i class="fa fa-fw fa-lock"></i> <?=$lang['This_Profile_Is_Private']?>
        </big>
        <br><br>
        <div class="col-lg-3 col-md-7 col-sm-3 col-centered">
          <div class="btn-group-vertical btn-block">
            <?php if($profile->id != $user->id) { ?>
            <?php if($is_friend == 0 && $sent_request == 1) { ?>
            <a href="#" class="btn btn-theme btn-block text-center mb-5 disabled"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i><?=$lang['Friend_Request_Sent']?></a>
            <?php } elseif($is_friend == 1 && $sent_request == 0) { ?>
            <a href="#" class="btn btn-theme btn-block text-center mb-5 disabled"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i><?=sprintf($lang['Is_Your_Friend'],$system->getFirstName($profile->full_name))?></a>
            <?php } elseif($is_friend == 0 && $sent_request == 0) { ?>
            <div id="friendArea" onclick="sendFriendRequest(<?=$user->id?>,<?=$profile->id?>)">
              <a href="#" class="btn btn-theme btn-block text-center mb-5"><i class="fa fa-user-plus pull-right" style="line-height:20px;"></i><?=$lang['Add_As_Friend']?></a>
            </div>
            <?php } ?>
            <a href="<?=$system->getDomain()?>/messages.php?id=<?=$profile->id?>" class="btn btn-theme btn-block text-center" style="margin-bottom:5px;"><i class="fa fa-envelope pull-right" style="line-height:20px;"></i><?=$lang['Message']?></a>
            <a href="#" class="btn btn-theme btn-block text-center mb-5" data-toggle="modal" data-target="#send-gift"><i class="fa fa-gift pull-right" style="line-height:20px;"></i><?=$lang['Send_Gift']?></a>
            <?php } else { ?>
            <a href="<?=$system->getDomain()?>/settings.php" class="btn btn-theme btn-block text-center" style="margin-bottom:5px;"><i class="fa fa-cog pull-right" style="line-height:20px;"></i><?=$lang['Settings']?></a>
            <? } ?>
          </div>
        </div>
        <br>
      </div>
    </div>
    <?php } else { ?>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12" style="padding-right:20px!important;padding-left:20px!important;">
        <?php 
        if(!empty($photos)) { 
          echo '<ul class="fbphotobox profile-gallery">';
          if($profile->id == $user->id) {
            $self = true;
            $start = -1;
          } else {
            $self = false;
            $start = 0;
          }
          for($i = $start; $i < count($photos); $i++) {
            if($i == $start && $self == true) {
              echo '
              <li>
              <a href="#" data-toggle="modal" data-target="#photo-upload">
              <img src="'.$system->getDomain().'/img/blank-photo-add.png" style="height:150px;">
              </a>
              </li>
              ';
            } else {
              if($photos[$i]['type'] == 'instagram') { 
                echo '
                <li>
                <a href="#">
                <img fbphotobox-src="'.$photos[$i]['path'].'" src="'.$photos[$i]['path'].'" class="photo" style="height:150px;">
                </a>
                </li>
                ';
              } else {
                echo '
                <li>
                <a href="#">
                <img fbphotobox-src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" data-id="'.$photos[$i]['id'].'" class="photo" style="height:150px;">
                </a>
                </li>
                ';
              } 
            }
          }
          echo '</ul>';
        } else {
         echo '<ul class="profile-gallery">';
         for($i = 0; $i <= 20; $i++) {
          if($i == 0) {
            if($user->id == $profile->id) {
              echo '
              <li>
              <a href="#" data-toggle="modal" data-target="#photo-upload">
              <img src="'.$system->getDomain().'/img/blank-photo-add.png" style="height:150px;">
              </a>
              </li>
              ';
            } else {
              echo '
              <li>
              <img src="'.$system->getDomain().'/img/blank-photo-first.png" style="height:150px;">
              </li>
              ';
            }
          } else {
            echo '
            <li>
            <img src="'.$system->getDomain().'/img/blank-photo.png" style="height:150px;">
            </li>
            ';
          }
        }
        echo '</ul>';
      }
      ?>
    </div>
  </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="well bg-white overflow-auto">
        <div class="col-lg-9 col-md-9 col-sm-9">
          <h4 class="font600"><?=$lang['Location']?></h4>
          <p><?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?> <?php if($distance > 0 && $user->id != $profile->id) { echo '(~'.sprintf($lang['km_away'],ceil($distance)).')'; } ?>
          </p>
          <hr>
          <h4 class="font600"><?=$lang['Description']?></h4> 
          <?php
          if(!empty($profile->bio)) {
            echo $profile->bio;
          } else {
            echo $lang['Nothing_To_Show'];
          }
          ?>
          <hr>
          <h4 class="font600"><?=$lang['Friends']?></h4>
          <?php 
          if($friends->num_rows >= 1) {
            while($friend = $friends->fetch_object()) { 
              $friend_info = $db->query("SELECT id,profile_picture,age,full_name,last_active,city,country FROM users WHERE (id='".$friend->user1."' OR id='".$friend->user2."') AND id != '".$id."'");
              $friend_info = $friend_info->fetch_object();
              echo '
              <a href="'.$system->getDomain().'/profile.php?id='.$friend_info->id.'">
              <img src="'.$system->getProfilePicture($friend_info).'" class="img-circle" style="height:45px;width:45px;" data-toggle="tooltip" data-placement="bottom" data-title="'.$system->getFirstName($friend_info->full_name).'" placeholder="" data-original-title="" title="">
              </a>
              ';
            } 
          } else { 
            echo $lang['Nothing_To_Show'];
          }
          ?>
          <hr>
          <h4 class="font600"><?=$lang['Interests']?></h4>
          <?php
          if(!empty($profile->interests)) {
            $interests = explode(',',$profile->interests);
            foreach($interests as $interest) {
              echo '<div class="interest-item badge">'.$interest.'</div>';
            }
          } else {
            echo $lang['Nothing_To_Show'];
          }
          ?>
          <hr>
          <h4 class="font600"><?=$lang['About']?></h4> 
          <?=$lang['Gender']?>: <?=$lang[$profile->gender]?> <br>
          <?=$lang['Sexual_Orientation']?>: <?=$lang[$sexual_orientation]?> <br>
          <?=$lang['Height']?>: <?=$profile->height?> <?=$unit['height']?> <br>
          <?=$lang['Weight']?>: <?=$profile->weight?> <?=$unit['weight']?>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3">
          <h4 class="font600"><?=$lang['Gifts']?></h4>
          <?php 
          if($gifts->num_rows >= 1) {
            while($gift = $gifts->fetch_object()) {
              $sender = $system->getUserInfo($gift->user1);
              echo '<a href="'.$system->getDomain().'/profile.php?id='.$sender->id.'">';
              echo '<img src="'.$system->getDomain().'/img/gifts/'.$gift->path.'" class="img-responsive gift-image-small pull-left" data-toggle="tooltip" data-placement="bottom" data-title="'.sprintf($lang['Gift_From'],$system->getFirstName($sender->full_name)).'" placeholder="" data-original-title="" title="">';
              echo '</a>';
            }
          } else { 
            echo sprintf($lang['Has_Not_Received_Gifts'],$system->getFirstName($profile->full_name)); 
          } 
          ?>
          <div class="clearfix"></div>
          <hr>
          <h4 class="font600"> Statistics </h4>
          <?=sprintf($lang["User_Stats"],$system->getFirstName($profile->full_name),$profile_views->num_rows,$profile_likes->num_rows)?>
          <div class="clearfix"></div>
          <hr>
          <div class="btn-group-vertical btn-block">
            <?php
            if($profile->id != $user->id) { 
              if($is_friend == 0 && $sent_request == 1) { 
                if($is_sender == 1) {
                  echo '
                  <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'cancel_request\')">
                  <a href="#" class="btn btn-theme btn-block text-center mb-5">
                  <i class="fa fa-user-times pull-right lh20"></i>
                  '.$lang['Cancel_Friend_Request'].'
                  </a>
                  </div>
                  ';
                } else {
                  echo '
                  <div id="friendArea">
                  <a href="#" class="btn btn-theme btn-block text-center mb-5" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'accept_request\')">
                  <i class="fa fa-user-plus pull-right lh20"></i>
                  '.$lang['Accept_Friend_Request'].'
                  </a>
                  <a href="#" class="btn btn-theme btn-block text-center mb-5" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'cancel_request\')">
                  <i class="fa fa-user-times pull-right lh20"></i>
                  '.$lang['Cancel_Friend_Request'].'
                  </a>
                  </div>
                  ';  
                }
              } elseif($is_friend == 1 && $sent_request == 0) { 
                echo '
                <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'unfriend\')">
                <a href="#" class="btn btn-theme btn-block text-center mb-5">
                <i class="fa fa-user-times pull-right lh20"></i>
                '.$lang['Unfriend'].'
                </a>
                </div>
                ';
              } elseif($is_friend == 0 && $sent_request == 0) { 
                echo '
                <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'send_request\')">
                <a href="#" class="btn btn-theme btn-block text-center mb-5">
                <i class="fa fa-user-plus pull-right lh20"></i>
                '.$lang['Add_As_Friend'].'
                </a>
                </div>
                ';
              } 
              echo '
              <a href="'.$system->getDomain().'/messages.php?id='.$profile->id.'" class="btn btn-theme btn-block text-center mb-5">
              <i class="fa fa-envelope pull-right lh20"></i>
              '.$lang['Message'].'
              </a>';
              echo '
              <a href="#" class="btn btn-theme btn-block text-center mb-5" data-toggle="modal" data-target="#send-gift">
              <i class="fa fa-gift pull-right lh20"></i>
              '.$lang['Send_Gift'].'
              </a>';
            } else { 
              echo '
              <a href="'.$system->getDomain().'/settings.php" class="btn btn-theme btn-block text-center mb-5">
              <i class="fa fa-cog pull-right lh20"></i>
              '.$lang['Settings'].'
              </a>
              ';
              echo '
              <a data-toggle="modal" data-target="#manage-photos" class="btn btn-theme btn-block text-center mb-5">
              <i class="fa fa-image pull-right lh20"></i>
              '.$lang['Manage_Photos'].'
              </a>
              ';
            } 
            ?>
          </div>
        </div>
      </div>
    </div>
    <? } ?>
  </div>

</div>
<!--/ End body content -->

</section>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photo-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="" enctype="multipart/form-data" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$lang['Photo_Upload']?></h4>
        </div>
        <div class="modal-body text-center">
          <div class="alert alert-danger" id="photo-upload-error" style="display:none;"></div>
          <a href="#" class="photo-upload-select no-underline text-muted" onclick="selectPhoto()"> <i class="fa fa-fw fa-image"></i> <?=$lang['Select_Photo']?> </a>
          <div class="clearfix"></div>
          <img src="" class="photo-upload-preview img-rounded" style="display:none;margin-top:15px !important;max-width:312px;max-height:312px;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
          <button type="submit" name="upload" class="btn btn-theme" id="upload-btn"><?=$lang['Upload']?></button>
        </div>
      </div>
      <input type="file" id="photo_file" name="photo_file" onchange="photoChange(this)">
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
          <h4 class="modal-title"><?=$lang['Send_Gift']?></h4>
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

<!-- Manage Photos Modal -->  
<div class="modal fade" id="manage-photos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$lang['Manage_Photos']?></h4>
        </div>
        <div class="modal-body overflow-auto text-center">
         <?php
         $c=0;
         if(!empty($photos)) {
          for($i = 0; $i < count($photos); $i++) {
            if($photos[$i]['type'] == 'instagram') { 

            } else {
              $c++;
              echo '<div class="col-sm-3 col-md-3 col-lg-3 thumbnail m-5">';
              echo '<div class="image-container">';
              echo '<img src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" class="img-responsive">';
              echo '
              <div class="caption">
              <h4>
              <a href="#" onclick="deletePhoto('.$photos[$i]['id'].')" class="no-underline pull-left"> <i class="fa fa-trash" data-toggle="tooltip" data-placement="right" data-title="'.$lang['Delete_Photo'].'" placeholder="" data-original-title="" title=""></i> </a>
              <a href="#" onclick="setAsProfilePhoto('.$photos[$i]['id'].')" class="no-underline pull-right"> <i class="fa fa-user" data-toggle="tooltip" data-placement="left" data-title="'.$lang['Profile_Photo'].'" placeholder="" data-original-title="" title=""></i> </a>
              </h4>
              </div>
              ';
              echo '</div>';
              echo '</div>';
            }
          }
        }
          if($c==0) {
          echo 'No photos to show';
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
      </div>
    </div>
    <input type="hidden" id="giftValue" name="giftValue">
  </form>
</div>
</div>

<input type="hidden" id="photo_id">
<input type="hidden" id="photo_url">
<input type="hidden" id="profile_id" value="<?=$profile->id?>">