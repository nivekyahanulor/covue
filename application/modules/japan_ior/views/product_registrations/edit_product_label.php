<?php

$id = $product_label_data->id;
$website = $product_label_data->website;
$product_info = $product_label_data->product_info;
$product_handling = $product_label_data->product_handling;
$country_of_origin = $product_label_data->country_of_origin;
$expiration_date = $product_label_data->expiration_date;
$status = $product_label_data->status;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Edit Product Label</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
                        <li class="breadcrumb-item active">Edit Product Label</li>
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

                    <br>

                    <?php
                    if ($status == 3) {
                        echo '<div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_revision_message"><i class="fas fa-exclamation-triangle mr-2"></i>View Needed Revisions</button>
                                </div>
                             </div>';
                    }
                    ?>

                    <br>

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="frm_edit_product_label">

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="product_info">Open Field</label>
                                    <textarea class="form-control <?php if (form_error('product_info')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="product_info" name="product_info" rows="5" placeholder="Open Field" maxlength="200" onkeydown="textCounter(this.form.product_info, this.form.product_info_char_count);" onkeyup="textCounter(this.form.product_info, this.form.product_info_char_count);"><?php echo $product_info; ?></textarea>
                                    <br>
                                    <div class="text-right"><input type="text" id="product_info_char_count" class="text-center" name="product_info_char_count" size="3" maxlength="3" value="200" disabled> character remaining</div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="product_handling">Open Field</label>
                                    <textarea class="form-control <?php if (form_error('product_handling')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="product_handling" name="product_handling" rows="5" placeholder="Open Field" maxlength="200" onkeydown="textCounter(this.form.product_handling, this.form.product_handling_char_count);" onkeyup="textCounter(this.form.product_handling, this.form.product_handling_char_count);"><?php echo $product_handling; ?></textarea>

                                    <br>
                                    <div class="text-right"><input type="text" id="product_handling_char_count" class="text-center" name="product_handling_char_count" size="3" maxlength="3" value="200" disabled> character remaining</div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control <?php if (form_error('website')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="website" name="website" placeholder="Website" value="<?php echo $website; ?>">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="country_of_origin">Made in (Country of Origin):</label>
                                    <select class="select2 form-control <?php if (form_error('country_of_origin')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="country_of_origin" name="country_of_origin" style="width: 100%;">
                                        <option value="">Select Country</option>
                                        <?php
                                        foreach ($countries as $country) {
                                            if ($country_of_origin != $country->id) {
                                                echo '<option value="' . $country->id . '">' . $country->nicename . '</option>';
                                            } else {
                                                echo '<option value="' . $country->id . '" selected>' . $country->nicename . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="expiration_date">Expiration / Used by Date:</label>
                                    <input type="date" class="form-control <?php if (form_error('expiration_date')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="<?php echo $expiration_date; ?>">
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label for="update_product_label_terms" class="dark-yellow-title"><strong>Terms and Conditions</strong></label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="update_product_label_terms" name="update_product_label_terms" value="1">
                                        <label class="custom-control-label" for="update_product_label_terms" style="font-weight: normal;">I accept the <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank" class="dark-blue-link">Privacy Policy</a>.</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" name="submit" id="btn_update_product_label" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Update Label Details</button>
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

    <div class="modal fade" id="modal_revision_message">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revisions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo (!empty($product_label_revision_msg->message) ? $product_label_revision_msg->message : ''); ?>
                </div>
                <div class="modal-footer">
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