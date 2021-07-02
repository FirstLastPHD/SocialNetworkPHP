</section><!-- /#wrapper -->
<!--/ END WRAPPER -->

<!-- Notifications Modal -->
<div class="modal fade" id="all-notifications" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$lang['All_Notifications']?></h4>
        </div>
        <div class="modal-body media-list no-padding" id="allNotifications" style="padding-bottom:7px!important;max-height:500px;"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->

<!-- START @CORE PLUGINS -->
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/jquery.gritter/js/jquery.gritter.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/sweet-alert/js/sweet-alert.js"></script>
<script src="//cdn.jsdelivr.net/emojione/2.0.0/lib/js/emojione.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bootstrap-slider/js/bootstrap-slider.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/bxslider/js/bxslider.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/global/plugins/bower_components/fbphotobox/js/fbphotobox.js"></script>
<!--/ END CORE PLUGINS -->

<!-- START @GLOBAL MANDATORY SCRIPTS -->
<script src="<?=$system->getDomain()?>/assets/themes/default/js/apps.js"></script>
<script src="<?=$system->getDomain()?>/assets/themes/default/js/main.js"></script>
<!--/ END @GLOBAL MANDATORY SCRIPTS -->

<!-- JS PREPROCESSOR -->
<?=$page['js']?>
<!-- JS PREPROCESSOR -->

<script>
var handler = StripeCheckout.configure({
  key: '<?=$publishable_key?>',
  locale: 'auto',
  token: function(token) {
    $.get("<?=$system->getDomain()?>/api/stripe.php?t="+token.id, function(data) {
      $("#result").html(data);
    });
  }
});

$('#stripe-pay').on('click', function(e) {
  // Open Checkout with further options
  handler.open({
    name: "<?=$site_name?>",
    description: "<?=$transaction->transaction_name?>",
    amount: <?=$transaction->transaction_amount*100?>
  });
  e.preventDefault();
});

// Close Checkout on page navigation
$(window).on('popstate', function() {
  handler.close();
});
</script>

<audio id="notification" src="<?=$system->getDomain()?>/assets/notification.mp3">

</body>
<!--/ END BODY -->

</html>