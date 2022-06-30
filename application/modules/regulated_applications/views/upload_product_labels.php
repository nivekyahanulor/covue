<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Upload Product Labels</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>regulated-applications">Regulated Applications</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item active">Upload Product Labels</li>
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
                                    <div class="form-group d-flex justify-content-end mb-0">
                                        <button class="btn btn-success" onClick="showBulkUploadProductLabelAdmin()"><i class="fa fa-tags mr-2"></i>Upload Product Labels in Bulk</button>
                                    </div>
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
                                                <th class="text-center">Product Labels</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($reg_products as $reg_product) {
                                                // echo '<form name="form-'. $reg_product->product_registration_id.'" id="form-'. $reg_product->product_registration_id.'" action="download" method="POST">
                                                //           <input type="txt" name="id" value="'.$reg_product->product_registration_id.'">
                                                //         </form>';
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

                                                if (!empty($reg_product->product_label)) {
                                                    echo '<td align="center"><a href="' . base_url() . 'uploads/product_labels/' . $reg_product->user_id . '/' . $reg_product->product_label . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                } else {
                                                    echo '<td align="center"><strong class="text-danger">Not Yet Uploaded</strong></td>';
                                                }

                                                if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                    echo '  <td align="center">
                                                            <button class="btn btn-outline-success" title="Upload Product Label" onclick="showUploadProductLabelAdmin(\'' . $reg_product->product_registration_id . '\')"><i class="fas fa-upload"></i></button>
                                                            <form style="display:contents !important" method="POST">
                                                            <input type="hidden" name="id" value="' . $reg_product->product_registration_id . '">
                                                            <button type="button" onclick="showDownloadProductLabel(\'' . $reg_product->product_registration_id . '\')" name="download_product_label" class="btn btn-outline-info" title="Download Product Label"><i class="fa fa-file-download"></i></button>
                                                            </form>
                                                            <a href="' . base_url() . 'regulated_applications/view-product-labels/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="View Details"><i class="fas fa-search-plus"></i></a>
                                                            <button onclick="showDeleteProductLabelAdmin(\'' . $reg_product->product_registration_id . '\')" role="button" class="btn btn-outline-danger" title="Upload Product Label"><i class="fas fa-trash"></i></button>
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
<!--  UPLOAD PRODUCT LABEL MODAL -->
<div class="modal fade" id="uploadproductlabel" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Upload Product Label</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="productlabelform">
                    <input type="hidden" name="regulated_product_id" id="regulated_product_id">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file <?php if (form_error('product_label')) {
                                                        echo 'is_invalid';
                                                    } ?>" style="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" id="product_label" name="product_label" value="<?php echo set_value('product_label'); ?>" accept="image/x-png,image/jpeg,application/pdf" required>
                                <label class="custom-file-label" for="fosr">Click to upload</label>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div>
                    <button type="submit" class="btn btn-success" name="upload_product_label">Upload</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--  END UPLOAD PRODUCT LABEL MODAL -->

<!--   DELETE PRODUCT LABEL MODAL -->
<div class="modal fade" id="deleteproductlabel" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Delete Product Label</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="regulated_product_id" id="regulated_product_btn_delete">
                    <label>Are you sure you want to <strong class="text-danger">delete</strong> this Product Label?</label>
                    <br><br>
                    <label><i>*This process will not delete the approved product, only the uploaded Product Label*</i></label>
            </div>
            <div class="modal-footer">
                <div>
                    <button type="submit" class="btn btn-success btn-remove-verification" name="remove_product_label">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--  DELETE PRODUCT LABEL MODAL -->

<!--  UPLOAD PRODUCT LABEL MODAL -->
<div class="modal fade" id="uploadbulkproductlabel" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Product Label in Bulk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="productlabelform">
                    <input type="hidden" name="regulated_product_id" id="regulated_product_id">
                    <label for="product_label">Upload your finished ZIP file here: <a href="<?php echo base_url(); ?>regulated-applications/product-label-bulk-guide" class="text-success" target="_blank"><strong>(Click here for instructions)</strong></a></label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file <?php if (form_error('product_label')) {
                                                        echo 'is_invalid';
                                                    } ?>" style="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" id="product_label" name="product_label" value="<?php echo set_value('product_label'); ?>" required>
                                <label class="custom-file-label" for="fosr">Click to upload</label>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div>
                    <button type="submit" class="btn btn-success" name="bulk_upload_product_label">Upload ZIP File</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--  END UPLOAD PRODUCT LABEL MODAL -->

<!--  DOWNLOAD PRODUCT LABEL MODAL -->
<div class="modal fade" id="down-prod-label-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Product Label Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="download_product_label" id="form-down-label-1">
                    <input type="hidden" name="id" class="regid">
                    <div class="row">

                        <div class="col-12 d-flex">
                            <div class="form-group" style="text-align: center;">
                                <button style="width: 100%" name="download_product_label" type="submit" class="btn btn-primary"><i class="fa fa-file-word"></i>&nbsp;&nbsp;Download Product Label Details</button>

                            </div>
                        </div>

                    </div>
                </form>

                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="regid" name="id">
                    <div class="row">

                        <div class="col-12 d-flex">
                            <div class="form-group" style="text-align: center;">
                                <button style="width: 100%" type="submit" name="download_ingredients_formula" class="btn btn-primary"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Download Ingredients Formula</button>

                            </div>
                        </div>

                    </div>
                </form>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="regid" name="id">
                    <div class="row">

                        <div class="col-12 d-flex">
                            <div class="form-group" style="text-align: center;">
                                <button style="width: 100%" type="submit" name="download_lab_result" class="btn btn-primary"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Download Lab Result</button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--  END DOWNLOAD PRODUCT LABEL MODAL -->