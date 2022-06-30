<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Shipping Invoice Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link">Shipping Invoices</a></li>
                        <li class="breadcrumb-item active">Shipping Invoice Information</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12 mt-5">

                    <h4 class="dark-blue-title text-center">IOR Shipping Invoice Fees</h4>

                    <div id="paypalCheckoutIOR_Shipping" class="col-md-4 offset-md-4 col-12">

                        <input type="hidden" name="notify_url" value="<?php echo base_url() ?>japan-ior/ipn">

                        <?php echo $ior_fees; ?>

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

<div class="modal fade" id="modal_billing_checkout_shipping">
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
            <div class="modal-footer justify-content-end">
                <button type="button" id="btn_submit_checkout_shipping" class="btn btn-dark-blue">Proceed to Checkout</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->