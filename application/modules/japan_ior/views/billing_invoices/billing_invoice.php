<?php  
    $tot_mail_price = 0;
    if($user_details->user_role_id == 3){
        
        foreach ($total_mailing_price as $key => $value) {
            $tot_mail_price = $tot_mail_price + ($value->quantity * $value->mailing_product_price);
        }
        
    }
    
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Billing Invoice Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="dark-blue-link">Billing Invoices</a></li>
                        <li class="breadcrumb-item active">Billing Invoice Information</li>
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

                    <?php if (isset($errors)) { ?>

                        <?php if ($errors == 0) { ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Successfully Updated Your Profile!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php } else { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Some Errors Found. Please contact administrator.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
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

                    <!-- <h4 class="dark-blue-title text-center">Covue Billing Invoice</h4>

                    <br> -->

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <!-- <div class="callout callout-info">
                                            <h5><i class="fas fa-info"></i> Note:</h5>
                                            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                                         </div> -->

                                    <input type="hidden" name="notify_url" value="<?php echo base_url() ?>japan-ior/ipn">

                                    <!-- Main content -->
                                    <div class="invoice p-3 mb-3">
                                        <!-- title row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                    <img src="<?php echo base_url(); ?>assets/img/covue_main_logo.png" alt="Covue Japan" width="250">
                                                    <!-- <small class="float-right"></small> -->
                                                </h4>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <!-- info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                From
                                                <address>
                                                    <strong><?php echo $user_details->company_name; ?></strong><br>
                                                    <?php echo $user_details->company_address; ?><br>
                                                    <?php echo $user_details->city . ', ' . $country_name->nicename . ' ' . $user_details->zip_code; ?><br>
                                                    Phone: <?php echo $user_details->contact_number; ?><br>
                                                    Email: <?php echo $user_details->email; ?><br>
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">
                                                To
                                                <address>
                                                    <strong>COVUE JAPAN K.K</strong><br>
                                                    3/F, 1-6-19 Azuchimachi Chuo-ku,<br>
                                                    Osaka, Japan 541-0052 Japan<br>
                                                    Phone: +81 (50) 8881-2699<br>
                                                    Email: info@covue.com
                                                </address>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 invoice-col">

                                                <?php
                                                $invoice_no = str_pad($user_payment_invoice->user_payment_invoice_id, 5, '0', STR_PAD_LEFT);
                                                ?>

                                                <b>Invoice #: </b><?php echo $invoice_no; ?><br>
                                                <b>Invoice Date: </b> <?php echo date('m/d/Y', strtotime($user_payment_invoice->invoice_date)); ?><br>
                                                <?php if ($user_payment_invoice->shipping_invoice_id != 0) { ?>
                                                    <b>Shipping Invoice ID : </b> <?php echo $user_payment_invoice->shipping_invoice_id; ?><br><br>
                                                    <?php } else {
                                                    echo "<br>";
                                                } ?>
                                                    <b>Status: </b> <strong><?php echo $user_payment_invoice->paid_sub == 0 ? '<span class="text-danger">Unpaid</span>' : '<span class="text-success">Paid</span>'; ?></strong>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Amount</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        if ($user_payment_invoice->shipping_invoice_id != 0) {
                                                            echo '<tr>';
                                                            echo '  <td>' . $product_pricing_fee->ior_shipment_fees . '</td>';
                                                            echo '  <td>$' . number_format($user_payment_invoice->total - $tot_mail_price - $user_payment_invoice->jct, 2) . '</td>';
                                                            echo '</tr>';

                                                            if($user_details->user_role_id == 3){
                                                                echo '<tr>';
                                                                echo '  <td>Mailing Product Total</td>';
                                                                echo '  <td>$' . number_format($tot_mail_price, 2) . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        }

                                                        if ($user_payment_invoice->register_ior == 1) {
                                                            echo '<tr>';
                                                            echo '  <td>' . $ior_reg_fee->name . '</td>';
                                                            echo '  <td>$' . number_format($ior_reg_fee->price, 2) . '</td>';
                                                            echo '</tr>';
                                                            // echo '<tr>';
                                                            // echo '  <td>Product Lab Testing</td>';
                                                            // echo '  <td>' . number_format($user_payment_invoice->product_lab_testing_total,2) . '</td>';
                                                            // echo '</tr>';
                                                        }

                                                        if ($user_payment_invoice->pli_sub == 1 && $user_details->user_role_id != 3) {
                                                            echo '<tr>';
                                                            echo '  <td>' . $pli_fee->name . '</td>';

                                                            echo '  <td>$' . number_format($pli_fee->price, 2) . '</td>';
                                                            echo '</tr>';
                                                            // echo '<tr>';
                                                            // echo '  <td>Product Lab Testing</td>';
                                                            // echo '  <td>$' . number_format($user_payment_invoice->product_lab_testing_total ,2). '</td>';
                                                            // echo '</tr>';
                                                        }

                                                        if ($user_payment_invoice->product_offer_id != 0) {
                                                            echo '<tr>';
                                                            echo '  <td>' . $user_payment_invoice->name . '</td>';

                                                            echo '  <td>$' . number_format($user_payment_invoice->price, 2) . '</td>';
                                                            echo '</tr>';
                                                            // echo '<tr>';
                                                            // echo '  <td>Product Lab Testing</td>';
                                                            // echo '  <td>$' . number_format($user_payment_invoice->product_lab_testing_total ,2). '</td>';
                                                            // echo '</tr>';
                                                        } 
                                                        
                                                        if ($user_payment_invoice->regulated_label_id != 0) {
                                                            echo '<tr>';
                                                            echo '  <td>' . $user_payment_invoice_product_label->category_name . ' ($4.95 x ' . $req_products_cnt . ' label/s)</td>';

                                                            echo '  <td>$' . number_format($user_payment_invoice_product_label->subtotal, 2) . '</td>';
                                                            echo '</tr>';
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row">
                                            <!-- accepted payments column -->
                                            <div class="col-6">
                                                <?php
                                                if ($user_payment_invoice->status == 0) {
                                                ?>
                                                    <p class="lead">Payment Methods:</p>
                                                    <img src="<?php echo base_url(); ?>assets/img/credit/visa.png" alt="Visa">
                                                    <img src="<?php echo base_url(); ?>assets/img/credit/mastercard.png" alt="Mastercard">
                                                    <img src="<?php echo base_url(); ?>assets/img/credit/american-express.png" alt="American Express">

                                                    <br><br>
                                                    <small class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                                        Please be advised that any payment process takes 2 hours during normal operating hours (Monday - Friday , 9am - 6pm JST). Payment after working hours will be processed on the next working day.
                                                    </small>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-6">
                                                <!-- <p class="lead">Amount Due 2/22/2014</p> -->

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th style="width:50%">Subtotal:</th>
                                                            <td>$<?php echo number_format($user_payment_invoice->subtotal + $tot_mail_price, 2); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>JCT (10%)</th>
                                                            <td>$<?php echo number_format($user_payment_invoice->jct, 2); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td>$<?php echo number_format($user_payment_invoice->total, 2); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                        <?php
                                        if ($user_payment_invoice->status == 0) {
                                        ?>
                                            <br>

                                            <div class="row text-right mr-3">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group mb-0">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="billing_invoice_terms" name="billing_invoice_terms" value="1">
                                                            <label class="custom-control-label" for="billing_invoice_terms" style="font-weight: normal;">I accept the <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank" class="dark-blue-link">Terms and Condition</a>.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>

                                        <br>

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                            <div class="col-12">
                                                <a href="<?php echo base_url() . 'japan-ior/billing-invoice-print/' . $user_payment_invoice->user_payment_invoice_id; ?>" target="_blank" class="btn btn-default"><i class="fas fa-print mr-2"></i>Print</a>
                                                <?php
                                                if ($user_payment_invoice->status == 0) {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="btn btn-outline-dark-blue float-right"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                                                    <a href="#" class="btn btn-dark-yellow float-right" onclick="showConfirmDeleteBillingInvoice(<?php echo $user_payment_invoice->user_payment_invoice_id; ?>)" style="margin-right: 5px;"><i class="fas fa-trash mr-2"></i>Delete Invoice</a>

                                                    <button type="button" id="btn_billing_payment" onclick="billing_invoice_checkout('<?php echo $user_payment_invoice->user_payment_invoice_id; ?>')" class="btn btn-dark-blue float-right" style="margin-right: 5px;"><i class="fas fa-credit-card mr-2"></i>Submit Payment</button>
                                                    <button type="button" id="btn-process-payment" class="btn btn-dark-blue float-right" style="margin-right: 5px;display:none;"><i class="fas fa-credit-card mr-2"></i>Processing .. </button>

                                                    <!--<a href="<?php echo base_url() . 'japan-ior/billing-invoice-checkout/' . $user_payment_invoice->user_payment_invoice_id; ?>" id="btn_billing_payment" class="btn btn-dark-blue float-right" style="margin-right: 5px;"><i class="fas fa-credit-card mr-2"></i>Submit Payment</a>-->
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="btn btn-outline-dark-blue float-right"><i class="fas fa-arrow-left mr-2"></i>Back to Billing Invoices</a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.invoice -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content -->

                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_delete_billing_invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <strong>delete</strong> this billing invoice?</p>
            </div>
            <div class="modal-footer">
                <div id="btn_delete_billing_invoice"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->