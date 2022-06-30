<?php

if (empty($shipping_invoice->invoice_no_big) && empty($shipping_invoice->invoice_no_tiny)) {
    $invoice_no = 'N/A';
} else {
    $invoice_user_id = str_pad($shipping_invoice->user_id, 2, '0', STR_PAD_LEFT);
    $invoice_no = $invoice_user_id . '-' . $shipping_invoice->invoice_no_big . '-' . $shipping_invoice->invoice_no_tiny;
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Send Shipping Invoice Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link">Shipping Invoice Requests</a></li>
                        <li class="breadcrumb-item active">Send Shipping Invoice Request</li>
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

                    <form action="" method="POST">

                        <div class="row">
                            <div class="col-12">

                                <?php if (isset($errors)) : ?>
                                    <?php if ($errors == 1) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (!empty(validation_errors())) : ?>

                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <h4 class="alert-heading">Form not yet submitted!</h4>

                                        <hr>

                                        <p class="mb-0"><?php echo validation_errors(); ?></p>

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                <?php endif ?>

                                <div class="form-group">
                                    <label for="invoice_send_to"><strong>Send To <small>(use comma to separate emails.):</small></strong></label>
                                    <input type="text" class="form-control" id="invoice_send_to" name="invoice_send_to" placeholder="Enter Recipients">
                                </div>

                                <div class="form-group">
                                    <label for="invoice_cc"><strong>CC <small>(use comma to separate emails.):</small></strong></label>
                                    <input type="text" class="form-control" id="invoice_cc" name="invoice_cc" placeholder="Enter CC emails">
                                </div>

                                <div class="form-group">
                                    <label for="invoice_subject"><strong>Subject:</strong></label>
                                    <input type="text" class="form-control" id="invoice_subject" name="invoice_subject" placeholder="Subject" value="<?php echo $user_details->company_name . ' - Invoice #: ' . $invoice_no; ?>">
                                </div>

                                <div class="row mb-2" style="margin-right: 0; margin-left: 0;">
                                    <span id="pdf_attached" class="badge badge-success col-12">PDF is successfully attached</span>
                                </div>

                                <div class="form-group">
                                    <textarea id="invoice_msg" name="invoice_msg" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-dark-blue" name="submit" title="Send Shipping Invoice"><i class="fas fa-check-circle mr-2"></i>Send Shipping Invoice</button>
                                            <a href="<?php echo base_url() . 'japan-ior/shipping-invoices'; ?>" role="button" class="btn btn-outline-dark-blue" title="Back"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(function() {
        // Summernote
        $("#invoice_msg").summernote({
            placeholder: 'Place your message here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })
    })
</script>