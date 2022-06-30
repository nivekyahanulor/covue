<div class="row contentIORreg">
    <div class="container">

        <br>

        <div class="row">
            <div class="col-md-12 col-12">
                <a href="<?php echo base_url() ?>home/login" class="dark-blue-link"><i class="fas fa-arrow-left mr-2"></i>Back to Login</a>
            </div>
        </div>

        <div class="row">

            <!-- <div id="IORguide" class="col-md-4">

                <br><br>

                <p>Get a quick guide on how to use COVUE IOR System</p>

                <a href="https://www.covue.com/ior-online-manual-guide-for-new-users/" target="_blank" class="btn btn-block btn-outline-dark-blue"><i class="fas fa-info-circle mr-2"></i>Click Here</a>

                <br><br>

                <p>To view COVUE Pricing for IOR click <a href="https://www.covue.com/ior-registration/" target="_blank" class="dark-blue-link">here</a></p>

            </div> -->

            <div id="IORform" class="col-md-12">

                <?php if (isset($errors)) { ?>

                    <?php if ($errors == 1) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Oops, something wasn't right</h4>
                            <hr>
                            <p class="mb-0">Please try again later or contact administrator through livechat/email.</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php } ?>

                    <?php if ($errors == 2) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Form not yet submitted!</h4>
                            <hr>
                            <p class="mb-0">Email address is already registered! Please try another.</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php } ?>

                    <?php if ($errors == 3) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Form not yet submitted!</h4>
                            <hr>
                            <p class="mb-0">Please use English Translation for Company Name or Contact Person!</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <?php } ?>

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

                <br>

                <h4 class="dark-blue-title text-center">Create your IOR online account</h4>

                <br>

                <form action="" method="POST" id="signup" role="form">

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="username"><strong>Username:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('username')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="password"><strong>Password:</strong> <span id="passwordvalidation"></span></label>
                                <input type="password" class="form-control <?php if (form_error('password')) {
                                                                                echo 'is_invalid';
                                                                            } ?> password" id="password" name="password" placeholder="Password"  maxlength="12">
                                <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Legal Company Name:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('company_name')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo set_value('company_name'); ?>">
                            </div>
                        </div>
                       
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Company Address:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('company_address')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="company_address" name="company_address" placeholder="Company Address" value="<?php echo set_value('company_address'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="city"><strong>City:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('city')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="city" name="city" placeholder="City" value="<?php echo set_value('city'); ?>">
                            </div>
                        </div>

                    </div>

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
                                <label for="zip_code"><strong>Zip Code:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('zip_code')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php echo set_value('zip_code'); ?>">
                            </div>
                        </div>

                        

                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="business_license"><strong>Business License Number:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('business_license')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="business_license" name="business_license" placeholder="Business License Number" value="<?php echo set_value('business_license'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_number"><strong>Contact Number:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('contact_number')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo set_value('contact_number'); ?>">
                            </div>
                        </div>


                        
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_person"><strong>Primary Contact Person:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo set_value('contact_person'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email"><strong>Email:</strong></label>
                                <input type="email" class="form-control <?php if (form_error('email')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                            </div>
                        </div>

                       
                    </div>

                    <div class="row">

                       <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="online_seller"><strong>Are you an online seller?</strong> <i class="fas fa-question-circle" data-toggle="tooltip" title="Seller in Amazon, Rakuten Ebay and other online platforms"></i></label>
                                <select class="form-control <?php if (form_error('online_seller')) {
                                                                echo 'is_invalid';
                                                            } ?>" id="online_seller" name="online_seller" style="width: 100%;">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <?php if ($this->input->post('online_seller') == '1') : ?>
                                    <script>
                                        $('select#online_seller').val('<?php echo $this->input->post('online_seller'); ?>')
                                    </script>
                                <?php endif ?>
                            </div>
                        </div>
                  
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="client_type"><strong>Client Type</strong></label>
                                <select class="form-control <?php if (form_error('client_type')) {
                                                                echo 'is_invalid';
                                                            } ?>" id="client_type" name="client_type" style="width: 100%;">
                                    <option value="2" selected>IOR services</option>
                                    <option value="3">Mailing Services</option>
                                </select>
                                <?php if (!empty($this->input->post('client_type'))) : ?>
                                    <script>
                                        $('select#client_type').val('<?php echo $this->input->post('client_type'); ?>')
                                    </script>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input <?php if (form_error('terms')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="terms" name="terms" value="1" required>
                                    <label class="custom-control-label" for="terms" style="font-weight: normal;"><strong>I accept <a href="https://www.covue.com/ior-terms-and-condition" target="_blank" class="dark-blue-link">IOR Terms and Condition</a>.</strong></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-3 offset-md-6 col-12">
                            <div class="form-group">
                                <button type="submit" name="submit" id="btn_sign_up" class="btn btn-block btn-dark-blue">Sign Up</button>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <a href="<?php echo base_url(); ?>home/login" class="btn btn-block btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="modal_signup_warning">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-12">
                        <div class="form-group">
                            <p>Is your shipment currently held in Japan Customs?</p>
                            <strong>COVUE IOR cannot be used to recover a shipment currently held in Japan Customs.</strong>
                            <br>
                            <br>
                            <p>By clicking Accept, you acknowledge that :</p>
                            <ol>
                                <li>You are not attempting to use COVUE IOR to recover a shipment currently held in Japan Customs regardless of reason for the detention.</li>
                                <li>COVUE will not assist in the recovery of a shipment held in customs prior to registration or shipping invoice authorization.</li>
                                <li>You accept all risk and will not receive a refund for your registration, label or IOR shipping fees if you attempt to use COVUE IOR to recover a shipment held in Japan customs prior to the issuing of the Authorized COVUE Shipping Invoice.</li>
                            </ol>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a href="#" class="btn btn-dark-blue" data-dismiss="modal">I accept and understand all of this</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->