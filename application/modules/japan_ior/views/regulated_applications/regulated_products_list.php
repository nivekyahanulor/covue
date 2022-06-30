<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Regulated Products List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'japan-ior/tracking-application/' . $regulated_application_id; ?>" class="dark-blue-link">Application Status</a></li>
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
                        <div class="card card-dark-blue">
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
                                            $('select#manufacturer_country').val(<?php echo $mancountry; ?>);
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
                            if ($reg_application->track == 1) {
                            ?>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-dark-yellow" name="submit"><i class="far fa-save mr-2"></i><?php echo $manuAction ?> Manufacturer Details</button>
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
                                <div class="card-header">
                                    <h3 class="card-title col-md-5">List of <?php echo $reg_application->category_name; ?> Products</h3>
                                    <?php
                                    if ($reg_application->track == 1) {
                                    ?>
                                        <div class=" col-md-7 d-flex justify-content-end">
                                            <div class="form-group">
                                                <a href="<?php echo base_url() . 'japan-ior/add-regulated-products/' . $regulated_application_id; ?>" class="btn btn-dark-blue"><i class="fas fa-plus-circle mr-2"></i>Add Single Product</a>
                                                <a href="<?php echo base_url() . 'japan-ior/add-regulated-products-bulk/' . $regulated_application_id; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-boxes mr-2"></i>Add Bulk Products</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div id="approve-all-con" class="col-md-12" style="display: none;text-align: right">

                                        <button onclick="showDeleteAllProduct()" class="btn btn-danger" title="Delete All"><i class="fas fa-trash"></i> Delete All</button>

                                    </div>
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
                                                    echo '<td align="center" class="text-danger">Not Yet Available</td>';
                                                }

                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank" class="dark-blue-link">View File</a></td>';
                                                echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank" class="dark-blue-link">View File</a></td>';

                                                switch ($reg_product->status) {
                                                    case 1:
                                                        echo '<td align="center"><span class="badge badge-success">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-regulated-products/' . $reg_product->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="View"><i class="nav-icon fas fa-search-plus mr-2"></i>View</a></td>';
                                                        break;
                                                    case 2:
                                                        echo '<td align="center"><span class="badge badge-danger">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center">
                                                                <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#declinedMsg_' . $reg_product->product_registration_id . '"><i class="fas fa-exclamation-circle mr-2"></i>Why Declined?</button>
                                                              </td>';
                                                        break;
                                                    case 3:
                                                        echo '<td align="center"><a href="#" data-toggle="modal" data-target="#revisionsMsg_' . $reg_product->product_registration_id . '"><span class="badge badge-warning" data-toggle="tooltip" title="Click to view Revisions Needed">' . $reg_product->label . '</span></a></td>';
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-regulated-products/' . $reg_product->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                                                        echo '  <button type="button" class="btn btn-xs btn-danger" onclick="showConfirmationDeleteRegulatedProduct(\'' . $reg_product->product_registration_id . '\',\'' . $reg_product->product_name . '\')" title="Delete"><i class="nav-icon fas fa-trash mr-2"></i>Delete</button>';
                                                        echo '</td>';
                                                        break;
                                                    case 5:
                                                        echo '<td align="center"><span class="badge badge-info">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-regulated-products/' . $reg_product->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                                                        echo '  <button type="button" class="btn btn-xs btn-danger" onclick="showConfirmationDeleteRegulatedProduct(\'' . $reg_product->product_registration_id . '\',\'' . $reg_product->product_name . '\')" title="Delete"><i class="nav-icon fas fa-trash mr-2"></i>Delete</button>';
                                                        echo '</td>';
                                                        break;
                                                    case 6:
                                                        echo '<td align="center"><span class="badge badge-danger">' . $reg_product->label . '</span></td>';
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-regulated-products/' . $reg_product->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                                                        echo '  <button type="button" class="btn btn-xs btn-danger" onclick="showConfirmationDeleteRegulatedProduct(\'' . $reg_product->product_registration_id . '\',\'' . $reg_product->product_name . '\',\'' . $user_type . '\')" title="Delete"><i class="nav-icon fas fa-trash mr-2"></i>Delete</button>';
                                                        echo '</td>';

                                                        break;
                                                    default:
                                                        $rai = $reg_product->rai;
                                                        $query = $this->db->query("SELECT count(*) as cnt From regulated_product_custom_details
                                                            WHERE `regulated_product_id` = $rai
                                                            ");

                                                        $result = $query->result();

                                                        if($result[0]->cnt > 0){
                                                            echo '<td align="center"><span class="badge badge-secondary">' . $reg_product->label . '</span> <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="Added new detail/s" style="color:red"></i></td>';
                                                        }else{
                                                            echo '<td align="center"><span class="badge badge-secondary">' . $reg_product->label . '</span></td>';
                                                        }

                                                        // echo '<td align="center"><span class="badge badge-secondary">' . $result[0]->cnt . '</span></td>';
                                                        
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-regulated-products/' . $reg_product->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                                                        echo '  <button type="button" class="btn btn-xs btn-danger" onclick="showConfirmationDeleteRegulatedProduct(\'' . $reg_product->product_registration_id . '\',\'' . $reg_product->product_name . '\',\'' . $user_type . '\')" title="Delete"><i class="nav-icon fas fa-trash mr-2"></i>Delete</button>';
                                                        echo '</td>';
                                                        break;
                                                }
                                                echo '</tr>';

                                                if (!empty($reg_product->revisions_msg)) {
                                                    echo '<div class="modal fade" id="revisionsMsg_' . $reg_product->product_registration_id . '">
                                                        <div class="modal-dialog">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Revisions Message</h4>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              
                                                              ' . $reg_product->revisions_msg . '
                          
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                                                            </div>
                                                          </div>
                                                          <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                      </div>
                                                      <!-- /.modal -->';
                                                }

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
                                                              <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
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
                                    if ($reg_application->tracking_status == 1) {
                                    ?>
                                        <a href="#" onclick="showConfirmRegulatedSubmit('<?php echo $reg_application->regulated_application_id; ?>')" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Submit Pre-import Products and Documents</a>
                                    <?php
                                    }
                                    ?>
                                    <!-- <a href="#" onclick="showConfirmRegulatedCancel('<?php //echo $reg_application->regulated_application_id; ?>')" class="btn btn-danger"><i class="fas fa-times-circle mr-2"></i>Cancel Application</a> -->
                                    <a href="<?php echo base_url() . 'japan-ior/tracking-application/' . $reg_application->regulated_application_id; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back to Tracking Application</a>
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