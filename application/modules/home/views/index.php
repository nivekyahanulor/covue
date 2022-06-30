<div id="contentBody">
    <div class="layer">
        <div class="container">

            <div class="row">
                <div id="newCustomerButtons" class="col-md-6">
                    <h1>Need Importer of Record?</h1>
                    <h4>Expand your business to Japan with no worries!</h4>
                </div>
            </div>

            <br><br>

            <div class="row">
                <div id="newCustomerButtons" class="col-md-6">

                    <?php if ($this->session->userdata('logged_in') == '1') : ?>
                        <div class="row">
                            <div class="col-12">
                                <h3>Welcome to COVUE Online</h3>
                                <br>
                                <a href="<?php echo base_url(); ?>japan-ior/dashboard" class="btn btn-block btn-dark-blue">Proceed to your Dashboard&nbsp;&nbsp;<i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php elseif ($this->session->userdata('logged_in') == '3') : ?>
                        <?php if ($this->session->userdata('admin') == "partners") : ?>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Welcome to COVUE Online</h3>
                                    <br>
                                    <a href="<?php echo base_url(); ?>partner_companies/dashboard" class="btn btn-block btn-dark-blue">Proceed to your Dashboard&nbsp;&nbsp;<i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        <?php endif  ?>
                    <?php else : ?>

                        <h4>Before you import, you mush first check your products eligibility to know if your products require regulatory compliance or not.</h4>

                        <br>

                        <div class="row">
                            <div class="col-12">
                                <ul id="homepage-links">
                                    <li><a href="https://www.covue.com/product-eligibility/" class="btn btn-lg btn-outline-dark-yellow btn-block">Check Product Eligibility</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/signup" class="btn btn-lg btn-outline-dark-yellow btn-block">Ready to Register IOR?</a></li>
                                    <!-- <li><a href="<?php //echo base_url(); 
                                                        ?>home/get-a-quote" class="btn btn-lg btn-outline-dark-yellow btn-block">Get Quotation</a></li> -->
                                </ul>
                                <span class="login-link">Already have an account? <a href="<?php echo base_url(); ?>home/login">login here</a></span>
                                <br>
                                <span class="login-link">Partner Company? <a href="<?php echo base_url(); ?>home/partner-login">log-in here</a></span>
                                <br>
                                <span class="login-link">Consultant Partner? <a href="<?php echo base_url(); ?>home/consultant-login">log-in here</a></span>
                            </div>
                        </div>

                        <br>

                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>
</div>

<div id="contentSection">
    <div class="container">

        <div class="row">
            <div class="left-cs col-md-7">
                <h4 class="text-center">Leave your custom clearance to us when shipping to Japan. </h4>

                <br>

                <p>Whether you’re a large company making regular shipments to Japan or an Amazon Japan seller wanting to expand your business, we can help.</p>

                <br>

                <p>We are more than just an Japan Importer of Record IOR service provider. We act as your virtual subsidiary, providing independent control of distributors and end-customer. This avoids potential problems when assigning your distribution licenses to a distributor. </p>

                <br>

                <p>Have any questions regarding IOR? Chat us on live chat or <a href="https://www.covue.com/contact/">contact us</a></p>

                <div class="row">
                    <div class="col-md-6">
                        <a href="https://www.covue.com/ior-registration" target="_blank" class="btn btn-dark-blue btn-block btn-lg">IOR Pricing</a>
                    </div>
                    <div class="col-md-6">
                        <a href="https://www.covue.com/wp-content/uploads/2020/09/New-User-Manual-IOR-Online-final.pdf" target="_blank" class="btn btn-dark-yellow btn-block btn-lg">Guide on IOR System</a>
                    </div>
                </div>

            </div>
            <div class="col-md-5">
                <img src="<?php echo base_url() . 'assets/img/mrec.jpg'; ?>" class="img-fluid">
            </div>
        </div>

    </div>
</div>

<div id="contentSection2">
    <div class="container">

        <div class="row">
            <div class="col-md-12 mb-5">
                <center>
                    <h2>How can we help your business in Japan?</h2>
                </center>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <ul class="list-cs2 list-unstyled">

                    <li class="media">
                        <img src="<?php echo base_url() . '/assets/img/ior.png'; ?>" class="mr-3" alt="Importer of Record" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Importer of Record</h5>
                            When importing products to Japan you’ll need an importer of record
                        </div>
                    </li>
                    <li class="media my-4">
                        <img src="<?php echo base_url() . '/assets/img/regulatory.png'; ?>" class="mr-3" alt="Regulatory and Compliance" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Regulatory and Compliance</h5>
                            COVUE’s comprehensive Regulatory Compliance services make the application process easy to navigate
                        </div>
                    </li>
                    <li class="media">
                        <img src="<?php echo base_url() . '/assets/img/testing.png'; ?>" class="mr-3" alt="Product Testing and inspection" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Product Testing and inspection</h5>
                            We can assist you with product testing for custom clearance
                        </div>
                    </li>

                    <li class="media">
                        <img src="<?php echo base_url() . '/assets/img/translation.png'; ?>" class="mr-3" alt="Translation Services" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Translation Services</h5>
                            COVUE Translations Services bring natural and accurate translations to increase purchases.
                        </div>
                    </li>
                    <li class="media my-4">
                        <img src="<?php echo base_url() . '/assets/img/storage.png'; ?>" class="mr-3" alt="Storage and Fulfillment" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Storage and Fulfillment</h5>
                            Our Fulfillment Services provides a cost effective alternative for Amazon sellers testing the market.
                        </div>
                    </li>
                    <li class="media">
                        <img src="<?php echo base_url() . '/assets/img/warranty.png'; ?>" class="mr-3" alt="Warranty Support" width="100">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">Warranty Support</h5>
                            COVUE Depot Repair and Field Service support provides Amazon Sellers local support and installation.
                        </div>
                    </li>

                </ul>

            </div>
        </div>

    </div>
</div>

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