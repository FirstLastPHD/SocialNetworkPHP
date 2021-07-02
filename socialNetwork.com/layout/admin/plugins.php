<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Plugins</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                                <th class="text-center"> Name </th>
                                <th class="text-center"> Author </th>
                                <th class="text-center"> Version </th>
                                <th class="text-center"> Actions </th>
                            </thead>
                            <tbody>
                                <?php foreach($plugin_list as $item) { ?>
                                <tr>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $item['name']?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $item['author']?></td>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo $item['version']?></td>
                                    <td class="text-center"> 
                                        <?php if($item['status'] == 0) { echo '<a href="?activate=true&path='.$item['path'].'" class="btn btn-danger"> Install </a>'; } else { echo '<a href="?deactivate=true&path='.$item['path'].'" class="btn btn-default"> Uninstall </a>'; } ?> 
                                    </td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                        <?php if(empty($plugin_list)) { echo '<p class="pt-20 text-center"> No plugins detected </p>'; } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/ End body content -->

</section>