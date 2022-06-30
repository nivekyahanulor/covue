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
                        <h6>Welcome, <strong><?php echo $user_details->shipping_company_name; ?></strong> (<a href="<?php echo base_url(); ?>partner-companies/edit-profile" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url(); ?>partner-companies/logout" class="dark-blue-link">Logout</a>)</h6>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div id="IORguide" class="col-md-4">
                        <?php if ($this->session->flashdata('success') != null) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span><?php echo $this->session->flashdata('success'); ?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php endif ?>
                        <div class="text-center">
                            <?php if ($user_details->logo != null) : ?>
                                <img src="<?php echo base_url(); ?>uploads/partners/<?php echo $user_details->logo; ?>" class="img-thumbnail" alt="Shipping Partner Logo">
                            <?php else : ?>
                                <img src="<?php echo base_url(); ?>assets/img/logo-here.png" class="img-thumbnail" alt="Shipping Partner Logo">
                            <?php endif ?>
                        </div>
                        <br><br>

                        <a href="#" class="btn btn-block btn-outline-dark-blue" data-toggle="modal" data-target="#squarespaceModal"><i class="fas fa-file-image mr-2"></i>Upload Logo</a>

                        <br><br>


                    </div>
                    <div class="col-md-8 col-12">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'partner-companies/dashboard'; ?>" data-toggle="tooltip" title="Users Referred"><i class="fas fa-users fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'partner-companies/customer-users'; ?>" data-toggle="tooltip" title="Shipping Invoices sent"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo base_url() . 'partner-companies/regulated-application'; ?>" data-toggle="tooltip" title="Regulated Application"><span class="dark-blue-title"><i class="fas fa-clipboard-check fa-2x"></i></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'partner-companies/pricing-list'; ?>" data-toggle="tooltip" title="IOR Pricing List"><i class="fas fa-search-dollar fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'partner-companies/content'; ?>" data-toggle="tooltip" title="Landing Page Customization"><i class="fas fa-sitemap fa-2x"></i></a>
                            </li>
                        </ul>

                        <div class="card partner-tab">
                            <div class="card-header">
                                <h3 class="card-title"><span class="dark-blue-title">List of Regulated Application</span></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblBillingInvoices" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Application</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($regulated_application as $customer_user) {
                                            echo '<tr>';
                                            echo '<td align="center" style="vertical-align:middle">' . $customer_user->company_name . '</td>';
                                            echo '<td align="center" style="vertical-align:middle">' . $customer_user->category_name . '</td>';
                                            if ($customer_user->tracking_status != 7) {
                                                echo '<td align="center" style="vertical-align:middle">Application Started</td>';
                                            } else {
                                                echo '<td align="center" style="vertical-align:middle">Application Approved</td>';
                                            }
                                            echo '<td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($customer_user->created_at)) . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>

                                    </tbody>
                                </table>
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