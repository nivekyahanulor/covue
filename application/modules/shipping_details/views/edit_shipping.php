<?php 
  
  $shipping_id = $shipping_details_data->shipping_id;
  $user_id = $shipping_details_data->user_id;
  $company_name = $shipping_details_data->company_name;
  $contact_person = $shipping_details_data->contact_person;
  $email = $shipping_details_data->email;
  $hscodes_multi = $shipping_details_data->product_qualification_id;
  $total_value_of_shipment = number_format($shipping_details_data->total_value_of_shipment, 2);
  $shipping_invoice = $shipping_details_data->shipping_invoice;
  $amazon_seller = $shipping_details_data->amazon_seller_report;
  $revisions_msg = $shipping_details_data->revisions_msg;
  $is_paid = $shipping_details_data->is_paid;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Shipping Info</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/shipping_details">Home</a></li>
            <li class="breadcrumb-item active">Edit Shipping Info</li>
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

                  <?php if (isset($errors)): ?>

                    <?php if ($errors == 0): ?>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              Successfully updated the shipping information.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>

                    <?php elseif ($errors == 2): ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <?php echo $error_msgs; ?>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>

                    <?php elseif ($errors == 3): ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              No uploaded image found.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>

                    <?php else: ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              Some errors Found. Please contact your administrator.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>

                    <?php endif ?>

                  <?php endif ?>

                  <?php if (!empty(validation_errors())): ?>

                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Form not yet submitted!</h4>

                            <hr>

                            <p class="mb-0"><?php echo validation_errors(); ?></p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                  <?php endif ?>

                  <div class="row justify-content-end">

                    <?php if (!empty($revisions_msg)): ?>

                            <div class="col-md-3 col-12">
                              <div class="form-group">
                                <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#revisionsMsg"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Revisions Message</button>
                              </div>
                            </div>

                    <?php endif ?>

                  </div>

                  <form action="" method="POST" enctype="multipart/form-data" id="edit_shipping" role="form">

                      <div class="row">

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="company_name">Legal Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $company_name; ?>" disabled>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="contact_person">Primary Contact Person</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>" disabled>
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" disabled>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="is_paid">Already Paid?</label>
                            <select class="form-control" id="is_paid" name="is_paid" style="width: 100%;">
                              <option value="0" <?php echo ($is_paid == 0) ? 'selected' : ''; ?>>No</option>
                              <option value="1" <?php echo ($is_paid == 1) ? 'selected' : ''; ?>>Yes</option>
                            </select>
                            <?php if ($this->input->post('is_paid') == '1'): ?>
                              <script>$('select#is_paid').val('<?php echo $this->input->post('is_paid'); ?>');</script>
                            <?php endif ?>
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="hscode_ship">HS Code</label>
                            <select class="form-control select2" multiple="multiple" id="hscode_ship" name="hscode_ship[]" data-placeholder="Select HS Code" style="width: 100%;">
                              <?php 

                                $hscodes_multi_arr = explode(', ', $hscodes_multi);
                                $hscodes_count = count($hscodes_multi_arr);

                                $user_hscodes = array();

                                for ($i=0; $i < $hscodes_count; $i++) { 
                                    array_push($user_hscodes, $hscodes_multi_arr[$i]);
                                }

                                $hscodes_option = '';

                                foreach ($hscodes as $hscode) {
                                    $hscodes_option = '<option value="'.$hscode->hscode.'"';

                                    foreach ($user_hscodes as $user_hscode) {
                                      if ($user_hscode == $hscode->hscode) {
                                        $hscodes_option .= 'selected';
                                      }
                                    }

                                    $hscodes_option .= '>'.$hscode->hscode.'</option>';

                                    echo $hscodes_option;
                                }

                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="total_value_of_shipment">Total Value of Shipment (JPY)</label>
                            <input type="text" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)" class="form-control" id="total_value_of_shipment" name="total_value_of_shipment" placeholder="Total Value of Shipment" value="<?php echo $total_value_of_shipment; ?>">
                          </div>
                        </div>

                      </div>

                      <div class="row">

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="shipping_invoice">Shipping Invoice <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> (<a href="<?php echo base_url().'uploads/shipping_invoice/'.$user_id.'/'.$shipping_invoice; ?>" target="_blank">View File Here</a>)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="shipping_invoice" name="shipping_invoice" title="">
                                <label class="custom-file-label" for="shipping_invoice"><?php echo $shipping_invoice; ?></label>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="amazon_seller">Amazon Seller Report <i class="fas fa-question-circle" data-toggle="tooltip" title="Only upload any of these file types: jpg, jpeg, png, pdf."></i> (<a href="<?php echo base_url().'uploads/amazon_seller/'.$user_id.'/'.$amazon_seller; ?>" target="_blank">View File Here</a>)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="amazon_seller" name="amazon_seller" title="">
                                <label class="custom-file-label" for="amazon_seller"><?php echo $amazon_seller; ?></label>
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
                            <a href="#" onclick="showConfirmationDeleteShipping('<?php echo $shipping_id ?>')" class="btn btn-block btn-secondary">Delete</a>
                          </div>
                        </div>

                        <div class="col-md-2 col-12">
                          <div class="form-group">
                            <a href="<?php echo base_url(); ?>shipping_details" class="btn btn-block btn-outline-danger">Go Back to All List</a>
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
        
        <?php echo $revisions_msg; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="deleteShipping">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Shipping</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-secondary">delete</strong> this shipping?
      </div>
      <div class="modal-footer">
        <div id="confirmButtonsDeleteShipping"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->