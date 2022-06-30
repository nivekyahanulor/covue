<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Upload Product Certificate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
                        <li class="breadcrumb-item active">Upload Product Certificate</li>
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

                    <form action="" method="POST" enctype="multipart/form-data" id="frm_upload_product_cert" role="form">

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="product_certificate">Product Certificate <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i></label>
                                    <div class="input-group">
                                        <div class="custom-file <?php if (form_error('product_certificate')) {
                                                                    echo 'is_invalid';
                                                                } ?>" style="border-radius: .25rem;">
                                            <input type="file" class="custom-file-input" id="product_certificate" name="product_certificate" title="">
                                            <label class="custom-file-label" for="product_certificate"><?php echo !empty($product_certificate) ? $product_certificate : 'Click here to upload'; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Upload Product Certificate</button>
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