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
          <h1 class="dark-blue-title">Update User Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item active">Update User Profile</li>
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
                <a class="nav-link active" href="<?php echo site_url('japan-ior/edit-profile/'.$this->session->userdata('user_id') ); ?>"><span class="dark-blue-title">My Profile</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link dark-blue-link" href="<?php echo site_url('japan-ior/my-files/'.$this->session->userdata('user_id') ); ?>">My Files</a>
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

          <?php if (isset($errors)) : ?>

            <?php if ($errors == 0) : ?>

              <div class="alert alert-success alert-dismissible fade show" role="alert">
                Successfully Updated Your Profile!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>

            <?php else : ?>

              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Some Errors Found. Please contact administrator.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>

            <?php endif ?>

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

          <form action="" method="POST" id="edit_profile" role="form">

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="username"><strong>Username:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('username')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="password"><strong>Password:</strong><span id="passwordvalidation"></span></label>
                  <input type="password" class="form-control <?php if (form_error('password')) {
                                                                echo 'is_invalid';
                                                              } ?> password" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>"  maxlength="12">
                  <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-12">
                <div class="form-group">
                  <label for="company_address"><strong>Company Address:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('company_address')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="company_address" name="company_address" placeholder="Company Address" value="<?php echo $company_address; ?>">
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="city"><strong>City:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('city')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="city" name="city" placeholder="City" value="<?php echo $city; ?>">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="country"><strong>Country:</strong></label>
                  <select class="select2 form-control <?php if (form_error('country')) {
                                                        echo 'is_invalid';
                                                      } ?>" id="country" name="country" style="width: 100%;">
                    <option value="" selected>- Select Country -</option>
                    <?php
                    foreach ($countries as $row) {

                      if ($country == $row->id) {
                        echo '<option value="' . $row->id . '" selected>' . $row->nicename . '</option>';
                      } else {
                        echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="zip_code"><strong>Zip Code:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('zip_code')) {
                                                              echo 'is_invalid';
                                                            } ?>" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php echo $zip_code; ?>">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="contact_person"><strong>Primary Contact Person:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>">
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="contact_number"><strong>Contact Number:</strong></label>
                  <input type="text" class="form-control <?php if (form_error('contact_number')) {
                                                            echo 'is_invalid';
                                                          } ?>" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo $contact_number; ?>">
                </div>
              </div>

              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label for="online_seller"><strong>Are you an online seller?</strong> <i class="fas fa-question-circle" data-toggle="tooltip" title="Seller in Amazon, Rakuten Ebay and other online platforms"></i></label>
                  <select class="form-control <?php if (form_error('online_seller')) {
                                                echo 'is_invalid';
                                              } ?>" id="online_seller" name="online_seller" style="width: 100%;">
                    <option value="0" <?php echo ($online_seller == 0) ? 'selected' : ''; ?>>No</option>
                    <option value="1" <?php echo ($online_seller == 1) ? 'selected' : ''; ?>>Yes</option>
                  </select>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="col-12 d-flex justify-content-end">
                <div class="form-group">
                  <button type="submit" name="submit" id="btnSignUp" class="btn btn-dark-blue"><i class="fas fa-check-circle mr-2"></i>Update Profile</button>
                  <a href="<?php echo base_url(); ?>japan-ior/dashboard" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                </div>
              </div>

            </div>

          </form>

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