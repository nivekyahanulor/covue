<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New User</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>users/listing">Users</a></li>
            <li class="breadcrumb-item active">Add New User</li>
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

              <div class="row">

                <div id="IORform" class="col-md-12">

                  <?php if (isset($errors)) : ?>

                    <?php if ($errors == 0) : ?>

                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Successfully Added New User!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php else : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Some Errors Found. Please contact your administrator.
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

                  <form action="" method="POST" id="add_users" role="form">

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control <?php if (form_error('username')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" class="form-control <?php if (form_error('password')) {
                                                                        echo 'is_invalid';
                                                                      } ?>" id="password" name="password" placeholder="Password">
                          <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-12 col-12">
                        <div class="form-group">
                          <label for="company_name">Legal Company Name</label>
                          <input type="text" class="form-control <?php if (form_error('company_name')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo set_value('company_name'); ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="company_address">Company Address</label>
                          <input type="text" class="form-control <?php if (form_error('company_address')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="company_address" name="company_address" placeholder="Company Address" value="<?php echo set_value('company_address'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="city">City</label>
                          <input type="text" class="form-control <?php if (form_error('city')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="city" name="city" placeholder="City" value="<?php echo set_value('city'); ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="country">Country</label>
                          <select class="select2 form-control <?php if (form_error('country')) {
                                                                echo 'is_invalid';
                                                              } ?>" id="country" name="country" style="width: 100%;">
                            <option value="" selected>- Select Country -</option>
                            <?php
                            foreach ($countries as $row) {
                              echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                            }
                            ?>
                          </select>
                          <script>
                            $('select#country').val('<?php echo $this->input->post('country'); ?>').trigger('change');
                          </script>
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="zip_code">Zip Code</label>
                          <input type="text" class="form-control <?php if (form_error('zip_code')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php echo set_value('zip_code'); ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="business_license">Business License Number</label>
                          <input type="text" class="form-control <?php if (form_error('business_license')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="business_license" name="business_license" placeholder="Business License Number" value="<?php echo set_value('business_license'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="contact_number">Contact Number</label>
                          <input type="text" class="form-control <?php if (form_error('contact_number')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo set_value('contact_number'); ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="contact_person">Primary Contact Person</label>
                          <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo set_value('contact_person'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control <?php if (form_error('email')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="ior_registered">Registered IOR?</label>
                          <select class="form-control <?php if (form_error('ior_registered')) {
                                                        echo 'is_invalid';
                                                      } ?>" id="ior_registered" name="ior_registered" style="width: 100%;">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                          </select>
                          <?php if ($this->input->post('ior_registered') == '1') : ?>
                            <script>
                              $('select#ior_registered').val('<?php echo $this->input->post('ior_registered'); ?>');
                            </script>
                          <?php endif ?>
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="online_seller">Are you an online seller? <i class="fas fa-question-circle" data-toggle="tooltip" title="Seller in Amazon, Rakuten Ebay and other online platforms"></i></label>
                          <select class="form-control <?php if (form_error('online_seller')) {
                                                        echo 'is_invalid';
                                                      } ?>" id="online_seller" name="online_seller" style="width: 100%;">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                          </select>
                          <?php if ($this->input->post('online_seller') == '1') : ?>
                            <script>
                              $('select#online_seller').val('<?php echo $this->input->post('online_seller'); ?>');
                            </script>
                          <?php endif ?>
                        </div>
                      </div>

                    </div>

                    <div class="row justify-content-end">

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-block btn-success"><i class="fas fa-save mr-2"></i>Submit</button>
                          <small>This will also add User Zoho account.</small>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="<?php echo base_url(); ?>users/listing" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                        </div>
                      </div>

                    </div>

                  </form>
                </div>

              </div>

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