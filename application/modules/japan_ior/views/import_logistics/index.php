<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Import Logistics</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item active">Import Logistics</li>
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
                                    <h3 class="card-title col-md-5">List of your Imported Logstics</h3>
                                    <div class=" col-md-7 d-flex justify-content-end">
                                        <a href="https://zfrmz.com/eYRbLhgrXZyscDgMDoiT?pocname=<?php echo $user_details->contact_person ?>&cname=<?php echo $user_details->company_name ?>&cemail=<?php echo $user_details->email ?>" class="btn btn-dark-blue"><strong>Avail our Import Logistics</strong></a>
                                     
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="tblRegulatedApplications" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Port of Arrival</th>
                                                <th class="text-center">Customs Clearance</th>
                                                <th class="text-center">Work Orders</th>
                                                <th class="text-center">Shipment Arrives In</th>
                                                <th class="text-center">Shipping Invoice</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (json_decode($logistic_infos)->data as $key => $value) {
                                                # code...

                                            ?>
                                            <tr style="text-align: center;">
                                                <td><?php echo $value->Port_of_Arrival_Street_Address .' '. $value->Port_of_Arrival_Address_Line_2 .' '. $value->Port_of_Arrival_City .' '. $value->Port_of_Arrival_Postal_Zip_Code ?></td>
                                                <td><?php echo $value->Customs_Clearance ?> </td>
                                                <td></td>
                                                <td><?php echo $value->How_will_the_shipment_arrive ?></td>
                                                <td><div class="dIB fL">  <span class="dIB vat mT1 fileIconDefault svgIconsImg fileIconpdf"></span>  <span class="dIB f13 col888 pR" style="max-width: 250px;">    <a id="fileUploadField_4582063000013317158" class="oH tOE nwrp vab dIB pT0" style="max-width: 180px;cursor: pointer;" title="<?php $value->Upload_Shipping_Invoice[0]->file_Name ?>" href="<?php echo 'https://crm.zoho.com/'.$value->Upload_Shipping_Invoice[0]->preview_Url?>"><?php echo $value->Upload_Shipping_Invoice[0]->preview_Url ?></a></span>      </div></td>
                                                <td></td>
                                            </tr>

                                            <?php
                                            } ?>
                                           


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