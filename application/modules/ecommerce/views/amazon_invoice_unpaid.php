<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col-md-6 col-12">
            <a href="<?php echo base_url() . 'ecommerce/amazon'; ?>" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to Amazon Services</a>

        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
        </div>
    </div>
</div>

<div class="row contentIORreg">
    <div class="container">

        <div class="row">

            <div id="IORform" class="col-12">

                <h3 class="dark-blue-title text-center">Covue Amazon Billing Invoice Notice</h3>

                <br>

                <center>
                    <i class="fa fa-exclamation-circle fa-10x dark-yellow-title"></i>

                    <br><br>

                    <p>Please pay your <strong>unpaid invoice</strong> first, to create a new invoice.</p>

                    <br>

                    <a href="<?php echo base_url(); ?>ecommerce/amazon_list_services" class="btn btn-dark-blue"><i class="fas fa-receipt mr-2"></i>Go to unpaid invoices</a>
                </center>
            </div>

        </div>

    </div>
</div>