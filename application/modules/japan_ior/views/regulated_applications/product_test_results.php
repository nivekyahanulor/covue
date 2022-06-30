<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Lab/Product Test Results</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'japan-ior/tracking-application/' . $regulated_application_id; ?>" class="dark-blue-link">Application Status</a></li>
                        <li class="breadcrumb-item active">Lab/Product Test Results</li>
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

                    <?php if (isset($errors)) { ?>

                        <?php if ($errors == 2) { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_msgs; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title col-md-5">List of <?php echo $reg_application->category_name; ?> Products</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-2">
                                    <table id="tblCosmeticProducts" cellspacing="1" cellpadding="1" class="table table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center">HS Code</th>
                                                <th class="text-center">Product Name</th>

                                                <?php
                                                if ($reg_application->product_category_id == 3 || $reg_application->product_category_id == 4 || $reg_application->product_category_id == 12 || $reg_application->product_category_id == 13 || $reg_application->product_category_id == 9) {
                                                    echo '<th class="text-center">Ingredients Formula</th>';
                                                } else {
                                                    echo '<th class="text-center">Material List</th>';
                                                }
                                                ?>

                                                <?php
                                                if ($reg_application->product_category_id == 3 || $reg_application->product_category_id == 12) {
                                                    echo '<th class="text-center">Product Testing</th>';
                                                } else {
                                                    echo '<th class="text-center">Lab Results</th>';
                                                }
                                                ?>

                                                <th class="text-center">Product Packaging</th>
                                                <th class="text-center">Product Image</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            $user_type = 'client';
                                            foreach ($reg_products as $reg_product) {
                                                echo '<tr id="' . $reg_product->product_registration_id . '">';
                                                echo '  <td align="center">' . $reg_product->sku . '</td>';
                                                echo '  <td align="center">' . $reg_product->product_name . '</td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->ingredients_formula . '" target="_blank" class="dark-blue-link">View File</a></td>';

                                                if (!empty($reg_product->lab_result)) {
                                                    echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->lab_result . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                } else {
                                                    if ($reg_product->product_category_id == 4 || $reg_product->product_category_id == 5 || $reg_product->product_category_id == 10 || $reg_product->product_category_id == 13) {
                                                        echo '<td align="center"><strong class="text-danger" data-toggle="tooltip" title="Lab/Product Test Results are not yet ready." style="cursor: pointer;">Not Yet Uploaded</strong></td>';
                                                    } else {
                                                        echo '<td align="center"><strong class="text-danger" data-toggle="tooltip" title="You are allowed to upload your Lab/Product Test Results." style="cursor: pointer;">Not Yet Uploaded</strong></td>';
                                                    }
                                                }

                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank" class="dark-blue-link">View File</a></td>';

                                                switch ($reg_product->status) {
                                                    case 1:
                                                        echo '<td align="center"><span class="badge badge-success">' . $reg_product->label . '</span></td>';
                                                        break;
                                                    case 2:
                                                        echo '<td align="center"><span class="badge badge-danger">' . $reg_product->label . '</span></td>';
                                                        break;
                                                    case 3:
                                                        echo '<td align="center"><a href="#" data-toggle="modal" data-target="#revisionsMsg_' . $reg_product->product_registration_id . '"><span class="badge badge-warning" data-toggle="tooltip" title="Click to view Revisions Needed">' . $reg_product->label . '</span></a></td>';

                                                        break;
                                                    case 5:
                                                        echo '<td align="center"><span class="badge badge-info">' . $reg_product->label . '</span></td>';
                                                        break;
                                                    case 6:
                                                        echo '<td align="center"><span class="badge badge-danger">' . $reg_product->label . '</span></td>';

                                                        break;
                                                    default:
                                                        echo '<td align="center"><span class="badge badge-secondary">' . $reg_product->label . '</span></td>';
                                                        break;
                                                }

                                                if ($reg_product->product_category_id == 4 || $reg_product->product_category_id == 5 || $reg_product->product_category_id == 10 || $reg_product->product_category_id == 13) {
                                                    echo '<td align="center">No Action</td>';
                                                } else {
                                                    echo '<td align="center">';
                                                    echo '  <button onclick="showUploadTestResult(\'' . $reg_product->product_registration_id . '\')" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-upload mr-2"></i>Upload</button>';
                                                    echo '  <button onclick="showDeleteTestResult(\'' . $reg_product->product_registration_id . '\')" role="button" class="btn btn-xs btn-danger" title="Delete"><i class="nav-icon fas fa-trash mr-2"></i>Delete</button>';
                                                    echo '</td>';
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
                                    <a href="<?php echo base_url() . 'japan-ior/tracking-application/' . $reg_application->regulated_application_id; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back to Tracking Application</a>
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

<div class="modal fade" id="modal_regulated_submit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Submit Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="dark-blue-title">submit</strong> Pre-import documents?
            </div>
            <div class="modal-footer">
                <div id="btn_regulated_submit"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_regulated_cancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancel Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">cancel</strong> your application?
            </div>
            <div class="modal-footer">
                <div id="btn_regulated_cancel"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_delete_regulated_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong>delete</strong> this regulated product?
                <br><span id="product_name"></span>
            </div>
            <div class="modal-footer">
                <div id="confirmButtons"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
                <div class="modal-footer d-flex justify-content-end">
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark-blue" name="upload_test_result">Upload</button>
                        <button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
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
                <h4 class="modal-title">Delete Test Result</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="product_registration_id_delete" id="product_registration_id_delete">
                    <label>Are you sure you want to <strong class="text-danger">delete</strong> the Lab/Product Test Result of this Product?</label>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark-blue btn-remove-verification" name="delete_test_result">Delete</button>
                        <button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  DELETE TEST RESULT MODAL -->