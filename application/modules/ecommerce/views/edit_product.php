<?php

$id = $product_data->product_registration_id;
$user_id = $product_data->user_id;
$company_name = $product_data->company_name;
$contact_person = $product_data->contact_person;
$email = $product_data->email;
$hscode = $product_data->hscode;
$product_details = $product_data->product_details;
$product_img = $product_data->product_img;
$product_label = $product_data->product_label;
$revisions_msg = $product_data->revisions_msg;
$declined_msg = $product_data->declined_msg;

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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/product_registrations">Home</a></li>
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

                      <div class="col-md-3 col-12">
                        <div class="form-group">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#revisionsMsg"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Revisions Message</button>
                        </div>
                      </div>

                    <?php endif ?>

                    <?php if (!empty($declined_msg)) : ?>

                      <div class="col-md-3 col-12">
                        <div class="form-group">
                          <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#declinedMsg"><i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp;Declined Message</button>
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
                          <label for="hscode">HS Code</label>
                          <input type="text" class="form-control <?php if (form_error('hscode')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="hscode" name="hscode" placeholder="HS Code" value="<?php echo $hscode; ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="product_details">Product Name & Details</label>
                          <input type="text" class="form-control <?php if (form_error('product_details')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="product_details" name="product_details" placeholder="Product Name & Details" value="<?php echo $product_details; ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="product_img">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> (<a href="<?php echo base_url() . 'uploads/product_qualification/' . $user_id . '/' . $product_img; ?>" target="_blank">View File Here</a>)</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="product_img" name="product_img" title="">
                              <label class="custom-file-label" for="product_img"><?php echo $product_img; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="product_label">Product Label <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> (<a href="<?php echo base_url() . 'uploads/product_labels/' . $user_id . '/' . $product_label; ?>" target="_blank">View File Here</a>)</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="product_label" name="product_label" title="">
                              <label class="custom-file-label" for="product_label"><?php echo $product_label; ?></label>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <br>

                    <div class="row justify-content-end">

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-block btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Update</button>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="#" onclick="showConfirmDelete('<?php echo $id ?>')" class="btn btn-block btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</a>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="<?php echo base_url(); ?>product_registrations" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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