<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <?php
                        echo '<h1 class="">View ' . $reg_product->product_name . ' </h1>';
                    ?>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_product->regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/upload-product-labels/' . $reg_product->regulated_application_id; ?>">Product Labels</a></li>
                        <li class="breadcrumb-item active">View Regulated Products</li>
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

                    <?php if (isset($errors)) : ?>

                        <?php if ($errors == 0) : ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Successfully submitted Regulated Product!
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

                        <?php else : ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Errors Found. Please contact your administrator.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php endif ?>

                    <?php endif ?>

                    <?php if ($this->session->flashdata('success') != null) : ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php endif ?>

                    <?php if ($this->session->flashdata('error') != null) : ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

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

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="edit_regulated_products">
                        <input type="hidden" name="regulated_application_id" value="<?php echo $reg_product->regulated_application_id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Product Registered</h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="">

                                            <div class="row">


                                                <div class="form-group col-md-4 col-12">
                                                    <label for="sku">HS Code</label>
                                                    <input type="text" class="form-control" id=" sku" name="sku" placeholder="HS Code" value="<?php echo $reg_product->sku; ?>" disabled>
                                                </div>


                                                <div class="form-group col-md-4 col-12">
                                                    <label for="product_name">Product Name</label>
                                                    <input type="text" class="form-control" id=" product_name" name="product_name" placeholder="Product Name" value="<?php echo $reg_product->product_name; ?>" disabled>
                                                </div>

                                                <div class="form-group col-md-4 col-12">
                                                    <label for="product_img">Product Image</label>
                                                    <div class="input-group">
                                                        <a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank">(View File Here)</a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.d-flex -->


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Regulated Product</h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="">

                                            <div class="row">

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="ingredients_formula">Ingredients Formula</label>
                                                    <div class="input-group">
                                                        <a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->ingredients_formula . '" target="_blank">(View File Here)</a>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="volume_weight">Volume/Weight (grams or ml)</label>
                                                    <input type="text" class="form-control" id=" volume_weight" name="volume_weight" placeholder="Volume/Weight" value="<?php echo $reg_product->volume_weight; ?>" disabled>
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="product_use_and_info">Product Use and Information</label>
                                                    <textarea class="form-control" id=" product_use_and_info" name="product_use_and_info" placeholder="Product Use and Information" rows="3" disabled><?php echo $reg_product->product_use_and_info; ?></textarea>
                                                </div>

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="consumer_product_packaging_img">Consumer Product Packaging Image</label>
                                                    <div class="input-group">
                                                        <a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank">(View File Here)</a>
                                                    </div>

                                                </div>

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="approx_size_of_package">Approximately Size of Package (cm)</label>
                                                    <input type="text" class="form-control" id=" approx_size_of_package" name="approx_size_of_package" placeholder="Approximately Size of Package" value="<?php echo $reg_product->approx_size_of_package; ?>" disabled>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.d-flex -->


                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <a href="<?php echo base_url(); ?>regulated-applications/upload-product-labels/<?php echo $reg_product->regulated_application_id ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left mr-2"></i>Go Back to Product Labels</a>
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