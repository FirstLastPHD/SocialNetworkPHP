<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<h2 class="text-special mb-20 mt-5" style="font-size:25px;"> Process Payment </h2>
				<div class="panel rounded shadow">
					<div class="panel-heading">
						<div class="pull-left">
							<h5 class="panel-title text-special">
								<?php 
								if($transaction->method == 3) {
									echo '<i class="fa fa-fw fa-credit-card"></i> Pay with Credit Card';
								} else {
									echo '<i class="fa fa-fw fa-mobile"></i> Pay with SMS';
								}
								?>
							</h5>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div id="result"></div>
							<table class="table table-tesponsive">
								<tr>
									<td> <b> Item </b> </td>
									<td> <?=$transaction->transaction_name?> </td>
								</tr>
								<tr>
									<td> <b> Amount </b> </td>
									<td> <?=$transaction->transaction_amount?> USD </td>
								</tr>
							</table>
							<br>
							<?php
							if($transaction->method == 3) {
								echo '<script src="https://checkout.stripe.com/checkout.js"></script>';
								echo '<a id="stripe-pay" class="btn btn-theme btn-block"> Pay </a>';
							} elseif($transaction->method == 1) {
								echo '<a id="fmp-button" class="btn btn-theme btn-block" rel="'.$fortumo_service_id.'/'.$user->id.'"> Pay </a>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!--/ End body content -->

</section>