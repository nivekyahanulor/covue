<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Covue | IOR Registration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/jpg" href="<?php echo base_url(); ?>assets/img/favicon.png" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jqvmap/jqvmap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.css">
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
  
  <?php if ($this->uri->segment(2) == 'billing_invoice' || $this->uri->segment(2) == 'shipping_invoice_fee' || $this->uri->segment(2) == 'product_label_terms' || $this->uri->segment(2) == 'billing-invoice' || $this->uri->segment(2) == 'shipping-invoice-fee' || $this->uri->segment(2) == 'product-label-terms') { ?>
    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>
  <?php } ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-VKXPXN6X1T"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-VKXPXN6X1T', {
      cookie_flags: 'SameSite=None;Secure'
    });
  </script>

  <link rel="alternate" hreflang="en" href="https://covueior.com">
  <link rel="alternate" hreflang="fr" href="https://fr.covueior.com">
  <link rel="alternate" hreflang="de" href="https://de.covueior.com">
  <link rel="alternate" hreflang="hi" href="https://hi.covueior.com">
  <link rel="alternate" hreflang="id" href="https://id.covueior.com">
  <link rel="alternate" hreflang="ja" href="https://ja.covueior.com">
  <link rel="alternate" hreflang="ko" href="https://ko.covueior.com">
  <link rel="alternate" hreflang="zh" href="https://zh.covueior.com">
  <link rel="alternate" hreflang="es" href="https://es.covueior.com">
  <link rel="alternate" hreflang="th" href="https://th.covueior.com">
  <link rel="alternate" hreflang="vi" href="https://vi.covueior.com">
  <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>
  <script>
    Weglot.initialize({
      api_key: 'wg_e2e42cf211fa28c956b97969c172ab388'
    });
  </script>
</head>

<body class="hold-transition <?php echo ($active_page == 'login') ? 'login-page' : 'sidebar-mini layout-fixed'; ?>">
  <div id="loader"></div>