<style type="text/css">
#regForm {
  background-color: #ffffff;
  margin: 20px auto;
  /*padding: 40px;*/
  width: 80%;
  min-width: 300px;
}

/*input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}*/

input.invalid {
  background-color: #ffdddd;
}

.tab {
  display: none;
}

.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

.step.finish {
  background-color: #4CAF50;
}
</style>
<div class="row contentIORreg ">
    <div class="container">
  
        <div class="row mt-4 mb-2">
          <div class="col-md-6 col-12">
            <a href="<?php echo base_url() . 'ecommerce/amazon'; ?>" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to Amazon Services</a>

          </div>
          <div class="col-md-6 d-flex justify-content-end">
            <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
          </div>
        </div>
        <div class="row justify-content-center">
      
            <div id="IORform" class="col-md-12">

                <?php if (isset($errors)) : ?>

                    <?php if ($errors == 0) : ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Successfully Registered New User!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    <?php elseif ($errors == 2) : ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Email Address Already Registered!
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
                
                
                <br>
                <h4 class="dark-blue-title text-center">Create your Amazon account Information.</h4>
                <div class="text-center" style="width: 100%;text-align:center;"><small>Input/s with * are required.</small></div>

                <!-- <form id="regForm" action=""> -->

                  <!-- <h1>Register:</h1> -->

                  <!-- One "tab" for each step in the form: -->
                  <div class="tab">
                    
                    <h2>Business Information</h2>
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Business Location:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Business Type:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="city"><strong>Company or business registration number:</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                    </div>
                    
                    <h2>Registered Business Address</h2>
                    <div class="row">

                        <div class="col-md-8 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Building name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>House/Room number:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Address line 1:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Address line 2:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>City/Town:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Province/Region/State :</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Postal/Zip code:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>            
                  </div>

                  <div class="tab">
                    <h2>Primary Contact Person</h2>
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>First Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Middle Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Last Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Country of citizenship:</strong></label>
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

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Country of birth:</strong></label>
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
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="expiration_date">Date of birth:</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Passport number:</strong></label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Passport expiry :</strong></label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="expiration_date">Country of issue:</label>
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
                    </div>
                     <h2>Residential address details</h2>
                     <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Country:</strong></label>
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
                                <label for="country"><strong>ZIP / Postal Code:</strong></label>
                                <input type="number" class="form-control">
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>State / Region:</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>City / Town :</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Address Line 1 :</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        
                       
                    </div>
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Address Line 2 :</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        
                       
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Street :</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        
                       <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Mobile number :</strong></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Status :</strong></label>
                                <select class="select2 form-control <?php if (form_error('country')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                    <option value="" selected>- Select -</option>
                                    <option value="">- Beneficial owner of the business  -</option>
                                    <option value="">- Legal representative of the business -</option>
                                    <option value="">- Non-legal representative of the business -</option>
                                    
                                </select>
                            </div>
                        </div>

                        
                       
                    </div>
                  </div>

                  <div class="tab">
                    <h2>Store Information</h2>
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Store name / Display name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Do you have UPC/EAN/JAN barcodes for ALL your products? :</strong></label>
                                <select class="select2 form-control <?php if (form_error('country')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                    <option value="" selected>- Select -</option>
                                    <option>Yes</option>
                                    <option>No</option>
                        
                                </select>
                                
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Are you the manufacturer or brand owner for any of the products you wish to sell on Amazon?:</strong></label>
                                <select class="select2 form-control <?php if (form_error('country')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                    <option value="" selected>- Select -</option>
                                    <option>Yes</option>
                                    <option>No</option>
                        
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Do you own government-registered trademark for the branded products you want to sell on Amazon? :</strong></label>
                                <select class="select2 form-control <?php if (form_error('country')) {
                                                                        echo 'is_invalid';
                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                    <option value="" selected>- Select -</option>
                                    <option>Yes</option>
                                    <option>No</option>
                        
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    
                  </div>

                  <div class="tab">
                    <h2>Bank deposit details</h2>
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Store name / Display name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Bank location country:</strong></label>
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

                    </div>

                    <div class="row">

                        
                      <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Bank code / Clearing code / 9-Digit Routing Number:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Branch code:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        
                      <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Bank account number:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Bank account type:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        
                      <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>BIC:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>IBAN:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab">
                    <h2>Beneficial Owner</h2>
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>First Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Middle Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Last Name:</strong></label>
                                <input type="text" class="form-control ">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Country of citizenship:</strong></label>
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

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Country of birth:</strong></label>
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
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="expiration_date">Date of birth:</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Passport number:</strong></label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country"><strong>Passport expiry :</strong></label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" placeholder="Invoice Date" value="">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="expiration_date">Country of issue:</label>
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
                    </div>
                     
                  </div>
                  <div class="tab">
                    <h2>Upload FIles</h2>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload1">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Photo page of Passport (all beneficial owners)</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_uploads" enctype="multipart/form-data" class="dropzone" id="image-upload2">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Front & back of credit card to be registered</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload3">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Company registration certificate</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload4">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Company registration document</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload5">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Business bank account or credit card statements to prove account ownership</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload6">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Online bank letter of ownership (if available)</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload7">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Business utility bills proving business address</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload8">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Personal bank account or credit card statements to prove account ownership and Primary Contact Person Details</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-12">
                          
                        <form action="../file_upload" enctype="multipart/form-data" class="dropzone" id="image-upload9">
                          <input type="hidden" name="request" value="add">
                          <div>
                            <h4>Personal utility bills proving business address</h4>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div style="overflow:auto;">
                    <div style="float:right;">
                      <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                      <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                  </div>

                  <!-- Circles which indicates the steps of the form: -->
                  <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                  </div>

                  <!-- </form> -->
              </div>

          </div>

      </div>
  </div>
<script src="<?php echo base_url(); ?>plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript">
    // $(function(){
      var currentTab = 0; 
      var body = $("html, body");


      showTab(currentTab); 

      function topFunction() {
        document.body.scrollTop = 0; 
        // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        body.stop().animate({scrollTop:0}, 250, 'swing');
      }

      function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        
        if (n == 0) {
          document.getElementById("prevBtn").style.display = "none";
        } else {
          document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
          document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
          document.getElementById("nextBtn").innerHTML = "Next";
        }
        
        fixStepIndicator(n)
      }

      function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
          document.getElementById("regForm").submit();
          return false;
        }
        showTab(currentTab);
        topFunction();
        // alert(""+currentTab)
       
      }

      function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
          if (y[i].value == "") {
            y[i].className += " invalid";
          }
        }
        if (valid) {
          document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; 
      }

      function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
          x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
      }

    // });

  
    Dropzone.autoDiscover = false;
  
    var myDropzone1 = new Dropzone("#image-upload1", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone2 = new Dropzone("#image-upload2", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone3 = new Dropzone("#image-upload3", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone4 = new Dropzone("#image-upload4", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone5 = new Dropzone("#image-upload5", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone6 = new Dropzone("#image-upload6", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone7 = new Dropzone("#image-upload7", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone8 = new Dropzone("#image-upload8", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

    var myDropzone9 = new Dropzone("#image-upload9", { 
       maxFilesize: 10,
       acceptedFiles: ".jpeg,.jpg,.png,.gif",
       addRemoveLinks: true,
       removedfile: function(file) {
         var fileName = file.name; 
         var fileuploded = file.previewElement.querySelector("[data-dz-name]");
         $.ajax({
           type: 'POST',
           url: '../file_upload',
           data: {name: fileuploded.innerHTML,request: 'delete'},
           sucess: function(data){
              console.log('success: ' + data);
           }
         });
  
         var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function( file, response ){
            var obj = JSON.parse(response)
             // console.log(obj.filename); // <---- here is your filename
            var fileuploded = file.previewElement.querySelector("[data-dz-name]");
            fileuploded.innerHTML = obj.filename;
        }
    });

      
</script>