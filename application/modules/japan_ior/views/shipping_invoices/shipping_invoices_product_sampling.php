<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title">Shipping Invoice Requests</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item active">Shipping Invoice Requests</li>
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
        
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link dark-blue-link" href="<?php echo site_url('japan-ior/shipping-invoices');?>">Shipping Invoice for Product Selling</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo site_url('japan-ior/shipping-invoices-product-sampling');?>"><span class="dark-blue-title">Shipping Invoice for Product Sampling</span></a>
            </li>
          </ul>


          <?php if ($this->session->flashdata('success') != null) : ?>
            <br>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php endif ?>

          <?php if ($this->session->flashdata('congratulation') != null) : ?>
            <br>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('congratulation'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php endif ?>

          <?php if ($this->session->flashdata('errors') != null) : ?>
            <br>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span><i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('errors'); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

          <?php endif ?>

          <div class="shipping-invoice-tab card">
       
            <div class="card-header">
              <h3 class="card-title col-md-5">List of your Shipping Invoices</h3>
              <div class="col-md-7 d-flex justify-content-end">
                <div class="form-group">
                  <?php
                  if ($user_details->ior_registered == 0 || $user_details->pli == 0) {
                    echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                          <button class="btn btn-block btn-dark-blue" style="pointer-events: none;" type="button" disabled><i class="fa fa-file-invoice mr-2"></i><strong>Create Shipping Invoice</strong></button>
                        </span>';
                  } else {
                    echo '<a href="' . base_url() . 'japan-ior/add-product-sampling" class="btn btn-outline-dark-blue"><i class="fas fa-box mr-2"></i><strong>Shipping Invoice for Product Sampling</strong></a>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tblShipping" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Product Category</th>
                    <th class="text-center">Invoice #</th>
                    <th class="text-center">Total Value of Shipment (JPY)</th>
                    <th class="text-center">Shipping Invoice</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($shipping_invoices as $shipping_invoice) {

                    if (empty($shipping_invoice->invoice_no_big) && empty($shipping_invoice->invoice_no_tiny)) {

                      if ($shipping_invoice->paid == 0) {
                        $invoice_no = '<a href="#" class="dark-blue-link" data-toggle="tooltip" data-placement="top" title="Shipping Invoice is not yet approved.">N/A</a>';
                      } else {
                        $invoice_no = '<a href="#" class="dark-blue-link" data-toggle="tooltip" data-placement="top" title="Please click \'Generate Watermarked Invoice\' button inside to generate your invoice number.">N/A</a>';
                      }
                    } else {
                      $invoice_user_id = str_pad($shipping_invoice->user_id, 2, '0', STR_PAD_LEFT);
                      $invoice_no = $invoice_user_id . '-' . $shipping_invoice->invoice_no_big . '-' . $shipping_invoice->invoice_no_tiny;
                    }

                    echo '<tr>';
                    echo '  <td align="center">' . $shipping_invoice->shipping_invoice_id . '</td>';
                    echo '  <td align="center">' . (($shipping_invoice->invoice_date != '0000-00-00') ? date('m/d/Y', strtotime($shipping_invoice->invoice_date)) : '<a href="#" class="dark-blue-link" data-toggle="tooltip" data-placement="top" title="Invoice Date is not yet generated.">N/A</a>') . '</td>';
                    echo '  <td align="center">' . $shipping_invoice->category_name . '</td>';
                    echo '  <td align="center">' . $invoice_no . '</td>';
                    echo '  <td align="center">' . (!empty($shipping_invoice->total_value_of_shipment) ? number_format($shipping_invoice->total_value_of_shipment, 2) : '0.00') . '</td>';

                    $shipping_invoice_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $shipping_invoice->user_id . DIRECTORY_SEPARATOR . $shipping_invoice->shipping_invoice_id . DIRECTORY_SEPARATOR . 'Shipping Invoice Preview.pdf';
                    $shipping_invoice_final_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $shipping_invoice->user_id . DIRECTORY_SEPARATOR . $shipping_invoice->shipping_invoice_id . DIRECTORY_SEPARATOR . $invoice_no . ' Shipping Invoice.pdf';


                    if (file_exists($shipping_invoice_pdf_file) && file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $shipping_invoice->user_id . '/' . $shipping_invoice->shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf" target="_blank" class="dark-blue-link">Preview (Approved)</a></td>';
                    }

                    if (file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $shipping_invoice->user_id . '/' . $shipping_invoice->shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf" target="_blank" class="dark-blue-link">Preview (Not Approved)</a></td>';
                    }

                    if (!file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center"><a href="#" class="dark-blue-link" data-toggle="tooltip" data-placement="top" title="Shipping Invoice is not yet generated. Click \'Preview\' button inside.">Not Available</a></td>';
                    }

                    switch ($shipping_invoice->shipping_status_id) {
                      case '1':
                        if ($shipping_invoice->paid == 0) {

                          echo '<td align="center"><span class="badge badge-primary">' . $shipping_invoice->label . '</span></td>';
                          if ($shipping_invoice->billing_invoice_id != 0) {
                            echo '<td align="center"><a href="#" onclick="generateApprovedInvoice(\'' . $shipping_invoice->shipping_invoice_id . '\',\'' . $shipping_invoice->fba_location  . '\',\'' . $shipping_invoice->ship_company . '\')" role="button" class="btn btn-xs btn-outline-dark-blue" title="Generate Approved Invoice"><i class="nav-icon fas fa-info-circle mr-2"></i>Generate Approved Invoice</a></td>';
                          } else {
                            echo '<td align="center"><a href="#" onclick="generateApprovedInvoice(\'' . $shipping_invoice->shipping_invoice_id . '\',\'' . $shipping_invoice->fba_location  . '\',\'' . $shipping_invoice->ship_company . '\')" role="button" class="btn btn-xs btn-outline-dark-blue" title="Generate Approved Invoice"><i class="nav-icon fas fa-info-circle mr-2"></i>Generate Approved Invoice</a></td>';
                          }
                        } else {
                          echo '<td align="center"><span class="badge badge-primary">' . $shipping_invoice->label . '</span></td>';

                          if (file_exists($shipping_invoice_pdf_file) && file_exists($shipping_invoice_final_pdf_file)) {
                            echo '<td align="center">
                            <a href="' . base_url() . 'japan-ior/send-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" id="btn_send_approved_invoice" role="button" class="btn btn-xs btn-dark-yellow" title="Send Approved Invoice"><i class="nav-icon fas fa-paper-plane mr-2"></i>Send Approved Invoice</a>
                          </td>';
                          }

                          if (file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                            echo '<td align="center"><a href="#" onclick="generateApprovedInvoice(\'' . $shipping_invoice->shipping_invoice_id . '\',\'' . $shipping_invoice->fba_location  . '\',\'' . $shipping_invoice->ship_company . '\')" role="button" class="btn btn-xs btn-outline-dark-blue" title="Generate Approved Invoice"><i class="nav-icon fas fa-info-circle mr-2"></i>Generate Approved Invoice</a></td>';
                          }
                        }
                        break;
                      case '2':
                        echo '<td align="center"><span class="badge badge-success">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center"><span class="badge badge-success">Shipment Success</span></td>';
                        break;
                      case '4':
                        echo '<td align="center"><span class="badge badge-secondary">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">
                          <a href="' . base_url() . 'japan-ior/edit-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>
                          <button type ="button" class="btn btn-xs btn-danger" onclick="showConfirmationInvoiceCancel(\'' . $shipping_invoice->shipping_invoice_id . '\')"><i class="nav-icon fas fa-trash-alt mr-2"></i>Cancel</button>
                        </td>';
                        break;
                      case '5':
                        echo '<td align="center"><span class="badge badge-warning"  data-toggle="tooltip" data-placement="top" title="Click Edit to view the needed revisions." style="cursor: pointer;">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">
                          <a href="' . base_url() . 'japan-ior/edit-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>
                          <button type ="button" class="btn btn-xs btn-danger" onclick="showConfirmationInvoiceCancel(\'' . $shipping_invoice->shipping_invoice_id . '\')"><i class="nav-icon fas fa-trash-alt mr-2"></i>Cancel</button>
                        </td>';
                        break;
                      case '6':
                        echo '<td align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">
                          <a href="' . base_url() . 'japan-ior/edit-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>
                          <button type ="button" class="btn btn-xs btn-danger" onclick="showConfirmationInvoiceCancel(\'' . $shipping_invoice->shipping_invoice_id . '\')"><i class="nav-icon fas fa-trash-alt mr-2"></i>Cancel</button>
                        </td>';
                        break;
                      case '7':
                        echo '<td align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">No Action</td>';
                        break;
                      case '8':
                        echo '<td align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">No Action</td>';
                        break;
                      default:
                        echo '<td align="center"><span class="badge badge-secondary">' . $shipping_invoice->label . '</span></td>';
                        echo '<td align="center">
                          <a href="' . base_url() . 'japan-ior/edit-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>
                          <button type ="button" class="btn btn-xs btn-danger" onclick="showConfirmationInvoiceCancel(\'' . $shipping_invoice->shipping_invoice_id . '\')"><i class="nav-icon fas fa-trash-alt mr-2"></i>Cancel</button>
                        </td>';
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
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <div class="modal fade" id="shippingInvoiceNotice">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Important Notice!</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <p>Your Shipping Invoice and Online Seller Report must be including with your shipment. Do not ship without including your Shipping Invoice and Online Seller Account Report.</p>

          <p>Failure to include your Shipping Invoice and Online Seller Account Report will result in your shipment being stopped and customs and returned without notice</p>

          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="shipping_terms" name="shipping_terms" value="1">
            <label class="custom-control-label" for="shipping_terms" style="font-weight: normal;">I fully read and understand</label>
          </div>

        </div>
        <div class="modal-footer">
          <div id="confirmButtonsShippingInvoiceNotice"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal_cancel_invoice">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cancel Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to <strong class="dark-blue-title">cancel</strong> this shipping invoice?
        </div>
        <div class="modal-footer">
          <div id="btn_cancel_invoice"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal_generate_approved_invoicce">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="dark-blue-title">Generate Approved IOR Shipping Invoice</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <p>Your Shipping Invoice has been <strong>approved</strong>.</p>
          <p>Please submit this document to your shipping company. </p>

          <br>

          <h4 class="text-danger"><strong>Important Notice!</strong></h4>
          <br>
          <ul>
            <li>Only the COVUE approved shipping invoice can be use for importing your products.</li><br>
            <li>Do not change or modify this document.</li><br>
            <li>Do not use a third-party shipping invoice.</li><br>
            <li>Failure to use the <strong>approved</strong> COVUE shipping invoice will result in your shipment being stopped in customs.</li><br>
            <li>If you fail to submit your this document to your shipping company and your shipment is stopped in customs, you will be charged a fee of 500.00 USD to recover your shipment from customs.</li>
          </ul>

        </div>
        <div class="modal-footer">
          <div id="btn_generate_invoice"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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
        <div class="modal-footer d-flex justify-content-end">
          <div id="btn-fba-invoice"></div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.content-wrapper -->

<!--<div class="modal fade" id="modal_ddp">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Important Notice!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">

          <div class="col-12">
            <div class="form-group">
              <p>We only accept shipment that are <strong>Incoterms: DDP</strong>.</p>
              <p>if shipments are not <strong>DDP</strong>, please <a href="https://www.covue.com/contact-us/" class="dark-blue-link" target="_blank"><strong>contact us</strong></a>.</p>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer d-flex justify-content-end">
        <a href="#" class="btn btn-dark-blue" data-dismiss="modal">Close</a>
      </div>
    </div>-->
    <!-- /.modal-content -->
  <!-- </div>-->
  <!-- /.modal-dialog -->
<!-- </div>-->
<!-- /.modal -->