<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="dark-blue-title">Products List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
            <li class="breadcrumb-item active">Products List</li>
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

          <div class="row">
            <div class="col-md-12 col-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title col-md-5">List of your Products</h3>
                  <div class="col-md-7 d-flex justify-content-end">

                    <?php
                    if ($user_details->ior_registered == 0) {
                      echo '<span id="IORshippingDisabled" class="d-block" tabindex="0" data-toggle="tooltip" title="Please register your company first to IOR.">
                              <button class="btn btn-dark-blue" style="pointer-events: none;" type="button" disabled><i class="fa fa-box-open mr-2"></i><strong>Add Product</strong></button>
                            </span>';
                    } else {
                      if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                        echo '<a href="' . base_url() . 'japan-ior/product-registrations" class="btn btn-dark-blue"><i class="fa fa-box-open mr-2"></i><strong>Add Product</strong></a>';
                      } else {
                        echo '<a href="' . base_url() . 'japan-ior/product-registration" class="btn btn-dark-blue"><i class="fa fa-box-open mr-2"></i><strong>Add Product</strong></a>';
                      }
                    }
                    ?>

                    <?php
                    if ($user_details->paid_product_label == 1) {
                      echo '&nbsp;<a href="' . base_url() . 'japan-ior/create-product-label" class="btn btn-dark-yellow"><i class="fa fa-tag mr-2"></i>Create Product Label</a>';
                    }
                    ?>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tbl_dashboard" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Date</th>
                        <th class="text-center"><?php echo ($user_details->user_role_id != 3) ? 'HS Code' : 'HS Code' ?></th>
                        <th class="text-center"><?php echo ($user_details->user_role_id != 3) ? 'Product Category' : 'Product Type' ?></th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Image</th>

                        <?php
                        if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                          echo ($user_details->user_role_id != 3) ? '<th class="text-center">Product Label</th>' : '<th class="text-center">Dimensions by piece</th>';
                        }
                        ?>

                        <?php if ($user_details->user_role_id != 3) {
                        ?>
                          <!-- <th class="text-center">Japan Radio Certificate /<br>Formaldehyde Test</th> -->
                          <th class="text-center">Certificates<i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Japan Radio Certificate/Formaldehyde Test (not applicable for Non-Regulated Products)"></i></th>
                        <?php
                        } else {
                        ?>
                          <th class="text-center">Weight by Piece</th>
                        <?php
                        } ?>





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
                        echo '  <td align="center">' . $product_registration->prod_registration_id . '</td>';
                        echo '  <td align="center">' . date('m/d/Y', strtotime($product_registration->product_registration_created)) . '</td>';
                        echo '  <td align="center">' . $product_registration->sku . '</td>';
                        if ($user_details->user_role_id != 3) {
                          echo '  <td align="center">' . $product_registration->category_name . '</td>';
                        } else {
                          if ($product_registration->product_type == 1) {
                            echo '  <td align="center">Commercial</td>';
                          } else {
                            echo '  <td align="center">Non-Commercial</td>';
                          }
                        }

                        echo '  <td align="center">' . $product_registration->product_name . '</td>';
                        echo '  <td align="center"><a href="' . base_url() . 'uploads/product_qualification/' . $product_registration->end_user_id . '/' . $product_registration->product_img . '" target="_blank" class="dark-blue-link">View File</a></td>';

                        if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                          if ($user_details->user_role_id != 3) {
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
                                echo '  <td align="center"><a href="' . base_url() . 'japan-ior/edit-product-label/' . $product_registration->product_label_id . '"><b><p class="text-danger" data-toggle="tooltip" title="Click here to edit Product Label"><i class="fas fa-exclamation-circle mr-2"></i>Pending Label</p></b></a></td>';
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
                                } elseif ($user_details->paid_product_label == 0 && file_exists($product_label_file) == false) {
                                  if ($product_registration->regulated_application_id == 0) {
                                    echo '  <td align="center"><a href="' . base_url() . 'japan-ior/product-label-terms" class="dark-blue-link"><b><p data-toggle="tooltip" title="Click here to purchase Product Label"><i class="fas fa-tag mr-2"></i>Purchase Label</p></b></a></td>';
                                  } else {
                                    echo '<td align="center"><strong class="text-danger">Not Yet Uploaded</strong><i class="fas fa-question-circle ml-2" data-toggle="tooltip" title="Product is tied up with the Regulated Application (cannot be updated here)." style="cursor: pointer;"></i></td>';
                                  }
                                } else {
                                  echo '  <td align="center"><a href="' . base_url() . 'japan-ior/create-product-label" class="dark-blue-link"><b><p data-toggle="tooltip" title="Click here to create Product Label"><i class="fas fa-tag mr-2"></i>Create Label</p></b></a></td>';
                                }

                                break;
                            }
                          } else {
                            echo '  <td align="center">' . $product_registration->dimensions_by_piece . '</td>';
                          }
                        }
                        if ($user_details->user_role_id != 3) {
                          if (!empty($product_registration->product_certificate)) {
                            echo '  <td align="center"><a href="' . base_url() . 'uploads/product_certificates/' . $product_registration->end_user_id . '/' . $product_registration->product_certificate . '" target="_blank" class="dark-blue-link">View File</a></td>';
                          } else {
                            if ($product_registration->product_category_id == 8) {
                              echo '<td align="center"><a href="' . base_url() . 'japan-ior/upload-product-certificate/' . $product_registration->prod_registration_id . '" class="text-danger"><b><p data-toggle="tooltip" title="Click here to upload Japan Radio Certificate"><i class="fas fa-exclamation-triangle mr-2"></i>Not Yet Uploaded</a></p></b></td>';
                            } else if ($product_registration->product_category_id == 11) {
                              echo '<td align="center"><a href="' . base_url() . 'japan-ior/upload-product-certificate/' . $product_registration->prod_registration_id . '" class="text-danger"><b><p data-toggle="tooltip" title="Click here to upload Baby Products Certificate"><i class="fas fa-exclamation-triangle mr-2"></i>Not Yet Uploaded</a></p></b></td>';
                            } else {
                              echo '<td align="center">N/A</td>';
                            }
                          }
                        } else {
                          echo '  <td align="center">' . $product_registration->weight_by_piece . '</td>';
                        }

                        switch ($product_registration->product_status) {
                          case 1:
                            echo '<td align="center"><span class="badge badge-success">' . $product_registration->label . '</span></td>';
                            echo '<td align="center">No Action</td>';
                            break;
                          case 2:
                            echo '<td align="center"><span class="badge badge-danger">' . $product_registration->label . '</span></td>';

                            if ($product_registration->product_category_id != 1 && $product_registration->product_category_id != 8 && $product_registration->product_category_id != 11) {
                              echo '<td align="center">
                                      <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#declineRegulatedMsg"><i class="fas fa-exclamation-circle mr-2"></i>Why Declined?</button>
                                    </td>';
                            } else {
                              echo '<td align="center">
                                      <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#declinedMsg_' . $product_registration->prod_registration_id . '"><i class="fas fa-exclamation-circle mr-2"></i>Why Declined?</button>
                                    </td>';
                            }
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
                              echo '<a href="' . base_url() . 'japan-ior/edit-product/' . $product_registration->prod_registration_id . '" role="button" class="btn btn-xs btn-dark-blue" title="Edit"><i class="nav-icon fas fa-pen mr-2"></i>Edit</a>';
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

<div class="modal fade" id="announcement">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Announcement to COVUE IOR Customers:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if ($user_details->ior_registered == 1 && $user_details->pli == 0) { ?>
          <p>We have updated our terms of use for COVUE IOR services.</p>
          <p>Effective January 1, 2021, all users will be assessed and annual Product Liability fee.</p>
          <p>Information about our updated terms can be found <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank">here</a>.</p>
        <?php } else { ?>
          <h5>From July 1, 2020, DHL Japan has stopped all shipments to Amazon FBA.</h5>
          <br>
          <h5>Do not use DHL for your shipping to Japan FBA locations.</h5>
        <?php } ?>

      </div>
      <div class="modal-footer d-flex justify-content-end">

        <?php if ($user_details->ior_registered == 1 && $user_details->pli == 0) { ?>
          <a href="<?php echo base_url(); ?>japan-ior/pli" id="btn_pay_pli_announcement" class="btn btn-dark-blue"><i class="fas fa-thumbs-up mr-2"></i>Pay Now</a>
        <?php } else { ?>
          <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Got It</button>
        <?php } ?>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_register_company">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Notice:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if (!$has_approved_products) { ?>
          <p>Make sure your products are eligible before you register and pay IOR registration.</p>
        <?php } else { ?>
          <p>Approval takes 24 hours from submission during normal business hours Monday to Friday 09:30 to 17:30.</p>
        <?php } ?>

      </div>
      <div class="modal-footer d-flex justify-content-end">
        <a href="https://www.covue.com/product-eligibility-check/" target="_blank" role="button" class="btn btn-dark-blue">Check Products Eligibility</a>
        <a href="<?php echo base_url(); ?>japan-ior/ior" role="button" class="btn btn-outline-dark-blue">Register IOR</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_request_ior_no_prod">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Notice:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p>Please register your products first before you request IOR shipping.</p>

      </div>
      <div class="modal-footer d-flex justify-content-end">
        <a href="<?php echo base_url(); ?>japan-ior/product_registrations" role="button" class="btn btn-dark-blue">Register Your Products Here</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="declineRegulatedMsg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product is Regulated</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Product has a regulation policy, needs to have a regulated application.</p>
        <p>Please <a href="<?php echo base_url(); ?>japan-ior/product-services-fee" class="dak-yellow-link">click here</a> to continue:</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal