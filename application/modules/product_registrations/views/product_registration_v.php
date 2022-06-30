<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Product Registration List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Product Registrations</li>
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
            <div class="card-header">
              <h3 class="card-title col-md-3">List of Products</h3>
              <div class="col-md-9" style="float: right">
                <div id="approve-all-con" style="display: none; float: right">
                  ALL :
                  <button onclick="showApproveAllProduct()" class="btn btn-outline-success" title="Approve"><i class="fas fa-check-circle mr-2"></i>Approve Selected</button>
                  <button onclick="showDeclineAllProduct()" class="btn btn-outline-danger" title="Decline"><i class="fas fa-times-circle mr-2"></i>Decline Selected</button>
                  <button onclick="showNeedRevAllProduct()" class="btn btn btn-outline-warning" title="Needs Revision"><i class="fas fa-sync-alt mr-2"></i>Needs Revision Selected</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <?php if ($this->session->flashdata('success') != null) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>

              <?php endif ?>

              <table id="tbl_product_registrations" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center"><input class="cb-reg-prod-all" type="checkbox" value="" id="selec_all_regulated_products"></th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Company</th>
                    <?php if ($active_url != 'product_registrations/mailing_products') : ?>
                      <th class="text-center">HS Code</th>
                    <?php else : ?>
                      <th class="text-center">HS Code</th>
                    <?php endif ?>
                    <?php if ($active_url != 'product_registrations/mailing_products') : ?>
                      <th class="text-center">Category</th>
                    <?php else : ?>
                      <th class="text-center">Product Type</th>
                    <?php endif ?>
                    <th class="text-center">Name</th>
                    <th class="text-center">Image</th>
                    <?php if ($active_url != 'product_registrations/mailing_products') : ?>
                      <th class="text-center">Label</th>
                      <th class="text-center">Certificates<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Japan Radio Certificate/Formaldehyde Test (not applicable for Non-Regulated Products)"></i></th>
                    <?php else : ?>
                      <th class="text-center">Dimensions by Piece</th>
                      <th class="text-center">Weight by Piece</th>
                    <?php endif ?>


                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <?php if ($active_url == 'product_registrations/mailing_products') : ?>
                      <th class="text-center">Mailing Product Price</th>
                    <?php endif ?>
                    <th class="text-center">Last Updated By</th>
                    <th class="text-center">Last Date Updated</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($product_registrations as $product_registration) {
                    $dropdown = '<select class="form-control product_category" data-id=' . $product_registration->product_registration_id . ' data-user-id=' . $product_registration->user_details_id . ' style="width:auto;height:30px;font-size:12px;">';
                    foreach ($product_categories as $product_category) {
                      if ($product_category->category_name == $product_registration->category_name) {
                        $dropdown .=  '<option value="' . $product_category->id . '" selected>' . $product_category->category_name . '</option>';
                      } else {
                        $dropdown .=  '<option value="' . $product_category->id . '" >' . $product_category->category_name . '</option>';
                      }
                    }
                    $dropdown .= '</select>';

                    echo '<tr id="' . $product_registration->product_registration_id . '">';
                    echo ' <td align="center"><input class="cb-reg-prod" type="checkbox" value="' . $product_registration->product_registration_id . '" id="' . $product_registration->product_registration_id . '"></td>';
                    echo ' <td align="center">' . $product_registration->product_registration_id . '</td>';
                    echo ' <td align="center">' . date('m/d/Y', strtotime($product_registration->product_registration_date)) . '</td>';
                    echo ' <td align="center">' . $product_registration->company_name . '</td>';
                    echo ' <td align="center">' . $product_registration->sku . '</td>';

                    if ($active_url != 'product_registrations/mailing_products') {
                      if ($product_registration->status == 1) {
                        echo '<td align="center">' . $product_registration->category_name . '</td>';
                      } else {
                        if ($product_registration->regulated_application_id == 0) {
                          echo ' <td id="prod_cat_' . $product_registration->product_registration_id . '" align="center" width="100px">' . $dropdown . '</td>';
                        } else {
                          echo '<td align="center">' . $product_registration->category_name . '<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be updated)." style="cursor: pointer;"></i></td>';
                        }
                      }
                    } else {
                      echo ($product_registration->product_type == 1) ? '<td align="center">Commercial</td>' : '<td align="center">Non-Commercial</td>';
                    }

                    echo ' <td align="center" width="200">' . $product_registration->product_name . '</td>';
                    echo ' <td align="center"> <a href="' . base_url() . 'uploads/product_qualification/' . $product_registration->user_details_id . '/' . $product_registration->product_img . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                    if ($active_url != 'product_registrations/mailing_products') {
                      if (!empty($product_registration->product_label)) {
                        echo '<td align="center"> <a href="' . base_url() . 'uploads/product_labels/' . $product_registration->user_details_id . '/' . $product_registration->product_label . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                      } else {
                        echo '<td align="center">No File Uploaded</td>';
                      }

                      if (!empty($product_registration->product_certificate)) {
                        echo '<td align="center"> <a href="' . base_url() . 'uploads/product_certificates/' . $product_registration->user_details_id . '/' . $product_registration->product_certificate . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                      } else {
                        if ($product_registration->product_category_id == 8) {
                          echo '<td align="center">No File Uploaded</td>';
                        } else {
                          echo '<td align="center">N/A</td>';
                        }
                      }
                    } else {
                      echo ' <td align="center">' . $product_registration->dimensions_by_piece . '</td>';
                      echo ' <td align="center">' . $product_registration->weight_by_piece . '</td>';
                    }

                    if ($product_registration->regulated_application_id == 0) {
                      if ($user_details->department == 1 && $user_details->user_level == 1) {
                        switch ($product_registration->status) {
                          case 1: // Approve
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                            break;
                          case 2: // Declined
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                            break;
                          case 3: // Needs Revision
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-warning">' . $product_registration->label . '</span></td>';
                            break;
                          case 4: // Pending
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-secondary">' . $product_registration->label . '</span></td>';
                            break;
                          case 5: // Recently Updated
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                            break;
                          case 6: // Purchased Product Label
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                            break;
                          default: // Blank
                            echo '<td align="center">Not Available</td>';
                            break;
                        }

                        echo '<td align="center" width="180">';
                        echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\',\'' . $active_url . '\',\'' . $product_registration->is_mailing_product . '\')" class="btn btn-outline-success" title="Approve" style="margin: 5px"><i class="fas fa-check-circle"></i></a>';
                        echo '  <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined" style="margin: 5px"><i class="fas fa-times-circle"></i></a><br>';
                        echo '  <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision" style="margin: 5px"><i class="fas fa-sync-alt"></i></a>';
                        echo '  <a href="' . base_url() . 'product-registrations/edit-product/' . $product_registration->product_registration_id . '" class="btn btn-outline-primary" title="Edit" style="margin: 5px"><i class="fas fa-edit"></i></a>';
                        echo '</td>';
                      } else {
                        switch ($product_registration->status) {
                          case 1: // Approve
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">';
                            echo '  <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined"><i class="fas fa-times-circle"></i></a>';
                            echo '</td>';
                            break;
                          case 2: // Declined
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                            echo '<td width="180" align="center">';
                            if ($admin == 1) {
                              echo '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\',\'' . $active_url . '\',\'' . $product_registration->is_mailing_product . '\')" class="btn btn-outline-success" title="Approve" style="margin: 5px"><i class="fas fa-check-circle"></i></a>';
                            }
                            echo '<a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision" style="margin: 5px"><i class="fas fa-sync-alt"></i></a>';
                            echo '<a href="' . base_url() . 'product-registrations/edit-product/' . $product_registration->product_registration_id . '" class="btn btn-outline-primary m-1" title="Edit"><i class="fas fa-edit"></i></a>';
                            echo '</td>';
                            break;
                          case 3: // Needs Revision
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-warning">' . $product_registration->label . '</span></td>';
                            echo '<td width="180" align="center">';
                            if ($admin == 1) {
                              echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\',\'' . $active_url . '\',\'' . $product_registration->is_mailing_product . '\')" class="btn btn-outline-success" title="Approve" style="margin: 5px"><i class="fas fa-check-circle"></i></a>';
                            }
                            echo '<a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined" style="margin: 5px"><i class="fas fa-times-circle"></i></a><br>';
                            echo '<a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision" style="margin: 5px"><i class="fas fa-sync-alt"></i></a>';
                            echo '<a href="' . base_url() . 'product-registrations/edit-product/' . $product_registration->product_registration_id . '" class="btn btn-outline-primary" title="Edit" style="margin: 5px"><i class="fas fa-edit"></i></a>';
                            echo '</td>';
                            break;
                          case 4: // Pending
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-secondary">' . $product_registration->label . '</span></td>';
                            echo '<td width="300" align="center">';
                            if ($admin == 1) {
                              echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\',\'' . $active_url . '\',\'' . $product_registration->is_mailing_product . '\')" class="btn btn-outline-success" title="Approve" style="margin: 5px"><i class="fas fa-check-circle"></i></a>';
                            }
                            echo '<a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined" style="margin: 5px"><i class="fas fa-times-circle"></i></a><br>';
                            echo '<a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision" style="margin: 5px"><i class="fas fa-sync-alt"></i></a>';
                            echo '<a href="' . base_url() . 'product-registrations/edit-product/' . $product_registration->product_registration_id . '" class="btn btn-outline-primary" title="Edit" style="margin: 5px"><i class="fas fa-edit"></i></a>';
                            echo '</td>';
                            break;
                          case 5: // Recently Updated
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                            echo '<td width="300" align="center">';
                            if ($admin == 1) {
                              echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\',\'' . $active_url . '\',\'' . $product_registration->is_mailing_product . '\')" class="btn btn-outline-success" title="Approve" style="margin: 5px"><i class="fas fa-check-circle"></i></a>';
                            }
                            echo '<a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-danger" title="Declined" style="margin: 5px"><i class="fas fa-times-circle"></i></a><br>';
                            echo '<a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="btn btn-outline-warning" title="Needs Revision" style="margin: 5px"><i class="fas fa-sync-alt"></i></a>';
                            echo '<a href="' . base_url() . 'product-registrations/edit-product/' . $product_registration->product_registration_id . '" class="btn btn-outline-primary" title="Edit" style="margin: 5px"><i class="fas fa-edit"></i></a>';
                            echo '</td>';
                            break;
                          case 6: // Purchased Product Label
                            echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">No Action</td>';
                            break;
                          default: // Blank
                            echo '<td align="center">Not Available</td>';
                            echo '<td align="center">No Action</td>';
                            break;
                        }
                      }
                    } else {
                      switch ($product_registration->status) {
                        case 1: // Approve
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                          break;
                        case 2: // Declined
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                          break;
                        case 3: // Needs Revision
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-warning">' . $product_registration->label . '</span></td>';
                          break;
                        case 4: // Pending
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-secondary">' . $product_registration->label . '</span></td>';
                          break;
                        case 5: // Recently Updated
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                          break;
                        case 6: // Purchased Product Label
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                          break;
                        default: // Blank
                          echo '<td align="center">Not Available</td>';
                          break;
                      }
                      echo '<td align="center">Not Available<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be updated)." style="cursor: pointer;"></i></td>';
                    }

                    if ($active_url == 'product_registrations/mailing_products') {

                      echo ' <td align="center">' . $product_registration->mailing_product_price . '</td>';
                    }

                    if (!empty($product_registration->last_updated_by_id)) {
                      echo ' <td align="center">' . $product_registration->last_updated_by . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    if (!empty($product_registration->last_date_updated)) {
                      echo ' <td align="center">' . date('m/d/Y', strtotime($product_registration->last_date_updated))  . '</td>';
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

<div class="modal fade" id="modal_regulated">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Category Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This product will be auto declined and user will be notify that this product requires regulated application.
      </div>
      <div class="modal-footer">
        <div id="btn_regulated"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_japan_radio">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Category Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        User will be notify that this product requires to upload their Japan Radio certification.
      </div>
      <div class="modal-footer">
        <div id="btn_japan_radio"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_baby_non_reg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Category Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        User will be notify that this product requires to upload their certification.
      </div>
      <div class="modal-footer">
        <div id="btn_baby_non_reg"></div>
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
        Are you sure you want to <strong class="text-danger">decline</strong> all selected products?
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

        <p>
          Are you sure you want to <strong class="text-success">approve</strong> this product?
        </p>
        <br>
        <p id="mailing-prod-price" style="display:none">
          Please enter Mailing Product Price :
          <input type="text" class="form-control" id="mailing_product_price" name="mailing_product_price" placeholder="Mailing Product Price" value="">
        </p>
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

<script>
  $(function() {

    $("#declined_msg").summernote({
      placeholder: 'Place your declined message here ...',
      tabsize: 2,
      height: 250,
      toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['fontsize', ['fontsize']],
        ['para', ['ul', 'ol', 'paragraph']]
      ]
    })

    $("#revisions_msg").summernote({
      placeholder: 'Place your revision message here ...',
      tabsize: 2,
      height: 250,
      toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['fontsize', ['fontsize']],
        ['para', ['ul', 'ol', 'paragraph']]
      ]
    })

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
  })
</script>