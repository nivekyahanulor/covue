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

  <!-- dropzone -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/dropzone/dropzone.css">

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

  <div class="row translated-pages">
    <div class="col-md-12">

      <!-- <div class="container">
        <a href="https://covue.jp" class="pull-right">日本語</a>
      </div> -->

    </div>
  </div>

  <header id="myHeader">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">
          <a href="<?php echo base_url(); ?>" class="custom-logo-link" rel="home">
            <img width="300" height="66" src="<?php echo base_url(); ?>assets/img/covue_logo.png" class="custom-logo" alt="covue_logo">
          </a>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-4" id="navbarSupportedContent">
          <ul class="homepage-nav navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <!-- <li class="nav-item <?php //echo ($current_slug == 'blog-posts') ? 'active' : ''; 
                                      ?>">
                <a class="nav-link" href="https://www.covue.com/japan-ior/">JAPAN IOR</a>
              </li> -->
            <li class="nav-item dropdown show">
              <a id="dropdownJapanIOR" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link dropdown-toggle">JAPAN IOR</a>
              <ul aria-labelledby="dropdownJapanIOR" class="dropdown-menu" style="right: inherit;">
                <li>
                  <h1 class="dropdown-header"><a id="japanIORmenu" href="https://www.covue.com/japan-ior/">Japan IOR</a></h1>
                </li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-to-amazon-japan-fba/">Importing to Amazon Japan FBA</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-electronics-into-japan/">Importing Electronics</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-shelf-stable-food-products-into-japan/">Importing Shelf-stable foods</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-food-apparatuses-in-japan/">Importing Food Apparatuses</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-baby-products-and-toys-for-children-under-6-year-of-age-in-to-japan/">Importing Baby Products and toys for Children</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-cosmetics-into-japan/">Importing Cosmetics</a></li>
                <li><a class="dropdown-item" href="https://www.covue.com/japan-ior/importing-medical-devices-into-japan/">Importing Medical Devices</a></li>
                <!-- End Level two -->
              </ul>
            </li>
            <li class="nav-item <?php //echo ($current_slug == 'about' || $current_slug == 'corporate-profile' || $current_slug == 'mission-and-vision') ? 'active' : ''; 
                                ?>">
              <a class="nav-link" href="https://www.covue.com/blog-posts-weekly-covue-japan/">News and Updates</a>
            </li>
            <li class="nav-item <?php //echo ($current_slug == 'about' || $current_slug == 'corporate-profile' || $current_slug == 'mission-and-vision') ? 'active' : ''; 
                                ?>">
              <a class="nav-link" href="https://www.covue.com/company-information/">About</a>
            </li>
            <li class="nav-item <?php //echo ($current_slug == 'contact') ? 'active' : ''; 
                                ?>">
              <a class="nav-link" href="https://www.covue.com/contact/">Contact Us</a>
            </li>
            <?php if ($this->session->userdata('logged_in') == '1' || $this->session->userdata('logged_in') == '3') : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>japan_ior/logout">Logout</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>home/login">Login</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>