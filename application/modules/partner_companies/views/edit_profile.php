<?php

$shipping_company_id = $user_details->id;
$shipping_company_name = $user_details->shipping_company_name;
$email = $user_details->email;
$username = $user_details->username;
$partner = $user_details->partner;
$password = $user_details->password;
$shipping_company_name = $user_details->shipping_company_name;
$added_by = $user_details->contact_person;
$contact_person = $user_details->contact_person;
$country = $user_details->country;
$date_added = $user_details->created_at;

?>

<div class="row contentIORreg">
    <div class="container">

        <div class="row">

            <div id="IORform" class="col-12">

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo base_url() ?>home/register_link?name=<?php echo $user_details->shipping_company_name . "&data=" . urlencode(base64_encode($user_details->id)); ?>" id="myInput">
                            <div class="input-group-append">
                                <button class="btn btn-dark-yellow" type="button" onclick="myFunction()"><i class="fa fa-file mr-2" aria-hidden="true"></i>Copy Link</button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <h6>Welcome, <strong><?php echo $user_details->shipping_company_name; ?></strong> (<a href="<?php echo base_url(); ?>partner-companies/dashboard">Go to Dashboard</a>, <a href="<?php echo base_url(); ?>partner-companies/logout" class="text-primary">Logout</a>)</h6>
                    </div>
                </div>

                <br>

                <div class="row">

                    <div class="col-md-12 col-12">
                        <?php if ($this->session->flashdata('success-update') != null) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span><?php echo $this->session->flashdata('success-update'); ?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php endif ?>

                        <div class="card">
                            <div class="card-header">
                                <h1 class="card-title dark-blue-title" style="font-size: 23px !important;">Edit Your Profile Here</h1>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <form method="POST">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_name">Shipping Company Name</label>
                                                <input type="text" class="form-control <?php if (form_error('shipping_company_name')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="shipping_company_name" name="shipping_company_name" placeholder="Shipping Company Name" value="<?php echo $shipping_company_name; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_email">Email Address</label>
                                                <input type="email" class="form-control <?php if (form_error('shipping_company_email')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="shipping_company_email" name="shipping_company_email" placeholder="Email Address" value="<?php echo $email; ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_name">Username</label>
                                                <input type="text" class="form-control <?php if (form_error('shipping_company_username')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="shipping_company_username" name="shipping_company_username" placeholder="Username" value="<?php echo $username; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_name">Password</label>
                                                <input type="password" class="form-control <?php if (form_error('shipping_company_password')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="shipping_company_password" name="shipping_company_password" placeholder="Password" value="<?php echo $password; ?>">
                                                <span toggle="#shipping_company_password" class="fas fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_name">Contact Name</label>
                                                <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="contact_person" name="contact_person" placeholder="Contact Name" value="<?php echo $contact_person; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="shipping_company_name">Country</label>
                                                <select class="select2 form-control <?php if (form_error('country')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>" id="country" name="country" style="width: 100%;">
                                                    <option value="">- Select Country -</option>
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

                                    <br>

                                    <div class="row">

                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="form-group">
                                                <button type="submit" name="submit" class="btn btn-dark-blue"><i class="fa fa-check-circle mr-2" aria-hidden="true"></i>Update Profile</button>
                                                <a href="<?php echo base_url(); ?>partner-companies/dashboard" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>