<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Regulated Applications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item active">Regulated Applications</li>
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

                    <?php if ($this->session->flashdata('error') != null) : ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-12 col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title col-md-5">List of your Regulated Products Application</h3>
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
                                    <table id="tblRegulatedApplications" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Invoice Date</th>
                                                <th class="text-center">Regulated Applications</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            foreach ($paid_regulated_applications as $paid_regulated_application) {
                                                echo '<tr id="' . $paid_regulated_application->user_payment_invoice_id . '">';
                                                echo '  <td align="center">' . $paid_regulated_application->regulated_application_id . '</td>';
                                                echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($paid_regulated_application->invoice_date)) . '</td>';
                                                echo '  <td align="center">' . $paid_regulated_application->category_name . '</td>';

                                                // if ($paid_regulated_application->reg_application_active == 0) {
                                                //     echo '<td align="center"><span class="badge badge-danger">Cancelled</span></td>';
                                                //     echo '<td align="center">N/A</td>';
                                                // } else {

                                                if ($paid_regulated_application->payment_status == 1) {
                                                    if (!empty($paid_regulated_application->regulated_application_id)) {
                                                        if ($paid_regulated_application->tracking_status == 7 && $paid_regulated_application->approve_status == 1) {
                                                            echo '<td align="center"><span class="badge badge-success">Application Approved</span></td>';
                                                        } else {
                                                            echo '<td align="center"><span class="badge badge-info">Application In Process</span></td>';
                                                        }
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/tracking-application/' . $paid_regulated_application->regulated_application_id . '" class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View</a></td>';
                                                    } else {
                                                        echo '<td align="center"><span class="badge badge-secondary">Pending</span></td>';
                                                        echo '<td align="center">
                                                                    <a href="' . base_url() . 'japan-ior/create-regulated-application/' . $paid_regulated_application->user_payment_invoice_id . '" id="btn_start_regulated" class="btn btn-xs btn-outline-dark-blue" data-toggle="button" aria-pressed="false"><i class="fa fa-play-circle mr-2"></i>Start Application</a>
                                                                    <button id="btn_start_loading" class="btn btn-xs btn-outline-dark-blue" type="button" disabled style="display: none;">
                                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        <span class="sr-only">Loading...</span>
                                                                    </button>
                                                                  </td>';
                                                    }
                                                } else {
                                                    echo '<td align="center">N/A</td>';
                                                    echo '<td align="center">N/A</td>';
                                                }
                                                // }

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