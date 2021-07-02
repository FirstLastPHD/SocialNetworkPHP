<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <a href="add-page.php" class="btn btn-theme pull-left mb-20"> <i class="fa fa-plus"></i> Add Page </a>
                <?php if($pages->num_rows >= 1) { ?>
                <table class="table table-responsive">
                 <thead>
                    <th style="text-align:center;"> # </th>
                    <th style="text-align:center;"> Title </th>
                    <th style="text-align:center;"> Actions </th>
                </thead>
                <tbody>
                    <?php while($page = $pages->fetch_object()) { ?>
                    <tr>
                        <td style="vertical-align:middle;width:100px;text-align:center;"> <?=$page->id?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$page->page_title?> </td>
                        <td style="vertical-align:middle;text-align:center;">
                            <a href="<?=$system->getDomain()?>/page.php/<?=$page->id?>" class="btn btn-theme"> <i class="fa fa-eye" style="color:#fff;"></i> </a> 
                            <a href="edit-page.php?id=<?=$page->id?>" class="btn btn-theme"> <i class="fa fa-pencil" style="color:#fff;"></i> </a> 
                            <a href="?delete=true&delid=<?=$page->id?>" class="btn btn-theme"> <i class="fa fa-trash" style="color:#fff;"></i> </a>
                        </td>
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