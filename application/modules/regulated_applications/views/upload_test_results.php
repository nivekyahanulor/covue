<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Upload Lab/Product Test Results</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>regulated-applications">Regulated Applications</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item active">Test Results</li>
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

                    <?php if (isset($errors)) : ?>

                        <?php if ($errors == 2) : ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_msgs; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php endif ?>

                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List of Approved <?php echo $reg_application->category_name; ?> Products</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-2">
                                    <table id="tblCosmeticProductsLabels" cellspacing="1" cellpadding="1" class="table table-bordered table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">HS Code</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Ingredients Formula</th>
                                                <th class="text-center">Lab Result</th>
                                                <th class="text-center">Product Packaging</th>
                                                <th class="text-center">Product Image</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($reg_products as $reg_product) {
                                                echo '<tr>';
                                                echo '  <td align="center">' . $reg_product->product_registration_id . '</td>';
                                                echo '  <td align="center">' . $reg_product->sku . '</td>';
                                                echo '  <td align="center">' . $reg_product->product_name . '</td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->ingredients_formula . '" target="_blank" class="dark-blue-link">View File</a></td>';

                                                if (!empty($reg_product->lab_result)) {
                                                    echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->lab_result . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                } else {
                                                    echo '<td align="center"><strong class="text-danger">Not Yet Uploaded</strong></td>';
                                                }

                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank" class="dark-blue-link">View File</a></td>';

                                                if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                    echo '  <td align="center">
                                                            <button onclick="showUploadTestResult(\'' . $reg_product->product_registration_id . '\')" role="button" class="btn btn-outline-success" title="Upload Lab/Product Test Result"><i class="fas fa-upload"></i></button>
                                                            <a href="' . base_url() . 'regulated_applications/view-product-lab/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="View Details"><i class="fas fa-search-plus"></i></a>
                                                            <button onclick="showDeleteTestResult(\'' . $reg_product->product_registration_id . '\')" role="button" class="btn btn-outline-danger" title="Delete Lab/Product Test Result"><i class="fas fa-trash"></i></button>
                                                        </td>';
                                                } else {
                                                    echo '<td align="center"><strong class="text-danger">No Access</td>';
                                                }
                                                echo '</tr>';
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group">
                                    <a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back to Tracking Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--  UPLOAD TEST RESULT MODAL -->
<div class="modal fade" id="uploadTestResult" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Lab/Product Test Result</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="productlabelform">
                <div class="modal-body">
                    <input type="hidden" name="product_registration_id_upload" id="product_registration_id_upload">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file <?php if (form_error('test_result')) {
                                                        echo 'is_invalid';
                                                    } ?>" style="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" id="test_result" name="test_result" value="<?php echo set_value('test_result'); ?>" accept="image/x-png,image/jpeg,application/pdf" required>
                                <label class="custom-file-label" for="fosr">Click to upload</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="submit" class="btn btn-success" name="upload_test_result">Upload</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  END UPLOAD TEST RESULT MODAL -->

<!--   DELETE TEST RESULT MODAL -->
<div class="modal fade" id="deleteTestResult" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Lab/Product Test Result</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="product_registration_id_delete" id="product_registration_id_delete">
                    <label>Are you sure you want to <strong class="text-danger">delete</strong> the Lab/Product Test Result of this Product?</label>
                    <br><br>
                    <label><i>*This process will not delete the approved product, only the uploaded Lab Test Results*</i></label>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="submit" class="btn btn-success btn-remove-verification" name="delete_test_result">Delete</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  DELETE TEST RESULT MODAL -->