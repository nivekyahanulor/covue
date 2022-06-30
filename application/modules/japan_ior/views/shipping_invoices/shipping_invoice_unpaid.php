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
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link">Shipping Invoice Requests</a></li>
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

                    <?php if ($this->session->flashdata('success') != null) : ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php endif ?>

                    <div class="row">
                        <div class="text-center col-md-12 col-12">

                            <br><br>
                            <h4 class="dark-blue-title">Shipping Invoice is not generated successfully</h4>
                            <br>
                            <p>Payment is not yet verified.</p>
                            <br><br>
                            <a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="btn btn-dark-blue"><i class="fa fa-arrow-left mr-2"></i>Back to Shipping Invoices</a>
                            <br>

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