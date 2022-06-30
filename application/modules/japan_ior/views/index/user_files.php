<?php

$username = $user_details->username;
$password = $user_details->password;
$company_name = $user_details->company_name;
$company_address = $user_details->company_address;
$city = $user_details->city;
$country = $user_details->country;
$zip_code = $user_details->zip_code;
$business_license = $user_details->business_license;
$contact_number = $user_details->contact_number;
$contact_person = $user_details->contact_person;
$email = $user_details->email;
$online_seller = $user_details->online_seller;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  
  <!-- Content Header (Page header) -->
  <section class="content-header">
 
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title"> User Files</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item active"> User Files</li>
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
          <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link dark-blue-link  " href="<?php echo site_url('japan-ior/edit-profile/'.$this->session->userdata('user_id') ); ?>">My Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo site_url('japan-ior/my-files/'.$this->session->userdata('user_id') ); ?>"><span class="dark-blue-title">My Files</span></a>
            </li>
           </ul>
        <div class="shipping-invoice-tab card">
         <div class="card-header">
 
          <?php if ($this->session->flashdata('success') != null) : ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          <?php endif ?>

            <h3 class="card-title col-md-5">List of your Files</h3>
            <div class=" col-md-7 d-flex justify-content-end">
               <a href="" class="btn btn-dark-blue" data-toggle="modal" data-target="#addfile"><i class="fa fa-file mr-2"></i>Add File</a>
            </div>
          </div>
           <div class="card-body">
                <table id="tblShipping" class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">File Name</th>
                      <th class="text-center">Date Added</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($user_files as $val) {
                      echo '<tr>';
                      echo '  <td align="center">' . $val->file_name . '</td>';
                      echo '  <td align="center">' . date('m/d/Y', strtotime($val->date_added)) . '</td>';
                      echo '<td align="center">
                            <a href="'. base_url() .'uploads/users_files/'.$this->session->userdata('user_id').'/'.$val->file_location.'" role="button" class="btn btn-md btn-dark-blue" title="View File" target="_blank"><i class="fas fa-search-plus"></i></a>
                            <button class="btn btn-md btn-danger" title="Delete File"  onclick="showConfirmationRemoveFile(\'' . $val->file_id . '\')"><i class="fas fa-trash-alt"></i></button>
                            </td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

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

<!-- /. modal add files -->
<div class="modal fade" id="addfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form id="myForm" method="post" enctype="multipart/form-data">
            <div class="form-group col-md-12 col-12">
                <label for="custom_name">File Name</label>
                 <input type="text" class="form-control" id="custom_name" name="file_name" placeholder="File Name" autocomplete="off" required>
            </div>
           <div class="form-group col-md-12 col-12">
            <div class="input-group">
                <div class="custom-file" style=" border-radius: .25rem;">
                    <input type="file" class="custom-file-input" name="file_location">
                    <label class="custom-file-label">Upload File</label>
                </div>
            </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-dark-blue" name="upload-file"> Upload </button>
        <button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- /.modal -->
<div class="modal fade" id="modal_remove_file">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Remove File</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to <strong class="dark-blue-title">remove</strong> this file?
        </div>
        <div class="modal-footer">
          <div id="btn_remove_file"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<!-- /.content-wrapper -->