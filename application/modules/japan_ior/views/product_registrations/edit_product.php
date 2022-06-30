<?php

$id = $product_data->id;
$user_id = $product_data->user_id;
$sku = $product_data->sku;
$product_name = $product_data->product_name;
$product_img = $product_data->product_img;
$product_label = $product_data->product_label;
$dimensions_by_piece = $product_data->dimensions_by_piece;
$weight_by_piece = $product_data->weight_by_piece;
$product_type = $product_data->product_type;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title">Edit Product Details</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
            <li class="breadcrumb-item active">Edit Product Details</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12">

          <?php if ($this->session->flashdata('success') != null) : ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php endif ?>

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

            <?php if ($errors == 3) { ?>

              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Form not yet submitted!</h4>
                <hr>
                <p class="mb-0">No uploaded image found.</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

            <?php } ?>

          <?php } ?>

          <?php if (!empty(validation_errors())) : ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <h4 class="alert-heading">Form not yet submitted!</h4>

              <hr>

              <p class="mb-0"><?php echo validation_errors(); ?></p>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

          <?php endif ?>

          <form action="" method="POST" enctype="multipart/form-data" id="frm_edit_product" role="form">

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <?php if ($user_details->user_role_id != 3) : ?>
                    <label for="sku">HS Code</label>
                  <?php else : ?>
                    <label for="sku">HS Code</label>
                  <?php endif ?>
                  <input type="text" class="form-control <?php if (form_error('sku')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="sku" name="sku" placeholder="HS Code" value="<?php echo $sku; ?>">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="product_name">Product Name</label>
                  <input type="text" class="form-control <?php if (form_error('product_name')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo $product_name; ?>">
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="product_img">Product Image <i class="fas fa-question-circle mr-2" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i><a href="<?php echo base_url() . 'uploads/product_qualification/' . $user_id . '/' . $product_img; ?>" target="_blank" class="dark-blue-link">(View File Here)</a></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="product_img" name="product_img" title="">
                      <label class="custom-file-label" for="product_img"><?php echo $product_img ?></label>
                    </div>
                  </div>
                </div>
              </div>

              <?php if ($user_details->user_role_id != 3) : ?>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label for="product_label">Product Label <i class="fas fa-question-circle mr-2" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i><a href="<?php echo base_url() . 'uploads/product_labels/' . $user_id . '/' . $product_label; ?>" target="_blank" class="dark-blue-link">(View File Here)</a></label>
                    <div class="input-group">
                      <div class="custom-file <?php if (form_error('product_label')) {
                                                echo 'is_invalid';
                                              } ?>" style="border-radius: .25rem;">
                        <input type="file" class="custom-file-input" id="product_label" name="product_label" title="">
                        <label class="custom-file-label" for="product_label"><?php echo !empty($product_label) ? $product_label : 'Click here to upload'; ?></label>
                      </div>
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label for="product_type">Product Type</label>
                    <select class="select form-control <?php if (form_error('product_type')) {
                                                          echo 'is_invalid';
                                                        } ?>" id="product_type" name="product_type" style="width: 100%;">
                      <?php
                      if ($product_type == 1) {
                        echo '<option value="0">Non-Commercial</option>';
                        echo '<option value="1" selected>Commercial</option>';
                      } else {
                        echo '<option value="0" selected>Non-Commercial</option>';
                        echo '<option value="1" >Commercial</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label for="dimensions_by_piece">Dimensions by Piece</label>
                    <input type="text" class="form-control <?php if (form_error('dimensions_by_piece')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="dimensions_by_piece" name="dimensions_by_piece" placeholder="Dimensions by Piece" value="<?php echo $dimensions_by_piece; ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label for="weight_by_piece">Weight by Piece</label>
                    <input type="text" class="form-control" id="weight_by_piece" name="weight_by_piece" placeholder="Weight by Piece" value="<?php echo $weight_by_piece; ?>">
                  </div>
                </div>
              <?php endif ?>
            </div>

            <br>

            <div class="row">

              <div class="col-12 d-flex justify-content-end">
                <div class="form-group">
                  <button type="submit" name="submit" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Update Product Details</button>
                  <a href="<?php echo base_url(); ?>japan-ior/products-list" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                </div>
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
          <h4 class="modal-title">Product Registration Notice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <p>Approval takes 24 hours from submission during normal business hours Monday to Friday 09:30 to 17:30.</p>

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
          <h4 class="modal-title">Important Notice!</h4>
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