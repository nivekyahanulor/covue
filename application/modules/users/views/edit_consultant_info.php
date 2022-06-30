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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Consultant</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>users/consultant-listing">Consultant Users</a></li>
                        <li class="breadcrumb-item active">Edit Consultant</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="container-fluid">

            <div class="row">

                <div id="IORform" class="col-12">

                    <div class="col-md-6 col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo base_url() ?>home/register_user?consultant=<?php echo urlencode(base64_encode($consultant_id)); ?>" id="myInput">
                            <div class="input-group-append">
                                <button class="btn orange-btn" type="button" onclick="myFunction()"><i class="fa fa-file mr-2" aria-hidden="true"></i>Copy Link</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-12">

                            <!--  <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php //echo site_url('users/edit_consultant_info/' . $consultant_id); ?>"><span class="dark-blue-title">Consultant Info</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php //echo site_url('users/edit_consultant/' . $consultant_id); ?>"><span class="dark-blue-title">Consultant Webpage Design</span></a>
                            </li>
                           
                        </ul> -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="<?php echo site_url('users/edit_consultant_info/' . $consultant_id); ?>"><span class="">Consultant Info</span></a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url('users/edit_consultant/' . $consultant_id); ?>">Consultant Webpage Design</a>
                                </li>

                            </ul>

                            <div class="card partner-tab">
                                <!-- <div class="card-header row">
                                <h3 class="card-title col-md-5">List of Users Referred</h3>
                                <div class=" col-md-7 d-flex justify-content-end">
                                    <?php
                                    // echo '<a href="#" class="btn btn-dark-blue" style="pointer-events: none;"><i class="fa fa-users"></i> Customer Count : ' . $count_customer . '</a>';
                                    ?>
                                </div>
                            </div> -->
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
                                                    <label for="username">Username:</label>
                                                    <input type="text" class="form-control <?php if (form_error('username')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Password:</label>
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
                                                    <label for="company_name">Legal Company Name:</label>
                                                    <input type="text" class="form-control <?php if (form_error('company_name')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $company_name; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country">Country:</label>
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

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="contact_person">Primary Contact Person:</label>
                                                    <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control <?php if (form_error('email')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>





                                        </div>

                                        <div class="row d-flex justify-content-end">
                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-block btn-success">
                                                        <i class="fas fa-edit mr-2"></i>Update
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url(); ?>users/consultant-listing" class="btn btn-block btn-secondary">
                                                        <i class="fas fa-arrow-left mr-2"></i>Back
                                                    </a>
                                                </div>
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
                        <label for="logo">Company Logo:</label>
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
</div>