<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Application ID #<?php echo $regulated_application->regulated_application_id; ?> : <?php echo $regulated_application->category_name; ?> Application for <?php echo $regulated_application->user_company_name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>regulated-applications">Regulated Applications</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item active">Products List</li>
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

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="frm_manufacturer_details">
                        <?php
                        if (!empty($manufacturer_details)) {
                            $manuAction = "Update";
                            $mancountry = $manufacturer_details->manufacturer_country;
                        ?>
                            <input type="hidden" name="manuaction" value="edit" id="manuaction">
                        <?php
                        } else {
                            $manuAction = "Add";
                            $mancountry = 0;
                        ?>
                            <input type="hidden" name="manuaction" value="add" id="manuaction">
                        <?php
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Manufacturer Details</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body row">

                                <?php
                                if ($reg_application->product_category_id != 4) {
                                ?>
                                    <div class="form-group col-md-6 col-12">
                                        <label for="manufacturer_flow_process">Manufacturer Flow Process <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo !empty($manufacturer_details->manufacturer_flow_process) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $manufacturer_details->regulated_application_id . '/' . $manufacturer_details->manufacturer_flow_process . '" target="_blank">(View File Here)</a>' : ''; ?></label>
                                        <div class="input-group">
                                            <div class="custom-file <?php if (form_error('manufacturer_flow_process')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" style="border-radius: .25rem;">
                                                <input type="file" class="custom-file-input" id="manufacturer_flow_process" name="manufacturer_flow_process">
                                                <label class="custom-file-label" for="manufacturer_flow_process"><?php echo !empty($manufacturer_details->manufacturer_flow_process) ? $manufacturer_details->manufacturer_flow_process : 'Upload'; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_name">Company Name</label>
                                    <input type="text" class="form-control  <?php if (form_error('manufacturer_name')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="manufacturer_name" name="manufacturer_name" placeholder="Company Name" value="<?php echo !empty($manufacturer_details->manufacturer_name) ? $manufacturer_details->manufacturer_name : set_value('manufacturer_name'); ?>">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_address">Company Address</label>
                                    <input type="text" class="form-control  <?php if (form_error('manufacturer_address')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="manufacturer_address" name="manufacturer_address" placeholder="Company Address" value="<?php echo !empty($manufacturer_details->manufacturer_address) ? $manufacturer_details->manufacturer_address : set_value('manufacturer_address'); ?>">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control  <?php if (form_error('manufacturer_city')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="manufacturer_city" name="manufacturer_city" placeholder="City" value="<?php echo !empty($manufacturer_details->manufacturer_city) ? $manufacturer_details->manufacturer_city : set_value('manufacturer_city'); ?>">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_country">Country</label>
                                    <select class="select2 form-control <?php if (form_error('manufacturer_country')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="manufacturer_country" name="manufacturer_country" style="width: 100%;">
                                        <option value="">- Select Country -</option>
                                        <?php
                                        foreach ($countries as $row) {
                                            echo '<option value="' . $row->id . '" >' . $row->nicename . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <script>
                                        if ($('#manuaction').val() == 'add') {
                                            $('select#manufacturer_country').val('<?php echo $this->input->post('manufacturer_country'); ?>').trigger('change');
                                        } else {
                                            $('select#manufacturer_country').val('<?php echo $mancountry; ?>').trigger('change');
                                        }
                                    </script>

                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_zipcode">Zip Code</label>
                                    <input type="text" class="form-control  <?php if (form_error('manufacturer_zipcode')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="manufacturer_zipcode" name="manufacturer_zipcode" placeholder="Zip Code" value="<?php echo !empty($manufacturer_details->manufacturer_zipcode) ? $manufacturer_details->manufacturer_zipcode : set_value('manufacturer_zipcode'); ?>">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_contact">Contact Number</label>
                                    <input type="text" class="form-control  <?php if (form_error('manufacturer_contact')) {
                                                                                echo 'is_invalid';
                                                                            } ?>" id="manufacturer_contact" name="manufacturer_contact" placeholder="Company Contact" value="<?php echo !empty($manufacturer_details->manufacturer_contact) ? $manufacturer_details->manufacturer_contact : set_value('manufacturer_contact'); ?>">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="manufacturer_website">Company Website</label>
                                    <input type="text" class="form-control" placeholder="Company Website" name="manufacturer_website" value="<?php echo !empty($manufacturer_details->manufacturer_website) ? $manufacturer_details->manufacturer_website : set_value('manufacturer_website'); ?>">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <?php
                            if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                            ?>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success" name="submit"><i class="far fa-save mr-2"></i><?php echo $manuAction ?> Manufacturer Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                        <!-- /.card -->

                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header row">
                                    <h3 class="card-title col-md-3">List of <?php echo $reg_application->category_name; ?> Products</h3>
                                    <div id="approve-all-con" class="col-md-9" style="display: none;text-align: right">
                                        ALL :
                                        <button onclick="showApproveAllProduct()" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle mr-2"></i>Approve Selected</button>
                                        <button onclick="showDeclineAllProduct()" class="btn btn-outline-danger" title="Decline"><i class="fas fa-times-circle mr-2"></i>Decline Selected</button>
                                        <button onclick="showNeedRevAllProduct()" class="btn btn btn-outline-warning" title="Needs Revision"><i class="fas fa-sync-alt mr-2"></i>Needs Revision Selected</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-2">
                                    <table id="tblCosmeticProducts" cellspacing="1" cellpadding="1" class="table table-bordered table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <?php
                                                if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                ?>
                                                    <th class="text-center"><input class="cb-reg-prod-all" type="checkbox" value="" id="selec_all_regulated_products"></th>
                                                <?php
                                                }
                                                ?>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">HS Code</th>
                                                <th class="text-center">Product Name</th>

                                                <?php
                                                if ($reg_application->product_category_id == 3 || $reg_application->product_category_id == 4 || $reg_application->product_category_id == 12 || $reg_application->product_category_id == 13 || $reg_application->product_category_id == 9) {
                                                    echo '<th class="text-center">Ingredients Formula</th>';
                                                } else {
                                                    echo '<th class="text-center">Material List</th>';
                                                }
                                                ?>

                                                <th class="text-center">Lab Result</th>
                                                <th class="text-center">Product Packaging</th>
                                                <th class="text-center">Product Image</th>
                                                <th class="text-center">Product Sample Status</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            foreach ($reg_products as $reg_product) {
                                                echo '<tr id="' . $reg_product->product_registration_id . '">';
                                                if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                    echo '  <td align="center"><input class="cb-reg-prod" type="checkbox" value="' . $reg_product->product_registration_id . '" id="' . $reg_product->product_registration_id . '"></td>';
                                                }
                                                echo '  <td align="center">' . $reg_product->product_registration_id . '</td>';
                                                echo '  <td align="center">' . $reg_product->sku . '</td>';
                                                echo '  <td align="center">' . $reg_product->product_name . '</td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->ingredients_formula . '" target="_blank" class="">View File</a></td>';

                                                if (!empty($reg_product->lab_result)) {
                                                    echo '<td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->lab_result . '" target="_blank" class="">View File</a></td>';
                                                } else {
                                                    echo '<td align="center"><strong class="text-danger">Not Yet Available</strong></td>';
                                                }

                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank" class="">View File</a></td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank" class="">View File</a></td>';

                                                echo '  <td align="center"><a href="#" onclick="showProductSamplingModal(' . $reg_product->product_registration_id . ')">View Status</a></td>';

                                                switch ($reg_product->status) {
                                                    case 1: // Approved
                                                        echo '<td align="center"><span class="badge badge-success">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center">';
                                                        echo '<a href="' . base_url() . 'regulated_applications/edit-regulated-products/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="View Details"><i class="fas fa-search-plus"></i></a>';
                                                        echo '&nbsp;';
                                                        echo '<a href="#" onclick="showConfirmDecline(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined"><i class="fas fa-times-circle"></i></a>';
                                                        echo '&nbsp;';
                                                        echo '</td>';
                                                        break;
                                                    case 2: // Declined
                                                        echo '<td align="center"><span class="badge badge-danger">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center">';

                                                        if ($admin == 1) {
                                                            echo  '<a href="#" onclick="showConfirmApproveRegApp(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle"></i></a>';
                                                            echo '&nbsp;';
                                                        }

                                                        if ($reg_product->declined_msg != '') {
                                                            echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#declinedMsg_' . $reg_product->product_registration_id . '"><i class="fas fa-exclamation-circle mr-2"></i>Why Declined?</button>';
                                                        } else {
                                                            echo 'No Action';
                                                        }

                                                        echo '</td>';
                                                        break;
                                                    case 3: // Needs Revision
                                                        echo '<td id="status_' . $reg_product->product_registration_id . '" align="center"><span class="badge badge-warning">' . $reg_product->label . '</span></td>';

                                                        if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                            echo '<td align="center" width="200">';

                                                            if ($admin == 1) {
                                                                echo  '<a href="#" onclick="showConfirmApproveRegApp(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle"></i></a>';
                                                                echo '&nbsp;';
                                                            }

                                                            echo '<a href="#" onclick="showConfirmDecline(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined"><i class="fas fa-times-circle"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="#" onclick="showConfirmRevision(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision"><i class="fas fa-sync-alt"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="' . base_url() . 'regulated_applications/edit-regulated-products/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>';
                                                            echo '</td>';
                                                        } else {
                                                            echo '<td align="center"><strong class="text-danger">No Access</td>';
                                                        }
                                                        break;
                                                    case 4: // Pending
                                                        echo '<td id="status_' . $reg_product->product_registration_id . '" align="center"><span class="badge badge-secondary">' . $reg_product->label . '</span></td>';

                                                        if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                            echo '<td align="center" width="200">';
                                                            if ($admin == 1) {
                                                                echo  '<a href="#" onclick="showConfirmApproveRegApp(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle"></i></a>';
                                                                echo '&nbsp;';
                                                            }
                                                            echo '<a href="#" onclick="showConfirmDecline(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined"><i class="fas fa-times-circle"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="#" onclick="showConfirmRevision(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision"><i class="fas fa-sync-alt"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="' . base_url() . 'regulated_applications/edit-regulated-products/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>';
                                                            echo '</td>';
                                                        } else {
                                                            echo '<td align="center"><strong class="text-danger">No Access</td>';
                                                        }
                                                        break;
                                                    case 5: // Recently Updated
                                                        echo '<td id="status_' . $reg_product->product_registration_id . '" align="center"><span class="badge badge-info">' . $reg_product->label . '</span></td>';
                                                        if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                                            echo '<td align="center" width="200">';
                                                            echo '&nbsp;';
                                                            if ($admin == 1) {
                                                                echo  '<a href="#" onclick="showConfirmApproveRegApp(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle"></i></a>';
                                                                echo '&nbsp;';
                                                            }
                                                            echo '<a href="#" onclick="showConfirmDecline(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined"><i class="fas fa-times-circle"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="#" onclick="showConfirmRevision(\'' . $reg_product->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision"><i class="fas fa-sync-alt"></i></a>';
                                                            echo '&nbsp;';
                                                            echo '<a href="' . base_url() . 'regulated_applications/edit-regulated-products/' . $reg_product->product_registration_id . '" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>';
                                                            echo '</td>';
                                                        } else {
                                                            echo '<td align="center"><strong class="text-danger">No Access</td>';
                                                        }
                                                        break;
                                                    case 6: // Purchased Product Label
                                                        echo '<td id="status_' . $reg_product->product_registration_id . '" align="center"><span class="badge badge-info">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center">No Action</td>';
                                                        break;
                                                    default: // Blank
                                                        echo '<td align="center">Not Available</td>';
                                                        echo '<td align="center">No Action</td>';
                                                        break;
                                                }
                                                echo '</tr>';

                                                if (!empty($reg_product->declined_msg)) {
                                                    echo '<div class="modal fade" id="declinedMsg_' . $reg_product->product_registration_id . '">
                                                        <div class="modal-dialog">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Declined Message</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              
                                                              ' . $reg_product->declined_msg . '
                          
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                            </div>
                                                          </div>
                                                          <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                      </div>
                                                      <!-- /.modal -->';
                                                }
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

                                    <?php
                                    if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $reg_application->assigned_admin_id) {
                                        if ($reg_application->tracking_status == 1) {
                                    ?>
                                            <a href="#" onclick="showConfirmRegulatedPreApprove('<?php echo $reg_application->regulated_application_id; ?>')" class="btn btn-success"><i class="fas fa-check-circle mr-2"></i>Pre-import Products and Documents Completed</a>
                                            <a href="#" onclick="showConfirmRegulatedPreDecline('<?php echo $reg_application->regulated_application_id; ?>')" class="btn btn-danger"><i class="fas fa-times-circle mr-2"></i>Decline Application</a>
                                            <a href="#" onclick="showConfirmRegulatedPreRevision('<?php echo $reg_application->regulated_application_id; ?>')" class="btn btn-warning"><i class="fas fa-sync-alt mr-2"></i>Needs Revision</a>

                                        <?php
                                        }
                                        ?>
                                        <a href="#" onclick="showConfirmRegulatedPreCancel('<?php echo $reg_application->regulated_application_id; ?>')" class="btn btn-secondary"><i class="fas fa-hand-paper mr-2"></i>Cancel Application</a>
                                        <a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back</a>
                                    <?php
                                    } else {
                                    ?>

                                        <a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_application->regulated_application_id; ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back to Tracking Details</a>

                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>

                            <br>

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

<div class="modal fade" id="modal_delete_regulated_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Regulated Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this regulated product?
                <br><br>
                <span id="product_name"></span>
            </div>
            <div class="modal-footer">
                <div id="confirmButtons"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_product_sampling_status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Sampling Status <i class="fas fa-question-circle ml-1" data-toggle="tooltip" title="Check the listed ID in the Product Sampling page to see the details."></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="product_sampling_status"></span>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>product-sampling" class="btn btn-success">Go to Product Sampling Page</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_approve_regulated_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Multiple Products Selected</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mod-bod-approve"></div>
            <div class="modal-footer">
                <div id="">
                    <button type="button" onclick="approveAllProduct()" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_decline_regulated_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Multiple Products Selected</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">decline</strong> all selected regulated product?
                <br><br>
                <div id="decline_msg_con">
                    <label for="declined_all_msg">Reason:</label>
                    <textarea id="declined_all_msg" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div id="">
                    <button type="button" onclick="declineAllProduct()" class="btn btn-success">Send Declined Message</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_need_revision_regulated_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Multiple Products Selected</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set all selected products to <strong class="text-warning">Needs Revision</strong>?
                <br><br>
                <div id="rev_msg_con">
                    <label for="revisions_all_msg">Revisions:</label>
                    <textarea id="revisions_all_msg" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div id="">
                    <button type="button" onclick="reviseAllProduct()" class="btn btn-success">Send Revisions</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_approve">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product is Approved</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-success">approve</strong> this product?
            </div>
            <div class="modal-footer">
                <div id="btn_approve"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_decline">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product is Declined</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="declined_msg">Reason:</label>
                <textarea id="declined_msg" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <div id="btn_decline"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_revision_product_registration">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Needs Revisions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="revisions_msg">Revisions:</label>
                <textarea id="revisions_msg" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <div id="btn_revision"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- APPROVING/DECLINE/NEEDS REVISION/CANCELLED OF PRE-IMPORT NOTIFICATION DOCS -->

<!-- /.modal -->
<div class="modal fade" id="modal_approve_pre_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pre-import Approving Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-success">approve</strong> Pre-import documents?
            </div>
            <div class="modal-footer">
                <div id="btn_approve_pre_import"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modal_decline_pre_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reason for Declining Pre-import Documents</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="declined_remarks">Remarks:</label>
                <textarea id="declined_remarks" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <div id="btn_decline_pre_import"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modal_revision_pre_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revision needed for Pre-import Documents</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="revision_remarks">Remarks:</label>
                <textarea id="revision_remarks" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <div id="btn_revision_pre_import"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modal_cancel_pre_import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pre-import Cancelling Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-secondary">cancel</strong> Pre-import documents?
            </div>
            <div class="modal-footer">
                <div id="btn_cancel_pre_import"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- END OF APPROVING/DECLINE/NEEDS REVISION/CANCELLED OF PRE-IMPORT NOTIFICATION DOCS -->

<script>
    $(function() {
        // Summernote
        $("#declined_msg").summernote({
            placeholder: 'Place your message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

        // Summernote
        $("#revisions_msg").summernote({
            placeholder: 'Place your message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

        // Summernote
        $("#declined_all_msg").summernote({
            placeholder: 'Place your message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

        // Summernote
        $("#revisions_all_msg").summernote({
            placeholder: 'Place your message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

        // Summernote
        $("#declined_remarks").summernote({
            placeholder: 'Why this application is decline?',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

        // Summernote
        $("#revision_remarks").summernote({
            placeholder: 'Place your revision needed here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })
    })
</script>
<!-- /.content-wrapper