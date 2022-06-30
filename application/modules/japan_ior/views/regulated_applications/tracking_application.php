<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title"><?php echo $reg_application->category_name; ?> Application Status</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item active">Application Status</li>
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

          <?php if ($this->session->flashdata('success') != null) { ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php } ?>

          <?php if ($this->session->flashdata('error') != null) { ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php } ?>

          <div class="row">
            <div class="col-md-12 col-12">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between">
                    <?php
                    foreach ($tracking_steps as $tracking_step) {
                    ?>
                      <?php
                      if ($tracking_step->tracking_steps !="" ) {
                        echo '<div class="step completed">';
                      } else {
                        echo '<div class="step">';
                      }
                      ?>
                      <div class="step-icon-wrap">
                        <div class="step-icon">
                        <?php if ($tracking_step->tracking_steps !="" ) {?>
                          <img src="<?php echo base_url(); ?>assets/img/tracking/<?php echo $tracking_step->tracking_status_name; ?>.png" width="40px" title="<?php echo $tracking_step->tracking_status_name; ?>">
                        <?php } ?>
                        </div>
                        <?php if ($tracking_step->tracking_steps !="" ) {?>
                          <div class="step-title"><?php echo $tracking_step->tracking_status_name; ?></div>
                        <?php } ?>
                      </div>
                  </div>
                  <?php
                   }
                  ?>

                </div>
                <!-- ./steps -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- ./card -->
          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-12 col-12">
            <div class="card mb-3">
              <div class="card-header">
                <h3 class="card-title col-md-5"><?php echo $reg_application->category_name; ?> Application</h3>
                <div class=" col-md-7 d-flex justify-content-end">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tblRegulatedTracking" class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">Date</th>
                      <th class="text-center">Tracking Details</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Remarks</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($reg_application_trackings as $reg_application_tracking) {
                      echo '<tr>';
                      echo '  <td align="center">' . date('m/d/Y', strtotime($reg_application_tracking->date)) . '</td>';
                      echo '  <td align="center">' . $reg_application_tracking->tracking_status_name . '</td>';

                      switch ($reg_application_tracking->approve_status) {
                        case "1":
                          echo '<td align="center"><span class="badge badge-success">' . $reg_application_tracking->tracking_status_label . '</span></td>';
                          break;
                        case "2":
                          echo '<td align="center"><span class="badge badge-danger">' . $reg_application_tracking->tracking_status_label . '</span></td>';
                          break;
                        case "3":
                          echo '<td align="center"><span class="badge badge-warning">' . $reg_application_tracking->tracking_status_label . '</span></td>';
                          break;
                        case "5":
                          echo '<td align="center"><span class="badge badge-secondary">' . $reg_application_tracking->tracking_status_label . '</span></td>';
                          break;
                        case "6":
                          echo '<td align="center"><span class="badge badge-info">' . $reg_application_tracking->tracking_status_label . '</span></td>';
                          break;
                        default:
                          if ($reg_products_revisions_cnt != 0 && $reg_application_tracking->tracking_status_id == 1) {
                            echo '<td align="center"><span class="badge badge-warning">Some products needs revision.</span></td>';
                          } elseif ($reg_products_declined_cnt != 0 && $reg_application_tracking->tracking_status_id == 1) {
                            echo '<td align="center"><span class="badge badge-danger">Some products are declined</span></td>';
                          } else {
                            echo '<td align="center"><span class="badge badge-info">In Process</span></td>';
                          }
                      }

                      if (empty($reg_application_tracking->remarks_status)) {
                        echo '<td class="text-center"></td>';
                      } else {
                        echo '<td align="center"><a href="#" class="dark-blue-link" data-toggle="modal" data-target="#viewremarks' . $reg_application_tracking->regulated_application_tracking_id . '">View Remarks</a></td>';
                      }

                      if ($reg_application_tracking->tracking_status_id == 1) {
                        if ($req_products_cnt != 0) {
                          echo '<td align="center"><a href="' . base_url() . 'japan-ior/regulated-products-list/' . $reg_application_tracking->regulated_application_id . '" class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View Products</a></td>';
                        } else {
                          echo '<td align="center"><a href="' . base_url() . 'japan-ior/regulated-products-list/' . $reg_application_tracking->regulated_application_id . '" class="btn btn-xs btn-dark-blue"><i class="fa fa-plus-circle mr-2"></i>Add Products Here</a></td>';
                        }
                      } elseif ($reg_application_tracking->tracking_status_id == 4) {
                        echo '<td align="center"><a href="' . base_url() . 'japan-ior/product-test-results/' . $reg_application_tracking->regulated_application_id . '" class="btn btn-xs btn-dark-blue"><i class="fa fa-flask mr-2"></i>View Lab/Product Testing Result</a></td>';
                      } elseif ($reg_application_tracking->tracking_status_id == 5) {
                        if ($reg_application->product_category_id == 2 || $reg_application->product_category_id == 5 || $reg_application->product_category_id == 10) {
                          // if ($is_regulated_label_paid > 0) {
                            echo '<td align="center"><a href="' . base_url() . 'japan-ior/view_product_labels/' . $reg_application_tracking->regulated_application_id . '"  class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View Product Labels</a></td>';
                          // } else {
                          //   echo '<td align="center"><a href="#" onclick="showPurchaseProductLabel(\'' . $reg_application->id . '\',\'' . $reg_application->category_name . '\',\'' . $req_products_cnt . '\',\'' . $reg_application->product_category_id . '\')" class="btn btn-xs btn-dark-blue"><i class="fa fa-tags mr-2"></i>Purchase Product Labels</a></td>';
                          // }
                        } else {
                          echo '<td align="center"><a href="' . base_url() . 'japan-ior/view_product_labels/' . $reg_application_tracking->regulated_application_id . '"  class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View Product Labels</a></td>';
                        }
                      } elseif ($reg_application_tracking->tracking_status_id == 7 && $reg_application_tracking->approve_status == 1) {
                        echo '<td align="center"><a href="#" onclick="showCreateShippingInvoice()" class="btn btn-xs btn-dark-blue"><i class="fa fa-file-invoice mr-2"></i>Create your Shipping Invoice now</a></td>';
                      } else {
                        echo '<td align="center">No Action</td>';
                      }
                      echo '</tr>';
                    ?>

                      <!--  VIEW REMARKS MODAL -->
                      <div class="modal fade" id="viewremarks<?php echo $reg_application_tracking->regulated_application_tracking_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Remarks</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <?php echo $reg_application_tracking->remarks_status; ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-dark-blue" data-dismiss="modal" role="button">Close</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- END VIEW REMARKS MODAL -->
                    <?php } ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div>
      <!-- /.col-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- create shipping invoice modal -->
<div class="modal fade" id="createshippinginvoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="dark-blue-title">Create Shipping Invoice</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <p>Are you shipping to Amazon FBA location?</p>
      </div>
      <div class="modal-footer">
        <div id="btn-fba-invoice"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="purchase-product-label">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="dark-blue-title">Purchase Product Label</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div id="paypalCheckoutIOR" class="col-12">
          <form action="" method="POST" id="purchaseProductLabel" role="form">
            <input type="hidden" name="notify_url" value="<?php echo base_url(); ?>japan-ior/ipn">
            <input type="hidden" id="ior_registered" name="ior_registered" value="<?php echo $user_details->ior_registered; ?>">
            <input type="hidden" id="pli" name="pli" value="<?php echo $user_details->pli; ?>">
            <input type="hidden" id="category_id" name="category_id">

            <div class="row">
              <div class="col-md-8">
                <p id="category_name"> </p>
              </div>
              <div class="col-md-4">
                <span id="regulated_price" style="float: right;"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <p id="item-count"> </p>
              </div>
            </div>



            <hr>

            <div class="row">
              <div class="col-md-8">
                <p>Subtotal</p>
              </div>
              <div class="col-md-4">
                <input type="hidden" id="subtotal_val" name="subtotal">
                <span id="subtotal" style="float: right;"></span>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <p>Japan Consumer Tax (10%)</p>
              </div>
              <div class="col-md-4">
                <input type="hidden" id="jct_val" name="jct">
                <span id="jct" style="float: right;"></span>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col-md-6">
                <h2 style="font-weight: bolder;">Total</h2>
              </div>
              <div class="col-md-6">
                <input type="hidden" id="total_val" name="total">
                <h2 id="total" style="float: right; font-weight: bolder;"></h2>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col-md-12">
                <h6 style="font-weight: bolder;">IMPORTANT REMINDER</h6>
                <p style="font-size: 11px;">Please be advised that IOR Registration process takes 2 hours during normal operating hours (Monday - Friday , 9am - 6pm JST) Registration after working hours will be processed on the next working day.</p>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col-md-12">
                <center>
                  <a href="#" onclick="showBillingModal()" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a>
                </center>
              </div>

            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <div id="btn-fba-invoice"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_billing_checkout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Important Notice!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p><strong>Billing Invoice</strong> will be created.</p>
        <p>You need to <strong>pay</strong> it first before creating another invoice.</p>
        <br>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="billing_checkout_terms" name="billing_checkout_terms" value="1">
          <label class="custom-control-label" for="billing_checkout_terms" style="font-weight: normal;"><strong>I fully read and understand.</strong></label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-end">
        <button type="button" id="btn_submit_product_label_checkout" class="btn btn-dark-blue">Proceed to Checkout</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->