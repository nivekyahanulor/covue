<?php

$username = $user_details->username;
$password = $user_details->password;
$company_name = $user_details->company_name;
$company_address = $user_details->company_address;
$city = $user_details->city;
$country_id = $user_details->country;
$zip_code = $user_details->zip_code;
$business_license = $user_details->business_license;
$contact_number = $user_details->contact_number;
$contact_person = $user_details->contact_person;
$email = $user_details->email;
$user_role_id = $user_details->user_role_id;
$ior_registered = $user_details->ior_registered;
$online_seller = $user_details->online_seller;
$amazon_seller = $user_details->amazon_seller;
$consultant_id = $user_details->consultant_id;

?>
<!-- Content Wrapper. Contains page content -->
<div class="row contentIORreg">
    <div class="container">
        <div class="row">
            <div class="container">

                <div class="row">

                    <div id="IORform" class="col-12">

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="<?php echo base_url() ?>home/register_user?consultant=<?php echo urlencode(base64_encode($user_id)); ?>" id="myInput">
                                    <div class="input-group-append">
                                        <button class="btn orange-btn" type="button" onclick="myFunction()"><i class="fa fa-file mr-2" aria-hidden="true"></i>Copy Link</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex justify-content-end">
                                <h6>Welcome, <strong><?php echo $user_details->company_name; ?></strong> (<a href="<?php echo base_url(); ?>consultant/dashboard" class="dark-blue-link">Go to Dashboard</a>, <a href="<?php echo base_url(); ?>consultant/logout" class="dark-blue-link">Logout</a>)</h6>
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
                                        <?php if ($this->session->flashdata('success-banner') != null) : ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span><?php echo $this->session->flashdata('success-banner'); ?></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($this->session->flashdata('success-background') != null) : ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span><?php echo $this->session->flashdata('success-background'); ?></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($this->session->flashdata('success-content') != null) : ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span><?php echo $this->session->flashdata('success-content'); ?></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($this->session->flashdata('success-header-color') != null) : ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span><?php echo $this->session->flashdata('success-header-color'); ?></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                        <?php if ($this->session->flashdata('success-footer-color') != null) : ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span><?php echo $this->session->flashdata('success-footer-color'); ?></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php endif ?>
                                        <form action="" method="POST" id="edit_users" role="form">

                                            <div class="row">

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="company_name"><strong>Legal Company Name:</strong></label>
                                                        <input type="text" class="form-control <?php if (form_error('company_name')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $company_name; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="email"><strong>Email:</strong></label>
                                                        <input type="email" class="form-control <?php if (form_error('email')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                                    </div>
                                                </div>

                                            </div>

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
                                                        <label for="password"><strong>Password:</strong></label>
                                                        <input type="password" class="form-control <?php if (form_error('password')) {
                                                                                                        echo 'is_invalid';
                                                                                                    } ?>" id="password" name="password" placeholder="Password" value="<?php echo $password ?>">
                                                        <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="row">

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="contact_person"><strong>Primary Contact Person:</strong></label>
                                                        <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="country"><strong>Country:</strong></label>
                                                        <select class="select2 form-control <?php if (form_error('country')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="country" name="country" style="width: 100%;">
                                                            <option value="">- Select Country -</option>
                                                            <?php
                                                            foreach ($countries as $country) {

                                                                if ($country_id == $country->id) {
                                                                    echo '<option value="' . $country->id . '" selected>' . $country->nicename . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $country->id . '">' . $country->nicename . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-12 d-flex justify-content-end">
                                                    <div class="form-group">
                                                        <button type="submit" name="submit" class="btn btn-dark-blue"><i class="fa fa-check-circle mr-2" aria-hidden="true"></i>Update Profile</button>

                                                        <a href="<?php echo base_url(); ?>consultant/dashboard" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
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

        <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="lineModalLabel">Upload Logo</h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="logo"><strong>Company Logo:</strong></label>
                                <div class="input-group">
                                    <div class="custom-file <?php if (form_error('logo')) {
                                                                echo 'is_invalid';
                                                            } ?>" logo="border-radius: .25rem;">
                                        <input type="file" class="custom-file-input" name="image" value="<?php echo set_value('logo'); ?>" required>
                                        <label class="custom-file-label" for="fosr">Click to upload</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                        <button type="submit" name="uploadlogo" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>