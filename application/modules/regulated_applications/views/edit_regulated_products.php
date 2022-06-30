<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">

                    <?php
                    if ($reg_product->status != 1) {
                        echo '<h1 class="">Edit ' . $reg_product->product_name . ' </h1>';
                    } else {
                        echo '<h1 class="">View ' . $reg_product->product_name . ' </h1>';
                    }
                    ?>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/tracking-details/' . $reg_product->regulated_application_id; ?>">Tracking Details</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'regulated-applications/regulated-products-list/' . $reg_product->regulated_application_id; ?>">Product List</a></li>
                        <?php
                        if ($reg_product->status != 1) {
                            echo '<li class="breadcrumb-item active">Edit Regulated Products</li>';
                        } else {
                            echo '<li class="breadcrumb-item active">View Regulated Products</li>';
                        }
                        ?>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- <?php var_dump($reg_product_cust) ?> -->
                <div class="col-12">

                    <?php if (isset($errors)) : ?>

                        <?php if ($errors == 0) : ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Successfully submitted Regulated Product!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php elseif ($errors == 2) : ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_msgs; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php else : ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Errors Found. Please contact your administrator.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        <?php endif ?>

                    <?php endif ?>

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

                    <form action="" method="POST" enctype="multipart/form-data" role="form" id="edit_regulated_products">
                        <input type="hidden" name="regulated_application_id" value="<?php echo $reg_product->regulated_application_id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Product Registered</h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="">

                                            <div class="row">


                                                <div class="form-group col-md-4 col-12">
                                                    <label for="sku">HS Code</label>
                                                    <input type="text" class="form-control <?php if (form_error('sku')) {
                                                                                                                                                            echo 'is_invalid';
                                                                                                                                                        } ?>"" id=" sku" name="sku" placeholder="HS Code" value="<?php echo $reg_product->sku; ?>">
                                                </div>


                                                <div class="form-group col-md-4 col-12">
                                                    <label for="product_name">Product Name</label>
                                                    <input type="text" class="form-control <?php if (form_error('product_name')) {
                                                                                                                                                            echo 'is_invalid';
                                                                                                                                                        } ?>"" id=" product_name" name="product_name" placeholder="Product Name" value="<?php echo $reg_product->product_name; ?>">
                                                </div>

                                                <div class="form-group col-md-4 col-12">
                                                    <label for="product_img">Product Image <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo ((!empty($reg_product->product_img))) ? '<a href="' . base_url() . 'uploads/product_qualification/' . $reg_product->user_id . '/' . $reg_product->product_img . '" target="_blank">(View File Here)</a>' : ''; ?></label>

                                                    
                                                        <div class="input-group">
                                                            <div class="custom-file <?php if (form_error('product_img')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>"" style=" border-radius: .25rem;">
                                                                <input type="file" class="custom-file-input" id="product_img" name="product_img">
                                                                <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($reg_product->product_img) ? $reg_product->product_img : 'Upload'; ?></label>
                                                            </div>
                                                        </div>
                                                    

                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.d-flex -->


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Regulated Product &nbsp; <button type="button" class="btn btn-success" name="submit" data-toggle="modal" data-target="#newDetails"><i class="fas fa-plus-circle mr-2"></i>Add Details</button></h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="">

                                            <div class="row">

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="ingredients_formula">Ingredients Formula <i class="fas fa-question-circle" data-toggle="tooltip" title="Only INCI is accepted. (only upload any of these file types: jpg, jpeg, png, pdf)."></i> <?php echo !empty($reg_product->ingredients_formula) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->ingredients_formula . '" target="_blank">(View File Here)</a>' : ''; ?></label>

                                                    
                                                        <div class="input-group">
                                                            <div class="custom-file <?php if (form_error('ingredients_formula')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>"" style=" border-radius: .25rem;">
                                                                <input type="file" class="custom-file-input" id="ingredients_formula" name="ingredients_formula">
                                                                <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($reg_product->ingredients_formula) ? $reg_product->ingredients_formula : 'Upload'; ?></label>
                                                            </div>
                                                        </div>
                                                

                                                </div>

                                                <!-- <div class="form-group col-md-4 col-12">
                                                    <label for="lab_result">Lab Results <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo !empty($reg_product->lab_result) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->lab_result . '" target="_blank">(View File Here)</a>' : ''; ?></label>
                                                    <div class="input-group">
                                                        <div class="custom-file <?php //if (form_error('lab_result')) {
                                                                                //echo 'is_invalid';
                                                                                //} 
                                                                                ?>"" style=" border-radius: .25rem;">
                                                            <input type="file" class="custom-file-input" id="lab_result" name="lab_result">
                                                            <label class="custom-file-label" for="manufacturing_flow_process"><?php //echo !empty($reg_product->lab_result) ? $reg_product->lab_result : 'Upload'; 
                                                                                                                                ?></label>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="volume_weight">Volume/Weight (grams or ml)</label>
                                                    <input type="text" class="form-control <?php if (form_error('volume_weight')) {
                                                                                                                                                            echo 'is_invalid';
                                                                                                                                                        } ?>"" id=" volume_weight" name="volume_weight" placeholder="Volume/Weight" value="<?php echo $reg_product->volume_weight; ?>">
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="product_use_and_info">Product Use and Information</label>
                                                    <textarea class="form-control <?php if (form_error('product_use_and_info')) {
                                                                                                                                                    echo 'is_invalid';
                                                                                                                                                } ?>"" id=" product_use_and_info" name="product_use_and_info" placeholder="Product Use and Information" rows="3"><?php echo $reg_product->product_use_and_info; ?></textarea>
                                                </div>

                                                

                                                <?php 
                                                    foreach ($reg_product_cust as $key => $value) {
                                                        $name_arr = explode(" ", ucwords($value->detail_name));
                                                        $cust_id = '';
                                                        $loop_cnt = 0;
                                                         foreach ($name_arr as $value1) {
                                                            # code...
                                                            if($loop_cnt > 0){
                                                                $cust_id = $cust_id.'_'.$value1;
                                                            }else{
                                                                $cust_id = $value1;
                                                            }

                                                            $loop_cnt++;
                                                            
                                                        }
                                                        
                                                        if($value->detail_type == 'input'){
                                                ?>
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="<?php echo strtolower($cust_id) ?>"><?php echo ucwords($value->detail_name); ?></label><a href="#" style="" onclick="showConfirmationDeleteDetail('<?php echo $value->id ?>','<?php echo $value->detail_name ?>')">&nbsp;<i class="fas fa-times-circle" style="color: #dc3545"></i></a>
                                                                <input type="text" class="form-control <?php if (form_error('<?php echo strtolower($cust_id) ?>')) {
                                                                                                            echo 'is_invalid';
                                                                                                        } ?>"" id=" <?php echo strtolower($cust_id) ?>" name="<?php echo strtolower($cust_id) ?>" placeholder="<?php echo ucwords($value->detail_name); ?>" value="<?php echo ($value->detail_value); ?>">
                                                            </div>
                                                <?php
                                                        }else{
                                                            
                                                ?>
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="approx_size_of_package"><?php echo ucwords($value->detail_name); ?>
                                                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i>
                                                                    <?php echo !empty($value->detail_value) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $value->detail_value . '" target="_blank">(View File Here)</a>' : ''; ?>
                                                                </label>
                                                                <a href="#" style="" onclick="showConfirmationDeleteDetail('<?php echo $value->id ?>','<?php echo $value->detail_name ?>')">&nbsp;<i class="fas fa-times-circle" style="color: #dc3545"></i></a>
                                                                <div class="input-group">
                                                                    <div class="custom-file <?php if (form_error('$cust_id')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>"" style=" border-radius: .25rem;">
                                                                        <input type="file" class="custom-file-input" id="<?php echo strtolower($cust_id) ?>" name="<?php echo strtolower($cust_id) ?>">
                                                                        <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($value->detail_value) ? $value->detail_value : 'Upload'; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                <?php
                                                        }
                                                    }
                                                ?>

                                            </div>

                                        </div>
                                        <!-- /.d-flex -->
                                        <!-- <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-default">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h3 class="card-title">Custom Details &nbsp; <button type="button" class="btn btn-success" name="submit" data-toggle="modal" data-target="#newDetails"><i class="fas fa-plus-circle mr-2"></i>Add New</button></h3>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row" id="cust-details-con">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Product Label Details</h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="">

                                            <div class="row">


                                                <div class="form-group col-md-6 col-12">
                                                    <label for="outerbox_frontside">Outerbox (Frontside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo !empty($reg_product->outerbox_frontside) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->outerbox_frontside . '" target="_blank">(View File Here)</a>' : ''; ?></label>
                                                    
                                                        <div class="input-group">
                                                            <div class="custom-file <?php if (form_error('outerbox_frontside')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>"" style=" border-radius: .25rem;">
                                                                <input type="file" class="custom-file-input" id="outerbox_frontside" name="outerbox_frontside">
                                                                <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($reg_product->outerbox_frontside) ? $reg_product->outerbox_frontside : 'Upload'; ?></label>
                                                            </div>
                                                        </div>
                                                    

                                                </div>

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="outerbox_backside">Outerbox (Backside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo !empty($reg_product->outerbox_backside) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->outerbox_backside . '" target="_blank">(View File Here)</a>' : ''; ?></label>
                                                    
                                                        <div class="input-group">
                                                            <div class="custom-file <?php if (form_error('outerbox_backside')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>"" style=" border-radius: .25rem;">
                                                                <input type="file" class="custom-file-input" id="outerbox_backside" name="outerbox_backside">
                                                                <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($reg_product->outerbox_backside) ? $reg_product->outerbox_backside : 'Upload'; ?></label>
                                                            </div>
                                                        </div>
                                                    

                                                </div>

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="consumer_product_packaging_img">Consumer Product Packaging Image (Frontside) <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> <?php echo !empty($reg_product->consumer_product_packaging_img) ? '<a href="' . base_url() . 'uploads/regulated_applications/' . $reg_product->regulated_application_id . '/' . $reg_product->consumer_product_packaging_img . '" target="_blank">(View File Here)</a>' : ''; ?></label>
                                                    
                                                        <div class="input-group">
                                                            <div class="custom-file <?php if (form_error('consumer_product_packaging_img')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>"" style=" border-radius: .25rem;">
                                                                <input type="file" class="custom-file-input" id="consumer_product_packaging_img" name="consumer_product_packaging_img">
                                                                <label class="custom-file-label" for="manufacturing_flow_process"><?php echo !empty($reg_product->consumer_product_packaging_img) ? $reg_product->consumer_product_packaging_img : 'Upload'; ?></label>
                                                            </div>
                                                        </div>
                                                

                                                </div>

                                                

                                                <div class="form-group col-md-6 col-12">
                                                    <label for="approx_size_of_package">Approximately Size of Package (cm)</label>
                                                    <input type="text" class="form-control <?php if (form_error('approx_size_of_package')) {
                                                                                                                                                            echo 'is_invalid';
                                                                                                                                                        } ?>"" id=" approx_size_of_package" name="approx_size_of_package" placeholder="Approximately Size of Package" value="<?php echo $reg_product->approx_size_of_package; ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.d-flex -->


                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="form-group">
                                   
                                        <button type="submit" class="btn btn-success" name="submit"><i class="fas fa-check-circle mr-2"></i>Update Regulated Product</button>

                                   

                                    <?php if (!empty($reg_product->revisions_msg)) : ?>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#revisionsMsg"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Revisions Message</button>
                                    <?php endif ?>
                                    <a href="<?php echo base_url(); ?>regulated-applications/regulated-products-list/<?php echo $reg_product->regulated_application_id ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left mr-2"></i>Go Back to Products List</a>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="revisionsMsg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Revisions Message</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $reg_product->revisions_msg; ?>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="newDetails">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="cust-details-con">
                    <div class="form-group col-md-6 col-12">
                        <label for="custom_name">Name</label>
                        <input type="text" class="form-control" id="custom_name" name="custom_name" placeholder="Name" value="">
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label for="custom_type">Type</label>
                        <select class="select2 form-control" id="custom_type" name="custom_type" style="width: 100%;">
                            <option value="">- Select Type -</option>
                            <option value="input">Input</option>
                            <option value="file">File Upload</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" name="add_details" id="add_details"><i class="fas fa-check-circle mr-2"></i>Submit</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal_delete_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this detail "<span id="detail_name"></span>"?
                <br><br>
                <span id="detail_name"></span>
            </div>
            <div class="modal-footer">
                <div id="confirmDeleteDetails"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
    $('#add_details').click(function(){
        if($('#custom_name').val() == '' || $('#custom_type').val() == ''){
            Toast.fire({
                icon: "error",
                position: "center",
                title:
                    "Inputs are required.",
            });
        }else{
            $.ajax({
                url: base_url + "regulated_applications/add_details",
                type: "POST",
                data: { name: $('#custom_name').val(),type:$('#custom_type').val(),regulated_product_id:'<?php echo $reg_product->id ?>',product_registration_id:'<?php echo $reg_product->product_registration_id ?>' },
                success: function (response) {
                    window.location.reload();
                },
                error: function () {
                    Toast.fire({
                        icon: "error",
                        position: "center",
                        title:
                            "Sorry for the inconvenience, some errors found. Please contact administrator.",
                    });
                },
            });
        }
        
    });

    function removeDetail(id){
        $.ajax({
            url: base_url + "regulated_applications/remove_details",
            type: "POST",
            data: { id: id },
            success: function (response) {
                window.location.reload();
            },
            error: function () {
                Toast.fire({
                    icon: "error",
                    position: "center",
                    title:
                        "Sorry for the inconvenience, some errors found. Please contact administrator.",
                });
            },
        });
    }
</script>