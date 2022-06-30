<style type="text/css">
    .modal {
        overflow-y: auto
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Application ID #<?php echo $regulated_application->regulated_application_id; ?> : <?php echo $regulated_application->category_name; ?> Application for <?php echo $regulated_application->user_company_name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>regulated-applications">Regulated Applications</a></li>
                        <li class="breadcrumb-item active">Tracking Details</li>
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
                        <div class="card-body">

                            <?php if ($this->session->flashdata('success') != null) : ?>

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('success'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php endif ?>
                            <?php if ($this->session->flashdata('cancelled') != null) : ?>

                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $this->session->flashdata('cancelled'); ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                            <?php endif ?>
                            <input type="hidden" id="regulated_application_id" value="<?php echo $regulated_application->regulated_application_id; ?>">
                            <table id="tblRegulatedApplicationsDetails" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Stages</th>
                                        <th class="text-center">Details</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Last Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $count = 1;
                                    foreach ($regulated_status_list as $regulated_status) {
                                        // echo $regulated_status->approve_status;
                                        if ($regulated_status->tracking_status == '1') {
                                            if ($regulated_status->approve_status == 4 || $regulated_status->approve_status == 6 || $regulated_status->approve_status == 2 || $regulated_status->approve_status == 3 || $regulated_status->approve_status == 5) {
                                                $stat = 'pending';
                                            } else {
                                                $stat = '';
                                            }
                                        } else {
                                            if ($regulated_status->approve_status == 4  || $regulated_status->approve_status == 3 || $regulated_status->approve_status == 2 || $regulated_status->approve_status == 5) {
                                                $stat = 'pending';
                                            }
                                        }
                                        if ($regulated_status->tracking_status != null) {
                                            $cnt = $count++;
                                            echo '<tr class="table-warning">';
                                            echo '<td>' . $regulated_status->tracking_status_name . '</td>';
                                            if ($regulated_status->tracking_status == 1) {
                                                echo '<td align="center"><a href="' . base_url('regulated-applications/regulated-products-list/' . $regulated_status->regulated_application_id) . '" class="btn btn-xs btn-primary"><i class="fas fa-search-plus mr-2"></i>View Products</a></td>';
                                            } elseif ($regulated_status->tracking_status == 4) {
                                                echo '<td align="center"><a href="' . base_url('regulated-applications/upload-test-results/' . $regulated_status->regulated_application_id) . '" class="btn btn-xs btn-primary"><i class="fas fa-flask mr-2"></i>Upload Lab/Product Test Results</a></td>';
                                            } elseif ($regulated_status->tracking_status == 5) {
                                                echo '<td align="center"><a href="' . base_url('regulated-applications/upload-product-labels/' . $regulated_status->regulated_application_id) . '" class="btn btn-xs btn-primary"><i class="fas fa-tags mr-2"></i>Upload Product Labels</a></td>';
                                            } else {
                                                echo "<td></td>";
                                            }
                                            switch ($regulated_status->approve_status) {
                                                case "1":
                                                    echo '<td align="center"><span class="badge badge-success">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                                case "2":
                                                    echo '<td align="center"><span class="badge badge-danger">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                                case "3":
                                                    echo '<td align="center"><span class="badge badge-warning">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                                case "5":
                                                    echo '<td align="center"><span class="badge badge-secondary">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                                case "6":
                                                    echo '<td align="center"><span class="badge badge-info">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    echo '<td align="center">No Action</td>';
                                                    break;
                                                default:
                                                    if ($reg_products_revisions_cnt != 0 && $regulated_status->tracking_status == 1) {
                                                        echo '<td align="center"><span class="badge badge-warning">Some products needs revision.</span></td>';
                                                    } elseif ($reg_products_declined_cnt != 0 && $regulated_status->tracking_status == 1) {
                                                        echo '<td align="center"><span class="badge badge-danger">Some products are declined</span></td>';
                                                    } else {
                                                        echo '<td align="center"><span class="badge badge-secondary">' . $regulated_status->tracking_status_label . '</span></td>';
                                                    }
                                                    if ($regulated_status->tracking_status == 1) {
                                                        echo '<td align="center">N/A</td>';
                                                    } else {
                                                        if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $regulated_application->assigned_admin_id) {
                                                            echo '<td align="center">';
                                                            echo '<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#sendNotification' . $regulated_status->r_id . '">Completed</button>';
                                                            echo '&nbsp;&nbsp;';
                                                            echo '<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#cancelStatus' . $regulated_status->r_id . '">Cancel</button>';
                                                            echo '</td>';
                                                        } else {
                                                            echo '<td align="center"><strong class="text-danger">No Access<strong></td>';
                                                        }
                                                    }
                                            }

                                            if (empty($regulated_status->remarks)) {
                                                if ($regulated_status->tracking_status == 1) {
                                                    echo '<td align="center">N/A</td>';
                                                } else {
                                                    echo '<td align="center">No Remarks</td>';
                                                }
                                            } else {
                                                if ($regulated_status->tracking_status == 1) {
                                    ?>
                                                    <td align="center"><a href="#" data-revisions="<?php echo strip_tags($regulated_status->remarks); ?>" data-toggle="modal" onclick="showMainRev('<?php echo htmlentities($regulated_status->remarks); ?>')" data-target="#viewremarks1"><i class="fas fa-comment-dots mr-2"></i>View Remarks</a></td>
                                        <?php
                                                } else {
                                                    echo '<td align="center"><a href="#" data-toggle="modal" data-target="#viewremarks' . $regulated_status->r_id . '"><i class="fas fa-comment-dots mr-2"></i>View Remarks</a></td>';
                                                }
                                            }

                                            if (!empty($regulated_status->updated_at)) {
                                                echo ' <td align="center">' . date('m/d/Y', strtotime($regulated_status->updated_at))  . '</td>';
                                            } else {
                                                echo ' <td align="center">N/A</td>';
                                            }

                                            echo '</tr>';
                                        }
                                        ?>

                                        <?php
                                        if ($regulated_status->approve_status == 4) {
                                        ?>

                                            <!-- SEND NOTIFICATION MODAL -->
                                            <div class="modal fade" id="sendNotification<?php echo $regulated_status->r_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Status Completed Confirmation</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="frm_completed" method="POST">
                                                                <input type="hidden" name="regulated_application_id" value="<?php echo $regulated_status->regulated_application_id; ?>">
                                                                <input type="hidden" name="tracking_status" value="<?php echo $regulated_status->tracking_status; ?>">
                                                                <input type="hidden" name="company_name" value="<?php echo $regulated_application->user_company_name; ?>">
                                                                <input type="hidden" name="user_id" value="<?php echo $regulated_application->user_id; ?>">
                                                                <input type="hidden" name="email" value="<?php echo $regulated_application->user_email; ?>">
                                                                <p> Do you want to set this stage to completed? (Remarks are optional) </p>
                                                                <textarea name="remarks" class="remarks_msg form-control"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div>
                                                                <button type="submit" id="btn_completed" class="btn btn-success" name="send_notification">Yes</button>
                                                                <button type="button" id="btn_sending" class="btn btn-success disabled" style="display:none;">Sending, please wait ...</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">No</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END SEND NOTIFICATION MODAL -->

                                            <!-- CANCEL STATUS MODAL -->
                                            <div class="modal fade" id="cancelStatus<?php echo $regulated_status->r_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cancel Status </h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="frm_completed" method="POST">
                                                                <input type="hidden" name="regulated_application_id" value="<?php echo $regulated_status->regulated_application_id; ?>">
                                                                <input type="hidden" name="tracking_status" value="<?php echo $regulated_status->tracking_status; ?>">
                                                                <p> Are you sure to cancel this process? </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div>
                                                                <button type="submit" id="btn_completed" class="btn btn-success" name="cance_status">Yes</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">No</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END CANCEL STATUS MODAL -->


                                        <?php
                                        }
                                        ?>

                                        <!--  VIEW REMARKS MODAL -->
                                        <div class="modal fade" id="viewremarks<?php echo $regulated_status->r_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Remarks</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo $regulated_status->remarks; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" role="button">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- END VIEW REMARKS MODAL -->

                                        <?php
                                    }
                                    if ($cnt != 7) {
                                        if ($stat != 'pending') {
                                            echo '<tr>';
                                            echo '<td>';
                                            echo '<select class="form-control" id="tracking-status">';
                                            echo "<option> - Select Status - </option>";
                                            foreach ($regulated_status_a as $row => $val) {
                                                if ($val->tracking_status == null) {
                                                        echo '<option value="' . $val->regulated_status_id . '" >' . $val->tracking_status_name . '</option>';
                                                }
                                            }
                                            echo '</select>';
                                            echo '</td>';
                                            echo '<td id="product-lab" align="center"></td>';
                                            echo "<td></td>";
                                            if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == $regulated_application->assigned_admin_id) {
                                                if ($cnt != 6) {
                                                    echo '<td align="center" id="btn-notif" style="display:none;"><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#sendComplete' . $val->r_id . '">Completed</button></td>';
                                                } else {
                                                    echo '<td align="center" ><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#sendComplete' . $val->r_id . '">Completed</button></td>';
                                                }
                                            } else {
                                                echo '<td align="center" id="btn-notif"  style="display:none;><strong class="text-danger">No Access<strong></td>';
                                            }
                                            echo '  <td></td>';
                                            echo '  <td></td>';
                                            echo '</tr>';

                                        ?>

                                            <!-- SEND NOTIFICATION MODAL -->
                                            <div class="modal fade" id="sendComplete<?php echo $val->r_id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Status Completed Confirmation</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="frm_completed" method="POST">
                                                                <input type="hidden" name="regulated_application_id" value="<?php echo $regulated_application->regulated_application_id; ?>">
                                                                <?php if ($cnt != 6) { ?>
                                                                    <input type="hidden" name="tracking_status" id="tracking_status">
                                                                <?php } else { ?>
                                                                    <input type="hidden" name="tracking_status" value="7">
                                                                <?php } ?>
                                                                <input type="hidden" name="company_name" value="<?php echo $regulated_application->user_company_name; ?>">
                                                                <input type="hidden" name="user_id" value="<?php echo $regulated_application->user_id; ?>">
                                                                <input type="hidden" name="email" value="<?php echo $regulated_application->user_email; ?>">
                                                                <input type="hidden" name="stepcount" id="stepcount">
                                                                <p> Do you want to set this stage to completed? (Remarks are optional) </p>
                                                                <textarea name="remarks" class="remarks_msg1 form-control"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div>
                                                                <button type="submit" id="btn_completed" class="btn btn-success" name="send_notification">Yes</button>
                                                                <button type="button" id="btn_sending" class="btn btn-success disabled" style="display:none;">Sending, please wait ...</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">No</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END SEND NOTIFICATION MODAL -->
                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="col-12 d-flex justify-content-end">
                        <div class="form-group">
                            <a href="<?php echo base_url(); ?>regulated-applications" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Go Back to Regulated Applications</a>
                        </div>
                    </div>

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

<div class="modal fade" id="modal_assigned_admin_reg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm New Application Assignment?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to assign the New Application to <strong id="assign_admin_name"></strong>?
                <br><br>
                The assigned compliance staff will receive a notification about the new application.
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

<div class="modal fade" id="modal_delete_shipping_company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Warning:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong class="text-danger">delete</strong> this shipping company?
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

<!-- /. confirm modal -->
<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_completed" method="POST">
                    <input type="hidden" name="regulated_application_id" value="<?php echo $regulated_application->regulated_application_id; ?>">
                    <input type="hidden" name="tracking_status_a" id="tracking_status_a">
                    <input type="hidden" name="stepcount" id="stepcount_a">
                    <p>Are you sure to confirm this status ?</p>
            </div>
            <div class="modal-footer">
                <div>
                    <button type="submit" id="btn_completed" class="btn btn-success" name="confirm_status">Yes</button>
                    <button type="button" class="btn btn-danger" id="no-status" data-dismiss="modal" role="button">No</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /. modal -->

<!--  VIEW REMARKS MODAL -->
<div class="modal fade" id="viewremarks1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remarks</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pre-import Notification Process <strong>(Needs Revision)</strong></h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-2">
                        <div id="rev-con"> </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of <?php echo $regulated_application->category_name; ?> Products <strong>(Needs Revision)</strong></h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-2">

                        <table id="tblCosmeticProducts" cellspacing="1" cellpadding="1" class="table table-bordered table-striped text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">Product ID</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Revisions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($reg_products_revisions as $prod_reg) {
                                    # code...
                                ?>
                                    <tr>
                                        <td align="center">
                                            <?php echo $prod_reg->product_registration_id ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $prod_reg->product_name ?>
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="#viewproductremarks2" onclick="showRevisionMsg('<?php echo $prod_reg->product_name ?>','<?php echo htmlentities($prod_reg->revisions_msg) ?>')" role="button" class="btn btn-warning" title="View Revisions"><i class="fas fa-comment-dots"></i></a>


                                        </td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" role="button">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- END VIEW REMARKS MODAL -->

<!--  VIEW REMARKS MODAL -->
<div class="modal fade" id="viewproductremarks2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="white-space: normal;"><span id="prod_title"></span> (Needs Revision)</h4>

            </div>
            <div class="modal-body">
                <span id="revision_msg"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="openModalModal('<?php echo $prod_reg->product_registration_id ?>')" role="button">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- END VIEW REMARKS MODAL -->

<script>
    $(function() {
        // Summernote
        $(".remarks_msg").summernote({
            placeholder: 'Place your remarks here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

    });
    $(function() {
        // Summernote
        $(".remarks_msg1").summernote({
            placeholder: 'Place your remarks here ...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]
        })

    });

    function openModalModal(id) {

        setTimeout(function() {
            $('#viewremarks1').modal('show');
        }, 500);
    }

    function showMainRev(msg) {
        $('#rev-con p').remove();
        $('#rev-con').append(msg);
    }

    function showRevisionMsg(name, rev_msg) {
        $('#prod_title').text(name);
        $('#revision_msg').html(rev_msg);
    }
</script>