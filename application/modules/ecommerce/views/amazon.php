<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col-md-6 col-12">
            <a href="<?php echo base_url() . 'ecommerce'; ?>" class="dark-blue-link"><i class="fas fa-arrow-left mr-3"></i>Back to Ecommerce Platform</a>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <h6>Welcome, <?php echo $user_details->contact_person; ?> (<a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url() ?>japan-ior/logout" class="dark-blue-link">Logout</a>)</h6>
        </div>
    </div>
</div>
<div id="contentEcommerceBody" class="row">
    <div class="container">
        <br>


        <div class="row">
            <div id="IORformInstruction" class="col-md-3 col-12">

                <h3>Announcements</h3>
                <br>
                <p>DHL Japan has stopped all shipments to Amazon FBA.</p>
                <br>
                <p>Do not use DHL for your shipping to Japan FBA locations.</p>
                <br><br>
                <ul>
                    <li><a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="dark-blue-link" target="_blank">COVUE Billing Invoices</a></li>
                    <li><a href="<?php echo base_url(); ?>japan-ior/terms-agreement" class="dark-blue-link" target="_blank">Download Terms Agreement</a></li>
                    <li><a href="#" class="dark-blue-link">Helpful Documents</a></li>
                    <li><a href="#" class="dark-blue-link">Help Center</a></li>
                </ul>

            </div>
            <div class="col-md-9 text-center">
                <div class="row">
                    <div class="col-md-11 text-center">
                        <img src="<?php echo base_url(); ?>assets/img/amazon.png">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <section style="width: 100%; display: flex; display: -webkit-flex; justify-content: center; -webkit-justify-content: center; max-width: 820px;">
                            <article class="card card--1">
                                <div class="card__img">
                                </div>
                                <a href="amazon_purchase_service">
                                    <div class="card__img--hover"></div>
                                </a>
                                <div class="card__info">
                                    <h3 class="card__title"><a href="amazon_purchase_service" class="card__author" title="author">Purchase Services</a></h3>
                                    <span class="card__by">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>

                                </div>
                            </article>

                            <article class="card card--2">
                                <div class="card__img">
                                </div>
                                <a href="amazon_list_services">
                                    <div class="card__img--hover"></div>
                                </a>
                                <div class="card__info">
                                    <h3 class="card__title"><a href="amazon_list_services" class="card__author" title="author">List of Services</a></h3>
                                    <span class="card__by">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>

                                </div>
                            </article>

                            <!-- <article class="card card--3">
                       <div class="card__img">
                        </div>
                        <a href="#">
                            <div class="card__img--hover"></div>
                        </a>
                        <div class="card__info">
                            <h3 class="card__title">User Profile</h3>
                            <span><a href="#" class="card__author" title="author">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></span>

                        </div>
                     </article> -->
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section style="width: 100%; display: flex; display: -webkit-flex; justify-content: left; -webkit-justify-content: left; max-width: 740px">
                            <!-- <article class="card card--4">
                       <div class="card__img">
                        </div>
                        <a href="order_tracking">
                            <div class="card__img--hover"></div>
                        </a>
                        <div class="card__info">
                            <h3 class="card__title">Track Orders</h3>
                            <span><a href="order_tracking" class="card__author" title="author">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></span>

                        </div>
                     </article> -->

                            <!-- <article class="card card--5">
                       <div class="card__img">
                            <img src="">
                        </div>
                        <a href="#" class="card_link">
                            <div class="card__img--hover"></div>
                        </a>
                        <div class="card__info">
                            <h3 class="card__title">Unknown</h3>
                            <span><a href="#" class="card__author" title="author">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></span>

                        </div>
                     </article> -->
                        </section>
                    </div>
                </div>
            </div>

        </div>

        <br><br>

    </div>

    <style type="text/css">
        .card--1 .card__img,
        .card--1 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/eligible.jpg');
        }

        .card--2 .card__img,
        .card--2 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/register_ior.jpg');
        }

        .card--3 .card__img,
        .card--3 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/purchase.jpg');
        }

        .card--4 .card__img,
        .card--4 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/reg_product.jpg');
        }

        .card--5 .card__img,
        .card--5 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/request.jpg');
        }

        .card--6 .card__img,
        .card--6 .card__img--hover {
            background-image: url('<?php echo base_url(); ?>assets/img/regulate.jpg');
        }

        .card__img {
            visibility: hidden;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 150px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;


        }

        .card__info-hover {
            position: absolute;
            padding: 16px;
            width: 100%;
            opacity: 0;
            top: 0;
        }

        .card__img--hover {
            transition: 0.2s all ease-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            position: absolute;
            height: 235px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            top: 0;

        }

        .card {
            margin-right: 25px;
            transition: all .4s cubic-bezier(0.175, 0.885, 0, 1);
            background-color: #fff;
            width: 33.3%;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 0px 0px 0px -0px rgba(0, 0, 0, 0.1);
            transform: scale(1.10, 1.10);
        }

        .card__info {
            z-index: 2;
            background-color: #fff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 16px 24px 24px 24px;
        }

        .card__title {
            margin-top: 5px;
            margin-bottom: 10px;
            font-family: 'Helvetica Neue', Arial;
        }

        .card__by {
            font-size: 12px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
        }

        .card__author {
            font-weight: 600;
            text-decoration: none;
            color: #AD7D52;
        }

        .card:hover .card__img--hover {
            height: 100%;
            opacity: 0.3;
        }

        .card:hover .card__info {
            background-color: transparent;
            position: relative;
        }

        .card:hover .card__info-hover {
            opacity: 1;
        }
    </style>

</div>