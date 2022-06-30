<?php

$id = $product_data->product_registration_id;
$user_id = $product_data->user_id;
$company_name = $product_data->company_name;
$contact_person = $product_data->contact_person;
$email = $product_data->email;
$sku = $product_data->sku;
$product_name = $product_data->product_name;
$product_img = $product_data->product_img;
$product_label = $product_data->product_label;
$revisions_msg = $product_data->revisions_msg;
$declined_msg = $product_data->declined_msg;
$product_type = $product_data->product_type;
$dimensions_by_piece = $product_data->dimensions_by_piece;
$weight_by_piece = $product_data->weight_by_piece;
$is_mailing_product = $product_data->is_mailing_product;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Product Registration</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Edit Products Registration</li>
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
          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title">Product Qualification List</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">

              <div class="row">

                <div id="IORform" class="col-md-12">

                  <?php if (isset($errors)) : ?>

                    <?php if ($errors == 0) : ?>

                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Successfully updated the product registration.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php elseif ($errors == 2) : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_msgs; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php elseif ($errors == 3) : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        No uploaded image found.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php else : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php endif ?>

                  <?php endif ?>

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

                  <div class="row justify-content-end">

                    <?php if (!empty($revisions_msg)) : ?>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#revisionsMsg"><i class="fas fa-comment-dots mr-2"></i>Revisions Message</button>
                        </div>
                      </div>

                    <?php endif ?>

                    <?php if (!empty($declined_msg)) : ?>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#declinedMsg"><i class="fas fa-exclamation-circle mr-2"></i>Declined Message</button>
                        </div>
                      </div>

                    <?php endif ?>

                  </div>

                  <form action="" method="POST" enctype="multipart/form-data" id="edit_products" role="form">

                    <div class="row">

                      <div class="col-md-12 col-12">
                        <div class="form-group">
                          <label for="company_name">Legal Company Name</label>
                          <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $company_name; ?>" disabled>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="contact_person">Primary Contact Person</label>
                          <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>" disabled>
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" disabled>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <?php if($is_mailing_product == 0): ?>
                          <label for="sku">HS Code</label>
                          <?php else: ?>
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
                          <label for="product_img">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i><a href="<?php echo base_url() . 'uploads/product_qualification/' . $user_id . '/' . $product_img; ?>" target="_blank">(View File Here)</a></label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="product_img" name="product_img" title="">
                              <label class="custom-file-label" for="product_img"><?php echo $product_img; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php if($is_mailing_product == 0): ?>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="product_label">Product Label <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i><a href="<?php echo base_url() . 'uploads/product_labels/' . $user_id . '/' . $product_label; ?>" target="_blank">(View File Here)</a></label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="product_label" name="product_label" title="">
                              <label class="custom-file-label" for="product_label"><?php echo $product_label; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php else: ?>
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

                    <div class="row justify-content-end">

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-block btn-success"><i class="fas fa-edit mr-2"></i>Update</button>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="#" onclick="showConfirmDelete('<?php echo $id ?>')" class="btn btn-block btn-danger"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <?php if($is_mailing_product != 1): ?>
                          <a href="<?php echo base_url(); ?>product-registrations" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                          <?php else: ?>
                          <a href="<?php echo base_url(); ?>product-registrations/mailing-products" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                          <?php endif ?>
                        </div>
                      </div>

                    </div>

                  </form>
                </div>

              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="revisionsMsg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Revisions Message</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php echo $revisions_msg; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="declinedMsg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Declined Message</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php echo $declined_msg; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_delete_product">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-danger">delete</strong> this product?
      </div>
      <div class="modal-footer">
        <div id="btn_delete"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->