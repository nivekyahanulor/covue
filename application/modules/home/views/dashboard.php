<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col-md-6 col-12">
            <a href="<?php echo base_url(); ?>" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to Homepage</a>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <?php if ($this->session->userdata('admin') == "partners") : ?>
                <h6>Welcome, <?php echo $this->session->userdata('contact_person'); ?> (<a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
            <?php else : ?>
                <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="row contentIORreg">
    <div class="container">

        <div class="row">
            <?php if ($this->session->userdata('admin') != 'partners') : ?>
                <div id="IORformInstruction" class="col-md-3 col-12">
                    <a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $user_details->user_id; ?>" class="btn-lg btn-outline-dark-blue btn-block"><i class="fas fa-user-circle mr-2"></i>My Profile</a>
                    <a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class=" btn-lg btn-outline-dark-blue btn-block"><i class="fas fa-credit-card mr-2"></i>Billing and Payment</a>
                    <a href="<?php echo base_url(); ?>home/get-a-quote" class=" btn-lg btn-outline-dark-blue btn-block"><i class="fas fa-quote-right mr-2"></i>Get a Quote</a>
                    <!-- <a href="#" class=" btn-lg btn-outline-dark-blue btn-block"><i class="fas fa-cogs mr-2"></i>Settings</a> -->
                </div>
                <div id="IORform" class="col-md-9">
                <?php else : ?>
                    <div id="IORform" class="col-md-6 mx-auto">
                    <?php endif ?>

                    <div id="home_dashboard" class="row ">
                        <?php
                        if ($this->session->userdata('admin') == 'partners') {
                        ?>
                            <div class="col mb-4">
                                <center>
                                    <div class="card h-100" style=" background: #fff; border-radius: 4px; box-shadow: 0px 0px 0px rgba(34, 35, 58, 0.5); display: flex; border-radius: 50px; position: relative;">
                                        <img src="<?php echo base_url(); ?>assets/img/partner1.jpg" class="card-img-top" style="width: 100%; height: 55%; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px; border-bottom-left-radius: 50px;">
                                        <!-- <center><i cass="fas fa-handshake fa-6x mt-3" style="opacity: .65;"></i></center>-->
                                        <div class="card-body">
                                            <h5 class="card-title">Partners</h5>
                                            <br><br>
                                            <p class="card-text">Looking for a perfect partner to support end to end customer needs?</p>
                                        </div>
                                        <div class=" card text-center">
                                            <a href="<?php echo base_url(); ?>partner_companies/dashboard" class=" btn btn-outline-dark-blue btn-block">View Services</a>
                                        </div>
                                    </div>
                                </center>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col mb-4">
                                    <div class="card h-100" style=" background: #fff; border-radius: 4px; box-shadow: 0px 0px 0px rgba(34, 35, 58, 0.5); max-width: 400px; max-height: 400px; display: flex; border-radius: 50px; position: relative;">
                                        <img src="<?php echo base_url(); ?>assets/img/service1.jpg" class="card-img-top" style="width: 100%; height: 55%; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px; border-bottom-left-radius: 50px;">
                                        <!--<center><i class="fas fa-people-carry fa-6x mt-3"></i></center>-->
                                        <div class="card-body">
                                            <h5 class="card-title">Japan IOR Services</h5>
                                            <br><br>
                                            <p class="card-text">When importing to Japan, you need an Importer of Record.</p>
                                        </div>
                                        <div class="card text-center">
                                            <a href="<?php echo base_url(); ?>japan-ior/dashboard" class=" btn btn-outline-dark-blue btn-block">View Services</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card h-100" style=" background: #fff; border-radius: 4px; box-shadow: 0px 0px 0px rgba(34, 35, 58, 0.5); max-width: 400px; max-height: 400px; display: flex; border-radius: 50px; position: relative;">
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-danger text-lg">
                                                Coming Soon
                                            </div>
                                        </div>
                                        <img src="<?php echo base_url(); ?>assets/img/e-commerce1.jpg" class="card-img-top" style="width: 100%; height: 55%; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px; border-bottom-left-radius: 50px;">
                                        <!--<center><i class="fas fa-shopping-cart fa-6x mt-3"></i></center>-->
                                        <div class="card-body" style="opacity: .65;">
                                            <h5 class="card-title">e-Commerce Services</h5>
                                            <br><br>
                                            <p class="card-text">COVUE e-Commerce services help you sell online with no worries.</p>
                                        </div>
                                        <div class=" card text-center">
                                            <a href="<?php echo base_url(); ?>ecommerce" class=" btn btn-outline-dark-blue btn-block disabled">View Services</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card h-100" style=" background: #fff; border-radius: 4px; box-shadow: 0px 0px 0px rgba(34, 35, 58, 0.5); max-width: 400px; max-height:  400px; display: flex; border-radius: 50px; position: relative;">
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-danger text-lg">
                                                Coming Soon
                                            </div>
                                        </div>
                                        <img src="<?php echo base_url(); ?>assets/img/business1.jpg" class="card-img-top" style="width: 100%; height: 55%; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px; border-bottom-left-radius: 50px;">
                                        <!--<center><i class="fas fa-briefcase fa-6x mt-3" style="opacity: .65;"></i></center>-->

                                        <div class="card-body" style="opacity: .65;">
                                            <h3 class="card-title">Japan Business Setup</h3>
                                            <br><br>
                                            <p class="card-text">Looking to expand your business to Japan?</p>
                                        </div>

                                        <div class=" card text-center">
                                            <a href="#" class=" btn btn-outline-dark-blue btn-block disabled">View Services</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col mb-4">
                                    <div class="card h-100" style=" background: #fff; border-radius: 4px; box-shadow: 0px 0px 0px rgba(34, 35, 58, 0.5); max-width: 400px; max-height: 400px; display: flex; border-radius: 50px; position: relative;">
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-danger text-lg">
                                                Coming Soon
                                            </div>
                                        </div>
                                        <img src="<?php echo base_url(); ?>assets/img/return.png" class="card-img-top" style="width: 100%; height: 55%; border-top-left-radius: 50px; border-top-right-radius: 50px; border-bottom-right-radius: 50px; border-bottom-left-radius: 50px;">
                                        <!-- <center><i cass="fas fa-handshake fa-6x mt-3" style="opacity: .65;"></i></center>-->
                                        <div class="card-body" style="opacity: .65;">
                                            <h5 class="card-title">Product Return</h5>
                                            <br><br>
                                            <p class="card-text">Looking for a perfect partner to support end to end customer needs?</p>
                                        </div>
                                        <div class=" card text-center">
                                            <a href="#" class=" btn btn-outline-dark-blue btn-block disabled">View Services</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>

                    </div>

                    </div>

                </div>

        </div>
    </div>