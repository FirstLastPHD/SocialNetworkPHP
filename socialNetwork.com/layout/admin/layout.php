<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Layout Settings</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Skin</label>
                                <select name="skin" class="chosen">
                                    <option value="dark" <?php if($skin == 'dark') { echo'selected'; } ?>> Dark </option>
                                    <option value="light" <?php if($skin == 'light') { echo'selected'; } ?>> Light</option>
                                </select>
                            </div>
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!--/ End body content -->

    </section>