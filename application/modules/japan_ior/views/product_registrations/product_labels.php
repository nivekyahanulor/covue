<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Product Labels List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Labels List</li>
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
                                    <h3 class="card-title col-md-5">List of your Product Labels</h3>
                                    <div class=" col-md-7 d-flex justify-content-end">

                                        <?php
                                        if ($user_details->ior_registered == 0) {
                                            echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                                                    <button class="btn btn-dark-blue" style="pointer-events: none;" type="button" disabled><i class="fa fa-tags mr-2"></i><strong>Purchase Product Label</strong></button>
                                                  </span>';
                                        } else {
                                            if ($user_details->paid_product_label == 1) {
                                                echo '&nbsp;<a href="' . base_url() . 'japan-ior/create-product-label" class="btn btn-dark-yellow"><i class="fa fa-tag mr-2"></i>Create Product Label</a>';
                                            } else {
                                                echo '<a href="' . base_url() . 'japan-ior/product-label-terms" class="btn btn-dark-blue"><i class="fa fa-tags mr-2"></i><strong>Purchase Product Label</strong></a>';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="tbl_product_labels" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Product Category</th>
                                                <th class="text-center">Product Details</th>
                                                <th class="text-center">Approved Product Label File</th>
                                                <th class="text-center">Status</th>
                                                <th width="200" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($product_labels as $product_label) {
                                                echo '<tr id="' . $product_label->product_label_id . '">';
                                                echo ' <td align="center">' . $product_label->product_label_id . '</td>';
                                                echo ' <td align="center">' . $product_label->category_name . '</td>';
                                                echo ' <td align="center">' . $product_label->product_name . '</td>';

                                                switch ($product_label->product_label_status) {
                                                    case 1:
                                                        echo '<td align="center"><a href="' . base_url() . 'uploads/product_labels/' . $product_label->user_details_id . '/' . $product_label->product_label_filename . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                                                        echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-success">' . $product_label->label . '</span></td>';
                                                        echo '<td align="center">';
                                                        echo '  <a href="' . base_url() . 'japan-ior/download/' . $product_label->product_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Download"><i class="nav-icon fas fa-download mr-2"></i>Download</a>';
                                                        echo '</td>';
                                                        break;
                                                    case 3:
                                                        echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">Pending</span></td>';
                                                        echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-warning">' . $product_label->label . '</span></td>';
                                                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/edit-product-label/' . $product_label->product_label_id . '" role="button" class="btn btn-xs btn-outline-dark-blue"><i class="fas fa-pen mr-2"></i>Edit Label Details</a></td>';
                                                        break;
                                                    default:
                                                        echo '<td id="status_' . $product_label->product_label_id . '" align="center"><span class="badge badge-secondary">Pending</span></td>';
                                                        echo '<td align="center"><span class="badge badge-primary">Product Label is on process</span></td>';
                                                        echo '<td align="center">No Action</td>';
                                                }

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

<div class="modal fade" id="announcement">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Announcement to COVUE IOR Customers:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php if ($user_details->ior_registered == 1 && $user_details->pli == 0) : ?>
                    <p>We have updated our terms of use for COVUE IOR services.</p>
                    <p>Effective January 1, 2021, all users will be assessed and annual Product Liability fee.</p>
                    <p>Information about our updated terms can be found <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank">here</a>.</p>
                <?php else : ?>
                    <h5>From July 1, 2020, DHL Japan has stopped all shipments to Amazon FBA.</h5>
                    <br>
                    <h5>Do not use DHL for your shipping to Japan FBA locations.</h5>
                <?php endif ?>

            </div>
            <div class="modal-footer d-flex justify-content-end">

                <?php if ($user_details->ior_registered == 1 && $user_details->pli == 0) : ?>
                    <a href="<?php echo base_url(); ?>japan-ior/pli" id="btn_pay_pli_announcement" class="btn btn-dark-blue"><i class="fas fa-thumbs-up mr-2"></i>Pay Now</a>
                <?php else : ?>
                    <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                <?php endif ?>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_register_company">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php if (!$has_approved_products) :
                ?>
                    <p>Make sure your products are eligible before you register and pay IOR registration.</p>
                <?php else :
                ?>
                    <p>Approval takes 24 hours from submission during normal business hours Monday to Friday 09:30 to 17:30.</p>
                <?php endif
                ?>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a href="https://www.covue.com/product-eligibility-check/" target="_blank" role="button" class="btn btn-dark-blue">Check Products Eligibility</a>
                <a href="<?php echo base_url(); ?>japan-ior/ior" role="button" class="btn btn-outline-dark-blue">Register IOR</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_request_ior_no_prod">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Please register your products first before you request IOR shipping.</p>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a href="<?php echo base_url(); ?>japan-ior/product_registrations" role="button" class="btn btn-dark-blue">Register Your Products Here</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->