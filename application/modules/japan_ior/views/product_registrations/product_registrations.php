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
            <div class="col-12">
              <p>All products for import must be registered on IOR Online System. Unregistered products cannot be imported.</p>
            </div>
          </div>
          <?php if ($user_details->user_role_id != 3) : ?>
            <div class="row">
              <div class="col-12">
                <p><strong>Product Label:</strong></p>
              </div>
            </div>

            <div class="row">

              <div class="col-md-8 col-12">
                <p>All products must have a Japan compliant label. All sellers are required to comply to Japan product labelling laws. You may upload your own product label or purchase COVUE’s Japan Compliant product labelling services. <a href="https://covueior.com/uploads/docs/product-labeling-compliance.pdf" target="_blank" class="dark-blue-link">(View process here)</a></p>
              </div>

              <div class="col-md-4 col-12 d-flex justify-content-end" style="vertical-align: bottom;">
                <div class="form-group">

                  <?php
                  if ($user_details->paid_product_label == 0) {
                  ?>

                    <a href="<?php echo base_url(); ?>japan-ior/product-label-terms" class="btn btn-md btn-dark-yellow">
                      <i class="fa fa-tags mr-2"></i>Click to purchase your Product Label here
                    </a>

                  <?php
                  } else {
                  ?>

                    <span id="productLabelDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please use your current product label first before you purchase your product label again.">
                      <button class="btn btn-md btn-dark-yellow" style="pointer-events: none;" type="button" disabled><i class="fas fa-tags mr-2"></i>Click to purchase your Product Label here</button>
                    </span>

                  <?php
                  }
                  ?>
                </div>
              </div>

            </div>
          <?php endif ?>
          <br>

          <form action="" method="POST" enctype="multipart/form-data" role="form" id="frmProdQ">



            <?php for ($i = 1; $i <= 3; $i++) { ?>
              <div class="row">
                <div class="<?php echo ($user_details->user_role_id != 3) ? 'col-md-2 col-12' : 'col-md-4 col-12' ?>">
                  <div class="form-group">
                    <label for="sku<?php echo $i; ?>">
                      <?php echo ($user_details->user_role_id == 3) ? 'HS Code' : 'HS Code' ?>


                    </label>
                    <input type="text" class="form-control <?php if (form_error('sku' . $i . '')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="sku<?php echo $i; ?>" name="sku<?php echo $i; ?>" placeholder="<?php echo ($user_details->user_role_id == 3) ? 'HS Code' : 'HS Code' ?>">
                  </div>
                </div>

                <div class="<?php echo ($user_details->user_role_id == 3) ? 'col-md-4 col-12' : 'col-md-6 col-12' ?>">
                  <div class="form-group">
                    <label for="product_name<?php echo $i; ?>">Product Name</label>
                    <input type="text" class="form-control <?php if (form_error('product_name' . $i . '')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="product_name<?php echo $i; ?>" name="product_name<?php echo $i; ?>" placeholder="Product Name">
                  </div>
                </div>

                <div class="<?php echo ($user_details->user_role_id != 3) ? 'col-md-2 col-12' : 'col-md-4 col-12' ?>">
                  <div class="form-group">
                    <label for="product_img<?php echo $i; ?>">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                    <div class="input-group">
                      <div class="custom-file <?php if (form_error('product_img' . $i . '')) {
                                                echo 'is_invalid';
                                              } ?>" style="border-radius: .25rem;">
                        <input type="file" class="custom-file-input" id="product_img<?php echo $i; ?>" name="product_img<?php echo $i; ?>">
                        <label class="custom-file-label" for="product_img<?php echo $i; ?>">Upload</label>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if ($user_details->user_role_id != 3) {
                ?>
                  <div class="col-md-2 col-12">
                    <div class="form-group">
                      <label for="product_label<?php echo $i; ?>">Product Label <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                      <div class="input-group">
                        <div class="custom-file <?php if (form_error('product_label' . $i . '')) {
                                                  echo 'is_invalid';
                                                } ?>" style="border-radius: .25rem;">
                          <input type="file" class="custom-file-input" id="product_label<?php echo $i; ?>" name="product_label<?php echo $i; ?>">
                          <label class="custom-file-label" for="product_label<?php echo $i; ?>">Upload</label>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                } else {
                ?>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="product_type<?php echo $i; ?>">Product Type</label>

                      <select class="form-control <?php if (form_error('product_type' . $i . '')) {
                                                    echo 'is_invalid';
                                                  } ?>" id="product_type<?php echo $i; ?>" name="product_type<?php echo $i; ?>">
                        <option value="">Select Product Type</option>
                        <option value="0">non-commercial</option>
                        <option value="1">commercial</option>


                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="dimensions_by_piece<?php echo $i; ?>">Dimension by Piece</label>
                      <input type="text" class="form-control <?php if (form_error('dimensions_by_piece' . $i . '')) {
                                                                echo 'is_invalid';
                                                              } ?>" id="dimensions_by_piece<?php echo $i; ?>" name="dimensions_by_piece<?php echo $i; ?>" placeholder="Dimension by Piece">
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="weight_by_piece<?php echo $i; ?>">Weight by Piece</label>
                      <input type="text" class="form-control <?php if (form_error('weight_by_piece' . $i . '')) {
                                                                echo 'is_invalid';
                                                              } ?>" id="weight_by_piece<?php echo $i; ?>" name="weight_by_piece<?php echo $i; ?>" placeholder="Weight by Piece">
                    </div>
                  </div>

                <?php
                } ?>

              </div>
              <hr>
            <?php } ?>



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
                <p class="qualifiedLink">*Products already qualified by COVUE? <a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-yellow-link">Click here</a></p>
                <p class="qualifiedLink">*Purchase label if you don't have a product label, we can generate for it.</p>
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
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product Registration</h4>
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
  </div>`
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