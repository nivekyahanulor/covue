<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Upload Lab Test Results</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>regulated-applications">Regulated Applications</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item active">Upload Lab Test Results</li>
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
                            <?php if ($this->session->flashdata('success') != null) { ?>

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php } ?>

                            <div class="col-md-8 offset-md-2 col-12">

                                <form action="" method="POST" enctype="multipart/form-data" role="form" id="frm_manufacturer_details">
                                    <input type="hidden" name="upload_num_id" id="upload_num_id" value='1'>
                                    <div id="upload-lab-test-con" style="padding: 1rem">
                                        <div class="row upload-row" id="con-upload-1" data-id="1">
                                            <div class="col-12">
                                                <div class="form-group col-12">
                                                    <div class="input-group">
                                                        <div class="custom-file" style="border-radius: .25rem;">
                                                            <input type="file" class="custom-file-input" id="con_file_1" name="con_file_1">
                                                            <label class="custom-file-label" for="con_file_1">Upload Product Lab Test Here</label>
                                                        </div>
                                                        &nbsp;&nbsp;
                                                        <button type="button" class="btn btn-outline-danger" onclick="removeUploadCon(1)"><i class="fas fa-times-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 d-flex justify-content-end">
                                            <div class="form-group">
                                                <button type="button" id="add_upload_lab_testing" data-fba="" class="btn btn-outline-primary"><i class="fas fa-plus-circle mr-2"></i>Add another item</button>
                                                <button type="submit" id="upload_lab_test_files" data-fba="" name="upload_lab_test_files" class="btn btn-outline-success"><i class="fas fa-arrow-up mr-2"></i>Upload Product Lab Results</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
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

<div class="modal fade" id="modal_assigned_admin_reg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm New Application Assignment?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to assign the New Application to <strong id="assign_admin_name"></strong>?
                <br><br>
                The assigned compliance staff will receive a notification about the new application.
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

<div class="modal fade" id="modal_delete_shipping_company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning:</h4>
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

<script>
    $(function() {
        // Summernote
        $(".remarks_msg").summernote({
            placeholder: 'Place your remarks here ...',
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