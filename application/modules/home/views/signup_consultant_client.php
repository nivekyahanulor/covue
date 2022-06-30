<div id="consultantBodyContent1" class="row">

    <div class="container">

        <div class="row">
            <div class="col-md-7">
                <center>
                    <img src="<?php echo base_url(); ?>uploads/consultants/<?php echo $user_details->landing_page_banner; ?>" alt="Consultant" height="400px" width="600px">
                </center>
            </div>
            <div class="col-md-5">
                <center>
                    <h2><strong><?php echo $user_details->landing_page_header_title; ?></strong></h2>
                    <br>
                    <p class="text-justify"><?php echo $user_details->landing_page_content; ?></p>
                </center>
            </div>
        </div>

    </div>

</div>

<div id="consultantBodyContent2" style="background-image: url('<?php echo base_url(); ?>uploads/consultants/<?php echo $user_details->landing_page_background; ?>');" class="row contentIORreg">
    <div class="container">

        <div class="row justify-content-center">

            <div id="consultantForm" class="col-md-8">

                <?php if (isset($errors)) { ?>

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

                    <?php elseif ($errors == 3) : ?>

                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Username Already Exist!
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

                <h3 class="dark-blue-title text-center">Japan Importer Of Record (IOR)</h3>
                <h3 class="dark-blue-title text-center">Product Import Compliance</h3>
                <br>
                <p class="text-center"> Powered by : <img width="200" height="44" src="<?php echo base_url(); ?>assets/img/covue_logo_black2.png" alt="COVUE Japan K.K."></p>
                <br>
                <h4 class="dark-blue-title text-center" style="font-weight: normal;">Create your IOR online account here!</h4>
                <br>

                <form action="" method="POST" id="signup" role="form">
                    <input type="hidden" name="consultant_id" value="<?php echo  $_GET['consultant'] ?>">
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="consultant_name"><strong>Consultant Name:</strong></label>
                                <input disabled type="text" class="form-control" id="consultant_name" value="<?php echo $user_details->contact_person; ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="consultant_email"><strong>Consultant Email:</strong></label>
                                <input disabled type="text" class="form-control" id="consultant_email" value="<?php echo $user_details->email; ?>">

                            </div>
                        </div>

                    </div>
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
                                <label for="password"><strong>Password:</strong></label>
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
                                <label for="city"><strong>City:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('city')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="city" name="city" placeholder="City" value="<?php echo set_value('city'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Company Address:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('company_address')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="company_address" name="company_address" placeholder="Company Address" value="<?php echo set_value('company_address'); ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="zip_code"><strong>Zip Code:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('zip_code')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php echo set_value('zip_code'); ?>">
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
                                <label for="contact_number"><strong>Contact Number:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('contact_number')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo set_value('contact_number'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="business_license"><strong>Business License Number:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('business_license')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="business_license" name="business_license" placeholder="Business License Number" value="<?php echo set_value('business_license'); ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email"><strong>Email:</strong></label>
                                <input type="email" class="form-control <?php if (form_error('email')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_person"><strong>Primary Contact Person:</strong></label>
                                <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                            echo 'is_invalid';
                                                                        } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo set_value('contact_person'); ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="shipping_company"><strong>Shipping Company:</strong></label>
                                <select class="select2 form-control <?php
                                                                    // if (form_error('shipping_company')) {
                                                                    //     echo 'is_invalid';
                                                                    // }
                                                                    ?>" id="shipping_company" name="shipping_company" style="width: 100%;">
                                    <option value="" selected>- Select Shipping Company-</option>
                                    <?php
                                    // if (isset($_GET['data'])) {
                                    //     $data = $_GET['data'];
                                    // }
                                    // if (!isset($_GET['data'])) {
                                    //     $data = " ";
                                    // }
                                    // foreach ($shipping_companies as $rows) {
                                    //     if ($data == $rows->id) {
                                    //         echo '<option value="' . $rows->id . '" selected>' . $rows->shipping_company_name . '</option>';
                                    //     } else {
                                    //         echo '<option value="' . $rows->id . '" >' . $rows->shipping_company_name . '</option>';
                                    //     }
                                    // }
                                    ?>
                                </select>
                                <script>
                                    $('select#shipping_company').val('<?php
                                                                        //echo $this->input->post('shipping_company'); 
                                                                        ?>').trigger('change');
                                </script>
                            </div>
                        </div> -->

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
                                                                                        } ?>" id="terms" name="terms" value="1">
                                    <label class="custom-control-label" for="terms" style="font-weight: normal;"><strong>I accept <a href="https://www.covue.com/ior-terms-and-condition" target="_blank" class="dark-blue-link">IOR Terms and Condition</a>.</strong></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="row">

                        <div class="col-md-4 offset-md-8 col-12">
                            <div class="form-group">
                                <button type="submit" name="submit" id="btnSignUp" class="btn btn-block btn-dark-blue">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>