<?php

$product_label_subtotal = $product_label_price->fees;
$product_label_percent = $product_label_subtotal * 0.10;
$product_label_total = $product_label_subtotal + $product_label_percent;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Product Labels Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link">Products List</a></li>
                        <li class="breadcrumb-item active">Product Labels Information</li>
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

                    <h4 class="dark-blue-title text-center">Product Label Checkout</h4>

                    <div id="paypalCheckoutIOR" class="col-md-4 offset-md-4 col-12">

                        <input type="hidden" name="notify_url" value="<?php echo base_url() ?>japan-ior/ipn">

                        <div class="row">
                            <div class="col-md-8">
                                <p>Product Label Fee per product</p>
                            </div>
                            <div class="col-md-4">
                                <span style="float: right;">$<?php echo number_format($product_label_price->fees, 2); ?></span>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-8">
                                <p>Subtotal</p>
                            </div>
                            <div class="col-md-4">
                                <span style="float: right;">$<?php echo number_format($product_label_subtotal, 2); ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <p>Japan Consumer Tax (10%)</p>
                            </div>
                            <div class="col-md-4">
                                <span style="float: right;">$<?php echo number_format($product_label_percent, 2); ?></span>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <h2 style="font-weight: bolder;">Total</h2>
                            </div>
                            <div class="col-md-6">
                                <h2 style="float: right; font-weight: bolder;">$<?php echo number_format($product_label_price->price, 2); ?></h2>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <h6 style="font-weight: bolder;">IMPORTANT REMINDER</h6>
                                <p style="font-size: 11px;">Please be advised that IOR Registration process takes 2 hours during normal operating hours (Monday - Friday , 9am - 6pm JST) Registration after working hours will be processed on the next working day.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <center><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppppcmcvdam.png" alt="Pay with PayPal, PayPal Credit or any major credit card" class="img-fluid" /></center>
                            </div>
                        </div>

                        <br>

                        <div class="row text-center">
                            <div class="col-md-12 col-12">
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="product_label_fee_terms" name="product_label_fee_terms" value="1">
                                        <label class="custom-control-label" for="product_label_fee_terms" style="font-weight: normal;">I accept the <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank" class="dark-blue-u-link">Terms and Condition</a>.</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                  <button type="button" onclick="product_label_checkout()" class="btn btn-dark-blue" id="btn_product_label_checkout" style="margin-right: 5px;"><i class="fas fa-credit-card mr-2"></i>Checkout</button>
                                   <button type="button"  id="btn-process-payment"  class="btn btn-dark-blue" style="margin-right: 5px;display:none;"><i class="fas fa-credit-card mr-2"></i>Processing .. </button>
                                 <!--<a href="<?php base_url(); ?>product_label_checkout" id="btn_product_label_checkout" class=" btn btn-dark-blue" name="submit"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>-->
                                </center>
                            </div>
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