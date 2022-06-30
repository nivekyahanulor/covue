<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Add <?php echo $reg_application->category_name; ?> Regulated Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/regulated-applications" class="dark-blue-link">Regulated Applications</a></li>
                        <li class="breadcrumb-item active">Add Regulated Product</li>
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

                        <?php if ($errors == 0) { ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Successfully submitted Regulated Product!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php } elseif ($errors == 2) { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_msgs; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php } else { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Errors Found. Please contact your administrator.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <?php if ($this->session->flashdata('success') != null) { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php } ?>

                    <?php if ($this->session->flashdata('error') != null) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php } ?>

                    <?php if (!empty(validation_errors())) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Form not yet submitted!</h4>
                            <hr>
                            <p class="mb-0"><?php echo validation_errors(); ?></p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php } ?>

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="add_regulated_products">

                        <div class="card card-dark-blue">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title"><i class="nav-icon fas fa-box mr-2"></i>Product Details</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-4 col-12">
                                        <label for="sku">HS Code</label>
                                        <input type="text" class="form-control <?php if (form_error('sku')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>"" id=" sku" name="sku" placeholder="HS Code" value="<?php echo set_value('sku'); ?>">
                                    </div>

                                    <div class="form-group col-md-4 col-12">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control <?php if (form_error('product_name')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>"" id=" product_name" name="product_name" placeholder="Product Name" value="<?php echo set_value('product_name'); ?>">
                                    </div>

                                    <div class="form-group col-md-4 col-12">
                                        <label for="product_img">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('product_img')) {
                                                                        echo 'is_invalid';
                                                                    } ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="product_img" name="product_img">
                                                <label class="custom-file-label" for="product_img">Upload</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card card-dark-blue">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title"><i class="nav-icon fas fa-gavel mr-2"></i>Regulated Product Details</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label for="ingredients_formula">Ingredients Formula / Material List <i class="fas fa-question-circle" data-toggle="tooltip" title="Only INCI is accepted. (only upload any of these file types: jpg, jpeg, png, pdf)."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('ingredients_formula')) {
                                                                        echo 'is_invalid';
                                                                    } ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="ingredients_formula" name="ingredients_formula">
                                                <label class="custom-file-label" for="ingredients_formula">Upload</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group col-md-4 col-12">
                                        <label for="lab_result">Lab Result <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php //if (form_error('lab_result')) {
                                                                    //echo 'is_invalid';
                                                                    //} 
                                                                    ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="lab_result" name="lab_result">
                                                <label class="custom-file-label" for="lab_result">Upload</label>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form-group col-md-6 col-12">
                                        <label for="volume_weight">Volume/Weight (grams or ml)</label>
                                        <input type="text" class="form-control <?php if (form_error('volume_weight')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>"" id=" volume_weight" name="volume_weight" placeholder="Volume/Weight" value="<?php echo set_value('volume_weight'); ?>">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="product_use_and_info">Product Use and Information</label>
                                        <textarea class="form-control <?php if (form_error('product_use_and_info')) {
                                                                            echo 'is_invalid';
                                                                        } ?>"" id=" product_use_and_info" name="product_use_and_info" placeholder="Product Use and Information" rows="3"><?php echo set_value('product_use_and_info'); ?></textarea>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="card card-dark-blue">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title"><i class="nav-icon fas fa-tags mr-2"></i>Product Label Details</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6 col-12">
                                        <label for="outerbox_frontside">Outerbox (Frontside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('outerbox_frontside')) {
                                                                        echo 'is_invalid';
                                                                    } ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="outerbox_frontside" name="outerbox_frontside">
                                                <label class="custom-file-label" for="outerbox_frontside">Upload</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="outerbox_backside">Outerbox (Backside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('outerbox_backside')) {
                                                                        echo 'is_invalid';
                                                                    } ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="outerbox_backside" name="outerbox_backside">
                                                <label class="custom-file-label" for="outerbox_backside">Upload</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="consumer_product_packaging_img">Consumer Product Packaging Image (Frontside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('consumer_product_packaging_img')) {
                                                                        echo 'is_invalid';
                                                                    } ?>"" style=" border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="consumer_product_packaging_img" name="consumer_product_packaging_img">
                                                <label class="custom-file-label" for="consumer_product_packaging_img">Upload</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label for="approx_size_of_package">Approximately Size of Package (cm)</label>
                                        <input type="text" class="form-control <?php if (form_error('approx_size_of_package')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>"" id=" approx_size_of_package" name="approx_size_of_package" placeholder="Approximately Size of Package" value="<?php echo set_value('approx_size_of_package'); ?>">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark-blue" name="submit"><i class="fas fa-check-circle mr-2"></i>Submit Regulated Product</button>
                                    <a href="<?php echo base_url() . 'japan-ior/regulated-products-list/' . $regulated_application_id; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

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