<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Add Page</h3>
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
                                <textarea name="content" class="textarea form-control"></textarea>
                            </div>
                            <br>
                            <input type="submit" name="add" class="btn btn-theme" value="Add">
                        </div>
                    </div>
                </div>

            </div>
            <!--/ End body content -->

        </section>