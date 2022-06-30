<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col-md-6 col-12">
            <a href="<?php echo base_url(); ?>home/dashboard" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to IOR Dashboard</a>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
        </div>
    </div>
</div>

<div id="contentEcommerceBody" class="row">

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" style="color: #777;">Choose Your Ecommerce Platform</h1>

            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-3 text-center">
                <div class="card">
                    <div class="card-body" style="height: 10rem;padding-top: 3rem">
                        <a href="ecommerce/amazon"><img src="<?php echo base_url(); ?>assets/img/amazon.png"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <button disabled class="btn">
                    <div class="card">
                        <div class="card-body" style="height: 10rem;padding-top: 3rem">
                            <img src="<?php echo base_url(); ?>assets/img/rakuten.png">
                        </div>
                    </div>
                </button>
            </div>
        </div>

    </div>

</div>

<br><br>