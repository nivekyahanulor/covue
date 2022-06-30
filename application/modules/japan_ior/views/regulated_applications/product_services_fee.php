<?php
if ($user_details->user_role_id != 3) {
    if ($user_details->ior_registered != 1 && $user_details->pli != 1) {
        $subtotal = $ior_reg_fee->price + $pli_fee->price;
    } else if ($user_details->ior_registered == 1 && $user_details->pli != 1) {
        $subtotal = $pli_fee->price;
    } else {
        $subtotal = 0.00;
    }
}else{
    if ($user_details->ior_registered != 1) {
        $subtotal = $ior_reg_fee->price;
    } else {
        $subtotal = 0.00;
    }
}


$jct = $subtotal * 0.1;
$total = $subtotal + $jct;

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Apply for Regulated Application</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/regulated-applications" class="dark-blue-link">Regulated Applications</a></li>
                        <li class="breadcrumb-item active">Apply for Regulated Application</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6 col-12 p-5">
                    <h4 id="product_title_info" class="dark-blue-title text-center">Non-regulated Applications Services</h4>

                    <br>

                    <p id="product_info" class="text-justify">Non-Regulated products are defined as products that can be imported without pre-approval from a Japan government agency or, that do not require the seller to have a Japan license for that product to be sold. <br><br>To know more about importing Non Regulated Product in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/Non-Regulated-Pricing-and-Information-3-1.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a></p>

                    <br>

                    <p class="text-center">Not sure what category of your product is?</p>
                    <p class="text-center"><a href="https://www.covue.com/product-eligibility/" class="dark-yellow-link" target="_blank">Click here</a> to check your Product Eligibility.</p>
                </div>

                <div class="col-md-6 col-12 p-5">

                    <form action="" method="POST" id="frmProductsServices" role="form">

                        <div class="row" style="display: none;">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product_services"><strong>Select Product Services:</strong></label>
                                    <select class="form-control" id="product_services" name="product_services" style="width: 100%;" disabled>
                                        <?php
                                        foreach ($product_services as $product_service) {
                                            if ($product_service->id != 3) {
                                                if ($product_service->id == 1) {
                                                    echo '<option value="' . $product_service->id . '" selected>' . $product_service->label . '</option>';
                                                } else {
                                                    echo '<option value="' . $product_service->id . '">' . $product_service->label . '</option>';
                                                }
                                            } else {
                                                echo '<option value="' . $product_service->id . '">' . $product_service->label . ' - Coming Soon*</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <center id="proc_ecom_btn" style="display: none"><a href="../ecommerce" class="btn btn-success">PROCCEED</a></center>
                        <br>

                        <div class="row" id="products_offer_con">

                            <div class="col-12">
                                <div class="form-group">
                                    
                                    <?php if($user_details->user_role_id != 3): ?>
                                    <label for="products_offer"><strong>Select Product Category:</strong></label>
                                    <select class="form-control" id="products_offer" name="products_offer" style="width: 100%;">
                                        <option value="0|0" selected>Non-Regulated Import</option>
                                        <?php
                                        foreach ($products_offer as $product_offer) {
                                            if ($product_offer->product_offer_id != 1 && $product_offer->product_offer_id != 2 && $product_offer->product_service_id != 2) {
                                                echo '<option value="' . $product_offer->product_category_id . '|' . $product_offer->product_offer_id . '">' . $product_offer->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php else: ?>
                                    <label for="products_offer"><strong>Product Category:</strong></label>
                                    <br>
                                    <label>Non-Regulated Import</label>
                                    <input type="hidden" id="products_offer" name="products_offer" value="0|0">
                                    <?php endif ?>
                                </div>
                            </div>

                        </div>

                        <!-- <div class="row" id="products_testing_con" style="display: none">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="products_testng"><strong>How many products are you planning to import?:</strong></label>
                                    <input class="form-control" type="number" name="product_testing" id="product_testing">
                                </div>
                                <small>To mitigate (lower) the risk of recall or potential harm to Japanese buyers of COVUE IOR clients. COVUE will require the testing of all regulated products. Product testing will be controlled by COVUE. Product testing is per product. Click <a href="#"><b>here</b></a> to know the process.</small>
                            </div>

                        </div> -->

                        <br>

                        <div id="paypalCheckoutIORregistered" class="col-12" style="<?php echo ($user_details->ior_registered == 1 && $user_details->pli == 1 ? 'display: block' : 'display: none'); ?>">

                            <div id="non_reg_notes" class="row" style="display: block;">
                                <div class="col-md-12">
                                    <strong>
                                        <p class="text-center">Registered company can register non-regulated products anytime.</p>
                                    </strong>
                                </div>
                            </div>

                            <center>
                                <?php
                                if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                                    echo '<a href="' . base_url() . 'japan-ior/product-registrations" class="btn btn-dark-blue"><i class="fa fa-box-open mr-2"></i><strong>Register Product</strong></a>';
                                } else {
                                    echo '<a href="' . base_url() . 'japan-ior/product-registration" class="btn btn-dark-blue"><i class="fa fa-box-open mr-2"></i><strong>Register Product</strong></a>';
                                }
                                ?>
                            </center>

                        </div>

                        <div id="paypalCheckoutIOR" class="col-12" style="<?php echo ($user_details->ior_registered != 1 || $user_details->pli != 1 ? 'display: block' : 'display: none'); ?>">

                            <input type="hidden" name="notify_url" value="<?php echo base_url(); ?>japan-ior/ipn">
                            <input type="hidden" id="ior_registered" name="ior_registered" value="<?php echo $user_details->ior_registered; ?>">
                            <input type="hidden" id="pli" name="pli" value="<?php echo $user_details->pli; ?>">

                            <?php
                            if ($user_details->ior_registered != 1) {
                            ?>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>
                                            <?php echo $ior_reg_fee->name; ?>
                                            &nbsp;
                                            <i class="fa fa-lg fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="This is only a one-time payment. We guarantee that you will not be charged again after payment."></i>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" id="ior_reg_fee" value="<?php echo $ior_reg_fee->price; ?>">
                                        <span style="float: right;">
                                            $<?php echo $ior_reg_fee->price; ?>
                                        </span>
                                    </div>
                                </div>

                            <?php
                            }

                            if ($user_details->pli != 1 && $user_details->user_role_id != 3) {
                            ?>

                                <div class="row">
                                    <div class="col-md-8">
                                        <p>
                                            <?php echo $pli_fee->name; ?>
                                            &nbsp;
                                            <i class="fa fa-lg fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="Product Liability Insurance will be expired after a year."></i>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" id="pli_fee" value="<?php echo $pli_fee->price; ?>">
                                        <span style="float: right;">$<?php echo $pli_fee->price; ?></span>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                            <div class="row" id="product_testing_con" style="display: none">
                                <div class="col-md-8">
                                    <p id="">Product Lab Testing Fee</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" id="plt_val" name="plt" value="0">
                                    <span id="product_testing_price" style="float: right;">0</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <p id="regulated_name"></p>
                                </div>
                                <div class="col-md-4">
                                    <span id="regulated_price" style="float: right;"></span>
                                </div>
                            </div>

                            <div id="medical_devices_desc" class="row" style="display: none;">
                                <div class="col-md-12">
                                    <strong>Includes:</strong><br>
                                    <span style="margin-left: 20px;">- MHLW Manufacturer & Ingredient Pre-Notification</span><br>
                                    <span style="margin-left: 20px;">- Product Labeling Compliance</span><br>
                                    <span style="margin-left: 20px;">- Product Approval Application</span>
                                </div>
                            </div>

                            <div id="cosmetics_desc" class="row" style="display: none;">
                                <div class="col-md-12">
                                    <strong>Includes:</strong><br>
                                    <span style="margin-left: 20px;">- MHLW Manufacturer & Ingredient Pre-Notification</span><br>
                                    <span style="margin-left: 20px;">- Internal Product Testing</span><br>
                                    <span style="margin-left: 20px;">- Product Labeling Compliance</span><br>
                                    <span style="margin-left: 20px;">- Product Approval Application</span>
                                </div>
                            </div>

                            <div id="japan_radio_desc" class="row" style="display: none;">
                                <div class="col-md-12">
                                    <strong>Need to upload your Japan Radio Law Certificate</strong>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-8">
                                    <p>Subtotal</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" id="subtotal_val" name="subtotal" value="<?php echo $subtotal; ?>">
                                    <span id="subtotal" style="float: right;">
                                        $<?php echo round($subtotal, 2); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <p>Japan Consumer Tax (10%)</p>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" id="jct_val" name="jct" value="<?php echo $jct; ?>">
                                    <span id="jct" style="float: right;">
                                        $<?php echo round($jct, 2); ?>
                                    </span>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <h2 style="font-weight: bolder;">Total</h2>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" id="total_val" name="total" value="<?php echo $total; ?>">
                                    <h2 id="total" style="float: right; font-weight: bolder;">
                                        $<?php echo round($total, 2); ?>
                                    </h2>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6 style="font-weight: bolder;">IMPORTANT REMINDER</h6>
                                    <p style="font-size: 11px;">Please be advised that IOR Registration process takes 2 hours during normal operating hours (Monday - Friday , 9am - 6pm JST) Registration after working hours will be processed on the next working day.</p>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <a href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
                                    </center>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>
            <!-- /.row -->

            <br>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_billing_checkout">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Important Notice!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p><strong>Billing Invoice</strong> will be created.</p>
                <p>You need to <strong>pay</strong> it first before creating another invoice.</p>
                <br>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="billing_checkout_terms" name="billing_checkout_terms" value="1">
                    <label class="custom-control-label" for="billing_checkout_terms" style="font-weight: normal;"><strong>I fully read and understand.</strong></label>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" id="btn_submit_checkout" class="btn btn-dark-blue">Proceed to Checkout</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->