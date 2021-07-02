<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Payments API Settings</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">Fortumo Service ID</label>
                                <input type="text" name="fortumo_service_id" value="<?php echo $fortumo_service_id?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">PayPal Account</label>
                                <input type="text" name="paypal_email" value="<?php echo $paypal_email?>" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label class="font600">Stripe Secret Key</label>
                                <input type="text" name="secret_key" value="<?php echo $secret_key?>" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label class="font600">Stripe Publishable Key</label>
                                <input type="text" name="publishable_key" value="<?php echo $publishable_key?>" class="form-control">
                            </div>  
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                            </form> 
                        </div>
                    </div>
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Payments</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                           <?php if($payments->num_rows >= 1) { ?>
                           <table class="table table-responsive">
                             <thead>
                                <th style="text-align:center;"> Item </th>
                                <th style="text-align:center;"> Amount </th>
                                <th style="text-align:center;"> Payment Method </th>
                            </thead>
                            <tbody>
                                <?php while($payment = $payments->fetch_object()) { ?>
                                <tr>
                                    <td style="vertical-align:middle;text-align:center;"> <?=$payment->transaction_name?> </td>
                                    <td style="vertical-align:middle;text-align:center;"> <?=$payment->transaction_amount?> </td>
                                    <td style="vertical-align:middle;text-align:center;">  <?php if($payment->method == 1) { echo 'PayPal'; } elseif($payment->method == 2) { echo 'Credit Card'; } else { echo 'SMS'; } ?> </td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                        <? 
                    } else { 
                        echo '<p> No payments have been made </p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/ End body content -->

</section>