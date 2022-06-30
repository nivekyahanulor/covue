<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Product - Knowledgebase</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>knowledgebase">Knowledgebase</a></li>
                        <li class="breadcrumb-item active">Add Product</li>
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
                                                Successfully Added New Product!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php else : ?>

                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                Some Errors Found. Please contact your administrator.
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

                                    <form action="" method="POST" id="add_product" role="form">

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product">Product</label>
                                                    <input type="text" class="form-control <?php if (form_error('product')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="product" name="product" placeholder="Product" value="<?php echo set_value('product'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product_url">Product URL</label>
                                                    <input type="text" class="form-control <?php if (form_error('product_url')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="product_url" name="product_url" placeholder="Product URL" value="<?php echo set_value('product_url'); ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="product_category">Product Category</label>
                                                    <select class="form-control <?php if (form_error('product_category')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>" id="product_category" name="product_category">
                                                        <option value=""> - Select Product Category - </option>
                                                        <?php foreach ($product_categories as $product_category) { ?>
                                                            <option value="<?php echo $product_category->id; ?>"> <?php echo $product_category->category_name; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $('select#product_category').val('<?php echo $this->input->post('product_category'); ?>');
                                            </script>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="laws_req_docs">Laws / required documents, etc.</label>
                                                    <input type="text" class="form-control <?php if (form_error('laws_req_docs')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="laws_req_docs" name="laws_req_docs" placeholder="Laws / required documents, etc." value="<?php echo set_value('laws_req_docs'); ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="contact_info">Contact Info</label>
                                                    <textarea id="contact_info" name="contact_info" class="form-control <?php if (form_error('contact_info')) {
                                                                                                                            echo 'is_invalid';
                                                                                                                        } ?>" rows="3"><?php echo set_value('contact_info'); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="comments">Comments</label>
                                                    <textarea id="comments" name="comments" class="form-control <?php if (form_error('comments')) {
                                                                                                                    echo 'is_invalid';
                                                                                                                } ?>" rows="3"><?php echo set_value('comments'); ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row justify-content-end">

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-block btn-success"><i class="fas fa-save mr-2"></i>Submit</button>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url(); ?>knowledgebase" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
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