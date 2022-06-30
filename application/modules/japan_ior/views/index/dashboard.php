<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title">Japan IOR Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>" class="dark-blue-link">Home</a></li>
            <li class="breadcrumb-item active">Japan IOR Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-9 col-12">

          <div class="row">
            <div class="col-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title dark-blue-title col-md-5"><i class="nav-icon fas fa-box mr-2"></i>List of your Product Registration</h3>
                  <div class=" col-md-7 d-flex justify-content-end">
                    <?php

                    if ($user_details->ior_registered == 0) {
                      echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                            <button id="my-element" class="btn btn-dark-blue" style="pointer-events: none;" type="button" disabled>Add Products</button>
                          </span>';
                    } else {
                      if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                        echo '<a href="' . base_url() . 'japan-ior/product-registrations" class="btn btn-dark-blue" id="my-element">Add Products</a>';
                      } else {
                        echo '<a href="' . base_url() . 'japan-ior/product-registration" class="btn btn-dark-blue" id="my-element">Add Products</a>';
                      }
                    }
                    ?>

                    <?php
                    if ($user_details->paid_product_label == 1) {
                      echo '&nbsp;<a href="' . base_url() . 'japan-ior/create-product-label" class="btn btn-outline-dark-blue"><i class="fa fa-tag mr-2"></i>Create Product Label</a>';
                    }
                    ?>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="my-other-element">
                  <table id="tblJapanIOR_product_reg" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">HS Code</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Image</th>

                        <?php
                        if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                          echo '<th class="text-center">Product Label</th>';
                        }
                        ?>

                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      foreach ($product_registrations as $product_registration) {
                        if (!empty($product_registration->product_label)) {
                          $product_label_file = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product_labels' . DIRECTORY_SEPARATOR . $user_details->user_id . DIRECTORY_SEPARATOR . $product_registration->product_label;
                        } else {
                          $product_label_file = '';
                        }

                        echo '<tr>';
                        echo ' <td align="center">' . date('m/d/Y', strtotime($product_registration->product_registration_created)) . '</td>';
                        echo '  <td align="center">' . $product_registration->sku . '</td>';
                        echo '  <td align="center">' . $product_registration->product_name . '</td>';
                        echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $product_registration->end_user_id . '/' . $product_registration->product_img . '" target="_blank" class="dark-blue-link">View File</a></td>';

                        if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                          switch ($product_registration->product_label_status) {
                            case 1:
                              echo '  <td align="center"><a href="' . base_url() . 'uploads/product_labels/' . $product_registration->end_user_id . '/' . $product_registration->product_label . '" target="_blank" class="dark-blue-link">View File</a></td>';
                              break;
                            case 2:
                              echo '  <td align="center"><span class="badge badge-primary">Label Generation is on process</span></td>';
                              break;
                            case 3:
                              echo '  <td align="center"><b><p class="text-warning" data-toggle="tooltip" title="Click Edit button to view needs revisions" style="cursor: pointer;"><i class="fas fa-exclamation-triangle mr-2"></i>Needs Revision</p></b></td>';
                              break;
                            case 4:
                              echo '  <td align="center"><a href="' . base_url() . 'japan-ior/edit-product-label/' . $product_registration->product_label_id . '"><b><p class="text-danger" data-toggle="tooltip" title="Click to edit product label"><i class="fas fa-exclamation-circle mr-2"></i>Pending Label</p></b></a></td>';
                              break;
                            case 5:
                              echo '  <td align="center"><span class="badge badge-primary">Label Generation is on process</span></td>';
                              break;
                            case 6:
                              echo '  <td align="center"><span class="badge badge-primary">Label Generation is on process</span></td>';
                              break;
                            default:
                              if (file_exists($product_label_file) == true) {
                                echo ' <td align="center"><a href="' . base_url() . 'uploads/product_labels/' . $product_registration->end_user_id . '/' . $product_registration->product_label . '" target="_blank" class="dark-blue-link">View File</a></td>';
                              } else if ($user_details->paid_product_label == 0 && file_exists($product_label_file) == false) {
                                if ($product_registration->regulated_application_id == 0) {
                                  echo '<td align="center"><a href="' . base_url() . 'japan-ior/product-label-terms" class="dark-blue-link"><b><p data-toggle="tooltip" title="Click to purchase product label"><i class="fas fa-tag mr-2"></i>Purchase Label</p></b></a></td>';
                                } else {
                                  echo '<td align="center"><strong class="text-danger">Not Yet Uploaded</strong><i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be updated here)." style="cursor: pointer;"></i></td>';
                                }
                              } else {
                                echo '  <td align="center"><a href="' . base_url() . 'japan-ior/create-product-label" class="dark-blue-link"><b><p data-toggle="tooltip" title="Click to create product label"><i class="fas fa-tag mr-2"></i>Create Label</p></b></a></td>';
                              }

                              break;
                          }
                        }

                        switch ($product_registration->product_status) {
                          case 1:
                            echo '<td align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">No Action</td>';
                            break;
                          case 2:
                            echo '<td align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">
                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#declinedMsg_' . $product_registration->prod_registration_id . '"><i class="fas fa-exclamation-circle mr-2"></i>Why Declined?</button>
                                      </td>';
                            break;
                          case 3:
                            echo '<td align="center"><span class="badge badge-warning">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">';
                            echo '  <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#revisionsMsg_' . $product_registration->prod_registration_id . '"><i class="fas fa-comment-dots mr-2"></i>View</button>';
                            if ($product_registration->regulated_application_id == 0) {
                              echo '  <a href="' . base_url() . 'japan-ior/edit-product/' . $product_registration->prod_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                            }
                            echo '</td>';
                            break;
                          case 5:
                            echo '<td align="center"><span class="badge badge-info">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">';
                            if ($product_registration->regulated_application_id == 0) {
                              echo '  <a href="' . base_url() . 'japan-ior/edit-product/' . $product_registration->prod_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                            } else {
                              echo '  N/A<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be edited here)." style="cursor: pointer;"></i>';
                            }
                            echo '</td>';
                            break;
                          case 6:
                            echo '<td align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">';
                            if ($product_registration->regulated_application_id == 0) {
                              echo '<a href="' . base_url() . 'japan-ior/edit-product-label/' . $product_registration->product_label_id . '" role="button" class="btn btn-xs btn-outline-dark-blue" title="Edit Label Details"><i class="nav-icon fas fa-tag mr-2"></i>Edit Label Details</a>';
                            } else {
                              echo '  N/A<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be edited here)." style="cursor: pointer;"></i>';
                            }
                            echo '</td>';

                            break;
                          default:
                            echo '<td align="center"><span class="badge badge-secondary">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">';
                            if ($product_registration->regulated_application_id == 0) {
                              echo '  <a href="' . base_url() . 'japan-ior/edit-product/' . $product_registration->prod_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
                            } else {
                              echo '  N/A<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be edited here)." style="cursor: pointer;"></i>';
                            }
                            echo '</td>';
                            break;
                        }

                        echo '</tr>';

                        if (!empty($product_registration->revisions_msg)) {

                          echo '<div class="modal fade" id="revisionsMsg_' . $product_registration->prod_registration_id . '">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Revisions Message</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            
                                            ' . $product_registration->revisions_msg . '

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->';
                        }

                        if (!empty($product_registration->declined_msg)) {

                          echo '<div class="modal fade" id="declinedMsg_' . $product_registration->prod_registration_id . '">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Declined Message</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            
                                            ' . $product_registration->declined_msg . '

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->';
                        }
                      }

                      ?>

                    </tbody>
                  </table>

                  <a href="<?php echo base_url(); ?>japan-ior/products-list" class="dark-blue-link" style="float: right;">see all >></a>
                </div>
                <!-- /.card-body -->

              </div>
              <!-- /.card -->
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title col-md-5 dark-blue-title"><i class="nav-icon fas fa-shipping-fast mr-2"></i>List of your Shipping Invoice Requests</h3>
                  <div class=" col-md-7 d-flex justify-content-end">
                    <?php
                    if ($user_details->ior_registered == 0 || $user_details->pli == 0) {
                      echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                          <button class="btn btn-block btn-dark-blue" style="pointer-events: none;" type="button" disabled>Create Shipping Invoice</button>
                        </span>';
                    } else {
                      echo '<a href="' . base_url() . 'japan-ior/shipping-invoices" class="btn btn-dark-blue">Create Shipping Invoice</a>';
                    }
                    ?>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tblJapanIOR_shipping" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Date</th>
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
                        echo '  <td align="center">' . (($shipping_invoice->invoice_date != '0000-00-00') ? date('m/d/Y', strtotime($shipping_invoice->invoice_date)) : '<a href="#" class="dark-blue-link" data-toggle="tooltip" data-placement="top" title="Invoice Date is not yet generated.">N/A</a>') . '</td>';
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
                              echo '<td align="center"><button type="submit" onclick="showShippingInvoiceNotice(\'' . $shipping_invoice->shipping_invoice_id . '\')" class="btn btn-sm btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Now</button></td>';
                            } else {
                              echo '<td align="center"><span class="badge badge-primary">Paid</span></td>';

                              if (file_exists($shipping_invoice_pdf_file) && file_exists($shipping_invoice_final_pdf_file)) {
                                echo '<td align="center">
                                        <a href="' . base_url() . 'japan-ior/send-shipping-invoice/' . $shipping_invoice->shipping_invoice_id . '" id="btn_send_approved_invoice" role="button" class="btn btn-xs btn-dark-yellow" title="Send Approved Invoice"><i class="nav-icon fas fa-paper-plane mr-2"></i>Send Approved Invoice</a>
                                      </td>';
                              }

                              if (file_exists($shipping_invoice_pdf_file) && !file_exists($shipping_invoice_final_pdf_file)) {
                                echo '<td align="center"><a href="#" onclick="generateApprovedInvoice(\'' . $shipping_invoice->shipping_invoice_id . '\')" role="button" class="btn btn-xs btn-outline-dark-blue" title="Generate Approved Invoice"><i class="nav-icon fas fa-info-circle mr-2"></i>Generate Approved Invoice</a></td>';
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

                  <a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link" style="float: right;">see all >></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-8 col-12">

              <div class="card" style="height: 246px;">
                <div class="card-header">
                  <h3 class="card-title col-md-8 dark-blue-title"><i class="fa fa-gavel mr-2"></i>List of your Regulated Applications</h3>
                  <div class=" col-md-4 d-flex justify-content-end">
                    <?php

                    if ($user_details->ior_registered == 0 || $user_details->pli == 0) {
                      echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                              <button class="btn btn-sm btn-dark-blue" style="pointer-events: none;" type="button" disabled>Apply for Regulated Application</button>
                            </span>';
                    } else {
                      if ($billing_invoices_unpaid_count == 0) {
                        echo '<a href="' . base_url() . 'japan-ior/product-services-fee" class="btn btn-sm btn-dark-blue">Apply for Regulated Application</a>';
                      } else {
                        echo '<a href="' . base_url() . 'japan-ior/billing-invoices" class="btn btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Unpaid Invoices first!</a>';
                      }
                    }

                    ?>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tblJapanIOR_regulated" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Regulated Applications</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      foreach ($paid_regulated_applications as $paid_regulated_application) {
                        echo '<tr id="' . $paid_regulated_application->user_payment_invoice_id . '">';
                        echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($paid_regulated_application->invoice_date)) . '</td>';
                        echo '  <td align="center">' . $paid_regulated_application->category_name . '</td>';

                        if ($paid_regulated_application->payment_status == 1) {
                          if (!empty($paid_regulated_application->regulated_application_id)) {
                            if ($paid_regulated_application->tracking_status == 7 && $paid_regulated_application->approve_status == 1) {
                              echo '<td align="center"><span class="badge badge-success">Application Approved</span></td>';
                            } else {
                              echo '<td align="center"><span class="badge badge-info">Application In Process</span></td>';
                            }
                            echo '<td align="center"><a href="' . base_url() . 'japan-ior/tracking-application/' . $paid_regulated_application->regulated_application_id . '" class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View</a></td>';
                          } else {
                            echo '<td align="center"><span class="badge badge-secondary">Pending</span></td>';
                            echo '<td align="center">
                                          <a href="' . base_url() . 'japan-ior/create-regulated-application/' . $paid_regulated_application->user_payment_invoice_id . '" id="btn_start_regulated" class="btn btn-xs btn-outline-dark-blue" data-toggle="button" aria-pressed="false"><i class="fa fa-play-circle mr-2"></i>Start Application</a>
                                          <button id="btn_start_loading" class="btn btn-xs btn-outline-dark-blue" type="button" disabled style="display: none;">
                                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                              <span class="sr-only">Loading...</span>
                                          </button>
                                        </td>';
                          }
                        } else {
                          echo '<td align="center">N/A</td>';
                          echo '<td align="center">N/A</td>';
                        }

                        echo '</tr>';
                      }

                      ?>

                    </tbody>
                  </table>

                  <a href="<?php echo base_url(); ?>japan-ior/regulated-applications" class="dark-blue-link" style="float: right;">see all >></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>


            <div class="col-md-4 col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title dark-blue-title">
                    <i class="fas fa-question-circle mr-2"></i>
                    Helpful Links
                  </h3>
                </div>
                <div class="card-body">
                  <ul>
                    <li><a href="<?php echo base_url() . 'japan-ior/ior-manual-guide'; ?>" target="_blank" class="dark-blue-link helpful-links">IOR User Manual Guide</a></li>
                    <li><a href="https://www.covue.com/ior-registration" target="_blank" class="dark-blue-link helpful-links">IOR Pricing Fees</a></li>
                    <li><a href="<?php echo base_url() . 'japan-ior/shipping-invoice-docs'; ?>" target="_blank" class="dark-blue-link helpful-links">Shipping Instructions and Amazon Seller Account Report Guide</a></li>
                    <li><a href="<?php echo base_url() . 'japan-ior/product-labelling-compliance'; ?>" target="_blank" class="dark-blue-link helpful-links">Product Labeling Compliance</a></li>
                  </ul>

                  <a href="<?php echo base_url(); ?>japan-ior/helpful-links" class="dark-blue-link" style="float: right;">see all >></a>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>

        </div>
        <!-- /.col -->

        <div class="col-md-3 col-12">

          <div class="row">

            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center"><a href="https://www.covue.com/product-eligibility/" class="dark-blue-link" target="_blank"><i class="nav-icon fas fa-check-circle mr-2"></i>Check Product Eligibility Here</a></h5>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title dark-blue-title">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Announcements
                  </h3>
                </div>
                <div class="card-body">

                  <?php
                  if (file_exists('uploads/docs/notice_and_addendum.pdf')) {;
                  ?>
                    <div class="callout callout-danger">
                      <h5>Notice and Addendum:</h5>
                      <a href="<?php echo base_url(); ?>uploads/docs/notice_and_addendum.pdf" class="dark-blue-link" target="_blank" style="text-decoration: none;">Click Here to View</a>
                    </div>
                  <?php
                  }
                  ?>

                  <div class="callout callout-danger">
                    <p>DHL Japan has stopped all shipments to Amazon FBA.</p>
                    <p>Do not use DHL for your shipping to Japan FBA locations.</p>
                  </div>

                </div>
                <!-- /.card-body -->
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title dark-blue-title">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Transactional Invoices
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tblJapanIOR_billing" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Product Category</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      foreach ($billing_invoices as $billing_invoice) {

                        $product_name = '';

                        if ($billing_invoice->shipping_invoice_id != 0) {
                          $product_name .= '<strong> Shipping Invoice ID #' . $billing_invoice->shipping_invoice_id . '</strong>';
                        } else {
                          if ($billing_invoice->register_ior == 1) {
                            $product_name .= 'IOR One-Time Registration Fee' . '<br>';
                          }

                          if ($billing_invoice->pli_sub == 1) {
                            $product_name .= 'Product Liability Insurance' . '<br>';
                          }

                          if ($billing_invoice->product_offer_id != 0) {
                            $product_name .= '<strong>' . $billing_invoice->name . '</strong>';
                          }
                        }

                        echo '<tr id="' . $billing_invoice->user_payment_invoice_id . '">';
                        echo '  <td align="center" style="vertical-align:middle">' . date('m/d/Y', strtotime($billing_invoice->invoice_date)) . '</td>';
                        echo '  <td align="center">' . $product_name . '</td>';
                        echo ($billing_invoice->payment_status == 1) ? '<td align="center" style="vertical-align:middle"><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-dark-blue"><i class="fa fa-search-plus mr-2"></i>View</a></td>' : '<td align="center" style="vertical-align:middle"><a href="' . base_url() . 'japan-ior/billing-invoice/' . $billing_invoice->user_payment_invoice_id . '" type="submit" onclick="" class="btn btn-xs btn-danger"><i class="fas fa-exclamation-circle mr-2"></i>Pay Now</a></td>';
                        echo '</tr>';
                      }

                      ?>

                    </tbody>
                  </table>

                  <a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="dark-blue-link" style="float: right;">see all >></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

          </div>

        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.modal -->

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

<div class="modal fade" id="modal_holidays">
  <div class="modal-dialog modal-lg">
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
              <p>Japan New Year will begin December 26, 2021 to January 4, 2021.</p>
              <p>Most of Japan business including all government agencies will be closed in recognition of the holiday.</p>
              <br>
              <p>COVUE will be operating on a limited scale.</p>
              <p>Active import applications will be paused during the holiday due to government agencies being closed.</p>
              <p>New application requests received during the holiday period will start from January 5, 2021.</p>
              <p>Please be advised that most logistics companies will not be operating during the holiday. Shipments within Japan will be limited.</p>
              <p>COVUE 3PL will be operating on a limited based for emergency services. Be advised that many transport companies may not be operating during the holiday period.</p>
            </div>
          </div>

        </div>

      </div>
      <div class="modal-footer d-flex justify-content-end">
        <a href="#" class="btn btn-dark-blue" data-dismiss="modal">I acknowledged and understand this</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>