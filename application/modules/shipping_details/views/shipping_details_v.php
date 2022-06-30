<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Shipping Details List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item active">Shipping Details</li>
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
                    <th>Date</th>
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>HS Code</th>
                    <th class="text-center">Total Value of Shipment (JPY)</th>
                    <th class="text-center">Shipping Invoice</th>
                    <th class="text-center">Amazon Seller Report</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Customs Report</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  foreach ($all_shipping as $row) {

                    echo '<tr>';
                    echo ' <td>' . date('m/d/Y', strtotime($row->shipping_date)) . '</td>';
                    echo ' <td>' . $row->company_name . '</td>';
                    echo ' <td>' . $row->contact_person . '</td>';
                    echo ' <td>' . $row->email . '</td>';
                    echo ' <td>' . $row->product_qualification_id . '</td>';
                    echo ' <td align="center">' . number_format($row->total_value_of_shipment, 2) . '</td>';
                    echo ' <td align="center"> <a href="' . base_url() . 'uploads/shipping_invoice/' . $row->users_id . '/' . $row->shipping_invoice . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                    echo ' <td align="center"> <a href="' . base_url() . 'uploads/amazon_seller/' . $row->users_id . '/' . $row->amazon_seller_report . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';

                    switch ($row->ior_status) {
                      case 'Accepted':
                        if ($row->is_paid == 1) {
                          echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-success">Paid</span></td>';
                          echo '<td align="center">
                                  No Action
                                </td>';
                          // echo '<td align="center" width="200">
                          //         <a href="' . base_url() . 'shipping_details/edit_shipping/' . $row->shipping_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-pen"></i></a>
                          //         <button type="button" class="btn btn-outline-warning" onclick="showConfirmationRevision(\'' . $row->shipping_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                          //         <button type="button" class="btn btn-outline-success" onclick="showConfirmationCompleted(\'' . $row->shipping_id . '\')" title="Completed"><i class="nav-icon fas fa-check-circle"></i></button>
                          //       </td>';
                        } else {
                          echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-info">' . $row->ior_status . '</span></td>';
                          echo '<td align="center">
                                  No Action
                                </td>';
                          // echo '<td align="center" width="200">
                          //         <a href="' . base_url() . 'shipping_details/edit_shipping/' . $row->shipping_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-pen"></i></a>
                          //         <button type="button" class="btn btn-outline-warning" onclick="showConfirmationRevision(\'' . $row->shipping_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                          //         <button type="button" class="btn btn-outline-success" onclick="showConfirmationCompleted(\'' . $row->shipping_id . '\')" title="Completed"><i class="nav-icon fas fa-check-circle"></i></button>
                          //       </td>';
                        }
                        break;
                      case 'Needs Revision':
                        echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-warning">' . $row->ior_status . '</span></td>'; // data-toggle="tooltip" data-html="true" title="'.$row->revisions_msg.'"
                        echo '<td align="center">
                                No Action
                              </td>';
                        // echo '<td align="center" width="200">
                        //         <button type="button" class="btn btn-outline-info" onclick="showConfirmationAccepted(\'' . $row->shipping_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                        //         <a href="' . base_url() . 'shipping_details/edit_shipping/' . $row->shipping_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-pen"></i></a>
                        //         <button type="button" class="btn btn-outline-warning" onclick="showConfirmationRevision(\'' . $row->shipping_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                        //       </td>';
                        break;
                      case 'Updated':
                        echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-primary">' . $row->ior_status . '</span></td>';
                        echo '<td align="center">
                                No Action
                              </td>';
                        // echo '<td align="center" width="200">
                        //           <button type="button" class="btn btn-outline-info" onclick="showConfirmationAccepted(\'' . $row->shipping_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                        //           <a href="' . base_url() . 'shipping_details/edit_shipping/' . $row->shipping_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-pen"></i></a>
                        //           <button type="button" class="btn btn-outline-warning" onclick="showConfirmationRevision(\'' . $row->shipping_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                        //         </td>';
                        break;
                      case 'Completed':
                        echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-success">' . $row->ior_status . '</span></td>';
                        echo '<td align="center">
                                No Action
                              </td>';
                        break;
                      default:
                        echo '  <td id="status_' . $row->shipping_id . '" align="center"><span class="badge badge-secondary">' . $row->ior_status . '</span></td>';
                        echo '<td align="center">
                                No Action
                              </td>';
                        // echo '<td align="center" width="200">
                        //         <button type="button" class="btn btn-outline-info" onclick="showConfirmationAccepted(\'' . $row->shipping_id . '\')" title="Accepted"><i class="nav-icon fas fa-handshake"></i></button>
                        //         <a href="' . base_url() . 'shipping_details/edit_shipping/' . $row->shipping_id . '" role="button" class="btn btn-outline-primary" title="Edit"><i class="nav-icon fas fa-pen"></i></a>
                        //         <button type="button" class="btn btn-outline-warning" onclick="showConfirmationRevision(\'' . $row->shipping_id . '\')" title="Needs Revision"><i class="nav-icon fas fa-sync-alt"></i></button>
                        //         <button type="button" class="btn btn-outline-success" onclick="showConfirmationCompleted(\'' . $row->shipping_id . '\')" title="Completed"><i class="nav-icon fas fa-check-circle"></i></button>
                        //       </td>';
                        break;
                    }

                    if (!empty($row->custom_report)) {
                      echo ' <td align="center"> <a href="' . base_url() . 'uploads/custom_report/' . $row->custom_report . '" target="_blank" class="product-info"><p class="text-info">View File</p></a></td>';
                    } else {
                      echo ' <td align="center"><p class="text-danger">No File Uploaded</p></td>';
                    }
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

<div class="modal fade" id="acceptShipping">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Shipping is Accepted</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to <strong class="text-info">accept</strong> this shipping?
      </div>
      <div class="modal-footer">
        <div id="confirmButtonsAccept"></div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="revisionShipping">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Shipping Needs Revision</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="revisions_msg">Reason for declining:</label>
        <textarea id="revisions_msg" class="form-control"></textarea>
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

<div class="modal fade" id="uploadCustomReport">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Custom Report</h4>
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
                <label for="custom_report">Upload your Custom Report
                  <!-- <i class="fas fa-question-circle" data-toggle="tooltip" title="Screenshot or any document, showing your selling price with company name"></i> -->
                </label>
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
              <button type="button" id="btn_upload" name="btn_upload" class="btn btn-block btn-success">Upload and Set to Completed</button>
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

<script>
  $(function() {
    // Summernote
    $("#revisions_msg").summernote({
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