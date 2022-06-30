<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Bulk <?php echo $reg_application->category_name; ?> Regulated Products </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/regulated-applications" class="dark-blue-link">Regulated Applications</a></li>
                        <li class="breadcrumb-item active">Add Bulk Regulated Products</li>
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
                            <span><i class="fas fa-exclamation-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?></span>
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

                    <br>

                    <div class="row">

                        <div class="col-12">
                            <h4>Instructions for uploading Bulk products*</h4>
                        </div>

                    </div>

                    <br><br>

                    <div class="row">

                        <div class="col-12">
                            <h5>Step 1: Create your CSV file and input your data files correctly according to the position below (Please follow the sequence to prevent the wrong output):</h5>
                            <strong>(HS Code, Product Name, Product Image, Ingredients File, Product Use and Information, Volume/Weight, Consumer Product Packaging File, Approximately Size of Package)</strong>
                            <br><br>
                            <img src="<?php echo base_url(); ?>assets/img/Step01.png" alt="Bulk Product Uploading Step 1" width="1000">
                        </div>

                    </div>

                    <br><br>

                    <div class="row">

                        <div class="col-12">
                            <h5>Step 2: Compile your files and name it according on what you have assigned name in the CSV file <strong>(Please make sure that the spelling, extension files and spaces are correct to prevent issues)</strong>.<br><br><strong>SELECT ALL FILES (Do not compress the folder itself)</strong> including the CSV file and compress to create a zip file. <strong>(Microsoft Windows has an ability to create a zipped file by Compressed or using WinRAR)</strong>.</h5>
                            <br><br>
                            <img src="<?php echo base_url(); ?>assets/img/Step02.png" alt="Bulk Product Uploading Step 2" width="1000">
                        </div>

                    </div>

                    <br><br>

                    <div class="row">

                        <div class="col-12">
                            <h5>Step 3: Upload your finished ZIP file in the file upload button <strong>(Only ZIP file are allowed, RAR and other files are not accepted)</strong>.</h5>
                            <br><br>
                            <img src="<?php echo base_url(); ?>assets/img/Step03.png" alt="Bulk Product Uploading Step 2" width="300">
                        </div>

                    </div>

                    <br><br>

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="add_regulated_products">

                        <div class="row">

                            <div class="form-group col-md-4 col-12">
                                <label for="zip_file"><strong>Upload your finished zip file here*</strong></label>
                                <div class="input-group">
                                    <div class="custom-file <?php if (form_error('ingredients_formula')) {
                                                                echo 'is_invalid';
                                                            } ?>" style=" border-radius: .25rem;">
                                        <input type="file" class="custom-file-input" id="zip_file" name="zip_file">
                                        <label class="custom-file-label" for="zip_file">Upload</label>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark-blue" name="submit"><i class="fas fa-check-circle mr-2"></i>Submit Bulk Products</button>
                                    <a href="<?php echo base_url() . 'japan-ior/regulated-products-list/' . $regulated_application_id; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
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