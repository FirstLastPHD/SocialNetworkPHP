<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Edit Page</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Page Title</label>
                                <input type="text" name="page_title" value="<?=$_page->page_title?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">Page Content</label>
                                <textarea name="content" class="textarea form-control" rows="7"><?=$_page->content?></textarea>
                            </div>   
                            <br>
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                        </div>
                    </div>
                </div>

            </div>
            <!--/ End body content -->

        </section>