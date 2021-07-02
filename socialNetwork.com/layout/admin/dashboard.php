<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-users fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong"><?=number_format($user_count)?> Users</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-money fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong"><?=number_format($purchase_count)?> Payments</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-info-circle fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong">Newest Version</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">System Status</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <p>Verifying the <b>Geolocation API</b>... <span class="text-success">success</span></p>
                            <p>Retrieving pictures from <b>Instagram</b>... <span class="text-success">success</span></p>
                            <p>Verifying file and folder permissions... <span class="text-success">success</span></p>
                            <p>Cleaning junk files and cache... <span class="text-success">success</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!--/ End body content -->

</section>