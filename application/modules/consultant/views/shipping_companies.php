<div class="row contentIORreg">
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
                        <h6>Welcome, <strong><?php echo $user_details->company_name; ?></strong> (<a href="<?php echo base_url(); ?>consultant/edit-consultant-info" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url(); ?>consultant/logout" class="dark-blue-link">Logout</a>)</h6>
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
                            <?php if ($user_details->avatar != null) : ?>
                                <img src="<?php echo base_url(); ?>uploads/consultants/<?php echo $user_details->avatar; ?>" class="img-thumbnail" alt="Landing Page Logo" style="background-color: #eaeaea;">
                            <?php else : ?>
                                <img src="<?php echo base_url(); ?>assets/img/logo-here.png" class="img-thumbnail" alt="Landing Page Logo" style="background-color: #eaeaea;">
                            <?php endif ?>
                        </div>
                        <br><br>

                        <a href="#" class="btn btn-block btn-outline-dark-blue" data-toggle="modal" data-target="#squarespaceModal"><i class="fas fa-file-image mr-2"></i>Upload Logo</a>

                        <br><br>


                    </div>
                    <div class="col-md-8 col-12">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/dashboard'; ?>" data-toggle="tooltip" title="Users Referred"><i class="fas fa-users fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo base_url() . 'consultant/shipping-companies'; ?>" data-toggle="tooltip" title="Shipping Invoices sent"><span class="dark-blue-title"><i class="fas fa-file-invoice-dollar fa-2x"></i></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/regulated-application'; ?>" data-toggle="tooltip" title="Regulated Application"><i class="fas fa-clipboard-check fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/pricing-list'; ?>" data-toggle="tooltip" title="IOR Pricing List"><i class="fas fa-search-dollar fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/content'; ?>" data-toggle="tooltip" title="Landing Page Customization"><i class="fas fa-sitemap fa-2x"></i></a>
                            </li>
                        </ul>

                        <div class="card partner-tab">
                            <div class="card-header">
                                <h3 class="card-title"><span class="dark-blue-title">List of Shipping Invoices sent</span></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblBillingInvoices" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Total Value of Shipment (JPY)</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if ($count_customer != 0) {
                                            foreach ($company_customer as $customer_user) {
                                                if (empty($customer_user->invoice_no_big) && empty($customer_user->invoice_no_tiny)) {
                                                    if ($customer_user->paid == 0) {
                                                        $invoice_no = '<a href="#" data-toggle="tooltip" data-placement="top" title="Shipping Invoice is not yet approved.">N/A</a>';
                                                    } else {
                                                        $invoice_no = '<a href="#" data-toggle="tooltip" data-placement="top" title="Please click \'Generate Watermarked Invoice\' button inside to generate your invoice number.">N/A</a>';
                                                    }
                                                } else {
                                                    $invoice_user_id = str_pad($customer_user->user_id, 2, '0', STR_PAD_LEFT);
                                                    $invoice_no = $invoice_user_id . '-' . $customer_user->invoice_no_big . '-' . $customer_user->invoice_no_tiny;
                                                }

                                                // $shipping_invoice_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $customer_user->user_id . DIRECTORY_SEPARATOR . $customer_user->shipping_invoice_id . DIRECTORY_SEPARATOR . 'Shipping Invoice Preview.pdf';
                                                // $shipping_invoice_final_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $customer_user->user_id . DIRECTORY_SEPARATOR . $customer_user->shipping_invoice_id . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice.pdf';

                                                echo '<tr>';
                                                echo '  <td align="center" style="vertical-align:middle">' . $customer_user->company_name . '</td>';
                                                // if (file_exists($shipping_invoice_pdf_file) && file_exists($shipping_invoice_final_pdf_file)) {
                                                //     echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $customer_user->user_id . '/' . $customer_user->shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf" target="_blank" class="dark-blue-link">Preview (Approved)</a></td>';
                                                // }

                                                // if (file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                                                //     echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $customer_user->user_id . '/' . $customer_user->shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf" target="_blank" class="dark-blue-link">Preview (Not Approved)</a></td>';
                                                // }

                                                // if (!file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                                                //     echo ' <td align="center"><a href="#" data-toggle="tooltip" data-placement="top" title="Shipping Invoice is not yet generated." class="dark-blue-link">Not Available</a></td>';
                                                // }


                                                echo '  <td align="center" style="vertical-align:middle">' . (($customer_user->paid != '1') ? 'Unpaid' : 'Paid') . '</td>';
                                                echo '  <td align="center" style="vertical-align:middle">' . (!empty($customer_user->total_value_of_shipment) ? number_format($customer_user->total_value_of_shipment, 2) : '0.00') . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
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
                                <div class="custom-file <?php if (form_error('avatar')) {
                                                            echo 'is_invalid';
                                                        } ?>" avatar="border-radius: .25rem;">
                                    <input type="file" class="custom-file-input" name="image" value="<?php echo set_value('avatar'); ?>" required>
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