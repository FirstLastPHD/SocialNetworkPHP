<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Ads</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Ad Slot #1 (Vertical)</label>
                                <textarea name="ad_1" class="form-control"><?=$ads->ad_1?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font600">Ad Slot #2 (Horizontal)</label>
                                <textarea name="ad_2" class="form-control"><?=$ads->ad_2?></textarea>
                            </div>  
                            Leave a specific ad slot empty if you don't want to use it
                            <br><br>
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                        </div>
                    </div>
                </div>

            </div>
            <!--/ End body content -->

        </section>