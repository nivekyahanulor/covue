  <footer class="site-footer">
    <div class="layer">
      <div class="footer-group container">
        <div class="footer-content row">
          <div class="footer-brand col-xs-12 col-sm-12 col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/covue_logo_white.png" class="img-fluid" width="200">
            <p>COVUE provides world class Pre-Market Entry and Post-Sale support solutions exclusively on behalf of corporations seeking access to Japan.</p>

            <br><br>

            <h4>Connect with Us!</h4>

            <ul class="social-media-icons">
              <li><a href="https://www.facebook.com/COVUEJapanK.K"><img src="<?php echo base_url(); ?>assets/img/facebook-icon.png"></a></li>
              <li><a href="https://twitter.com/COVUEGROUP"><img src="<?php echo base_url(); ?>assets/img/twitter-icon.png"></a></li>
              <li><a href="https://www.linkedin.com/company/2875769"><img src="<?php echo base_url(); ?>assets/img/linkedin-icon.png"></a></li>
              <li><a href="https://lin.ee/a8YAL2I"><img src="<?php echo base_url(); ?>assets/img/line-icon.png" width="30"></a></li>
            </ul>
          </div>
          <div class="footer-contact col-xs-12 col-sm-12 col-md-6">
            <h4>Contact us!</h4>
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/img/email-icon.png" class="align-self-start mr-3" alt="">
              <div class="media-body">
                <p>info@covue.com</p>
              </div>
            </div>
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/img/phone-icon.png" class="align-self-start mr-3" alt="">
              <div class="media-body">
                <p>+81 050-8881-2699</p>
              </div>
            </div>
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/img/location-icon.png" class="align-self-start mr-3" alt="">
              <div class="media-body">
                <p>1-6-19
                  Azuchimachi Chuo-ku,
                  Osaka, 541-0052 Japan</p>
              </div>
            </div>
          </div>

          <!-- <div class="footer-newsletter col-xs-12 col-sm-12 col-md-4"> 
            <h4>Newsletter Sign Up</h4>

            <div class="newsletter-box card">
              <div class="card-body">
                <p>Subscribe to our newsletter to get the news right into your inbox</p>

                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">GO</button>
                  </div>
                </div>

              </div>
            </div>
          </div> -->
        </div>

        <hr class="footer-line">

        <div class="site-map row">

          <div class="col-xs-12 col-sm-12 col-md-5">
            <p>Copyright &copy; <?= date("Y") ?> COVUE - All Rights Reserved.</p>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-7">
            <ul class="site-map-list">
              <li><a href="https://www.covue.com">Home</a></li> |
              <li><a href="https://www.covue.com/company-information">About Us</a></li> |
              <li><a href="https://www.covue.com/contact">Contact Us</a></li> |
              <li><a href="https://www.covue.com/ior-terms-and-condition/">Terms Of Use</a></li> |
              <li><a href="https://www.covue.com/privacy-policy">Privacy Policy</a></li>
            </ul>
          </div>

        </div>


      </div>
    </div>
  </footer>

  <!-- <script type="text/javascript" id="zsiqchat">
    var $zoho = $zoho || {};
    $zoho.salesiq = $zoho.salesiq || {
      widgetcode: "c73aaa524a646db9498cd08b44eaccebf86fbb2cdbb77f7b78c0774a94407fdf",
      values: {},
      ready: function() {}
    };
    var d = document;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.id = "zsiqscript";
    s.defer = true;
    s.src = "https://salesiq.zoho.com/widget";
    t = d.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(s, t);
  </script> -->

  <!-- base_url for JS -->
  <input type="hidden" id="base" value="<?php echo base_url(); ?>">
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <!-- <script src="<?php //echo base_url(); 
                    ?>plugins/chart.js/Chart.min.js"></script> -->
  <!-- JQVMap -->
  <script src="<?php echo base_url(); ?>plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url(); ?>plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="<?php echo base_url(); ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- jquery-validation -->
  <script src="<?php echo base_url(); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?php echo base_url(); ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- dropzone -->

  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="<?php //echo base_url(); 
                    ?>dist/js/pages/dashboard.js"></script> -->
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="<?php //echo base_url(); 
                    ?>dist/js/demo.js"></script> -->
  <?php if ($active_page == 'dashboard') : ?>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>plugins/sparklines/sparkline.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="<?php echo base_url(); ?>plugins/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/pages/dashboard3.js"></script>
  <?php endif ?>

  <?php if ($this->session->flashdata('modal_signup_warning') != null) : ?>
    <script>
      $('#modal_signup_warning').modal('show');
    </script>
  <?php endif ?>

  <!-- custom JS -->
  <script src="<?php echo base_url(); ?>assets/js/ecommerce_scripts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

  <?php if ($active_page == 'get-a-quote') : ?>
    <script src="<?php echo base_url(); ?>assets/js/quotation_scripts.js"></script>
  <?php endif ?>

  <?php //if ($this->session->flashdata('modal_holidays') != null) : ?>
    <!-- <script>
      $('#modal_holidays').modal('show');
    </script> -->
  <?php //endif ?>

  </body>

  </html>