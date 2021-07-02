<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="dropdown">
                    <button class="btn btn-theme dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Quick Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="?quick_actions=true&action=2">Set all users as online</a></li>
                        <li><a href="?quick_actions=true&action=3">Set all fake users as online</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="?quick_actions=true&action=1">Delete all fake users</a></li>
                        <li><a href="?quick_actions=true&action=4">Delete all users without a profile photo</a></li>
                    </ul>
                </div>        
                <br>
                <?php if(isset($_GET['success'])) { echo '<div class="alert alert-success"> <i class="fa fa-check-circle fa-fw"></i> Changes to the user have been successfully saved  </div>'; } ?>
                <?php if($users->num_rows >= 1) { ?>
                <table class="table table-responsive">
                 <thead>
                    <th style="text-align:center;"> # </th>
                    <th style="text-align:center;"> Profile Picture </th>
                    <th style="text-align:center;"> Full Name </th>
                    <th style="text-align:center;"> Email </th>
                    <th style="text-align:center;"> Country </th>
                    <th style="text-align:center;"> Credits </th>
                    <th style="text-align:center;"> Join Date </th>
                    <th style="text-align:center;"> Actions </th>
                </thead>
                <tbody>
                    <?php while($user = $users->fetch_object()) { ?>
                    <tr>
                        <td style="vertical-align:middle;width:100px;text-align:center;"> <?=$user->id?> </td>
                        <td style="vertical-align:middle;width:150px;text-align:center;"> <img src="<?=$system->getProfilePicture($user)?>" class="img-circle" style="height:60px;width:60px"> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$user->full_name?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$user->email?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$user->country?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$user->credits?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=date("F j, Y",$user->registered)?> </td> 
                        <td style="vertical-align:middle;text-align:center;">
                            <a href="<?=$system->getDomain()?>/profile.php?id=<?=$user->id?>" class="btn btn-theme"> <i class="fa fa-eye" style="color:#fff;"></i> </a>
                           <a href="edit-user.php?id=<?=$user->id?>" class="btn btn-theme"> <i class="fa fa-pencil" style="color:#fff;"></i> </a>
                           <a href="?delete=true&delid=<?=$user->id?>" class="btn btn-theme"> <i class="fa fa-trash" style="color:#fff;"></i> </a> </td>
                       </tr>
                       <? } ?>
                   </tbody>
               </table>
               <? } ?>

           </div>
       </div>

   </div>
   <!--/ End body content -->

</section>