<?php

$id = $product_label_details->product_label_id;
$user_id = $product_label_details->user_id;
$company_name = $product_label_details->company_name;
$company_address = $product_label_details->company_address . ', ' . $product_label_details->city . ', ' . $country->nicename . ', ' . $product_label_details->zip_code;
$contact_number = $product_label_details->contact_number;

$product_registration_id = $product_registration->product_registration_id;
$sku = $product_registration->sku;
$product_name = $product_registration->product_name;
$product_img = $product_registration->product_img;

$website = $product_label_details->website;
$product_info = $product_label_details->product_info;
$product_handling = $product_label_details->product_handling;

$country_of_origin = $product_label_details->made_in;
$expiration_date = $product_label_details->expiration_date;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Label Details</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations/product-labels">Product Labels</a></li>
                        <li class="breadcrumb-item active">Product Label Details</li>
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
                                                Sorry for the inconvenience, some errors found. Please contact administrator.
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

                                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="frm_edit_product_label">

                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                                <h4>Seller's Information:</h4>
                                            </div>

                                            <?php if (!empty($product_label_revision_msg)) : ?>

                                                <div class="col-md-2 col-12">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#revisionsMsg"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Revisions Message</button>
                                                    </div>
                                                </div>

                                            <?php endif ?>
                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="company_name">Company Name</label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $company_name; ?>" readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="company_address">Company Address</label>
                                                    <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Company Address" value="<?php echo $company_address; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="contact_number">Contact Number</label>
                                                    <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo $contact_number; ?>" readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Product's Information:</h4>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="sku">HS Code</label>
                                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="HS Code" value="<?php echo $sku; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product_name">Product Name</label>
                                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo $product_name; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="product_img">Product Image</label>
                                                    <p id="product_img"><a href="<?php echo base_url() . 'uploads/product_qualification/' . $user_id . '/' . $product_img; ?>" target="_blank">Click Here to View File</a></p>
                                                </div>
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Product Label's Details:</h4>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="<?php echo $website; ?>" readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product_info">Product Use & Information</label>
                                                    <textarea class="form-control" id="product_info" name="product_info" rows="10" placeholder="Product Use & Information" readonly><?php echo $product_info; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product_handling">Product Handling | Preparation</label>
                                                    <textarea class="form-control" id="product_handling" name="product_handling" rows="10" placeholder="Product Handling | Preparation" readonly><?php echo $product_handling; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country_of_origin">Made In (Country of Origin)</label>
                                                    <input type="text" class="form-control" id="country_of_origin" name="country_of_origin" placeholder="Made In (Country of Origin)" value="<?php echo $country_of_origin; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="expiration_date">Expiration Date</label>
                                                    <input type="text" class="form-control" id="expiration_date" name="expiration_date" placeholder="Expiration Date" value="<?php echo (($expiration_date != '0000-00-00') ? date('m/d/Y', strtotime($expiration_date)) : 'N/A'); ?>" readonly>
                                                </div>
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="col-12 d-flex justify-content-end">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-file-word"></i>&nbsp;&nbsp;Download Label Details</button>
                                                    <a href="#" onclick="showConfirmProductLabelRevision('<?php echo $id; ?>')" class="btn btn-warning"><i class="fa fa-undo"></i>&nbsp;&nbsp;Needs Revision</a>
                                                    <a href="<?php echo base_url(); ?>product-registrations/product-labels" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back</a>
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

                <?php echo $product_label_revision_msg->message; ?>

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

<div class="modal fade" id="modal_product_label_on_process">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="dark-blue-title">accept</strong> this Product Label details?
            </div>
            <div class="modal-footer">
                <div id="btn_product_label_on_process"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_product_label_revision">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Label Needs Revisions:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="revisions_msg">Revisions:</label>
                <textarea id="revisions_msg" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <div id="btn_product_label_revision"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $(function() {
        // Summernote
        $("#revisions_msg").summernote({
            placeholder: 'Place your revision message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })
    })
</script>