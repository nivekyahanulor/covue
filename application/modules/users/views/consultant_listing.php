<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Consultant List<a href="<?php echo base_url(); ?>users/add-consultant" class="btn btn-info ml-2"><i class="fas fa-plus-circle mr-2"></i>Add Consultant</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Consultant Users</li>
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
            <div class="card-body">

              <?php if ($this->session->flashdata('success') != null) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
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
                    <th>Country</th>
                    <th>Contact Person</th>
                    <th width="100">Email</th>
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
                    echo ' <td>' . $row->nicename . '</td>';
                    echo ' <td>' . $row->contact_person . '</td>';
                    echo ' <td>' . $row->email . '</td>';

                 
                  
                    echo '  <td align="center" width="200">
                      <a href="' . base_url() . 'users/edit-consultant-info/' . $row->user_id . '" class="btn btn-outline-primary mb-1" title="Edit Consultant Details"><i class="fa fa-user-edit"></i></a>
                     
                      <a href="#" onclick="showConfirmDeleteConsultant(\'' . $row->user_id . '\')" class="btn btn-outline-danger mb-1" title="Delete User"><i class="fa fa-user-slash"></i></a>
                    </td>';
                  
                    


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

<div class="modal fade" id="modal_delete_consultant">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-danger">delete</strong> this consultant?
      </div>
      <div class="modal-footer">
        <div id="btn_delete_consultant"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal