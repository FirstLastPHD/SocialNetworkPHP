<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Mass Notification</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php if(isset($success)) { ?> <div class="alert alert-success"> <i class="fa fa-check fa-fw"></i> Notification have been sent succesfully </div> <?php } ?>
                            From here you can send a custom notification to all users of your website <br>
                            <br>
                            <textarea name="notification_content" class="form-control" placeholder="Notification content..." required></textarea>
                            <br>
                            <input type="submit" name="create" class="btn btn-theme" value="Create">
                        </div>
                    </div>
                </div>

            </div>
            <!--/ End body content -->

        </section>