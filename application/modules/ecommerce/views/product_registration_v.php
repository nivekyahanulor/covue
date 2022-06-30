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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/product_qualification">Home</a></li>
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
            <!-- <div class="card-header">
              <h3 class="card-title">Product Qualification List</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">

              <?php if ($this->session->flashdata('success') != null) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>

              <?php endif ?>

              <table id="tbl_product_registrations" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Company Name</th>
                    <th>HS Code</th>
                    <!-- <th class="text-center">Category</th> -->
                    <th class="text-center">Product Details</th>
                    <th class="text-center">Product Image</th>
                    <th class="text-center">Product Label</th>
                    <th class="text-center">Status</th>
                    <th width="150" class="text-center">Action</th>
                    <th class="text-center">Last Updated By</th>
                    <th class="text-center">Last Date Updated</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($product_registrations as $product_registration) {

                    // $dropdown = '<select  class="form-control product_category" data-id=' . $product_registration->product_registration_id . ' style="width:auto;height:30px;font-size:10px;">';
                    // foreach ($product_categories as $product_category) {
                    //   if ($product_category->category_name == $product_registration->category_name) {
                    //     $dropdown .=  '<option value="' . $product_category->id . '" selected>' . $product_category->category_name . '</option>';
                    //   } else {
                    //     $dropdown .=  '<option value="' . $product_category->id . '" >' . $product_category->category_name . '</option>';
                    //   }
                    // }
                    // $dropdown .= '</select>';

                    echo '<tr id="' . $product_registration->product_registration_id . '">';
                    echo ' <td>' . $product_registration->product_registration_id . '</td>';
                    echo ' <td>' . date('m/d/Y', strtotime($product_registration->product_registration_date)) . '</td>';
                    echo ' <td>' . $product_registration->company_name . '</td>';
                    echo ' <td>' . $product_registration->hscode . '</td>';
                    // echo ' <td id="prod_cat_' . $product_registration->product_registration_id . '" align="center" width="100px">' . $dropdown . '</td>';
                    echo ' <td>' . $product_registration->product_details . '</td>';
                    echo ' <td align="center"> <a href="' . base_url() . 'uploads/product_qualification/' . $product_registration->users_details_id . '/' . $product_registration->product_img . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';

                    if (!empty($product_registration->product_label)) {
                      echo '<td align="center"> <a href="' . base_url() . 'uploads/product_labels/' . $product_registration->users_details_id . '/' . $product_registration->product_label . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                    } else {
                      echo '<td align="center">No File Uploaded</td>';
                    }

                    if ($user_id == 1) {

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
                          echo '<td>Not Available</td>';
                          break;
                      }

                      echo '<td align="center">';
                      echo ' <a href="' . base_url() . 'product_registrations/edit_product/' . $product_registration->product_registration_id . '" title="Edit"><i class="fas fa-edit fa-2x mb-1"></i></a>';

                      echo '&nbsp;';
                      echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\')" class="text-success" title="Approve"><i class="fas fa-check-circle fa-2x mb-1"></i></a>';
                      echo '&nbsp;';
                      echo ' <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="text-danger" title="Declined"><i class="fas fa-times-circle fa-2x mb-1"></i></a>';
                      echo '&nbsp;';
                      echo ' <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="text-warning" title="Needs Revision"><i class="fas fa-undo fa-2x mb-1"></i></a>';
                      echo '&nbsp;';
                      echo '</td>';
                    } else {
                      switch ($product_registration->status) {
                        case 1: // Approve
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                          echo '<td align="center">';
                          echo '  <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="text-danger" title="Declined"><i class="fas fa-times-circle fa-2x mb-1"></i></a>';
                          echo '</td>';

                          break;
                        case 2: // Declined
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                          echo '<td align="center">';
                          echo '  <a href="' . base_url() . 'product_registrations/edit_product/' . $product_registration->product_registration_id . '" title="Edit"><i class="fas fa-edit fa-2x mb-1"></i></a>';
                          if ($admin == 1) {
                            echo '&nbsp;';
                            echo '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\')" class="text-success" title="Approve"><i class="fas fa-check-circle fa-2x mb-1"></i></a>';
                          }
                          echo '&nbsp;';
                          echo '   <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="text-warning" title="Needs Revision"><i class="fas fa-undo fa-2x mb-1"></i></a>';
                          echo '</td>';
                          break;
                        case 3: // Needs Revision
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-warning">' . $product_registration->label . '</span></td>';
                          echo '<td align="center">';
                          echo ' <a href="' . base_url() . 'product_registrations/edit_product/' . $product_registration->product_registration_id . '" title="Edit"><i class="fas fa-edit fa-2x mb-1"></i></a>';
                          if ($admin == 1) {
                            echo '&nbsp;';
                            echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\')" class="text-success" title="Approve"><i class="fas fa-check-circle fa-2x mb-1"></i></a>';
                          }
                          echo '&nbsp;';
                          echo ' <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="text-danger" title="Declined"><i class="fas fa-times-circle fa-2x mb-1"></i></a>';
                          echo '&nbsp;';
                          echo ' <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="text-warning" title="Needs Revision"><i class="fas fa-undo fa-2x mb-1"></i></a>';
                          echo '</td>';
                          break;
                        case 4: // Pending
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-secondary">' . $product_registration->label . '</span></td>';
                          echo '<td align="center" width="130">';
                          echo '<a href="' . base_url() . 'product_registrations/edit_product/' . $product_registration->product_registration_id . '" title="Edit"><i class="fas fa-edit fa-2x mb-1"></i></a>';
                          if ($admin == 1) {
                            echo '&nbsp;';
                            echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\')" class="text-success" title="Approve"><i class="fas fa-check-circle fa-2x mb-1"></i></a>';
                          }
                          echo ' <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="text-danger" title="Declined"><i class="fas fa-times-circle fa-2x mb-1"></i></a>';
                          echo '&nbsp;';
                          echo ' <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="text-warning" title="Needs Revision"><i class="fas fa-undo fa-2x mb-1"></i></a>';
                          echo '</td>';
                          break;
                        case 5: // Recently Updated
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                          echo '<td align="center" width="130">';
                          echo '<a href="' . base_url() . 'product_registrations/edit_product/' . $product_registration->product_registration_id . '" title="Edit"><i class="fas fa-edit fa-2x mb-1"></i></a>';
                          if ($admin == 1) {
                            echo '&nbsp;';
                            echo  '<a href="#" onclick="showConfirmApprove(\'' . $product_registration->product_registration_id . '\')" class="text-success" title="Approve"><i class="fas fa-check-circle fa-2x mb-1"></i></a>';
                          }
                          echo '&nbsp;';
                          echo ' <a href="#" onclick="showConfirmDecline(\'' . $product_registration->product_registration_id . '\')" class="text-danger" title="Declined"><i class="fas fa-times-circle fa-2x mb-1"></i></a>';
                          echo '&nbsp;';
                          echo ' <a href="#" onclick="showConfirmRevision(\'' . $product_registration->product_registration_id . '\')" class="text-warning" title="Needs Revision"><i class="fas fa-undo fa-2x mb-1"></i></a>';
                          echo '</td>';
                          break;
                        case 6: // Purchased Product Label
                          echo '<td id="status_' . $product_registration->product_registration_id . '" align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                          echo '<td align="center">No Action</td>';
                          break;
                        default: // Blank
                          echo '<td>Not Available</td>';
                          echo '<td align="center">No Action</td>';
                          break;
                      }
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

<div class="modal fade" id="modal_approve">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Registration:</h4>
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
        <h4 class="modal-title">Product is Declined:</h4>
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
        <h4 class="modal-title">Product Needs Revisions:</h4>
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

<!-- <div class="modal fade" id="modal_set_category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Category:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="product_registration_id" name="product_registration_id">
        <select class="form-control" id="product_category" name="product_category" style="width: 100%;">
          <?php
          // foreach ($product_categories as $product_category) {
          //   echo '<option value="' . $product_category->id . '|' . $product_category->category_name . '">' . $product_category->category_name . '</option>';
          // }
          ?>
        </select>
      </div>
      <div class="modal-footer">
        <div id="btn_approve">
          <button type="button" id="btn_set_category" class="btn btn-success">Set Product Category</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    <!-- /.modal-content 
  </div>
  <!-- /.modal-dialog 
</div> 
<!-- /.modal -->

<script>
  $(function() {
    // Summernote
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
  })
</script>