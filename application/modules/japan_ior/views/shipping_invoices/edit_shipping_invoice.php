<?php

$user_id = $user_details->user_id;

$company_name = $user_details->company_name;
$company_address = $user_details->company_address;
$city = $user_details->city;
$country_id = $user_details->country;
$country = $user_details->country_name;
$zip_code = $user_details->zip_code;
$contact_number = $user_details->contact_number;
$business_license = $user_details->business_license;
$contact_person = $user_details->contact_person;
$email = $user_details->email;

$shipping_invoice_id = $shipping_invoice->shipping_invoice_id;
$invoice_date = $shipping_invoice->invoice_date;
$shipping_company = $shipping_invoice->shipping_invoice_company;
$shipping_tracking_no = $shipping_invoice->shipping_tracking_no;

$supplier_name = $shipping_invoice->supplier_name;
$supplier_address = $shipping_invoice->supplier_address;
$supplier_phone_no = $shipping_invoice->supplier_phone_no;

$same_address = $shipping_invoice->same_address;

$destination_recipient_name = $shipping_invoice->destination_recipient_name;
$destination_company_name = $shipping_invoice->destination_company_name;
$destination_address = $shipping_invoice->destination_address;
$destination_phone_no = $shipping_invoice->destination_phone_no;

$country_of_origin = $shipping_invoice->country_of_origin;

$total_unit_value = $shipping_invoice->total_unit_value;
$fba_fees = $shipping_invoice->fba_fees;
$total_value_of_shipment = $shipping_invoice->total_value_of_shipment;

$fosr = $shipping_invoice->fosr;
$simulator = $shipping_invoice->simulator;

$fba_location = $shipping_invoice->fba_location;
$product_sampling = $shipping_invoice->product_sampling;

$shipping_invoice_status = $shipping_invoice->status;
$shipping_session =  $shipping_invoice->shipping_code;

$prod_cat = $shipping_invoice->category_type;
$user_role_id = $user_details->user_role_id;
$shipping_company_link = $user_details->shipping_company_link;
foreach ($shipping_companies  as $data1) {
    if ($data1->id == $shipping_company) {
        $shipping_company_email =  $data1->email;
    } else {
        $shipping_company_email = "";
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dark-blue-title">Edit Shipping Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link">Shipping Invoice Requests</a></li>
                        <li class="breadcrumb-item active">Edit Shipping Invoice</li>
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

                    <?php if (isset($errors)) : ?>
                        <?php if ($errors == 1) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_msgs; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($errors == 2) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php var_dump($errors_msg); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if (!empty(validation_errors())) : ?>
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

                        <!-- <div class="<?php //echo ($shipping_invoice_status == 5 ? 'col-md-9 ' : '') 
                                            ?>col-12">
                            <h2 class="dark-blue-title text-left">Edit Your Shipping Invoice Here</h2>
                        </div> -->

                        <?php

                        if ($shipping_invoice_status == 5) {
                            echo '<div class="col-md-3 col-12">
                                <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#modal_revision_message"><i class="fas fa-exclamation-triangle mr-2"></i>View Needed Revisions</button>
                              </div>';
                        }

                        ?>

                    </div>

                    <br><br>

                    <form action="<?php echo base_url(); ?>japan_ior/process_shipping_invoice" method="POST" enctype="multipart/form-data" id="frm_update_shipping_invoice" onsubmit="$(this).find('select').prop('disabled', false)" role="form">
                        <input type="hidden"  name="shipping_session" id="shipping_session_v" value="<?php if(set_value('shipping_session')) { echo set_value('shipping_session');} else { echo $shipping_session; } ?>" >
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" id="shipping_invoice_id" name="shipping_invoice_id" value="<?php echo $shipping_invoice_id; ?>">
                        <input type="hidden" id="shipping_email_add" name="shipping_email_add" value="<?php echo $shipping_company_email; ?>">
                        <input type="hidden" id="company_name" name="company_name" value="<?php echo $company_name; ?>">
                        <?php if ($product_sampling == 1) { ?>
                            <input type="hidden" id="shipping_company_link" name="shipping_company_link" value="1">
                        <?php } else { ?>
                            <input type="hidden" id="shipping_company_link" name="shipping_company_link" value="<?php echo $shipping_company_link; ?>">
                        <?php } ?>

                        <div class="row">

                            <div class="col-12">

                                <h4>Your Business Information <small>(<a href="#" class="dark-blue-link" data-toggle="modal" data-target="#edit-business-details">edit</a>)</small></h4>

                                <br>

                                <div class="ml-4 business-details">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="user_company_name" class="col-form-label">
                                                        <strong><?php echo $company_name; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_company_name" name="user_company_name" value="<?php echo $company_name; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="user_company_address" class="col-form-label">
                                                        <strong><?php echo $company_address; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_company_address" name="user_company_address" value="<?php echo $company_address; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="user_city_country_zipcode" class="col-form-label">
                                                        <strong><?php echo $city . ', ' . $country . ', ' . $zip_code; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_city_country_zipcode" name="user_city_country_zipcode" value="<?php echo $city . ', ' . $country . ', ' . $zip_code; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="user_contact_no" class="col-form-label">
                                                        <strong><?php echo $contact_number; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_contact_no" name="user_contact_no" value="<?php echo $contact_number; ?>">
                                                </div>
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="user_business_license" class="col-form-label">
                                                        Business License #: <strong><?php echo $business_license; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_business_license" name="user_business_license" value="<?php echo $business_license; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="user_contact_person" class="col-form-label">
                                                        Contact Person: <strong><?php echo $contact_person; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_contact_person" name="user_contact_person" value="<?php echo $contact_person; ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="user_email" class="col-form-label">
                                                        Contact Email: <strong><?php echo $email; ?></strong>
                                                    </label>
                                                    <input type="hidden" id="user_email" name="user_email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <?php if ($shipping_company_link == 1) { ?>
                                                <div class="col-12">
                                                    <div class="row mb-1">
                                                        <label for="shipping_company" class="col-sm-6 col-form-label text-right">Shipping Company Name:</label>
                                                        <div class="col-sm-6">
                                                            <select class="select2 form-control" id="shipping_company" name="shipping_company" style="width: 100%;" readonly>
                                                                <option value="" selected>Select Shipping Company</option>
                                                                <?php
                                                                foreach ($shipping_companies as $row) {
                                                                    if ($shipping_company != $row->id) {
                                                                        echo '<option value="' . $row->id . '">' . $row->shipping_company_name . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $row->id . '" selected >' . $row->shipping_company_name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                            if ($shipping_company_link == 1) {
                                                            ?>
                                                                <script type="text/javascript">
                                                                    $('select#shipping_company').val('<?php echo $shipping_company; ?>');
                                                                    $("select#shipping_company").prop('disabled', true);
                                                                </script>
                                                                <?php
                                                            } else {
                                                                if ($this->input->post('shipping_company') != NULL) {
                                                                ?>
                                                                    <script type="text/javascript">
                                                                        $('select#shipping_company').val('<?php echo $this->input->post('shipping_company'); ?>');
                                                                    </script>
                                                                <?php } ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else if ($product_sampling == 1) { ?>
                                                <div class="col-12">
                                                    <div class="row mb-1">
                                                        <label for="shipping_company" class="col-sm-6 col-form-label text-right">Shipping Company Name:</label>
                                                        <div class="col-sm-6">
                                                            <select class="select2 form-control" id="shipping_company" name="shipping_company" style="width: 100%;" readonly>
                                                                <option value="" selected>Select Shipping Company</option>
                                                                <?php
                                                                foreach ($shipping_companies as $row) {
                                                                    if ($shipping_company != $row->id) {
                                                                        echo '<option value="' . $row->id . '">' . $row->shipping_company_name . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $row->id . '" selected >' . $row->shipping_company_name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                            if ($shipping_company_link == 1) {
                                                            ?>
                                                                <script type="text/javascript">
                                                                    $('select#shipping_company').val('<?php echo $shipping_company; ?>');
                                                                    $("select#shipping_company").prop('disabled', true);
                                                                </script>
                                                                <?php
                                                            } else {
                                                                if ($this->input->post('shipping_company') != NULL) {
                                                                ?>
                                                                    <script type="text/javascript">
                                                                        $('select#shipping_company').val('<?php echo $this->input->post('shipping_company'); ?>');
                                                                    </script>
                                                                <?php } ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>

                                <br>

                                <div id="shippingInvoiceContent" class="ml-4">

                                    <br><br>

                                    <div class="row">

                                        <div class="col-md-4 col-12">
                                            <h5>Supplier <small>(where goods are shipping from)</small></h5>

                                            <br>

                                            <div class="row mb-1">
                                                <label for="supplier_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Company Name" value="<?php echo $supplier_name; ?>" <?php echo ($same_address == 1) ? 'disabled' : '' ?>>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <label for="supplier_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" id="supplier_address" name="supplier_address" rows="3" placeholder="Address" maxlength="100" <?php echo ($same_address == 1) ? 'disabled' : '' ?>><?php echo $supplier_address; ?></textarea>
                                                    <div id="supplier_address_count" class="text-center"></div>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <label for="supplier_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="supplier_phone_no" name="supplier_phone_no" placeholder="Phone Number" value="<?php echo $supplier_phone_no; ?>" <?php echo ($same_address == 1) ? 'disabled' : '' ?>>
                                                </div>
                                            </div>

                                            <div class="row mt-3 mb-1">
                                                <div class="col-12 text-right">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="same_address" name="same_address" value="1" <?php echo ($same_address == 1) ? 'checked' : '' ?>>
                                                        <label class="custom-control-label" for="same_address" style="font-weight: normal;">Same address as the Company?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <h5>Destination</h5>
                                            <br>
                                            <?php if ($product_sampling == 1) { ?>
                                                <?php if ($prod_cat == 3 || $prod_cat == 4 || $prod_cat == 12 || $prod_cat == 13) { ?>
                                                    <div class="row mb-1">
                                                        <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo $destination_company_name; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                        <div class="col-sm-7">
                                                            <textarea class="form-control" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100" readonly><?php echo $destination_address; ?></textarea>
                                                            <div id="destination_address_count" class="text-center"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo $destination_phone_no; ?>" readonly>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row mb-1">
                                                        <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                        <div class="col-sm-7">
                                                            <?php if ($prod_cat == 1) { ?>
                                                                <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>" readonly>
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>" readonly>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo $destination_company_name; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                        <div class="col-sm-7">
                                                            <textarea class="form-control" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100" readonly><?php echo $destination_address; ?></textarea>
                                                            <div id="destination_address_count" class="text-center"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo $destination_phone_no; ?>" readonly>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            <?php } else { ?>
                                                <?php if ($prod_cat == 3 || $prod_cat == 4 || $prod_cat == 12 || $prod_cat == 13) { ?>
                                                    <div class="row mb-1">
                                                        <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo $destination_company_name; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                        <div class="col-sm-7">
                                                            <textarea class="form-control" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100" readonly><?php echo $destination_address; ?></textarea>
                                                            <div id="destination_address_count" class="text-center"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo $destination_phone_no; ?>" readonly>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row mb-1">
                                                        <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                        <div class="col-sm-7">
                                                            <?php if ($prod_cat == 1) { ?>
                                                                <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo $destination_recipient_name; ?>">
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo $destination_company_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                        <div class="col-sm-7">
                                                            <textarea class="form-control" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100"><?php echo $destination_address; ?></textarea>
                                                            <div id="destination_address_count" class="text-center"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-1">
                                                        <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo $destination_phone_no; ?>">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <h5>Importer of Record</h5>

                                            <br>

                                            <div class="row mb-1">
                                                <label for="ior_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                <div class="col-sm-7">
                                                    <label for="ior_company_name" class="col-form-label"><strong>COVUE JAPAN K.K</strong></label>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <label for="ior_japan_customs_no" class="col-sm-5 col-form-label text-right">Customs No:</label>
                                                <div class="col-sm-7">
                                                    <label for="ior_japan_customs_no" class="col-form-label"><strong>P002AK300000</strong></label>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <label for="ior_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                <div class="col-sm-7">
                                                    <label for="ior_address" class="col-form-label"><strong>3/F, 1-6-19 Azuchimachi Chou-ku, Osaka, Japan 541-0052 Japan</strong></label>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <label for="ior_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                <div class="col-sm-7">
                                                    <label for="ior_phone_no" class="col-form-label"><strong>+81 (50) 8881-2699</strong></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-8 col-12">
                                            <div class="row mb-1">
                                                <label for="country_of_origin" class="col-sm-5 col-form-label text-right">Country of Origin:</label>
                                                <div class="col-sm-7">
                                                    <select class="select2 form-control" id="country_of_origin" name="country_of_origin" style="width: 100%;">
                                                        <option value="" selected>- Select Country -</option>
                                                        <?php
                                                        foreach ($countries as $country) {

                                                            if ($country_of_origin != $country->id) {
                                                                echo '<option value="' . $country->id . '">' . $country->nicename . '</option>';
                                                            } else {
                                                                echo '<option value="' . $country->id . '" selected>' . $country->nicename . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="row mb-1">
                                                <label for="incoterms" class="col-sm-5 col-form-label text-right">Incoterms:</label>
                                                <div class="col-sm-7">
                                                    <label for="incoterms" class="col-form-label"><strong>DDP</strong></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br><br>

                                    <div class="row">

                                        <div class="col-12">
                                            <div class="card">
                                                <!-- /.card-header -->
                                                <div class="card-body table-responsive p-0">
                                                    <input id="user_role_id" type="hidden" name="" value="<?php echo $user_role_id ?>">
                                                    <table cellspacing="1" cellpadding="1" id="product_table_list" class="table table-hover text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Product Name</th>
                                                                <?php if ($user_details->user_role_id != 3) : ?>
                                                                    <th class="text-center">HS Code</th>
                                                                <?php else : ?>
                                                                    <th class="text-center">Product Type</th>
                                                                    <th class="text-center">HS Code</th>
                                                                <?php endif ?>
                                                                <?php if ($fba_location == '1') { ?>
                                                                    <th class="text-center">ASIN</th>
                                                                <?php } ?>
                                                                <th class="text-center">Quantity</th>
                                                                <?php if ($user_details->user_role_id != 3) : ?>

                                                                    <?php if ($product_sampling == 1) : ?>
                                                                        <th class="text-center">Unit Cost</th>
                                                                    <?php else : ?>
                                                                        <th class="text-center">Declared Online<br>Selling Price/Value (per unit)</th>
                                                                    <?php endif ?>

                                                                    <?php if ($fba_location == '1') { ?>
                                                                        <th class="text-center">Adjusted Online Declared<br>Selling Price/Value (per unit)</th>
                                                                        <th class="text-center">AMZ<br>Selling Fee (per unit)</th>
                                                                        <th class="text-center">AMZ<br>FBA Fee (per unit)</th>
                                                                    <?php } ?>

                                                                    <?php if ($product_sampling == 1) : ?>
                                                                        <th class="text-center">Total Unit Cost</th>
                                                                    <?php else : ?>
                                                                        <th class="text-center">Total Declared Online<br>Selling Pricing/Value</th>
                                                                    <?php endif ?>

                                                                    <?php if ($fba_location == '1') { ?>
                                                                        <th class="text-center">Total Adjusted Online<br>Declared Selling Price/Value (- Fee)</th>
                                                                    <?php } ?>
                                                                <?php else : ?>
                                                                    <th class="text-center">Unit Cost</th>
                                                                    <th class="text-center">Total Unit Cost</th>
                                                                <?php endif ?>
                                                                <th class="text-center">Add</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php

                                                            $product_tbl_count = 0;
                                                            $len = count($shipping_invoice_products);

                                                            foreach ($shipping_invoice_products as $shipping_invoice_product) {
                                                            ?>
                                                                <input type="hidden" id="shipping_invoice_product_<?php echo $product_tbl_count; ?>" name="shipping_invoice_product_id[]" value="<?php echo $shipping_invoice_product->shipping_invoice_product_id; ?>">
                                                                <input type="hidden" id="shipping_invoice_active_<?php echo $product_tbl_count; ?>" name="shipping_invoice_active[]" value="1">
                                                                <tr id="product_table_<?php echo $product_tbl_count; ?>">
                                                                    <input type="hidden" id="new_shipping_invoice_<?php echo $product_tbl_count; ?>" name="new_shipping_invoice[]" value="0">
                                                                    <input type="hidden" class="prod_selected" id="cur_sel_<?php echo $product_tbl_count; ?>" value="<?php echo $shipping_invoice_product->product_registration_id; ?>">
                                                                    <td>
                                                                        <?php if ($prod_cat == 2 || $prod_cat == 5 || $prod_cat == 6 || $prod_cat == 7 || $prod_cat == 10 ) { ?>
                                                                            <?php
                                                                            foreach ($prod_q as $row) {
                                                                                if ($shipping_invoice_product->product_registration_id != $row->id) {
                                                                                } else {
                                                                                    echo '<input type="hidden" class="form-control" value="' . $row->id . '" name="product[]" readonly>';
                                                                                    echo '<input type="text" class="form-control" value="' . $row->product_name . '" readonly>';
                                                                                    
                                                                                }
                                                                            }
                                                                            ?>
                                                                        <?php } else { ?>
                                                                            <input type="hidden" class="prod_selected" id="cur_sel_<?php echo $product_tbl_count; ?>" value="<?php echo $shipping_invoice_product->product_registration_id; ?>">
                                                                            <select class="form-control" id="product_<?php echo $product_tbl_count; ?>" name="product[]" onchange="displaySKU(<?php echo $product_tbl_count; ?>)">
                                                                                <option value="" selected>- Select Product -</option>
                                                                                <?php
                                                                                foreach ($prod_q as $row) {

                                                                                    if ($shipping_invoice_product->product_registration_id != $row->id) {
                                                                                        echo '<option value="' . $row->id . '">' . $row->product_name . '</option>';
                                                                                    } else {
                                                                                        echo '<option value="' . $row->id . '" selected>' . $row->product_name . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <?php if ($user_details->user_role_id == 3) : ?>
                                                                        <td><input type="text" class="text-center form-control" id="product_type_<?php echo $product_tbl_count; ?>" name="product_type[]" placeholder="Product Type" value="<?php echo ($shipping_invoice_product->product_type == 1) ? 'Commercial' : 'Non_Commercial'; ?>" readonly></td>
                                                                    <?php endif ?>
                                                                    <td><input type="text" class="text-center form-control" id="sku_<?php echo $product_tbl_count; ?>" name="sku[]" placeholder="HS Code" value="<?php echo $shipping_invoice_product->sku; ?>" readonly> <input type="hidden" class="text-center form-control" value="<?php echo $shipping_invoice_product->product_category_id; ?>" name="category_0" id="category_0"></td>
                                                                    <?php if ($fba_location == '1') { ?>
                                                                        <td><input type="text" class="text-center form-control" id="asin_<?php echo $product_tbl_count; ?>" name="asin[]" placeholder="ASIN" value="<?php echo $shipping_invoice_product->asin; ?>"></td>
                                                                    <?php } ?>
                                                                    <td><input type="text" class="text-center form-control" id="qty_<?php echo $product_tbl_count; ?>" name="qty[]" onkeyup="calcTotalAmount(<?php echo $product_tbl_count; ?>)" placeholder="1" value="<?php echo $shipping_invoice_product->quantity; ?>"></td>
                                                                    <td><input type="text" class="text-right form-control" id="price_<?php echo $product_tbl_count; ?>" name="price[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $product_tbl_count; ?>)" placeholder="0.00" value="<?php echo $shipping_invoice_product->online_selling_price; ?>"></td>
                                                                    <?php if ($fba_location == '1') { ?>
                                                                        <td><input type="text" class="text-right form-control" id="unit_value_<?php echo $product_tbl_count; ?>" name="unit_value[]" placeholder="0.00" value="<?php echo $shipping_invoice_product->unit_value; ?>" readonly></td>
                                                                        <td><input type="text" class="text-right form-control" id="fba_listing_fee_<?php echo $product_tbl_count; ?>" name="fba_listing_fee[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $product_tbl_count; ?>)" placeholder="0.00" value="<?php echo $shipping_invoice_product->fba_listing_fee; ?>"></td>
                                                                        <td><input type="text" class="text-right form-control" id="fba_shipping_fee_<?php echo $product_tbl_count; ?>" name="fba_shipping_fee[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $product_tbl_count; ?>)" placeholder="0.00" value="<?php echo $shipping_invoice_product->fba_shipping_fee; ?>"></td>
                                                                    <?php } ?>
                                                                    <td><input type="text" class="text-right form-control" id="total_amount_<?php echo $product_tbl_count; ?>" name="total_amount[]" placeholder="0.00" value="<?php echo number_format($shipping_invoice_product->total_amount, 2); ?>" readonly></td>
                                                                    <?php if ($fba_location == '1') { ?>
                                                                        <td><input type="text" class="text-right form-control" id="unit_value_total_amount_<?php echo $product_tbl_count; ?>" name="unit_value_total_amount[]" placeholder="0.00" value="<?php echo number_format($shipping_invoice_product->unit_value_total_amount, 2); ?>" readonly></td>
                                                                    <?php } ?>
                                                                    <td>
                                                                       <button type="button" onclick="addProductDetails(<?php echo $product_tbl_count;?>)" id="add_product_details_<?php echo $product_tbl_count; ?>" class="btn btn-outline-dark-blue " ><i class="fas fa-plus-circle"></i> Add</button>
                                                                    </td>       
                                                                    <?php
                                                                    if ($prod_cat == 5 || $prod_cat == 6 || $prod_cat == 7 || $prod_cat == 10  || $prod_cat == 2) {
                                                                    ?>
                                                                        <td><button type="button" id="remove_product_<?php echo $product_tbl_count; ?>" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(<?php echo $product_tbl_count; ?>)" disabled><i class="fas fa-times-circle"></i></button></td>
                                                                        <?php } else {
                                                                        if ($product_tbl_count == 0) {
                                                                        ?>
                                                                            <td><button type="button" id="remove_product_<?php echo $product_tbl_count; ?>" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(<?php echo $product_tbl_count; ?>)" disabled><i class="fas fa-times-circle"></i></button></td>
                                                                        <?php
                                                                        } else if ($product_tbl_count == $len - 1 && $product_tbl_count != 0) {
                                                                        ?>
                                                                            <td><button type="button" id="remove_product_<?php echo $product_tbl_count; ?>" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(<?php echo $product_tbl_count; ?>)"><i class="fas fa-times-circle"></i></button></td>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <td><button type="button" id="remove_product_<?php echo $product_tbl_count; ?>" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(<?php echo $product_tbl_count; ?>)" disabled><i class="fas fa-times-circle"></i></button></td>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </tr>
                                                            <?php
                                                                $product_tbl_count = $product_tbl_count + 1;
                                                            }
                                                            ?>

                                                            <input type="hidden" id="product_tbl_count" name="product_tbl_count" value="<?php echo $product_tbl_count; ?>">

                                                        </tbody>
                                                        <tfoot>
                                                            <td colspan="11"></td>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <?php if ($prod_cat == 5 || $prod_cat == 6 || $prod_cat == 7 || $prod_cat == 10  || $prod_cat == 2) {
                                            } else { ?>
                                                <?php if ($product_sampling == 1) { ?>
                                                    <button type="button" id="add_product_sampling_edit" data-fba="<?php echo $fba_location; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-plus-circle mr-2"></i>Add another item</button>
                                                <?php } else { ?>
                                                    <button type="button" id="add_product_edit" data-fba="<?php echo $fba_location; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-plus-circle mr-2"></i>Add another item</button>
                                            <?php }
                                            } ?>
                                        </div>
                                        <?php if ($fba_location == 2) { ?>
                                            <div class="col-md-4 text-right">
                                                <label>
                                                    <?php if ($user_details->user_role_id != 3) : ?>

                                                        <?php if ($product_sampling == 1) : ?>
                                                            <h4>Total Cost:</h4>
                                                        <?php else : ?>
                                                            <h4>Total Declared Online Selling Price:</h4>
                                                        <?php endif ?>

                                                    <?php else : ?>
                                                        <h4>Total Cost:</h4>
                                                    <?php endif ?>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="fba_fees" value="<?php echo '0.00'; ?>">
                                                <input type="hidden" name="total_unit_value" value="<?php echo  '0.00'; ?>">
                                                <input type="hidden" name="total_value_of_shipment" value="<?php echo (!empty($total_value_of_shipment) ? $total_value_of_shipment : '0.00'); ?>">
                                                <label>
                                                    <h4>&#165; <span id="total_value_of_shipment"><?php echo (!empty($total_value_of_shipment) ? number_format($total_value_of_shipment, 2) : '0.00'); ?></span></h4>
                                                </label>
                                            </div>
                                        <?php  } else { ?>
                                            <div class="col-md-4 text-right">
                                                <label>Total Declared Online Selling Price:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="total_value_of_shipment" value="<?php echo (!empty($total_value_of_shipment) ? $total_value_of_shipment : '0.00'); ?>">
                                                <label>&#165; <span id="total_value_of_shipment"><?php echo (!empty($total_value_of_shipment) ? number_format($total_value_of_shipment, 2) : '0.00'); ?></span></label>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <?php if ($fba_location == 1) { ?>
                                        <div class="row">
                                            <div class="col-md-3 offset-md-6 text-right">
                                                <label>AMZ Fees:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="fba_fees" value="<?php echo (!empty($fba_fees) ? $fba_fees : '0.00'); ?>">
                                                <label>&#165; <span id="fba_fees"><?php echo (!empty($fba_fees) ? number_format($fba_fees, 2) : '0.00'); ?></span></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 offset-md-5 text-right">
                                                <h4>Total Adjusted Selling Price: </h4>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="total_unit_value" value="<?php echo (!empty($total_unit_value) ? $total_unit_value : '0.00'); ?>">
                                                <h4>&#165; <span id="total_unit_value"><?php echo (!empty($total_unit_value) ? number_format($total_unit_value, 2) : '0.00'); ?></span></h4>
                                            </div>
                                        </div>
                                    <?php } ?>




                                </div>

                                <br>

                                <div class="ml-4">

                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">

                                                <?php if ($fba_location == 1) { ?>
                                                    <div id="fosr_label">
                                                        <?php if ($user_details->user_role_id != 3) : ?>
                                                            <?php if ($product_sampling == 1) : ?>
                                                                <label for="fosr">Unit Cost Declaration Report <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                            <?php else : ?>
                                                                <label for="fosr">FOSR Report <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <label for="fosr">Total Cost Declaration </label>
                                                        <?php endif ?>

                                                        <?php if (!empty($fosr)) {
                                                        ?>
                                                            <a href="<?php echo base_url() . 'uploads/shipping_invoice_pdf/' . $user_id . '/' . $fosr;
                                                                        ?>" target="_blank">(View File)</a>
                                                        <?php  }
                                                        ?>

                                                    </div>
                                                    <div class="input-group">
                                                        <input type="hidden" name="fosr_value" value="<?php echo $fosr; ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fosr" name="fosr" accept="application/pdf">
                                                            <label class="custom-file-label" for="fosr"><?php echo (!empty($fosr) ? $fosr : 'Click to upload'); ?></label>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div id="fosr_label">
                                                        <?php if ($user_details->user_role_id != 3) : ?>
                                                            <?php if ($product_sampling == 1) : ?>
                                                                <label for="fosr">Unit Cost Declaration Report <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                            <?php else : ?>
                                                                <label for="fosr"> Simulator Report</label>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <label for="fosr">Total Cost Declaration </label>
                                                        <?php endif ?>

                                                        <?php if (!empty($simulator)) {
                                                        ?>
                                                            <a href="<?php echo base_url() . 'uploads/shipping_invoice_pdf/' . $user_id . '/' . $simulator;
                                                                        ?>" target="_blank">(View File)</a>
                                                        <?php  }
                                                        ?>

                                                    </div>
                                                    <div class="input-group">
                                                        <input type="hidden" name="simulator_value" value="<?php echo $simulator; ?>">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="simulator" name="simulator" accept="application/pdf">
                                                            <label class="custom-file-label" for="simulator"><?php echo (!empty($simulator) ? $simulator : 'Click to upload'); ?></label>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div id="fosr_label">
                                                        <?php if ($user_details->user_role_id != 3) : ?>
                                                            <?php if ($product_sampling == 1) : ?>
                                                                <label for="fosr">Unit Cost Declaration Report <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                            <?php else : ?>
                                                                <label for="fosr">FOSR and Simulator Report <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                            <?php endif ?>
                                                        <?php else : ?>
                                                            <label for="fosr">Total Cost Declaration </label>
                                                        <?php endif ?>

                                                        <?php if (!empty($fosr)) {
                                                        ?>
                                                            <a href="<?php echo base_url() . 'uploads/shipping_invoice_pdf/' . $user_id . '/' . $fosr;
                                                                        ?>" target="_blank">(View File)</a>
                                                        <?php  }
                                                        ?>

                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="fosr" name="fosr" accept="application/pdf">
                                                            <label class="custom-file-label" for="fosr"><?php echo (!empty($fosr) ? $fosr : 'Click to upload'); ?></label>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <br>
                                                <small>Please upload FOSR and FBA Simulator here.<br>You may visit this <a href="<?php echo base_url(); ?>japan-ior/shipping-invoice-docs" target="_blank">link</a> to learn how to create your FOSR and FBA Simulator.</small>

                                                <input type="hidden" id="fosr_value" value="<?php echo $fosr; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="1">
                                                    <label class="custom-control-label" for="terms" style="font-weight: normal;">I accept the <a href="https://www.covue.com/ior-terms-and-condition/" target="_blank">Terms and Condition</a>.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="no_edit_terms" name="no_edit_terms" value="1">
                                                    <label class="custom-control-label" for="no_edit_terms" style="font-weight: normal;">By submitting your IOR Shipping Invoice Request, you are agreed that once it is approved, you cannot edit all the details. Please be reminded that you must have the approved shipping invoice before you ship your products. Failure to comply will be subjected to additional charges.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <br><br>

                                <div class="row">

                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <input type="hidden" name="fba_location" value="<?php echo $fba_location; ?>">
                                            <input type="hidden" name="product_sampling" value="<?php echo $product_sampling; ?>">

                                            <button type="submit" id="btn_generate_preview" class="btn btn-dark-yellow" name="preview"><i class="fas fa-file-pdf mr-2"></i>Preview</button>

                                            <button type="submit" id="btn_submit_for_approval" class="btn btn-dark-blue" name="submit"><i class="fas fa-check-circle mr-2"></i>Submit for Approval</button>

                                            <button type="submit" id="btn_save_draft" class="btn btn-outline-dark-blue" name="save"><i class="fas fa-save mr-2"></i>Save as Draft</button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="add-product-details">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Logistic Details</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                     <form method="POST" id="add_logistic_details" role="form">
                     <input type="hidden" class="form-control" id="shipping_session" name="shipping_session" value="<?php if(set_value('shipping_session')) { echo set_value('shipping_session');} else { echo $shipping_session; } ?>">
                     <input type="hidden" class="form-control" id="prod_log_id" name="prod_log_id">
                         <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_person">Work Orders</label>
                                    <select id="work_order" name="work_order" class="form-control" multiple="multiple">
                                        <option value="Kitting">Kitting</option>
                                        <option value="Product Labeling">Product Labeling</option>
                                    </select>
                                </div>
                            </div>
                          
                        </div>      
                        <hr></hr>    
                        <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_person">Batch Number</label>
                                <input type="text" class="form-control" id="batch_number" name="batch_number">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_person">FDA Licence No.</label>
                                <input type="text" class="form-control" id="fda_no" name="fda_no" >
                            </div>
                        </div>

                        </div>

                        <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="contact_person">Barcode </label>
                                <input type="text" class="form-control" id="barcode" name="barcode">
                            </div>
                        </div>

                        </div>

                        <hr></hr>
                         <div class="row">

                             <div class="col-md-6 col-12">
                                 <div class="form-group">
                                     <label for="contact_person">Pallets</label>
                                     <input type="text" class="form-control" id="pallets" name="pallets">
                                 </div>
                             </div>
                             <div class="col-md-6 col-12">
                                 <div class="form-group">
                                     <label for="contact_person">Cases</label>
                                     <input type="text" class="form-control" id="cases" name="cases" >
                                 </div>
                             </div>

                         </div>

                         <div class="row">

                             <div class="col-md-6 col-12">
                                 <div class="form-group">
                                     <label for="contact_number">Units</label>
                                     <input type="text" class="form-control" id="units" name="units" >
                                 </div>
                             </div>

                             <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">Pallet Length (CM) </label>
                                    <input type="text" class="form-control" id="pallet_length" name="pallet_length">
                                </div>
                            </div>

                         </div>

                         <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label for="contact_number">Pallet Width (CM) </label>
                                    <input type="text" class="form-control" id="pallet_width" name="pallet_width">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">Pallet Height (CM) </label>
                                    <input type="text" class="form-control" id="pallet_height" name="pallet_height">
                                </div>
                            </div>


                          </div>

                            <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">G.W (KG)</label>
                                    <input type="text" class="form-control" id="gw" name="gw">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">VOLUME (CBM)</label>
                                    <input type="text" class="form-control" id="volume" name="volume">
                                </div>
                            </div>


                            </div>

                            <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">Manufacture Date</label>
                                    <input type="date" class="form-control" id="md" name="md">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">Expiration Date</label>
                                    <input type="date" class="form-control" id="ed" name="ed">
                                </div>
                            </div>


                            </div>

                 </div>
                 <div class="modal-footer justify-content-end">
                     <div>
                         <div id="process_add_logistic" style="display:none;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span>Processing Data...</span></div>
                         <button type="submit" id="btn_add_logistic" class="btn btn-dark-blue">Add </button>
                         <button type="button" id="btn_close_logistic" class="btn btn-outline-dark-blue" data-dismiss="modal">Close</button>
                     </div>
                 </div>
                 </form>

             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     <!-- /.modal -->

    <div class="modal fade" id="edit-business-details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit your contact details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST" id="edit_profile" role="form">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="contact_person">Primary Contact Person*</label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo $contact_person; ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number*</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo $contact_number; ?>">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <div>
                        <button type="button" id="btn_quick_update" class="btn btn-dark-blue">Save changes</button>
                        <button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_revision_message">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revisions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo (!empty($revision_message->message) ? $revision_message->message : ''); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_invoice_created">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Congratulations!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Your shipping invoice has been successfully created.
                    <br><br>
                    <strong>Preview</strong> is now available.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_add_shipping_company">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Shipping Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST" id="frm_add_shipping_company" role="form">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="add_shipping_company">Shipping Company Name*</label>
                                    <input type="text" class="form-control" id="add_shipping_company" name="add_shipping_company" placeholder="Shipping Company Name">
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <div>
                        <button type="button" id="btn_add_shipping_company" class="btn btn-dark-blue">Add New</button>
                        <button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_submit_shipping">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Important Notice!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>By submitting your IOR Shipping Request:</p>
                    <p>You are agreed that once it is approved, you cannot edit all the details.</p>
                    <p>Please be reminded that you must have the approved shipping invoice before you ship your products.</p>
                    <p>Failure to comply will be subjected to additional charges.</p>
                    <br>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="chk_edit_shipping" name="chk_edit_shipping" value="1">
                        <label class="custom-control-label" for="chk_edit_shipping" style="font-weight: normal;">I fully read and understand</label>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" id="btn_submit_shipping" class="btn btn-dark-blue disabled">Proceed</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_select_shipping_company">
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
                                <p>You have selected <strong id="selected_shipping_company"></strong>, you must use this company for shipping.</p>
                                <p>Do not change your shipping company after completing this shipping invoice.</p>
                                <p>Do you want to proceed?</p>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <div>
                        <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Yes</button>
                        <a href="<?php echo base_url(); ?>japan_ior/shipping_invoices" role="button" class="btn btn-outline-dark-blue">No</a>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.content-wrapper -->