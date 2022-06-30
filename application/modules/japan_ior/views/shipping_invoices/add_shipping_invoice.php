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
    $shipping_company = $user_details->shipping_company;
    $shipping_company_link = $user_details->shipping_company_link;
    $user_role_id = $user_details->user_role_id;
    $fba =  $this->uri->segment(3);
    if ($fba == 'fba-invoice' || set_value('fba') == 1) {
        $fbas = 'fba-invoice';
    } else {
        $fbas = 'non-fba-invoice';
    }
    ?>
 <style>
     select#country_of_origin[readonly] {
         pointer-events: none;
     }


     /* irrelevent styling */

     * {
         box-sizing: border-box;
     }
 </style>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="dark-blue-title">Create Shipping Invoice</h1>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/dashboard" class="dark-blue-link">Japan IOR Dashboard</a></li>
                         <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="dark-blue-link">Shipping Invoice Requests</a></li>
                         <li class="breadcrumb-item active">Create Shipping Invoice</li>
                     </ol>
                 </div>
             </div>
         </div><!-- /.container-fluid -->
     </section>

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <div class="row">

                 <div class="col-12 mt-5">

                     <?php if (isset($errors)) : ?>
                         <?php if ($errors == 1) : ?>
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                 </i><?php echo $error_msgs; ?>
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

                     <!-- <div class="row justify-content-end">
                        <div class="col-12">
                            <h4 class="dark-blue-title text-center">Create Your Shipping Invoice Here</h4>
                        </div>
                    </div>

                    <br><br> -->
                     <form action="<?php echo base_url(); ?>japan-ior/create-shipping-invoice" method="POST" enctype="multipart/form-data" id="frm_create_shipping_invoice" onsubmit="$(this).find('select').prop('disabled', false)" role="form">

                         <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                         <input type="hidden" id="company_name" name="company_name" value="<?php echo $company_name; ?>">
                         <input type="hidden" id="shipping_company_link" name="shipping_company_link" value="<?php echo $shipping_company_link; ?>">

                         <div class="row">

                             <div class="col-12">

                                 <h4>Your Business Information <small>(<a href="#" class="dark-blue-link" data-toggle="modal" data-target="#edit-business-details">edit</a>)</small></h4>

                                 <br>

                                 <div class="ml-4 business-details">

                                     <div class="row">


                                         <div class="col-md-6">

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <label for="user_company_name" class="col-form-label"><strong><?php echo $company_name; ?></strong></label>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <label for="user_company_address" class="col-form-label"><strong><?php echo $company_address; ?></strong></label>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <label for="user_city_country_zipcode" class="col-form-label"><strong><?php echo $city . ', ' . $country . ', ' . $zip_code; ?></strong></label>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <label for="user_contact_no" class="col-form-label"><strong><?php echo $contact_number; ?></strong></label>
                                                 </div>
                                             </div>

                                             <br>

                                             <div class="row">
                                                 <div class="col-12">
                                                     <label for="user_business_license" class="col-form-label">Business License #: <strong><?php echo $business_license; ?></strong></label>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-12">
                                                     <label for="user_contact_person" class="col-form-label">Contact Person: <strong><?php echo $contact_person; ?></strong></label>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-12">
                                                     <label for="user_email" class="col-form-label">Contact Email: <strong><?php echo $email; ?></strong></label>
                                                 </div>
                                             </div>

                                         </div>

                                         <div class="col-md-6">
                                            <input type="hidden"  name="shipping_session" id="shipping_session_v" value="<?php if(set_value('shipping_session')) { echo set_value('shipping_session');} else { echo $shipping_session; } ?>" >
                                            <div class="col-12">
                                            <div class="row mb-1">
                                                <div class="col-sm-6 text-right">
                                                <div class="custom-control custom-checkbox">
                                                     <input type="checkbox" class="custom-control-input" id="logistic_form" name="logistic_form" value="1" <?php echo set_checkbox('logistic_form', '1', FALSE); ?>>
                                                     <label class="custom-control-label" for="logistic_form" style="font-weight: normal;">Import Logistics?  <div id="edit_logistic_form" style="display:none;">(<a href="#" class="dark-blue-link" id="logistic_form_v">edit</a>)</div></label>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
										 
                                             <?php if ($shipping_company_link == 1) { ?>
                                                 <div class="col-12">
                                                     <div class="row mb-1">
                                                         <label for="shipping_company" class="col-sm-6 col-form-label text-right">Shipping Company Name:</label>
                                                         <div class="col-sm-6">
                                                             <select class="select2 form-control <?php if (form_error('shipping_company')) {
                                                                                                        echo 'is_invalid';
                                                                                                    } ?>" id="shipping_company" name="shipping_company" style="width: 100%;">
                                                                 <option value="">Select Shipping Company</option>
                                                                 <?php
                                                                    foreach ($shipping_companies as $row) {
                                                                        echo '<option value="' . $row->id . '">' . $row->shipping_company_name . '</option>';
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
                                                             <?php
                                                                    }
                                                                }
                                                                ?>

                                                         </div>
                                                     </div>
                                                 </div>
                                             <?php } ?>

                                         </div>

                                     </div>

                                     <br>

                                 </div>

                                 <div id="shippingInvoiceContent" class="ml-4">

                                     <br><br>

                                     <div class="row">

                                         <div class="col-md-4 col-12">
                                             <h5>Supplier <small>(where goods are shipping from)</small></h5>

                                             <br>

                                             <div class="row mb-1">
                                                 <label for="supplier_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                 <div class="col-sm-7">
                                                     <input type="text" class="form-control <?php if (form_error('supplier_name')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="supplier_name" name="supplier_name" placeholder="Company Name" value="<?php echo set_value('supplier_name'); ?>" <?php echo $this->input->post('same_address') == 1 ? 'disabled' : '' ?>>
                                                 </div>
                                             </div>

                                             <div class="row mb-1">
                                                 <label for="supplier_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                 <div class="col-sm-7">
                                                     <textarea class="form-control <?php if (form_error('supplier_address')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>" id="supplier_address" name="supplier_address" rows="3" placeholder="Address" maxlength="100" <?php echo $this->input->post('same_address') == 1 ? 'disabled' : '' ?>><?php echo set_value('supplier_address'); ?></textarea>
                                                     <div id="supplier_address_count" class="text-center"></div>
                                                 </div>
                                             </div>

                                             <div class="row mb-1">
                                                 <label for="supplier_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                 <div class="col-sm-7">
                                                     <input type="text" class="form-control <?php if (form_error('supplier_phone_no')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="supplier_phone_no" name="supplier_phone_no" placeholder="Phone Number" value="<?php echo set_value('supplier_phone_no'); ?>" <?php echo $this->input->post('same_address') == 1 ? 'disabled' : '' ?>>
                                                 </div>
                                             </div>

                                             <div class="row mt-3 mb-1">
                                                 <div class="col-12 text-right">
                                                     <div class="custom-control custom-checkbox">
                                                         <input type="checkbox" class="custom-control-input" id="same_address" name="same_address" value="1" <?php echo set_checkbox('same_address', '1', FALSE); ?>>
                                                         <label class="custom-control-label" for="same_address" style="font-weight: normal;">Same address as the Company?</label>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-md-4 col-12">
                                             <h5>Destination</h5>

                                             <br>

                                             <input type="hidden" id="destination_recipient_name_v" name="destination_recipient_name_v" value="<?php echo set_value('destination_recipient_name_v'); ?>">
                                             <input type="hidden" id="destination_company_name_v" name="destination_company_name_v" value="<?php echo set_value('destination_company_name_v'); ?>">
                                             <input type="hidden" id="destination_address_v" name="destination_address_v" value="<?php echo set_value('destination_address_v'); ?>">
                                             <input type="hidden" id="destination_phone_no_v" name="destination_phone_no_v" value="<?php echo set_value('destination_phone_no_v'); ?>">
                                             <input type="hidden" id="country_of_origin_v" name="country_of_origin_v" value="<?php echo set_value('country_of_origin'); ?>">

                                             <?php if (set_value('category_0') == 4 || set_value('category_0') == 3 || set_value('category_0') == 12 || set_value('category_0') == 13 ) { ?>
                                                 <div class="row mb-1">
                                                     <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_recipient_name')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo set_value('destination_recipient_name'); ?>" readonly>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_company_name')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo set_value('destination_company_name'); ?>" readonly>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                     <div class="col-sm-7">
                                                         <textarea class="form-control <?php if (form_error('destination_address')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100" readonly><?php echo set_value('destination_address'); ?></textarea>
                                                         <div id="destination_address_count" class="text-center"></div>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_phone_no')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo set_value('destination_phone_no'); ?>" readonly>
                                                     </div>
                                                 </div>
                                             <?php } else { ?>
                                                 <div class="row mb-1">
                                                     <label for="destination_recipient_name" class="col-sm-5 col-form-label text-right">Recipient Name:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_recipient_name')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_recipient_name" name="destination_recipient_name" placeholder="Recipient Name" value="<?php echo set_value('destination_recipient_name'); ?>">
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_company_name" class="col-sm-5 col-form-label text-right">Company Name:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_company_name')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_company_name" name="destination_company_name" placeholder="Company Name" value="<?php echo set_value('destination_company_name'); ?>">
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_address" class="col-sm-5 col-form-label text-right">Address:</label>
                                                     <div class="col-sm-7">
                                                         <textarea class="form-control <?php if (form_error('destination_address')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="destination_address" name="destination_address" rows="3" placeholder="Address" maxlength="100"><?php echo set_value('destination_address'); ?></textarea>
                                                         <div id="destination_address_count" class="text-center"></div>
                                                     </div>
                                                 </div>

                                                 <div class="row mb-1">
                                                     <label for="destination_phone_no" class="col-sm-5 col-form-label text-right">Phone No:</label>
                                                     <div class="col-sm-7">
                                                         <input type="text" class="form-control <?php if (form_error('destination_phone_no')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="destination_phone_no" name="destination_phone_no" placeholder="Phone Number" value="<?php echo set_value('destination_phone_no'); ?>">
                                                     </div>
                                                 </div>
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
                                        <!--- UPDATE CHANGE FOR COUNTRY ORIGIN -->                                                                
                                         <div class="col-md-8 col-12">
                                             <div class="row mb-1">
                                                 <label for="country_of_origin" class="col-sm-5 col-form-label text-right">Country of Origin:</label>
                                                 <div class="col-sm-7">
                                                         <select class="select2 form-control <?php if (form_error('country_of_origin')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="country_of_origin" name="country_of_origin" style="width: 100%;">
                                                             <option value="" selected>Select Country</option>
                                                             <?php
                                                                foreach ($countries as $row) {
                                                                    echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                                                                }
                                                                ?>
                                                         </select>

                                                     <script type="text/javascript">
                                                         $('select#country_of_origin').val('<?php echo $this->input->post('country_of_origin'); ?>');
                                                     </script>
                                                 </div>
                                             </div>
                                         </div>
                                        <!-- END UPDATE CHANGE FOR COUNTRY ORIGIN -->
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
                                                                 <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                     <th class="text-center">ASIN</th>
                                                                 <?php } ?>
                                                                 <th class="text-center">Quantity</th>
                                                                 <?php if ($user_details->user_role_id != 3) : ?>
                                                                     <th class="text-center">Declared Online<br>Selling Price/Value (per unit)</th>
                                                                     <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                         <th class="text-center"> Adjusted Online Declared<br>Selling Price/Value (per unit)</th>
                                                                         <th class="text-center"> AMZ<br>Selling Fee (per unit)</th>
                                                                         <th class="text-center"> AMZ<br>FBA Fee (per unit)</th>
                                                                     <?php } ?>
                                                                     <th class="text-center">Total Declared Online<br>Selling Pricing/Value</th>
                                                                 <?php else : ?>
                                                                     <th class="text-center">Unit Cost</th>
                                                                     <th class="text-center">Total Unit Cost</th>
                                                                 <?php endif ?>

                                                                 <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                     <th class="text-center">Total Adjusted Online<br>Declared Selling Price/Value (- Fee)</th>
                                                                 <?php } ?>
                                                                 <th class="text-center">Add</th>
                                                                 <th class="text-center">Action</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>

                                                             <?php
                                                                if (empty($this->input->post('product[]'))) {
                                                                ?>
                                                                 <tr id="product_table_0">
                                                                     <td class="text-center">
                                                                         <input type="hidden" class="prod_selected" id="cur_sel_0">
                                                                         <select class="sel_prod form-control text-center <?php echo (form_error('product[]') ? 'is_invalid' : ''); ?>" id="product_0" name="product[]">
                                                                             <option value="" selected>- Select Product -</option>
                                                                             <?php foreach ($prod_q as $row) {
                                                                                    echo '<option class="opt_sel_' . $row->id . '" value="' . $row->id . '">' . $row->product_name . '</option>';
                                                                                } ?>
                                                                         </select>
                                                                     </td>
                                                                     <?php if ($user_details->user_role_id == 3) : ?>
                                                                         <td><input type="text" class="text-center form-control" id="product_type_0" name="product_type[]" placeholder="Product Type" readonly></td>
                                                                     <?php endif ?>

                                                                     <td><input type="text" class="text-center form-control" id="sku_0" name="sku[]" placeholder="<?php echo ($user_details->user_role_id != 3) ? 'HS Code' : 'HS Code' ?>" readonly><input type="hidden" class="text-center form-control" name="category_name" id="category_name"><input type="hidden" class="text-center form-control" name="category_0" id="category_0"></td>
                                                                     <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                         <td><input type="text" class="text-center form-control" id="asin_0" name="asin[]" placeholder="ASIN"></td>
                                                                     <?php } ?>
                                                                     <td><input type="text" class="text-center form-control" id="qty_0" name="qty[]" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(0)"></td>
                                                                     <td><input type="text" class="text-right form-control" id="price_0" name="price[]" value="0.00" onkeypress="return validateDec(event)" placeholder="0.00" onkeyup="calcTotalAmount(0)"></td>
                                                                     <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                         <td><input type="text" class="text-right form-control" id="unit_value_0" name="unit_value[]" value="0.00" onkeypress="return validateDec(event)" placeholder="0.00" readonly></td>
                                                                         <td><input type="text" class="text-right form-control" id="fba_listing_fee_0" name="fba_listing_fee[]" value="0.00" onkeypress="return validateDec(event)" placeholder="0.00" onkeyup="calcTotalAmount(0)"></td>
                                                                         <td><input type="text" class="text-right form-control" id="fba_shipping_fee_0" name="fba_shipping_fee[]" value="0.00" onkeypress="return validateDec(event)" placeholder="0.00" onkeyup="calcTotalAmount(0)"></td>
                                                                     <?php } ?>
                                                                     <td><input type="text" class="text-right form-control" id="total_amount_0" name="total_amount[]" placeholder="0.00" value="0.00" readonly></td>
                                                                     <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                         <td><input type="text" class="text-right form-control" id="unit_value_total_amount_0" name="unit_value_total_amount[]" placeholder="0.00" value="0.00" readonly></td>
                                                                     <?php } ?>
                                                                     <td>
                                                                         <button type="button" onclick="addProductDetails(0)" id="add_product_details_0" class="btn btn-outline-dark-blue " disabled><i class="fas fa-plus-circle"></i> Add</button>
                                                                     </td>
                                                                     <td>
                                                                         <button type="button" id="remove_product_0" class="btn btn-block btn-outline-danger" onclick="removeRow(0)" disabled><i class="fas fa-times-circle"></i></button>
                                                                     </td>
                                                                 
                                                                    </tr>

                                                                 <?php
                                                                } else {
                                                                    $products_count = count($this->input->post('product[]'));
                                                                    $x = $products_count - 1;

                                                                    for ($i = 0; $i < $products_count; $i++) {
                                                                    ?>
                                                                     <tr id="product_table_<?php echo $i; ?>">
                                                                         <td>
                                                                             <?php if (set_value('category_0') == 2 || set_value('category_0') == 5 || set_value('category_0') == 6 || set_value('category_0') == 7 || set_value('category_0') == 10) { ?>
                                                                                 <?php
                                                                                    if ($i == 0) {
                                                                                    ?>
                                                                                     <input type="hidden" class="prod_selected" id="cur_sel_<?php echo $i; ?>" value="<?php echo $this->input->post('product[' . $i . ']'); ?>">
                                                                                     <select class="form-control text-center <?php echo (form_error('product[]') ? 'is_invalid' : ''); ?>" id="product_<?php echo $i; ?>" name="product[]" onchange="displaySKU(<?php echo $i; ?>)">
                                                                                         <option value="" selected>- Select Product -</option>
                                                                                         <?php foreach ($prod_q as $row) {
                                                                                                echo '<option value="' . $row->id . '">' . $row->product_name . '</option>';
                                                                                            } ?>
                                                                                     </select>
                                                                                     <script type="text/javascript">
                                                                                         $('select#product_<?php echo $i; ?>').val('<?php echo $this->input->post('product[' . $i . ']'); ?>');
                                                                                     </script>
                                                                                 <?php } else {
                                                                                        foreach ($prod_q as $row) {

                                                                                            if ($this->input->post('product[' . $i . ']') != $row->id) {
                                                                                            } else {
                                                                                                echo '<input type="hidden" class="form-control" value="' . $this->input->post('product[' . $i . ']') . '" name="product[]" readonly>';
                                                                                                echo '<input type="text" class="form-control" value="' . $row->product_name . '" readonly style="width:100%">';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                             <?php } else { ?>
                                                                                 <input type="hidden" class="prod_selected" id="cur_sel_<?php echo $i; ?>" value="<?php echo $this->input->post('product[' . $i . ']'); ?>">
                                                                                 <select class="form-control text-center <?php echo (form_error('product[]') ? 'is_invalid' : ''); ?>" id="product_<?php echo $i; ?>" name="product[]" onchange="displaySKU(<?php echo $i; ?>)">
                                                                                     <option value="" selected>- Select Product -</option>
                                                                                     <?php foreach ($prod_q as $row) {
                                                                                            echo '<option value="' . $row->id . '">' . $row->product_name . '</option>';
                                                                                        } ?>
                                                                                 </select>
                                                                                 <script type="text/javascript">
                                                                                     $('select#product_<?php echo $i; ?>').val('<?php echo $this->input->post('product[' . $i . ']'); ?>');
                                                                                 </script>
                                                                             <?php } ?>
                                                                         </td>
                                                                         <?php if ($user_details->user_role_id == 3) : ?>
                                                                             <td><input type="text" class="text-center form-control" id="product_type_<?php echo $i; ?>" name="product_type[]" placeholder="Product Type" value="<?php echo set_value('product_type[' . $i . ']'); ?>" readonly></td>
                                                                         <?php endif ?>
                                                                         <td><input type="text" class="text-center form-control" id="sku_<?php echo $i; ?>" name="sku[]" placeholder="HS Code" value="<?php echo set_value('sku[' . $i . ']'); ?>" readonly><input type="hidden" class="text-center form-control" value="<?php echo set_value('category_name'); ?>" name="category_name" id="category_name"><input type="hidden" class="text-center form-control" value="<?php echo set_value('category_0'); ?>" name="category_0" id="category_0"></td>
                                                                         <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                             <td><input type="text" class="text-center form-control" id="asin_<?php echo $i; ?>" name="asin[]" placeholder="ASIN" value="<?php echo set_value('asin[' . $i . ']'); ?>"></td>
                                                                         <?php } ?>
                                                                         <td><input type="text" class="text-center form-control" id="qty_<?php echo $i; ?>" name="qty[]" placeholder="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(<?php echo $i; ?>)" value="<?php echo set_value('qty[' . $i . ']'); ?>"></td>
                                                                         <td><input type="text" class="text-right form-control" id="price_<?php echo $i; ?>" name="price[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $i; ?>)" placeholder="0.00" value="<?php echo set_value('price[' . $i . ']'); ?>"></td>
                                                                         <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                             <td><input type="text" class="text-right form-control" id="unit_value_<?php echo $i; ?>" name="unit_value[]" onkeypress="return validateDec(event)" placeholder="0.00" value="<?php echo set_value('unit_value[' . $i . ']'); ?>" readonly></td>
                                                                             <td><input type="text" class="text-right form-control" id="fba_listing_fee_<?php echo $i; ?>" name="fba_listing_fee[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $i; ?>)" placeholder="0.00" value="<?php echo set_value('fba_listing_fee[' . $i . ']'); ?>"></td>
                                                                             <td><input type="text" class="text-right form-control" id="fba_shipping_fee_<?php echo $i; ?>" name="fba_shipping_fee[]" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(<?php echo $i; ?>)" placeholder="0.00" value="<?php echo set_value('fba_shipping_fee[' . $i . ']'); ?>"></td>
                                                                         <?php } ?>
                                                                         <td><input type="text" class="text-right form-control" id="total_amount_<?php echo $i; ?>" name="total_amount[]" placeholder="0.00" value="<?php echo set_value('total_amount[' . $i . ']'); ?>" readonly></td>
                                                                         <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                                                             <td><input type="text" class="text-right form-control" id="unit_value_total_amount_<?php echo $i; ?>" name="unit_value_total_amount[]" placeholder="0.00" value="<?php echo set_value('unit_value_total_amount[' . $i . ']'); ?>" readonly></td>
                                                                         <?php } ?>
                                                                         <td>
                                                                            <button type="button" onclick="addProductDetails(<?php echo $i; ?>)" id="add_product_details_<?php echo $i; ?>" class="btn btn-outline-dark-blue " ><i class="fas fa-plus-circle"></i> Add</button>
                                                                         </td>
                                                                         <td>
                                                                         <?php if (set_value('category_0') == 2 || set_value('category_0') == 5 || set_value('category_0') == 6 || set_value('category_0') == 7 || set_value('category_0') == 10) { ?>
                                                                            <button type="button" id="remove_product_<?php echo $i; ?>" class="btn btn-block btn-outline-danger" onclick="removeRow(<?php echo $i; ?>)" <?php echo ($x != $i) ? 'disabled' : ''; ?> disabled><i class="fas fa-times-circle"></i></button>
                                                                        <?php } else { ?>
                                                                            <button type="button" id="remove_product_<?php echo $i; ?>" class="btn btn-block btn-outline-danger" onclick="removeRow(<?php echo $i; ?>)" <?php echo ($x != $i) ? 'disabled' : ''; ?>><i class="fas fa-times-circle"></i></button>
                                                                        <?php } ?>
                                                                        </td>
                                                                     </tr>
                                                             <?php
                                                                    }
                                                                }
                                                                ?>

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
                                             <?php if (set_value('category_0') == 2 || set_value('category_0') == 5 || set_value('category_0') == 6 || set_value('category_0') == 7 || set_value('category_0') == 10) { ?>
                                                 <button type="button" id="add_product" data-fba="<?php echo $fbas; ?>" class="btn btn-outline-dark-blue" style="display:none;"><i class="fas fa-plus-circle mr-2"></i>Add another item</button>
                                             <?php } else { ?>
                                                 <button type="button" id="add_product" data-fba="<?php echo $fbas; ?>" class="btn btn-outline-dark-blue"><i class="fas fa-plus-circle mr-2"></i>Add another item</button>
                                             <?php } ?>
                                         </div>
                                         <?php if ($fba == 'non-fba-invoice' || set_value('fba') == 2) { ?>
                                             <div class="col-md-4 text-right">
                                                 <label>

                                                     <?php if ($user_details->user_role_id != 3) : ?>
                                                         <h4>Total Declared Online Selling Price:</h4>
                                                     <?php else : ?>
                                                         <h4>Total Cost:</h4>
                                                     <?php endif ?>
                                                 </label>
                                             </div>
                                             <div class="col-md-3">

                                                 <?php
                                                    if (empty($this->input->post('product[]'))) {
                                                    ?>
                                                     <input type="hidden" name="total_value_of_shipment" value="0.00">
                                                     <h4><label>&#165; <span id="total_value_of_shipment">0.00</span></label></h4>

                                                 <?php
                                                    } else {
                                                    ?>
                                                     <input type="hidden" name="total_value_of_shipment" value="<?php echo set_value('total_value_of_shipment'); ?>">
                                                     <label>
                                                         <h4>&#165; <span id="total_value_of_shipment"><?php echo number_format(set_value('total_value_of_shipment'), 2); ?></span></h4>
                                                     </label>
                                                 <?php
                                                    }
                                                    ?>

                                             </div>
                                         <?php } else { ?>
                                             <div class="col-md-4 text-right">
                                                 <label>Total Declared Online Selling Price:</label>
                                             </div>
                                             <div class="col-md-3">

                                                 <?php
                                                    if (empty($this->input->post('product[]'))) {
                                                    ?>
                                                     <input type="hidden" name="total_value_of_shipment" value="0.00">
                                                     <label>&#165; <span id="total_value_of_shipment">0.00</span></label>

                                                 <?php
                                                    } else {
                                                    ?>
                                                     <input type="hidden" name="total_value_of_shipment" value="<?php echo set_value('total_value_of_shipment'); ?>">
                                                     <label>&#165; <span id="total_value_of_shipment"><?php echo number_format(set_value('total_value_of_shipment'), 2); ?></span></label>
                                                 <?php
                                                    }
                                                    ?>

                                             </div>
                                         <?php } ?>
                                     </div>
                                     <?php if ($fba == 'fba-invoice' || set_value('fba') == 1) { ?>
                                         <div class="row">
                                             <div class="col-md-3 offset-md-6 text-right">
                                                 <label>AMZ Fees:</label>
                                             </div>
                                             <div class="col-md-3">

                                                 <?php
                                                    if (empty($this->input->post('product[]'))) {
                                                    ?>
                                                     <input type="hidden" name="fba_fees" value="0.00">
                                                     <label>&#165; <span id="fba_fees">0.00</span></label>

                                                 <?php
                                                    } else {
                                                    ?>
                                                     <input type="hidden" name="fba_fees" value="<?php echo set_value('fba_fees'); ?>">
                                                     <label>&#165; <span id="fba_fees"><?php echo number_format(set_value('fba_fees'), 2); ?></span></label>
                                                 <?php
                                                    }
                                                    ?>

                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-md-4 offset-md-5 text-right">
                                                 <h4>Total Adjusted Selling Price: </h4>
                                             </div>
                                             <div class="col-md-3">

                                                 <?php
                                                    if (empty($this->input->post('product[]'))) {
                                                    ?>
                                                     <input type="hidden" name="total_unit_value" value="0.00">
                                                     <h4>&#165; <span id="total_unit_value">0.00</span></h4>

                                                 <?php
                                                    } else {
                                                    ?>
                                                     <input type="hidden" name="total_unit_value" value="<?php echo set_value('total_unit_value'); ?>">
                                                     <h4>&#165; <span id="total_unit_value"><?php echo number_format(set_value('total_unit_value'), 2); ?></span></h4>
                                                 <?php
                                                    }
                                                    ?>

                                             </div>
                                         </div>
                                     <?php } ?>
                                 </div>

                                 <br>

                                 <div class="ml-4">

                                     <div class="row">

                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <?php if ($fba == 'fba-invoice' ||  set_value('fba') == 1) { ?>
                                                     <div id="fosr_label" style="display: block;">
                                                         <?php if ($user_details->user_role_id != 3) : ?>
                                                             <label for="fosr">FOSR <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                         <?php else : ?>
                                                             <label for="fosr">Total Cost Declaration </label>
                                                         <?php endif ?>

                                                     </div>
                                                     <div class="input-group">
                                                         <div class="custom-file <?php if (form_error('fosr')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>" style="border-radius: .25rem;">
                                                             <input type="file" class="custom-file-input" id="fosr" name="fosr" accept="application/pdf">
                                                             <label class="custom-file-label" for="fosr">Click to upload</label>
                                                         </div>
                                                     </div>
                                                     <br>
                                                     <div id="fosr_label" style="display: block;">
                                                         <?php if ($user_details->user_role_id != 3) : ?>
                                                             <label for="fosr">Simulator Report </label>
                                                         <?php else : ?>
                                                             <label for="fosr">Total Cost Declaration </label>
                                                         <?php endif ?>

                                                     </div>
                                                     <div class="input-group">
                                                         <div class="custom-file <?php if (form_error('simulator')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>" style="border-radius: .25rem;">
                                                             <input type="file" class="custom-file-input" id="simulator" name="simulator" accept="application/pdf">
                                                             <label class="custom-file-label" for="simulator">Click to upload</label>
                                                         </div>
                                                     </div>
                                                     <br>
                                                 <?php } else { ?>
                                                     <div id="fosr_label" style="display: block;">
                                                         <?php if ($user_details->user_role_id != 3) : ?>
                                                             <label for="fosr">FOSR <i class="fas fa-info-circle" data-toggle="tooltip" title="A Foreign Online Seller Account Report is a combination of profile page showing your legal company name and address and product page showing your online price. If your products are currently out of stock, please provide the inventory page." style="cursor: pointer;"></i></label>
                                                         <?php else : ?>
                                                             <label for="fosr">Total Cost Declaration </label>
                                                         <?php endif ?>

                                                     </div>
                                                     <div class="input-group">
                                                         <div class="custom-file <?php if (form_error('fosr')) {
                                                                                        echo 'is_invalid';
                                                                                    } ?>" style="border-radius: .25rem;">
                                                             <input type="file" class="custom-file-input" id="fosr" name="fosr" accept="application/pdf">
                                                             <label class="custom-file-label" for="fosr">Click to upload</label>
                                                         </div>
                                                     </div>
                                                     <br>
                                                 <?php } ?>
                                                 <?php if ($fba == 'fba-invoice' ||  set_value('fba') == 1) { ?>
                                                     <small>Please upload your FOSR (Foreign Online Seller Report) and FBA Simulator here. View this <a href="<?php echo base_url(); ?>japan-ior/shipping-invoice-docs" target="_blank">file</a> to know how to provide those documents.</small>
                                                 <?php } else { ?>
                                                     <small>Please upload your shipping invoice supporting documents here. View this <a href="<?php echo base_url(); ?>japan-ior/shipping-invoice-docs" target="_blank">file</a> to know how to provide those documents.</small>
                                                 <?php } ?>
                                             </div>
                                         </div>

                                     </div>

                                     <br>

                                 </div>

                             </div>

                         </div>

                         <div class="row">
                             <div class="col-12 d-flex justify-content-end">
                                 <div class="form-group">
                                     <input type="hidden" class="text-center form-control" name="product_category" value="<?php echo set_value('product_category'); ?>" id="product_category">
                                     <input type="hidden" class="text-center form-control" name="category_type" value="<?php echo set_value('category_type'); ?>" id="category_type">
                                     <input type="hidden" class="text-center form-control" name="product_sampling" id="product_sampling" value="<?php if (set_value('product_sampling') != null) {
                                                                                                                                                    echo set_value('product_sampling');
                                                                                                                                                } else {
                                                                                                                                                    echo '0';
                                                                                                                                                } ?>">
                                     <input type="hidden" name="fba" id="fba" value="<?php if ($fba == 'fba-invoice' ||  set_value('fba') == 1) {
                                                                                            echo 1;
                                                                                        } else {
                                                                                            echo 2;
                                                                                        } ?>">
                                     <button type="submit" id="btn_create_invoice" class="btn btn-dark-blue" name="submit"><i class="fas fa-edit mr-2"></i>Create Invoice</button>
                                     <a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="btn btn-outline-dark-blue"><i class="fas fa-arrow-left mr-2"></i>Back</a>
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

     <div class="modal fade" id="logistic-details-modal">
        <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Logistic Details</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
             </div>
           <div class="modal-body">
           <form method="POST" id="add_port_of_arrival" role="form">
           <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php if(set_value('user_id')) { echo set_value('user_id');} else { echo $user_id; } ?>">
           <input type="hidden" class="form-control" id="shipping_session" name="shipping_session" value="<?php if(set_value('shipping_session')) { echo set_value('shipping_session');} else { echo $shipping_session; } ?>">
             <p style="font-size:30px;"><strong> Port of Arrival </strong> </p>  
               <div class="row">
                <div class="col-md-12 col-12">
                    <div class="form-group">
                    <label for="username"><strong>Street Address:</strong></label>
                    <input type="text" class="form-control" id="street_address" value="<?php echo set_value('street_address'); ?>" name="street_address" placeholder="" >
                    </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12 col-12">
                <div class="form-group">
                  <label for="username"><strong>Address Line 2:</strong></label>
                   <input type="text" class="form-control" id="address_line_2" value="<?php echo set_value('address_line_2'); ?>" name="address_line_2" placeholder="">
                </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="username"><strong>City:</strong></label>
                        <input type="text" class="form-control" id="city" value="<?php echo set_value('city'); ?>"  name="city" placeholder="">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="username"><strong>State/Region/Province:</strong></label>
                        <input type="text" class="form-control" id="state" value="<?php echo set_value('state'); ?>" name="state" placeholder="">
                     </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                    <div class="form-group">
                     <label for="username"><strong>Postal/Zip Code:</strong></label>
                     <input type="text" class="form-control" id="postal" value="<?php echo set_value('postal'); ?>" name="postal" placeholder="">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                     <div class="form-group">
                     <label for="username"><strong>Country:</strong></label>
                      <select class="select2 form-control" id="country_1" name="country_1" style="width: 100%;">
                        <option value="" selected>Select Country</option>
                         <?php foreach ($countries as $row) {
                                 echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                                }
                           ?>
                       </select>
                      </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
            <div id="process_add_port_of_arrival" style="display:none;"><i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span>Processing Data...</span></div>
              <button type="submit" id="button_done_process" class="btn btn-dark-blue">Done</button>
            </div>
           </form>
            </div>
            <!-- /.modal-content -->
        </div>
         <!-- /.modal-dialog -->
    </div>
                                                                                    
     
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
                                    <select id="work_order" name="work_order[]" class="form-control" multiple="multiple">
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
                 <div class="modal-footer justify-content-end">
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
                 <div class="modal-footer justify-content-end">
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

     <!-- <div class="modal fade" id="modal_create_notice">
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
                                <p>We have made things easier for you! We have now launched our new IOR Shipping Invoice Generator. Be guided on our newest feature, visit <a href="<?php //echo base_url(); 
                                                                                                                                                                                    ?>uploads/docs/shipping_invoice_guide.mp4" target="_blank" class="dark-blue-link" style="text-decoration: underline;"><strong>here</strong></a> to know how to use our invoice generator.</p>
                                <?php //if($user_details->user_role_id != 3): 
                                ?>
                                <p>To all AMAZON Sellers:</p>
                                <p>Rules have changed! All Amazon Sellers are required to use the FBA Invoice Template and must provide FOSR and FBA Simulator for each products.</p>
                                <p>To be guided about how you can create your FOSR and FBA Simulator, click <a href="<?php //echo base_url(); 
                                                                                                                        ?>japan-ior/shipping-invoice-docs" target="_blank" class="dark-blue-link" style="text-decoration: underline;"><strong>here</strong></a>.</p>
                                <?php //endif 
                                ?>
                                <span class="text-danger"><strong>Reminder:</strong>
                                    <ul>
                                        <li>DHL stopped shipments.</li>
                                        <li>DHL Japan has stopped all shipments to Amazon FBA.</li>
                                        <li>Do not use DHL for your shipping to Japan FBA locations.</li>
                                    </ul>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <div>
                        <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Get Started</button>
                        <a href="<?php //echo base_url(); 
                                    ?>uploads/docs/shipping_invoice_guide.mp4" role="button" class="btn btn-outline-dark-blue" target="_blank">View User Manual Guide</a>
                    </div>
                </div>
            </div>
            <!-- /.modal-content 
        </div>
        <!-- /.modal-dialog 
    </div> -->
     <!-- /.modal -->

     <div class="modal fade" id="modal_create_notice">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title text-danger"><strong>STOP!</strong></h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                     <div class="row">

                         <div class="col-12">
                             <div class="form-group">
                                 <p><strong>DO YOU REQUIRE CUSTOM CLEARANCE?</strong></p>

                                 <p>IOR is not Customs Clearance.</p>
                                 
                                 <p>Customs Clearance requires IOR paperwork to complete the Customs Clearance process.</p>

                                 <p>COVUE can support customs clearance for large shipments when using COVUE Logistics Services.</p>
                                 
                                 <p>1 pallet minimum is required.</p>

                                 <p>COVUE Logistics Services is available to COVUE IOR customers.</p>

                                 <p>From Japan<br>
                                 Pick up from Japan Port of Entry<br>
                                 Customs Clearance<br>
                                 Delivery to Japan Destination</p>
                                 <br>

                                 <p>If you would like add COVUE Logistics Services, please click <a href="https://www.covue.com/customs-clearance-form/" class="dark-blue-link" target="_blank"><strong>Here</strong></a>!</p>
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer d-flex justify-content-end">
                     <div>
                         <button type="button" class="btn btn-dark-blue" data-dismiss="modal">Close</button>
                     </div>
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
     <div class="modal fade" id="non-regulated-modal">
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
                                 <ul>
                                     <li>
                                         <div id="selected-category"></div>
                                     </li><br>
                                     <li>Please be reminded that only products with the same category must be on this invoice.</li><br>
                                     <li>If you are shipping products that are under different categories, please create another shipping request.</li>
                                 </ul>
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer d-flex justify-content-end">
                     <button type="button" class="btn btn-dark-blue" data-dismiss="modal">OK, I understand</button>
                 </div>
             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     <!-- /.modal -->
     <div class="modal fade" id="non-cosmetics-modal">
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
                                 <ul>
                                     <li>
                                         <div id="selected-category"></div>
                                     </li><br>
                                     <li>Shipping Destination is locked to COVUE IOR address because your license IOR is responsible for shipment inspection.</li><br>
                                     <li>Please be reminded that only products with the same category must be on this invoice.</li><br>
                                     <li>If you are shipping products that are under different categories, please create another shipping request.</li>
                                 </ul>
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer d-flex justify-content-end">
                     <button type="button" class="btn btn-dark-blue" data-dismiss="modal">OK, I understand</button>
                 </div>
             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     <!-- /.modal -->
     <div class="modal fade" id="non-food-modal">
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
                                 <ul>
                                     <li>
                                         <div id="selected-category"></div>
                                     </li><br>
                                     <li>Japan Customs requires a Food Import Application for every shipment and pre-import approval from Japan MHLW. Only IOR Fees is charged for Replicated Application</li><br>
                                     <li>All products included in the same application are included on this invoice to process the replicated application.</li><br>
                                     <li>You can’t make any changes except quantity, destination and pricing. You need to apply for a new Food Import application if you remove, add products that are not on the same application.</li>
                                 </ul>
                             </div>
                         </div>

                     </div>

                 </div>
                 <div class="modal-footer d-flex justify-content-end">
                     <button type="button" class="btn btn-dark-blue" data-dismiss="modal">OK, I understand</button>
                 </div>
             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     <!-- /.modal -->


 </div>
 <!-- /.content-wrapper -->