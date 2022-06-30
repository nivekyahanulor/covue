<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Knowledgebase Database<a href="<?php echo base_url(); ?>knowledgebase/add-product" class="btn btn-info ml-2"><i class="fas fa-plus-circle mr-2"></i>Add New Product</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Knowledgebase</li>
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

                            <table id="tblKnowledgebase" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Product URL</th>
                                        <th class="text-center">Product Category</th>
                                        <th class="text-center">Laws / required documents, etc.</th>
                                        <th class="text-center">Contact Info</th>
                                        <th class="text-center">Comment</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Last Updated By</th>
                                        <th class="text-center">Last Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    foreach ($knowledgebases as $knowledgebase) {

                                        echo '<tr id="' . $knowledgebase->knowledgebase_id . '">';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->knowledgebase_id . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->product . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->product_url . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->category_name . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->laws_req_docs . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->contact_info . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . $knowledgebase->comments . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">';
                                        echo '      <a href="' . base_url() . 'knowledgebase/edit-product/' . $knowledgebase->knowledgebase_id . '" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-edit"></i></a>';
                                        echo '      <button type="button" class="btn btn-outline-danger" onclick="showConfirmDelKnowledgebaseProd(' . $knowledgebase->knowledgebase_id . ')" title="Delete"><i class="nav-icon fas fa-trash"></i></button>';
                                        echo '  </td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . (!empty($knowledgebase->updated_by) ? $knowledgebase->contact_person : 'N/A') . '</td>';
                                        echo '  <td align="center" style="vertical-align:middle">' . (!empty($knowledgebase->updated_at) ? date('m/d/Y', strtotime($knowledgebase->updated_at)) : 'N/A') . '</td>';
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

<div class="modal fade" id="modal_delete_knowledgebase_product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this knowledgebase product?
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