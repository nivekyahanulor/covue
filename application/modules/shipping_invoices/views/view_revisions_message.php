<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Invoice Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>shipping-invoices">Shipping Invoices</a></li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8 offset-md-2 col-12">
                                    <h4 class="text-center">Revisions Message for Shipping Invoice ID: <?php echo $shipping_invoice->shipping_invoice_id; ?></h4>
                                    <br>
                                    <p><?php echo $revision_message->message; ?></p>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-group">
                                        <a href="<?php echo base_url(); ?>shipping-invoices" class="btn btn-secondary"><i class="fa fa-arrow-left mr-2"></i>Back</a>
                                    </div>
                                </div>
                            </div>

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