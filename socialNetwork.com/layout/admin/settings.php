<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">General Settings</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Website Name</label>
                                <input type="text" name="site_name" value="<?=$site_name?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">Website Keywords</label>
                                <textarea name="meta_keywords" class="form-control"><?=$meta['keywords']?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font600">Website Description</label>
                                <textarea name="meta_description" class="form-control"><?=$meta['description']?></textarea>
                            </div> 
                            <div class="form-group">
                                <label class="font600">Minimum Registration Age</label>
                                <select name="minimum_age" class="chosen" required>
                                    <?php for($i = 16; $i <= 100; $i++) { ?>
                                    <?php if($minimum_age == $i) { ?>
                                    <option value="<?php echo $i?>" selected> <?php echo $i?> </option>
                                    <? } else { ?>
                                    <option value="<?php echo $i?>"> <?php echo $i?> </option>
                                    <? } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font600">Email Sender</label>
                                <input type="text" name="email_sender" value="<?=$email_sender?>" class="form-control"> <br> The email from which all system emails will be sent 
                            </div>


                        </div>
                    </div>
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Units of Measurement</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Height</label>
                                <select name="unit_height" class="chosen">
                                    <option value="cm" <?php if($unit['height'] == 'cm') { echo 'selected'; } ?>> cm </option>
                                    <option value="ft" <?php if($unit['height'] == 'ft') { echo 'selected'; } ?>> ft </option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label class="font600">Weight</label>
                                <select name="unit_weight" class="chosen">
                                    <option value="kg" <?php if($unit['weight'] == 'kg') { echo 'selected'; } ?>> kg </option>
                                    <option value="lbs" <?php if($unit['weight'] == 'lbs') { echo 'selected'; } ?>> lbs </option>
                                </select>
                            </div> 
                        </div>
                    </div>
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Social Login API Settings</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                           <div class="form-group">
                            <label class="font600">Facebook App ID</label>
                            <input type="text" name="fb_app_id" value="<?php echo $fb_app_id?>" class="form-control">
                        </div> 
                        <div class="form-group">
                            <label class="font600">Facebook App Secret Key</label>
                            <input type="text" name="fb_secret_key" value="<?php echo $fb_secret_key?>" class="form-control">
                        </div>   
                    </div>
                </div>
                <input type="submit" name="save" class="btn btn-theme" value="Save">
            </form>
        </div>

    </div>
    <!--/ End body content -->

</section>