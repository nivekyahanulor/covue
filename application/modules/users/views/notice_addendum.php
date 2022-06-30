<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Notice and Addendum</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Update Notice and Addendum</li>
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

                            <div class="row">

                                <div id="IORform" class="col-md-12">

                                    <?php if (isset($errors)) : ?>

                                        <?php if ($errors == 0) : ?>

                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Successfully Updated Notice and Addendum!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php endif ?>

                                        <?php if ($errors == 1) : ?>

                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                Notice and Addendum is empty!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php endif ?>

                                        <?php if ($errors == 2) : ?>

                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?php echo $error_msgs; ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php endif ?>

                                    <?php endif ?>

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

                                    <form action="" method="POST" enctype="multipart/form-data" id="frm_notice_addendum" role="form">

                                        <div class="row">

                                            <div class="col-md-6 offset-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="notice_addendum">Notice and Addendum <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: pdf only."></i>

                                                        <?php
                                                        if (file_exists('uploads/docs/notice_and_addendum.pdf')) {
                                                        ?>
                                                            <a href="<?php echo base_url() . 'uploads/docs/notice_and_addendum.pdf'; ?>" target="_blank">(View File Here)</a>
                                                        <?php
                                                        }
                                                        ?>

                                                    </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="notice_addendum" name="notice_addendum" title="">
                                                            <label class="custom-file-label" for="notice_addendum">Click to Browse</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row justify-content-end">

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-block btn-success">Update</button>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url(); ?>users/listing" class="btn btn-block btn-outline-danger">Back</a>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
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