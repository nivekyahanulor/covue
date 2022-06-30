<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Create Product Label</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
                        <li class="breadcrumb-item active">Create Product Label</li>
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

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="frm_create_product_label">

                        <h4 class="text-center">Seller Information:</h4>

                        <br>

                        <div class="row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $user_details->company_name; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="company_address">Company Address</label>
                                    <input type="text" class="form-control" id="company_address" name="company_address" value="<?php echo $user_details->company_address . ', ' . $user_details->city . ', ' . $user_details->zip_code . ', ' . $user_details->country_name; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control <?php if (form_error('website')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="website" name="website" placeholder="Website" value="<?php echo set_value('website'); ?>">
                                </div>
                            </div>

                        </div>

                        <br>

                        <h4 class="text-center">Product Information:</h4>

                        <br>

                        <div class="row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="sku">HS Code</label>
                                    <input type="text" class="form-control <?php if (form_error('sku')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="sku" name="sku" placeholder="HS Code" value="<?php echo set_value('sku'); ?>">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control <?php if (form_error('product_name')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo set_value('product_name'); ?>">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="product_img">Product Image</label>
                                    <div class="input-group">
                                        <div class="custom-file <?php if (form_error('product_img')) {
                                                                    echo 'is_invalid';
                                                                } ?>" style="border-radius: .25rem;">
                                            <input type="file" class="custom-file-input" id="product_img" name="product_img">
                                            <label class="custom-file-label" for="product_img">Upload file here</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <h4 class="text-center">Product Label Information:</h4>

                        <br>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="product_info">Product Label Info 1</label>



                                    <textarea class="form-control <?php if (form_error('product_info')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="product_info" name="product_info" rows="5" placeholder="Product Label Info 1" maxlength="200" onkeydown="textCounter(this.form.product_info, this.form.product_info_char_count);" onkeyup="textCounter(this.form.product_info, this.form.product_info_char_count);"><?php echo set_value('product_info'); ?></textarea>
                                    <br>
                                    <div class="text-right"><input type="text" id="product_info_char_count" class="text-center" name="product_info_char_count" size="3" maxlength="3" value="200" disabled> character remaining</div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="product_handling">Product Label Info 2</label>
                                    <textarea class="form-control <?php if (form_error('product_handling')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="product_handling" name="product_handling" rows="5" placeholder="Product Label Info 2" maxlength="200" onkeydown="textCounter(this.form.product_handling, this.form.product_handling_char_count);" onkeyup="textCounter(this.form.product_handling, this.form.product_handling_char_count);"><?php echo set_value('product_handling'); ?></textarea>
                                    <br>
                                    <div class="text-right"><input type="text" id="product_handling_char_count" class="text-center" name="product_handling_char_count" size="3" maxlength="3" value="200" disabled> character remaining</div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country_of_origin">Made in (Country of Origin):</label>
                                    <select class="select2 form-control <?php if (form_error('country_of_origin')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="country_of_origin" name="country_of_origin" style="width: 100%;">
                                        <option value="" selected>Select Country</option>
                                        <?php
                                        foreach ($countries as $row) {
                                            echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('select#country_of_origin').val('<?php echo $this->input->post('country_of_origin'); ?>');
                                    </script>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="expiration_date">Expiration / Used by Date:</label>
                                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="">
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-12 ">
                                <div class="form-group mb-0">
                                    <label for="create_product_label_terms" class="dark-yellow-title"><strong>Terms and Condition</strong></label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_product_label_terms" name="create_product_label_terms" value="1">
                                        <label class="custom-control-label" for="create_product_label_terms" style="font-weight: normal;">I accept the <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank" class="dark-blue-link">Privacy Policy</a>.</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row mb-2">

                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" id="btn_create_product_label" name="submit" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Submit Product and Label Details</button>
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
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_label_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Important Notice!</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <p>A Product Label can only be made for a register product. Product registration requires a product image to be uploaded to continue the product label generation.</p>
                            <p>The image will not be displayed on your product label. </p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a href="#" class="btn btn-dark-blue" data-dismiss="modal">OK, I understand</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->