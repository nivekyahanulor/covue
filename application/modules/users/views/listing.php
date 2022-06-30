<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Client Users List<a href="<?php echo base_url(); ?>users/add-users" class="btn btn-info ml-2"><i class="fas fa-plus-circle mr-2"></i>Add Users</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
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

              <table id="tblUsers" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Company Address</th>
                    <th class="text-center">Business License</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th width="100">Email</th>
                    <th class="text-center">IOR Status</th>
                    <th class="text-center">PLI</th>
                    <th class="text-center">Product Label</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Last Updated By</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($users as $row) {

                    echo '<tr>';
                    echo ' <td>' . $row->user_id . '</td>';
                    echo ' <td>' . $row->company_name . '</td>';
                    echo ' <td>' . $row->company_address . ', ' . $row->city . ', ' . $row->nicename . ', ' . $row->zip_code . '</td>';
                    echo ' <td align="center">' . $row->business_license . '</td>';
                    echo ' <td>' . $row->contact_person . '</td>';
                    echo ' <td>' . $row->contact_number . '</td>';
                    echo ' <td>' . $row->email . '</td>';

                    if ($row->ior_registered == 1) {
                      echo '  <td align="center"><span class="badge badge-success">Registered IOR</span></td>';
                    } else {
                      echo '  <td align="center"><span class="badge badge-danger">Unregistered</span></td>';
                    }

                    if($row->user_role_id != 3){
                      if ($row->pli == 1) {
                        echo '  <td align="center"><span class="badge badge-success">Paid</span></td>';
                      } else {
                        echo '  <td align="center"><span class="badge badge-danger">Unpaid</span></td>';
                      }
                    }else{
                      echo '  <td align="center"><span class="badge badge-default">N/A</span></td>';
                    }
                    

                    

                    if($row->user_role_id != 3){
                      if ($row->paid_product_label == 1) {
                        echo '  <td align="center"><span class="badge badge-success">Paid</span></td>';
                      } else {
                        echo '  <td align="center"><span class="badge badge-danger">Unpaid</span></td>';
                      }
                    }else{
                      echo '  <td align="center"><span class="badge badge-default">N/A</span></td>';
                    }

                    if($row->user_role_id != 3){
                      echo '  <td align="center" width="200">
                              <a href="' . base_url() . 'users/edit-users/' . $row->user_id . '" class="btn btn-outline-primary mb-1" title="Edit User Details"><i class="fa fa-user-edit"></i></a>
                              <a href="#" onclick="showConfirmPaidPLI(\'' . $row->user_id . '\')" class="btn btn-outline-success mb-1" title="Set PLI to Paid"><i class="fa fa-user-shield"></i></a>
                              <a href="#" onclick="showConfirmPaidProductLabel(\'' . $row->user_id . '\')" class="btn btn-outline-info mb-1" title="Set Product Label to Paid"><i class="fa fa-user-tag"></i></a>
                              <a href="#" onclick="showConfirmDeleteUser(\'' . $row->user_id . '\')" class="btn btn-outline-danger mb-1" title="Delete User"><i class="fa fa-user-slash"></i></a>
                              <a href="#" onclick="showSyncUser(\'' . $row->user_id . '\')" class="btn btn-outline-warning mb-1" title="Sync User to Zoho Account"><i class="fa fa-sync"></i></a>
                            </td>';
                          }else{
                            echo '  <td align="center" width="200">
                              <a href="' . base_url() . 'users/edit-users/' . $row->user_id . '" class="btn btn-outline-primary mb-1" title="Edit User Details"><i class="fa fa-user-edit"></i></a>
                             
                              <a href="#" onclick="showConfirmDeleteUser(\'' . $row->user_id . '\')" class="btn btn-outline-danger mb-1" title="Delete User"><i class="fa fa-user-slash"></i></a>
                              <a href="#" onclick="showSyncUser(\'' . $row->user_id . '\')" class="btn btn-outline-warning mb-1" title="Sync User to Zoho Account"><i class="fa fa-sync"></i></a>
                            </td>';
                          }
                    


                    if (!empty($row->last_updated_by_id)) {
                      echo ' <td align="center">' . $row->last_updated_by . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    echo '</tr>';
                  }

                  ?>

                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
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

<div class="modal fade" id="modal_paid_pli">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to set to <strong class="text-success">paid</strong> the Product Liability Insurance of this user?
      </div>
      <div class="modal-footer">
        <div id="btn_pli"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_paid_product_label">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to set to <strong class="text-info">paid</strong> the Product Label creation access of this user?
      </div>
      <div class="modal-footer">
        <div id="btn_product_label"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_delete_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-danger">delete</strong> this user?
      </div>
      <div class="modal-footer">
        <div id="btn_delete_user"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_sync_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-warning">sync</strong> this user?
      </div>
      <div class="modal-footer">
        <div id="btn_sync_user"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->