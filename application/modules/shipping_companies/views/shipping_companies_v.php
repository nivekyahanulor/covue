<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Companies List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Shipping Companies</li>
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
                        <!-- <div class="card-header">
              <h3 class="card-title">Product Qualification List</h3>
            </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">

                            <?php if ($this->session->flashdata('success') != null) : ?>

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php endif ?>

                            <table id="tblShippingCompanies" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Shipping Company Name</th>
                                        <th class="text-center">Contact Person</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Partner</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Last Updated By</th>
                                        <th class="text-center">Last Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    foreach ($shipping_companies as $shipping_company) {
                                        echo '<tr id="' . $shipping_company->shipping_company_id . '">';
                                        echo '  <td align="center">' . $shipping_company->shipping_company_id . '</td>';
                                        echo '  <td align="center">' . $shipping_company->shipping_company_name . '</td>';
                                        echo '  <td align="center">' . $shipping_company->contact_person . '</td>';
                                        echo '  <td align="center">' . $shipping_company->email . '</td>';
                                        echo '  <td align="center">' . (($shipping_company->partner == 1) ? 'Yes' : 'No') . '</td>';
                                        echo '  <td align="center">';
                                        echo '  <a href="' . base_url() . 'shipping-companies/edit-shipping-company/' . $shipping_company->shipping_company_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-edit"></i></a>';
                                        echo '  <button type="button" class="btn btn-outline-danger" onclick="showConfirmationDeleteShippingCompany(\'' . $shipping_company->shipping_company_id . '\')" title="Delete"><i class="nav-icon fas fa-trash-alt"></i></button>';
                                        echo '  </td>';

                                        if (!empty($shipping_company->last_updated_by_id)) {
                                            echo ' <td align="center">' . $shipping_company->last_updated_by . '</td>';
                                        } else {
                                            echo '<td align="center">N/A</td>';
                                        }

                                        if (!empty($shipping_company->last_date_updated)) {
                                            echo ' <td align="center">' . date('m/d/Y', strtotime($shipping_company->last_date_updated))  . '</td>';
                                        } else {
                                            echo '<td align="center">N/A</td>';
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
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal_delete_shipping_company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Shipping Company:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this shipping company?
            </div>
            <div class="modal-footer">
                <div id="confirmButtons"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->