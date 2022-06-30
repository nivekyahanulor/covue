<!-- <div id="contentEcommerceBody" class="row">
    <div class="container">
        <br>
        

        <div class="row">
            <div  class="col-md-3 wrap" style="padding-right: 2rem">
                <p><a href="">Announcement</a></p>
                <p class="text-left">DHL Japan has stopped all shipments to Amazon FBA.
                </p>
                <p>
                Do not use DHL for your shipping to Japan FBA locations
                </p>
                <br><br><br><br><br><br>
                <p>
                    <a href="">Helpful Documents</a>
                </p>
                <p>
                    <a href="">Help Center</a>
                </p>
            </div>
            <div  class="col-md-9 text-left" style="">
                <h1 style="color: #012d60; margin-top: 10px">List of Services</h1>
                <table id="example" class="display" style="width:100%">
                    <thead style="background: #f1c40f">
                        <tr>
                            <th>List of Product/s</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Amazon Account Set-up</td>
                            <td>Pending</td>
                            <td><a href="#">View Details</a></td>
                            <td><a href=""><i class="fas fa-pen"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div> -->

<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col-md-6 col-12">
            <a href="<?php echo base_url() . 'ecommerce/amazon'; ?>" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to Amazon Services</a>

        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
        </div>
    </div>
</div>

<div class="row contentIORreg">
    <div class="container">

        <div class="row">

            <div id="IORform" class="col-12">

                <?php if ($this->session->flashdata('success') != null) : ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endif ?>

                <?php if ($this->session->flashdata('error') != null) : ?>

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endif ?>

                <div class="row">
                    <div class="col-md-12 col-12">

                        <div class="card">
                            <div class="card-header row">
                                <h3 class="card-title col-md-5">List of your COVUE Amazon Billing Invoices</h3>
                                <div class=" col-md-7 d-flex justify-content-end">
                                    <?php
                                    if ($billing_invoices_unpaid_count == 0) {
                                        echo '<a href="' . base_url() . 'ecommerce/amazon_purchase_service" class="btn btn-dark-blue"><i class="fa fa-cogs mr-2"></i><strong>Purchase AMAZON Services</strong></a>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblBillingInvoices" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Invoice Date</th>
                                            <th class="text-center">Product Category</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        foreach ($billing_invoices as $billing_invoice) {

                                            $product_name = '';

                                            if ($billing_invoice->register_ior == 1) {
                                                $product_name .= 'IOR One-Time Registration Fee' . '<br>';
                                            }

                                            if ($billing_invoice->pli_sub == 1) {
                                                $product_name .= 'Product Liability Insurance' . '<br>';
                                            }

                                            if ($billing_invoice->product_offer_id != 0) {
                                                $product_name .= '<strong>' . $billing_invoice->name . '</strong>';
                                            }

                                            echo '<tr id="' . $billing_invoice->user_payment_invoice_id . '">';
                                            echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($billing_invoice->invoice_date)) . '</td>';
                                            echo '  <td align="center">' . $product_name . '</td>';

                                            if ($billing_invoice->register_ior == 1 || $billing_invoice->pli_sub == 1) {
                                                if ($billing_invoice->product_offer_id != 0) {
                                                    echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered, Application On Process</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                                } else {
                                                    echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                                }
                                            } else {
                                                echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">Application On Process</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                            }

                                            echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><p><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-dark-blue"><i class="fa fa-receipt mr-2"></i>View Invoice</a></p><p><a href="' . base_url() . 'ecommerce/amazon_account_setup_form/' . $billing_invoice->amazon_account_id . '" type="submit" onclick="" class="btn btn-xs btn-dark-blue"><i class="fa fa-receipt mr-2"></i>Submit requirements</a></p></td>' : '<td align="center" style="vertical-align:middle"><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Now</a></td>';
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