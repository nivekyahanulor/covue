<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Billing Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item active">Billing Invoices</li>
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

                    <?php if ($this->session->flashdata('success') != null) { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php } ?>

                    <?php if ($this->session->flashdata('error') != null) { ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('error'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12 col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title col-md-5">List of your COVUE Billing Invoices</h3>
                                    <div class=" col-md-7 d-flex justify-content-end">
                                        <?php
                                        if ($billing_invoices_unpaid_count == 0) {
                                            echo '<a href="' . base_url() . 'japan-ior/product-services-fee" class="btn btn-dark-blue"><i class="fa fa-gavel mr-2"></i><strong>Apply for Regulated Application</strong></a>';
                                        } else {
                                            echo '<a href="' . base_url() . 'japan-ior/billing-invoices" class="btn btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Unpaid Invoices first!</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="tblBillingInvoices" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
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
                                                
                                                if ($billing_invoice->shipping_invoice_id != 0) {
                                                    $product_name .= '<strong> Shipping Invoice ID #' . $billing_invoice->shipping_invoice_id . '</strong>';
                                                } else {
                                                    if ($billing_invoice->register_ior == 1) {
                                                        $product_name .= 'IOR One-Time Registration Fee' . '<br>';
                                                    }

                                                    if ($billing_invoice->pli_sub == 1 && $user_details->user_role_id != 3) {
                                                        $product_name .= 'Product Liability Insurance' . '<br>';
                                                    }

                                                    if ($billing_invoice->product_offer_id != 0) {
                                                        $product_name .= '<strong>' . $billing_invoice->name . '</strong>';
                                                    }else{
                                                        $q_billing_invoice_product_label = $this->Japan_ior_model->fetch_billing_invoice_product_label($billing_invoice->user_payment_invoice_id);
                                                        $billing_invoice_product_label = $q_billing_invoice_product_label->result();
                                                        $product_name .= '<strong>' . $billing_invoice_product_label[0]->category_name . '</strong>';
                                                    }
                                                }

                                                echo '<tr id="' . $billing_invoice->user_payment_invoice_id . '">';
                                                echo '  <td align="center">' . $billing_invoice->user_payment_invoice_id . '</td>';
                                                echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($billing_invoice->invoice_date)) . '</td>';
                                                echo '  <td align="center">' . $product_name . '</td>';

                                                if ($billing_invoice->register_ior == 1 || $billing_invoice->pli_sub == 1) {
                                                    if ($billing_invoice->product_offer_id != 0) {
                                                        echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered, Application In Process</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                                    } else {
                                                        echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                                    }
                                                } else {
                                                    echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><span class="badge badge-success">Application In Process</span></td>' : '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                                }

                                                echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View</a></td>' : '<td align="center" style="vertical-align:middle"><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Now</a></td>';
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
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->