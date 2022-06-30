<style>
    .btn-quote {
        background-color: #002c61;
        color: #fff;
    }

    .btn-quote:hover {
        background-color: #001c3d;
        color: #fff;
    }
</style>
<div id="contentBody" style="height:auto;">
    <div class="layer">
        <div class="container">
            <div class="row">
                <div id="newCustomerButtons" class="col-md-7">
                    <h1>COVUE GET A QUOTE</h1>
                    <br>
                    <h4>We are confident our services can help your<br>business achieve.</h4>
                    <br>
                    <a href="<?php echo base_url(); ?>" class="btn btn-outline-dark-yellow" style="margin-left: 10px;"><i class="fas fa-arrow-left mr-2"></i>Go Back to Home</a>
                </div>
                <br><br>
                <div id="newCustomerButtons" class="col-md-5">
                    <div class="row">
                        <div id="IORguide" class="col-md-12" style="min-height:600px; background-color: rgba(245, 245, 245, 0.4) !important;">
                            <p>
                            <h3>START HERE</h3>
                            </p>
                            <p>Fill in the information below to get a quote. </p>
                            <form method="get" action="home/quotes-result">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="username"><strong>Services</strong></label>
                                            <select class="form-control " id="quoatecategory" name="category">
                                                <option value="">- Select Category -</option>
                                                <?php foreach ($category_data as $row => $val) { ?>
                                                    <option> <?php echo $val->label; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="ior" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="username"><strong>Category</strong> <i class="fas fa-question-circle" data-toggle="tooltip" title="Each category may require import applications"></i></label>
                                                <select class="form-control" id="ior_category" name="services">
                                                    <option value="">- Select Services -</option>
                                                    <?php foreach ($category_ior_data as $row => $val) { ?>
                                                        <option> <?php echo $val->category_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="product_label">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company_address"><strong>Product Label </strong> <i class="fas fa-question-circle" data-toggle="tooltip" title="Japanese law requires labels for products in many categories"></i></label>
                                                <input type="text" class="form-control" name="product_label" id="ior_label" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" autocomplete="off" placeholder="Ex. 10">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="company_address"><strong>Import Value (JPY)</strong> <i class="fas fa-question-circle" data-toggle="tooltip" title="Please put the amount to determine your IOR Shipping fees"></i></label>
                                                <input type="text" class="form-control " id="ior_import_value" onkeyup="comma(this);" name="import_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" autocomplete="off" placeholder="Ex. 100,000,000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12 text-center">
                                            <div class="form-group">
                                                <div style="height:10px;"></div>
                                                <button class="btn btn-block btn-quote btn-md"> Get a Quote </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="ecommerce" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="username"><strong>Platform:</strong></label>
                                                <select type="text" class="form-control" id="ecommerce_platform" name="ecommerce_platform">
                                                    <option value=""> -- Select Platform -- </option>
                                                    <option> Amazon </option>
                                                    <option> Rakuten </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="amazon" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label for="company_address"><strong>Amazon Account Set-Up</strong></label>
                                                <div class="col-md-12">
                                                    <ul style="list-style-type:none;">
                                                        <li><label><input type="checkbox" name="check1" value="Account set-up"> Account set-up</label></li>
                                                        <li><label><input type="checkbox" name="check2" value="Brand registry"> Brand registry</label> </li>
                                                        <li><label><input type="checkbox" name="check3" value="Primary contact person"> Primary contact person</label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label for="company_address"><strong>Product Set-Up</strong></label>
                                                <div class="col-md-12">
                                                    <ul style="list-style-type:none;">
                                                        <li><label> <input type="checkbox" name="check4" value="Basic Product Set-Up"> Amazon Product Listing Translation & Upload in Japanese</label> </li>
                                                        <li><label> <input type="checkbox" name="check5" value="Language Localization"> Amazon SEO-Optimized Product Listing in Japanese</label> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label for="company_address"><strong>Brand And Optimization</strong></label>
                                                <div class="col-md-12">
                                                    <ul style="list-style-type:none;">
                                                        <li><label> <input type="checkbox" name="check13" value="Basic Product Set-Up"> Amazon Product Listing Japanese Listing Optimization</label></li>
                                                        <li><label> <input type="checkbox" name="check14" value="Language Localization">Amazon Optimized A+/EBC Design and creation in Japanese</label> </li>
                                                        <li><label> <input type="checkbox" name="check15" value="Language Localization">Amazon Optimized Brand Store Design and Build in Japanese </label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label for="company_address"><strong>Account Management</strong></label>
                                                <div class="col-md-12">
                                                    <ul style="list-style-type:none;">
                                                        <li><label><input type="checkbox" name="check6" value="Amazon Account Management"> Amazon Account Management</label></li>
                                                        <li><label><input type="checkbox" name="check7" value="Optimization"> Amazon Account Operation Management</label></li>
                                                        <li><label><input type="checkbox" name="check8" value="Customer Service"> Customer Service</label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="rakuten" style="display:none;">
                                        <div class="col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul style="list-style-type:none;">
                                                        <li><label><input type="checkbox" name="check9">
                                                                <b>Rakuten Account Set-Up </b></label>
                                                        </li>
                                                        <li><label><input type="checkbox" name="check10">
                                                                <b> Store Design and construction </b></label>
                                                        </li>
                                                        <li><label><input type="checkbox" name="check11">
                                                                <b> Optimization </b></label>
                                                        </li>
                                                        <li><label><input type="checkbox" name="check12">
                                                                <b> System and admin fees </b></label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12 text-center">
                                            <div class="form-group">
                                                <div style="height:10px;"></div>
                                                <button class="btn btn-block btn-quote btn-md"> Get a Quote </button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div id="otherservices" style="display:none;">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="username"><strong>Category:</strong></label>
                                        <select type="text" class="form-control" id="ior_category">
                                            <option selected> -- Select Category -- </option>
                                            <option> Call Center Support </option>
                                            <option> Dedicated Technical Staffing </option>
                                            <option> Technical Support Solution </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="jbsetup" style="display:none;">
                            <div class="row">
                                <div class="col-md-12 col-12 text-center">
                                    <div class="form-group">
                                        <div style="height:10px;"></div>
                                        <a href="https://www.covue.com/contact/" class="btn btn-block btn-success btn-lg"><strong>Contact Us</strong></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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