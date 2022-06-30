<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Labels List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Product Labels</li>
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

                            <?php if ($this->session->flashdata('success') != null) : ?>

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php endif ?>

                            <table id="tbl_product_labels" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Product Registration ID</th>
                                        <th class="text-center">Product Label ID</th>
                                        <th class="text-center">Company</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Label Uploaded</th>
                                        <th class="text-center">Status</th>
                                        <th width="200" class="text-center">Action</th>
                                        <th class="text-center">Last Updated By</th>
                                        <th class="text-center">Last Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    foreach ($product_labels as $product_label) {

                                        echo '<tr id="' . $product_label->product_label_id . '">';
                                        echo ' <td align="center">' . $product_label->product_registration_id . '</td>';
                                        echo ' <td align="center">' . $product_label->product_label_id . '</td>';
                                        echo ' <td align="center">' . $product_label->company_name . '</td>';
                                        echo ' <td align="center">' . $product_label->product_name . '</td>';

                                        if ($product_label->product_label_status == 1 || $product_label->product_label_status == 5) {
                                            echo '<td align="center"><a href="' . base_url() . 'uploads/product_labels/' . $product_label->user_details_id . '/' . $product_label->product_label_filename . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                                        } else {
                                            echo '<td align="center"><span class="badge badge-danger">Not yet uploaded</span></td>';
                                        }

                                        if ($user_details->department == 1 && $user_details->user_level == 1) {
                                            switch ($product_label->product_label_status) {
                                                case 1: // Label Completed
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-success">' . $product_label->label . '</span></td>';
                                                    break;
                                                case 2: // Label On Process (Accepted)
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">Pending</span></td>';
                                                    break;
                                                case 3: // Needs Revisions
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-warning">' . $product_label->label . '</span></td>';
                                                    break;
                                                case 4: // Pending
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">' . $product_label->label . '</span></td>';
                                                    break;
                                                case 5: // Label Generated
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-info">' . $product_label->label . '</span></td>';
                                                    break;
                                                default: // Blank
                                                    echo '<td align="center">Not Available</td>';
                                                    break;
                                            }

                                            echo '<td align="center">';
                                            echo '  <a href="#" onclick="showConfirmProductLabelApprove(\'' . $product_label->product_label_id . '\')" role="button" class="btn btn-outline-success" title="Approve Uploaded Label"><i class="fas fa-check-circle"></i></a>';
                                            echo '  <a href="' . base_url() . 'product-registrations/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-outline-primary" title="View Label Details"><i class="fas fa-search-plus"></i></a>';
                                            echo '  <a href="#" onclick="showUploadProductLabel(\'' . $product_label->product_label_id . ' | ' . $product_label->product_registration_id . '\');" role="button" class="btn btn-outline-info" title="Upload Finished Product Label"><i class="fas fa-file-upload"></i></a>';
                                            echo '</td>';
                                        } else {
                                            switch ($product_label->product_label_status) {
                                                case 1: // Label Completed
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-success">' . $product_label->label . '</span></td>';
                                                    echo '<td align="center">
                                                            No Action
                                                          </td>';
                                                    break;
                                                case 2: // Label On Process (Accepted)
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">Pending</span></td>';
                                                    echo '<td align="center">
                                                            <a href="' . base_url() . 'product-registrations/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-outline-primary" title="View Label Details"><i class="fas fa-search-plus"></i></a>
                                                            <a href="#" onclick="showUploadProductLabel(\'' . $product_label->product_label_id . ' | ' . $product_label->product_registration_id . '\');" role="button" class="btn btn-outline-info" title="Upload Finished Product Label"><i class="fas fa-file-upload"></i></a>
                                                          </td>';
                                                    break;
                                                case 3: // Needs Revisions
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-warning">' . $product_label->label . '</span></td>';
                                                    echo '<td align="center">
                                                            <a href="' . base_url() . 'product-registrations/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-outline-primary" title="View Label Details"><i class="fas fa-search-plus"></i></a>
                                                          </td>';
                                                    break;
                                                case 4: // Pending
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">' . $product_label->label . '</span></td>';
                                                    echo '<td align="center">
                                                            <a href="' . base_url() . 'product-registrations/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-outline-primary" title="View Label Details"><i class="fas fa-search-plus"></i></a>
                                                          </td>';
                                                    break;
                                                case 5: // Label Generated
                                                    echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-info">' . $product_label->label . '</span></td>';
                                                    echo '<td align="center">
                                                            <a href="#" onclick="showConfirmProductLabelApprove(\'' . $product_label->product_label_id . '\')" role="button" class="btn btn-outline-success" title="Approve Uploaded Label"><i class="fas fa-check-circle"></i></a>
                                                            <a href="' . base_url() . 'product-registrations/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-outline-primary" title="View Label Details"><i class="fas fa-search-plus"></i></a>
                                                            <a href="#" onclick="showUploadProductLabel(\'' . $product_label->product_label_id . ' | ' . $product_label->product_registration_id . '\');" role="button" class="btn btn-outline-info" title="Upload Finished Product Label"><i class="fas fa-file-upload"></i></a>
                                                          </td>';
                                                    break;
                                                default: // Blank
                                                    echo '<td align="center">Not Available</td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                            }
                                        }

                                        if (!empty($product_label->last_updated_by_id)) {
                                            echo ' <td align="center">' . $product_label->last_updated_by . '</td>';
                                        } else {
                                            echo '<td align="center">N/A</td>';
                                        }

                                        if (!empty($product_label->last_date_updated)) {
                                            echo ' <td align="center">' . date('m/d/Y', strtotime($product_label->last_date_updated))  . '</td>';
                                        } else {
                                            echo '<td align="center">N/A</td>';
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

<div class="modal fade" id="modal_upload_product_label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Product Label</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form action='' method='POST' enctype="multipart/form-data">

                    <input type="hidden" id="product_label_id" name="product_label_id" value="">
                    <input type="hidden" id="product_registration_id" name="product_registration_id" value="">

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="product_label">Product Label
                                    <!-- <i class="fas fa-question-circle" data-toggle="tooltip" title="Screenshot or any document, showing your selling price with company name"></i> -->
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="product_label" name="product_label">
                                        <label class="custom-file-label" for="product_label">Upload file here</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">

                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <button type="button" id="btn_upload_product_label" name="btn_upload_product_label" class="btn btn-success"><i class="nav-icon fa fa-file-upload mr-2"></i>Upload Now</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                </div>

                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_product_label_approve">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-success">approve</strong> this product label?
            </div>
            <div class="modal-footer">
                <div id="btn_product_label_approve"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->