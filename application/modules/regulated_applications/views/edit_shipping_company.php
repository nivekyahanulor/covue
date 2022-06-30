<?php

$shipping_company_id = $shipping_company_details->shipping_company_id;
$shipping_company_name = $shipping_company_details->shipping_company_name;
$email = $shipping_company_details->email;
$username = $shipping_company_details->username;
$partner = $shipping_company_details->partner;
$password = $shipping_company_details->password;
$shipping_company_name = $shipping_company_details->shipping_company_name;
$contact_person = $shipping_company_details->contact_person;
$country = $shipping_company_details->country;
$added_by = $shipping_company_details->contact_person;
$date_added = $shipping_company_details->created_at;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Shipping Company</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/product_qualification">Home</a></li>
            <li class="breadcrumb-item active">Edit Shipping Company</li>
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
                        Successfully updated the shipping company details.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php else : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Sorry for the inconvenience, some errors Found. Please contact your administrator.
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

                  <form action="" method="POST" enctype="multipart/form-data" id="frm_edit_shipping_company" role="form">

                  
                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Shipping Company Name</label>
                          <input type="text" class="form-control <?php if (form_error('shipping_company_name')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="shipping_company_name" name="shipping_company_name" placeholder="Shipping Company Name" value="<?php echo $shipping_company_name; ?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Email Address</label>
                          <input type="text" class="form-control <?php if (form_error('shipping_company_email')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="shipping_company_name" name="shipping_company_email" placeholder="Shipping Company Name" value="<?php echo $email; ?>">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">User Name</label>
                          <input type="text" class="form-control <?php if (form_error('username')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="shipping_company_name" name="shipping_company_username" placeholder="Shipping Company Name" value="<?php echo $username; ?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Password</label>
                          <input type="text" class="form-control <?php if (form_error('password')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="shipping_company_name" name="shipping_company_password" placeholder="Shipping Company Name" value="<?php echo $password; ?>">
                        </div>
                      </div>

                    </div>
					 <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Contact Name</label>
                          <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="contact_person" name="contact_person" placeholder="Shipping Contact Name" value="<?php echo $contact_person; ?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Country</label>
						  <select class="select2 form-control <?php if (form_error('country')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                    <?php
                                    foreach ($countries as $row) {
										if($row->nicename == $country){
											echo '<option value="' . $row->id . '" selected>' . $row->nicename . '</option>';
										} else {
											echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
										}
                                    }
                                    ?>
                                </select>
                                <script>
                                    $('select#country').val('<?php echo $country; ?>').trigger('change');
                                </script>
                         
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="shipping_company_name">Partner</label>
                          <select type="text" class="form-control <?php if (form_error('shipping_company_name')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="shipping_company_partner" name="shipping_company_partner">
                            <option> -- Select -- </option>
                            <?php if ($partner == 1) {
                              echo ' <option value="1" selected> Yes </option>
								   <option value="0"> No </option> ';
                            } else if ($partner == 0) {
                              echo ' <option value="1"> Yes </option>
								   <option value="0" selected> No </option> ';
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                    </div>

                    <br>

                    <div class="row justify-content-end">

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-block btn-success">Update</button>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="<?php echo base_url(); ?>shipping_companies" class="btn btn-block btn-outline-danger">Go Back</a>
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