<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Regulated Application List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Regulated Applications</li>
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

                            <table id="tblRegulatedApplicationsAdmin" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Company Name</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Details</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Application Date</th>
                                        <th class="text-center">Last Date Updated</th>
                                        <th class="text-center">Assigned Personnel</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    foreach ($regulated_applications as $regulated_application) {
                                        $dropdown = '<select class="form-control assign_admin_reg" data-id=' . $regulated_application->regulated_application_id . ' style="height:30px; font-size:12px;">';

                                        if ($regulated_application->assigned_admin_id == 0) {
                                            $dropdown .=  '<option value="0" selected>Unassigned</option>';
                                        }

                                        foreach ($admins_no_super as $admin_no_super) {
                                            if ($admin_no_super->user_details_id == $regulated_application->assigned_admin_id) {
                                                $dropdown .=  '<option value="' . $admin_no_super->user_details_id . '" data-name="' . $admin_no_super->contact_person . '" data-assignor="' . $user_id . '" selected>' . $admin_no_super->contact_person . '</option>';
                                            } else {
                                                $dropdown .=  '<option value="' . $admin_no_super->user_details_id . '" data-name="' . $admin_no_super->contact_person . '" data-assignor="' . $user_id . '">' . $admin_no_super->contact_person . '</option>';
                                            }
                                        }

                                        $dropdown .= '</select>';
                                        echo '<tr>';
                                        echo '  <td align="center">' . $regulated_application->regulated_application_id . '</td>';
                                        echo '  <td align="center">' . $regulated_application->user_company_name . '</td>';
                                        echo '  <td align="center">' . $regulated_application->category_name . '</td>';
                                        echo '  <td align="center"><a href="' . base_url() . 'regulated-applications/tracking-details/' . $regulated_application->regulated_application_id . '"><i class="fas fa-search-plus mr-2"></i>View Tracking Details</a></td>';
                                        switch ($regulated_application->tracking_status) {
                                            case 1:
                                                if ($regulated_application->assigned_admin_id != 0) {
                                                    if ($regulated_application->approve_status == 2) {
                                                        echo '<td align="center"><strong class="text-danger"><i class="fas fa-exclamation-circle mr-2"></i>DECLINED APPLICATION!</strong></td>';
                                                    } else if ($regulated_application->approve_status == 5) {
                                                        echo '<td align="center"><strong class="text-danger"><i class="fas fa-exclamation-circle mr-2"></i>APPLICATION CANCELLED!</strong></td>';
                                                    } else {
                                                        echo '<td align="center"><strong>' . $regulated_application->tracking_status_name . '</strong></td>';
                                                    }
                                                } else {
                                                    if ($regulated_application->approve_status == 2) {
                                                        echo '<td align="center"><strong class="text-danger"><i class="fas fa-exclamation-circle mr-2"></i>DECLINED APPLICATION!</strong></td>';
                                                    } else if ($regulated_application->approve_status == 4) {
                                                        echo '<td align="center"><strong class="text-danger"><i class="fas fa-exclamation-circle mr-2"></i>NEW APPLICATION STARTED!</strong></td>';
                                                    } else if ($regulated_application->approve_status == 5) {
                                                        echo '<td align="center"><strong class="text-danger"><i class="fas fa-exclamation-circle mr-2"></i>APPLICATION CANCELLED!</strong></td>';
                                                    } else {
                                                        echo '<td align="center"><strong>' . $regulated_application->tracking_status_name . '</strong></td>';
                                                    }
                                                }
                                                break;
                                            case 4:
                                                echo '  <td align="center"><strong class="text-primary">' . $regulated_application->tracking_status_name . '</strong></td>';
                                                break;
                                            case 5:
                                                echo '  <td align="center"><strong class="text-danger">' . $regulated_application->tracking_status_name . '</strong></td>';
                                                break;
                                            case 7:
                                                if ($regulated_application->approve_status == 1) {
                                                    echo '  <td align="center"><strong class="text-success">' . $regulated_application->tracking_status_name . '</strong></td>';
                                                } else {
                                                    echo '  <td align="center"><strong class="text-warning">Pending for ' . $regulated_application->tracking_status_name . '</strong></td>';
                                                }
                                                break;
                                            default:
                                                echo '  <td align="center"><strong>' . $regulated_application->tracking_status_name . '</strong></td>';
                                        }

                                        echo '  <td align="center">' . date('F j, Y', strtotime($regulated_application->application_date)) . '</td>';
                                        echo '  <td align="center">' . (!empty($regulated_application->last_date_updated) ? date('F j, Y', strtotime($regulated_application->last_date_updated)) : 'N/A') . '</td>';

                                        if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_level') == 1 || $this->session->userdata('user_level') == 2) {
                                            echo ($regulated_application->assigned_admin_id == 0) ? '<td align="center"><input type="hidden" id="last_assign_admin_reg' . $regulated_application->regulated_application_id . '" value="0">' . $dropdown . '</td>' : '<td align="center"><input type="hidden" id="last_assign_admin_reg" value="' . $regulated_application->assigned_admin_id . '">' . $dropdown . '</td>';
                                        } else {
                                            if ($regulated_application->assigned_admin_id == 0) {
                                                echo  '<td align="center">Unassigned</td>';
                                            } else {
                                                echo '<td align="center">' . $regulated_application->assigned_admin_name . '</td>';
                                            }
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