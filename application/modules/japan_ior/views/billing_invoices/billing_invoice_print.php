<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Covue Billing Invoice Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/jpg" href="<?php echo base_url(); ?>assets/img/favicon.png" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <img src="<?php echo base_url(); ?>assets/img/covue_main_logo.png" alt="Covue Japan" width="250">
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
                                    <b>Invoice Date: </b> <?php echo date('m/d/Y', strtotime($user_payment_invoice->invoice_date)); ?><br><br>
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
                                            
                                            if($user_payment_invoice->shipping_invoice_id != 0){ 
                                                echo '<tr>';
                                                echo '  <td>' . $product_pricing_fee->ior_shipment_fees . '</td>';
                                                echo '  <td>$' . number_format($user_payment_invoice->total, 2) . '</td>';
                                                echo '</tr>';
                                            }

                                            if ($user_payment_invoice->register_ior == 1) {
                                                echo '<tr>';
                                                echo '  <td>' . $ior_reg_fee->name . '</td>';
                                                echo '  <td>$' . number_format($ior_reg_fee->price, 2) . '</td>';
                                                echo '</tr>';
                                            }

                                            if ($user_payment_invoice->pli_sub == 1 && $user_details->user_role_id != 3) {
                                                echo '<tr>';
                                                echo '  <td>' . $pli_fee->name . '</td>';
                                                echo '  <td>$' . number_format($pli_fee->price, 2) . '</td>';
                                                echo '</tr>';
                                            }

                                            if ($user_payment_invoice->product_offer_id != 0) {
                                                echo '<tr>';
                                                echo '  <td>' . $user_payment_invoice->name . '</td>';
                                                echo '  <td>$' . number_format($user_payment_invoice->price, 2) . '</td>';
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
                                <div class="col-6 offset-md-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$<?php echo number_format($user_payment_invoice->subtotal, 2); ?></td>
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

                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>