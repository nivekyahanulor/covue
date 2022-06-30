<?php if ($active_page != 'login' && $active_page != 'registration') : ?>

  <?php if ($external_page == 3) : ?>
    <footer class="main-footer" style="margin: 0 !important;">
      <center><strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://covue.com">COVUE</a>.</strong> All rights reserved.</center>
    </footer>
  <?php else : ?>
    <footer class="main-footer">
      <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://covue.com">COVUE Online Japan</a>.</strong> All rights reserved.
    </footer>
  <?php endif ?>

<?php endif ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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

<?php if ($this->session->flashdata('new_launch') != null) : ?>
  <script>
    $('#modal_new_launch').modal('show');
  </script>
<?php endif ?>

<?php if ($this->session->flashdata('modal_dashboard_popup') != null) : ?>
  <script>
    $('#modal_dashboard_popup').modal('show');
  </script>
<?php endif ?>

<?php if ($this->session->flashdata('modal_create_notice') != null) : ?>
  <script>
    $('#modal_create_notice').modal('show');
  </script>
<?php endif ?>

<!-- custom JS -->
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<?php if ($this->uri->segment(2) == 'billing_invoice' || $this->uri->segment(2) == 'ior_shipping_invoice_fee' || $this->uri->segment(2) == 'product_label_terms') { ?>
  <input type="hidden" id="keys" value="<?php echo $system_settings->stripe_published_key; ?>">
  <script src="<?php echo base_url(); ?>assets/js/stripe.js"></script>
<?php } ?>

</body>

</html>