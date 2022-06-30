<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Billing Invoice List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
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
                    <div class="card">
                        <!-- <div class="card-header">
              <h3 class="card-title">Product Qualification List</h3>
            </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">

                            <?php if ($this->session->flashdata('success') != null) : ?>

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php endif ?>

                            <table id="tblUsersSub" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Invoice Date</th>
                                        <th class="text-center">Company Name</th>
                                        <th class="text-center">Product Category</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Total Paid (USD)</th>
                                        <th width="170" class="text-center">Action</th>
                                        <th class="text-center">Last Updated By</th>
                                        <th class="text-center">Last Date Updated</th>
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

                                            if ($billing_invoice->pli_sub == 1) {
                                                $product_name .= 'Product Liability Insurance' . '<br>';
                                            }

                                            if ($billing_invoice->product_offer_id != 0) {
                                                $product_name .= '<strong>' . $billing_invoice->name . '</strong>';
                                            }
                                        }

                                        echo '<tr id="' . $billing_invoice->user_payment_invoice_id . '">';
                                        echo '  <td align="center" style="vertical-align:middle">' . $billing_invoice->user_payment_invoice_id . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($billing_invoice->invoice_date)) . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $billing_invoice->user_company_name . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $product_name . '</td>';

                                        switch ($billing_invoice->payment_status) {
                                            case 1:
                                                if ($billing_invoice->register_ior == 1 || $billing_invoice->pli_sub == 1) {
                                                    if ($billing_invoice->product_offer_id != 0) {
                                                        echo '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered, Application In Process</span></td>';
                                                    } else {
                                                        echo '<td align="center" style="vertical-align:middle"><span class="badge badge-success">IOR Registered</td>';
                                                    }
                                                } else {
                                                    echo '<td align="center" style="vertical-align:middle"><span class="badge badge-success">Application In Process</td>';
                                                }
                                                break;
                                            case 2:
                                                echo '<td align="center" style="vertical-align:middle"><span class="badge badge-success">Completed</span></td>';
                                                break;
                                            default:
                                                echo '<td align="center" style="vertical-align:middle"><span class="badge badge-danger">Not Yet Paid</span></td>';
                                        }

                                        echo '  <td align="center" style="vertical-align:middle">' . number_format($billing_invoice->total, 2) . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">';
                                        echo '      <button type="button" class="btn btn-outline-success" onclick="showSetBillingComplete(' . $billing_invoice->user_payment_invoice_id . ')" title="Application is Completed"><i class="nav-icon fas fa-check-circle"></i></button>';
                                        echo '      <button type="button" class="btn btn-outline-primary" onclick="showSetBillingPaid(' . $billing_invoice->user_payment_invoice_id . ')" title="Payment Verified"><i class="nav-icon fas fa-hand-holding-usd"></i></button>';
                                        echo '      <button type="button" class="btn btn-outline-danger" onclick="showSetBillingCancel(' . $billing_invoice->user_payment_invoice_id . ')" title="Cancel Invoice"><i class="nav-icon fas fa-times-circle"></i></button>';
                                        echo '  </td>';
                                        echo (!empty($billing_invoice->last_updated_by_id)) ? '<td align="center" style="vertical-align:middle">' . $billing_invoice->last_updated_by . '</td>' : '<td align="center" style="vertical-align:middle">N/A</td>';
                                        echo (!empty($billing_invoice->last_date_updated)) ? '<td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($billing_invoice->last_date_updated)) . '</td>' : '<td align="center" style="vertical-align:middle">N/A</td>';
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
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_billing_complete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-success">complete</strong> status?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_complete"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_billing_paid">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-primary">paid</strong>?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_paid"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_billing_cancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-danger">cancel</strong>?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_cancel"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_delete_user_subscriptions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this shipping company?
            </div>
            <div class="modal-footer">
                <div id="confirmButtons"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->