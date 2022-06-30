<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Shipping Invoices List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Shipping Invoices</li>
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

              <table id="tblShippingDetails" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Invoice Date</th>
                    <th class="text-center">Invoice #</th>
                    <th class="text-center">Product Category</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Total Value of Shipment (JPY)</th>
                    <th class="text-center">Shipping Invoice</th>
                    <th class="text-center">Status</th>
                    <th width="220" class="text-center">Action</th>
                    <th class="text-center">Customs Report</th>
                    <th class="text-center">Approved By</th>
                    <th class="text-center">Approved Date</th>
                    <th class="text-center">Last Updated By</th>
                    <th class="text-center">Last Date Updated</th>
                    <th class="text-center">Cancel Invoice</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($shipping_invoices as $shipping_invoice) {

                    if (empty($shipping_invoice->invoice_no_big) && empty($shipping_invoice->invoice_no_tiny)) {
                      $invoice_no = 'N/A';
                    } else {
                      $invoice_user_id = str_pad($shipping_invoice->user_id, 2, '0', STR_PAD_LEFT);
                      $invoice_no = $invoice_user_id . '-' . $shipping_invoice->invoice_no_big . '-' . $shipping_invoice->invoice_no_tiny;
                    }

                    echo '<tr>';
                    echo ' <td>' . $shipping_invoice->shipping_invoice_id . '</td>';
                    echo ' <td>' . ($shipping_invoice->invoice_date != '0000-00-00' ? date('m/d/Y', strtotime($shipping_invoice->invoice_date)) : 'N/A') . '</td>';
                    echo ' <td>' . $invoice_no . '</td>';
                    echo ' <td>' . $shipping_invoice->category_name . '</td>';
                    echo ' <td>' . $shipping_invoice->company_name . '</td>';
                    echo ' <td align="center">' . number_format($shipping_invoice->total_value_of_shipment, 2) . '</td>';

                    $shipping_invoice_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $shipping_invoice->user_id . DIRECTORY_SEPARATOR . $shipping_invoice->shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf';
                    $shipping_invoice_final_pdf_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shipping_invoice_pdf' . DIRECTORY_SEPARATOR . $shipping_invoice->user_id . DIRECTORY_SEPARATOR . $shipping_invoice->shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf';

                    if (file_exists($shipping_invoice_pdf_file) && file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $shipping_invoice->user_id . '/' . $shipping_invoice->shipping_invoice_id . '/' . $invoice_no . ' Shipping Invoice.pdf" target="_blank">Preview (Approved)</a></td>';
                    }

                    if (file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center"><a href="' . base_url() . 'uploads/shipping_invoice_pdf/' . $shipping_invoice->user_id . '/' . $shipping_invoice->shipping_invoice_id . '/' . 'Shipping Invoice Preview.pdf" target="_blank">Preview (Not Approved)</a></td>';
                    }

                    if (!file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                      echo ' <td align="center">Not Yet Generated</td>';
                    }

                    if ($user_id == 1) {
                      switch ($shipping_invoice->shipping_status_id) {
                        case '1':
                          if ($shipping_invoice->paid == '0') {
                            echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-primary">' . $shipping_invoice->label . '</span></td>';
                          } else {
                            echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-primary">Paid</span></td>';
                          }
                          break;
                        case '2':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-success">' . $shipping_invoice->label . '</span></td>';
                          break;
                        case '4':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-secondary">' . $shipping_invoice->label . '</span></td>';
                          break;
                        case '5':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><a href="' . base_url() . 'shipping-invoices/view-revisions-message/' . $shipping_invoice->shipping_invoice_id . '" data-toggle="tooltip" data-placement="top" title="Click to view revisions message"><span class="badge badge-warning">' . $shipping_invoice->label . '</span></a></td>';
                          break;
                        case '6':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          break;
                        case '7':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          break;
                        case '8':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          break;
                        default:
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-danger">' . $shipping_invoice->label . '</span></td>';
                      }

                      echo '<td align="center">';
                      echo '<a href="#" class="btn btn-outline-primary" onclick="showConfirmationInvoiceAccepted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Accepted" style="margin: 2px;"><i class="nav-icon fas fa-handshake"></i></a>';
                      echo '<a href="#" class="btn btn-outline-primary" onclick="showConfirmationInvoicePaid(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Paid" style="margin: 2px;"><i class="nav-icon fas fa-hand-holding-usd"></i></a>';
                      echo '<a href="#" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision" style="margin: 2px;"><i class="nav-icon fas fa-sync-alt"></i></a>';
                      echo '<br>';
                      echo '<a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceArrived(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Arrived at COVUE Facility" style="margin: 2px;"><i class="nav-icon fas fa-truck"></i></a>';
                      echo '<a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceReady(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Ready for Pickup" style="margin: 2px;"><i class="nav-icon fas fa-shipping-fast"></i></a>';
                      echo '<a href="#" class="btn btn-outline-success" onclick="showConfirmationInvoiceCompleted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Completed" style="margin: 2px;"><i class="nav-icon fas fa-check-circle"></i></a>';
                      echo '</td>';
                    } else {
                      switch ($shipping_invoice->shipping_status_id) {
                        case '1':
                          if ($shipping_invoice->paid == '0') {
                            echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-primary">' . $shipping_invoice->label . '</span></td>';
                            echo '<td align="center">
                                    <button type="button" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-outline-primary" onclick="showConfirmationInvoicePaid(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Paid"><i class="nav-icon fas fa-hand-holding-usd"></i></button>
                                    <a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceArrived(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Arrived at COVUE Facility"><i class="nav-icon fas fa-truck"></i></a>
                                    <a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceReady(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Ready for Pickup"><i class="nav-icon fas fa-shipping-fast"></i></a>
                                  </td>';
                          } else {
                            echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-primary">Paid</span></td>';
                            echo '<td align="center">
                                    <button type="button" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-outline-success" onclick="showConfirmationInvoiceCompleted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Completed"><i class="nav-icon fas fa-check-circle"></i></button>
                                    <a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceArrived(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Arrived at COVUE Facility"><i class="nav-icon fas fa-truck"></i></a>
                                    <a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceReady(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Ready for Pickup"><i class="nav-icon fas fa-shipping-fast"></i></a>
                                  </td>';
                          }
                          break;
                        case '2':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-success">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  No Action
                                </td>';
                          break;
                        case '4':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-secondary">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  <button type="button" class="btn btn-outline-primary" onclick="showConfirmationInvoiceAccepted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                                  <button type="button" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                                </td>';
                          break;
                        case '5':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-warning">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  <button type="button" class="btn btn-outline-primary" onclick="showConfirmationInvoiceAccepted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                                  <button type="button" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                                </td>';
                          break;
                        case '6':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                    <button type="button" class="btn btn-outline-primary" onclick="showConfirmationInvoiceAccepted(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                                    <button type="button" class="btn btn-outline-warning" onclick="showConfirmationInvoiceRevision(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                                  </td>';
                          break;
                        case '7':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  <a href="#" class="btn btn-outline-info" onclick="showConfirmationInvoiceReady(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Shipment Ready for Pickup"><i class="nav-icon fas fa-shipping-fast"></i></a>
                                </td>';
                          break;
                        case '8':
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-info">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  No Action
                                </td>';
                          break;
                        default:
                          echo '<td id="status_' . $shipping_invoice->shipping_invoice_id . '" align="center"><span class="badge badge-danger">' . $shipping_invoice->label . '</span></td>';
                          echo '<td align="center">
                                  No Action
                                </td>';
                      }
                    }

                    if (!empty($shipping_invoice->custom_report)) {
                      echo ' <td align="center"> <a href="' . base_url() . 'uploads/shipping_invoice_custom_report/' . $shipping_invoice->custom_report . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                    } else {
                      echo ' <td align="center"><p class="text-danger">No File Uploaded</p></td>';
                    }

                    if ($shipping_invoice->approved_by != 0) {
                      echo ' <td align="center">' . $shipping_invoice->approved_name . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    if (!empty($shipping_invoice->approved_date)) {
                      echo ' <td align="center">' . date('m/d/Y', strtotime($shipping_invoice->approved_date))  . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    if (!empty($shipping_invoice->last_updated_by_id)) {
                      echo ' <td align="center">' . $shipping_invoice->last_updated_by . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    if (!empty($shipping_invoice->last_date_updated)) {
                      echo ' <td align="center">' . date('m/d/Y', strtotime($shipping_invoice->last_date_updated))  . '</td>';
                    } else {
                      echo '<td align="center">N/A</td>';
                    }

                    echo '<td align="center"><a href="#" class="btn btn-danger" onclick="showConfirmationInvoiceCancel(\'' . $shipping_invoice->shipping_invoice_id . '\')" title="Cancel Shipping Invoice"><i class="nav-icon fas fa-times-circle"></i></a></td>';

                    echo '</tr>';
                  }

                  ?>

                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
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

<div class="modal fade" id="modal_accepted_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Accepted:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-primary">accept</strong> this shipping invoice?
      </div>
      <div class="modal-footer">
        <div id="btn_accept_invoice"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_paid_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Paid:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to set to <strong class="text-primary">paid</strong> this shipping invoice?
      </div>
      <div class="modal-footer">
        <div id="btn_paid_invoice"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_custom_report">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Custom Report:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Form -->
        <form action='' method='POST' enctype="multipart/form-data">

          <input type="hidden" id="custom_report_id" name="custom_report_id" value="">

          <div class="row">

            <div class="col-md-12 col-12">
              <div class="form-group">
                <label for="custom_report">Upload your Custom Report</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="custom_report" name="custom_report">
                    <label class="custom-file-label" for="custom_report">Upload file here</label>
                  </div>
                </div>
              </div>
            </div>

          </div>

      </div>
      <div class="modal-footer">

        <div class="row">

          <div class="col-12">
            <div class="form-group">
              <button type="button" id="btn_custom_report" name="btn_custom_report" class="btn btn-block btn-success">Upload and Set to Completed</button>
            </div>
          </div>

        </div>

        </form>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_revision_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Revisions:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea id="revision_messsage" class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <div id="btn_revision_invoice"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_arrived_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Shipment Arrived:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to set this as <strong class="text-info">Shipment Arrived at COVUE Facility</strong>?
      </div>
      <div class="modal-footer">
        <div id="btn_arrived_invoice"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_ready_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Shipment Ready:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to set this to <strong class="text-info">Shipment Ready for Pickup</strong>?
      </div>
      <div class="modal-footer">
        <div id="btn_ready_invoice"></div>
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
        <h4 class="modal-title">Cancel Confirmation:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-danger">cancel</strong> this shipping invoice?
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

<script>
  $(function() {
    // Summernote
    $("#revision_messsage").summernote({
      placeholder: 'Place your revision message here ...',
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