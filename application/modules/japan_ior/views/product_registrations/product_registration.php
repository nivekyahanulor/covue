<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title">Product Registrations</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
            <li class="breadcrumb-item active">Product Registrations</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">

          <?php if (isset($errors)) { ?>

            <?php if ($errors == 1) { ?>

              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Oops, something wasn't right</h4>
                <hr>
                <p class="mb-0">Please try again later or contact administrator through livechat/email.</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

            <?php } ?>

            <?php if ($errors == 2) { ?>

              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Form not yet submitted!</h4>
                <hr>
                <p class="mb-0"><?php echo $error_msgs; ?></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>

            <?php } ?>

          <?php } ?>

          <?php if (!empty(validation_errors())) { ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <h4 class="alert-heading">Please input at least one product!</h4>

              <hr>

              <p class="mb-0"><?php echo validation_errors(); ?></p>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

          <?php } ?>

          <div class="row">

            <div class="col-md-6 col-12">

              <p>To avoid any delays, please fill up the form below for product registration.</p>

            </div>

            <div class="col-md-6 col-12 text-right">

              <h5 class="dark-blue-title">Reminder for Uploading Files:</h5>
              <p>1 HS Code : 1 image only. DO NOT upload multiple files in 1 field. <br>
                Upload only any of these filetypes : JPG, JPEG, PDF, PNG</p>

            </div>

          </div>

          <br>

          <form action="" method="POST" enctype="multipart/form-data" role="form" id="frmProdQ">

            <div class="row">

              <?php for ($i = 1; $i <= 3; $i++) { ?>
                <div class="col-md-3 col-12">
                  <div class="form-group">
                    <label for="sku<?php echo $i; ?>">HS Code</label>
                    <input type="text" class="form-control <?php if (form_error('sku' . $i . '')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="sku<?php echo $i; ?>" name="sku<?php echo $i; ?>" placeholder="HS Code">
                  </div>
                </div>

                <div class="col-md-5 col-12">
                  <div class="form-group">
                    <label for="product_name<?php echo $i; ?>">Product Name</label>
                    <input type="text" class="form-control <?php if (form_error('product_name' . $i . '')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="product_name<?php echo $i; ?>" name="product_name<?php echo $i; ?>" placeholder="Product Name & Details">
                  </div>
                </div>

                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label for="product_img<?php echo $i; ?>">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                    <div class="input-group">
                      <div class="custom-file <?php if (form_error('product_img' . $i . '')) {
                                                echo 'is_invalid';
                                              } ?>" style="border-radius: .25rem;">
                        <input type="file" class="custom-file-input" id="product_img<?php echo $i; ?>" name="product_img<?php echo $i; ?>">
                        <label class="custom-file-label" for="product_img<?php echo $i; ?>">Upload File Here</label>
                      </div>
                    </div>
                  </div>
                </div>

              <?php } ?>

            </div>

            <br>

            <div class="row">

              <div class="col-12 d-flex justify-content-end">
                <div class="form-group">
                  <a href="#" class="btn btn-dark-blue" data-toggle="modal" data-target="#modal_product_registration"><i class="fas fa-check-circle mr-2"></i>Submit for Product Approval</a>
                  <a href="<?php echo base_url(); ?>japan-ior/products-list" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                </div>
              </div>

            </div>

            <br>

            <div class="row">

              <div class="col-md-12 text-center">
                <p class="qualifiedLink">*Products already qualified by COVUE? <a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-yellow-link">Click here</a></p>
              </div>

            </div>

          </form>

        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <div class="modal fade" id="modal_product_registration">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product Registration:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Thank you for registering your product.</p>
          <p>Please allow 24 hours for the product verification process to complete.</p>
        </div>
        <div class="modal-footer d-flex justify-content-end">
          <button type="button" id="btn_product_registration" class="btn btn-dark-blue">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal_product_name_info">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product Registration Info</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Product Name requires only English characters.</p>
        </div>
        <div class="modal-footer d-flex justify-content-end">
          <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

</div>
<!-- /.content-wrapper -->