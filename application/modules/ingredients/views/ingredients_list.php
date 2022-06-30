<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ingredients List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/product-registrations">Home</a></li>
                        <li class="breadcrumb-item active">Ingredients List</li>
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

                            <table id="tblIngredients" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Standard</th>
                                        <th class="text-center">Component</th>
                                        <th class="text-center">Name of Additive</th>
                                        <th class="text-center">Display Name</th>
                                        <th class="text-center">Related Ingredients</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $last_standard = '';
                                    $last_component = '';

                                    foreach ($ingredients as $ingredient) {
                                        echo '<tr id="' . $ingredient->id . '">';

                                        if ($ingredient->standard == 0) {
                                            echo '  <td align="center">' . $last_standard . '</td>';
                                        } else {
                                            echo '  <td align="center">' . $ingredient->standard . '</td>';
                                        }

                                        if ($ingredient->component == 0) {
                                            echo '  <td align="center">' . $last_component . '</td>';
                                        } else {
                                            echo '  <td align="center">' . $ingredient->component . '</td>';
                                        }

                                        if (empty($ingredient->name_of_additive)) {
                                            echo '  <td align="center">' . $last_name_of_additive . '</td>';
                                        } else {
                                            echo '  <td align="center">' . $ingredient->name_of_additive . '</td>';
                                        }

                                        echo '  <td align="center">' . $ingredient->display_name . '</td>';

                                        if (empty($ingredient->related_ingredients)) {
                                            echo '  <td align="center">' . $last_related_ingredients . '</td>';
                                        } else {
                                            echo '  <td align="center">' . $ingredient->related_ingredients . '</td>';
                                        }

                                        echo '</tr>';

                                        $last_standard = $ingredient->standard;
                                        $last_component = $ingredient->component;
                                        $last_name_of_additive = $ingredient->name_of_additive;
                                        $last_related_ingredients = $ingredient->related_ingredients;
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

<div class="modal fade" id="modal_billing_complete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-success">complete</strong> status?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_complete"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_billing_paid">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-primary">paid</strong>?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_paid"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_billing_cancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Invoice:</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to set this to <strong class="text-danger">cancel</strong>?
            </div>
            <div class="modal-footer">
                <div id="btn_billing_cancel"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal_delete_user_subscriptions">
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