<style>
    tr.spaceUnder>td {
        padding-bottom: 1em;
    }

    .btn-register {
        background-color: #f08135;
        color: #ffff;
    }
</style>
<div class="row contentIORreg">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-12 col-12">
                <a href="<?php echo base_url(); ?>" class="dark-blue-link"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Go Back to Homepage</a>
            </div>
        </div>
        <div class="row">
            <div id="IORform" class="col-md-6">
                <br>
                <h4 class="dark-blue-title text-center">Quotation Result</h4>
                <br>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="username"><strong>Services</strong></label>
                            <select class="form-control " id="quoatecategory" name="category">
                                <option value=""> -- Select Category -- </option>

                                <?php foreach ($category_data as $row => $val) { ?>
                                    <?php if ($val->label == $_GET['category']) { ?>
                                        <option selected> <?php echo $val->label; ?></option>
                                    <?php } else { ?>
                                        <option> <?php echo $val->label; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="ior" <?php if ($_GET['category'] != 'Importer of Record (IOR)') {
                                    echo "style=display:none;";
                                } ?>>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="username"><strong>Category</strong></label>
                                <select type="text" class="form-control" id="ior_category">
                                    <?php foreach ($category_ior_data as $row => $val) { ?>
                                        <?php if ($val->category_name == $_GET['services']) { ?>
                                            <option selected> <?php echo $val->category_name; ?></option>
                                        <?php } else { ?>
                                            <option> <?php echo $val->category_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-12" id="product_label">
                            <div class="form-group">
                                <label for="company_address"><strong>Product Label </strong></label>
                                <input type="text" class="form-control" name="label" value="<?php echo $_GET['product_label']; ?>" id="ior_label" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" autocomplete="off" placeholder="Ex. 10">
                            </div>
                        </div>


                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Import Value (JPY)</strong></label>
                                <input type="text" class="form-control " id="ior_import_value" onkeyup="comma(this);" value="<?php echo $_GET['import_value']; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" autocomplete="off" placeholder="Ex. 100,000,000">
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <button class="btn btn-block btn-outline-dark-blue" id="btn-calculate"><i class="fas fa-calculator mr-2"></i>Calculate</button>
                            </div>
                        </div>


                    </div>
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
                <div id="ecommerce" <?php if ($_GET['category'] != 'e-Commerce') {
                                        echo "style=display:none;";
                                    } ?>>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="username"><strong>Platform:</strong></label>
                                <select type="text" class="form-control" id="ecommerce_platform" name="ecommerce_platform">
                                    <?php if ($_GET['ecommerce_platform'] == 'Amazon') {
                                        echo " 	<option value='' > -- Select Platform -- </option>
												<option selected> Amazon </option>
												<option> Rakuten </option>";
                                    } else  if ($_GET['ecommerce_platform'] == 'Rakuten') {
                                        echo " 	<option value='' > -- Select Platform -- </option>
												<option> Amazon </option>
												<option selected> Rakuten </option>";
                                    } else {
                                        echo "  <option value='' selected> -- Select Platform -- </option>
												<option> Amazon </option>
												<option selected> Rakuten </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="amazon" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                        echo "style=display:none;";
                                                    } ?>>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Amazon Account Set-Up</strong></label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul style="list-style-type:none;">
                                        <li><label><input type="checkbox" name="check1" class="check1" <?php if (isset($_GET['check1'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Account set-up<label></li>
                                        <li><label><input type="checkbox" name="check2" class="check2" <?php if (isset($_GET['check2'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Brand registry <label></li>
                                        <li><label><input type="checkbox" name="check3" class="check3" <?php if (isset($_GET['check3'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Primary contact person<label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Product Set-Up</strong></label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul style="list-style-type:none;">
                                        <li><label> <input type="checkbox" name="check4" class="check4" <?php if (isset($_GET['check4'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Amazon Product Listing Translation & Upload in Japanese <label></li>
                                        <li><label> <input type="checkbox" name="check5" class="check5" <?php if (isset($_GET['check5'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Amazon SEO-Optimized Product Listing in Japanese <label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Brand And Optimization</strong></label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul style="list-style-type:none;">
                                        <li><label> <input type="checkbox" name="check13" class="check13" <?php if (isset($_GET['check13'])) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Amazon Product Listing Japanese Listing Optimization <label></li>
                                        <li><label> <input type="checkbox" name="check14" class="check14" <?php if (isset($_GET['check14'])) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Amazon Optimized A+/EBC Design and creation in Japanese <label></li>
                                        <li><label> <input type="checkbox" name="check15" class="check15" <?php if (isset($_GET['check15'])) {
                                                                                                                echo 'checked';
                                                                                                            } ?>> Amazon Optimized Brand Store Design and Build in Japanesee <label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_address"><strong>Account Management</strong></label>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul style="list-style-type:none;">
                                        <li><label><input type="checkbox" name="check6" class="check6" <?php if (isset($_GET['check6'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Amazon Account Management <label></li>
                                        <li><label><input type="checkbox" name="check7" class="check7" <?php if (isset($_GET['check7'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Amazon Account Operation Management <label></li>
                                        <li><label><input type="checkbox" name="check8" class="check8" <?php if (isset($_GET['check8'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> Customer Service <label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="rakuten" <?php if ($_GET['ecommerce_platform'] != 'Rakuten') {
                                                        echo "style=display:none;";
                                                    } ?>>
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul style="list-style-type:none;">
                                        <li><label><input type="checkbox" name="check" class="check9" <?php if (isset($_GET['check9'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> <b>Rakuten Account Set-Up </b><label></li>
                                        <li><label><input type="checkbox" name="check" class="check10" <?php if (isset($_GET['check10'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> <b> Store Design and construction </b> <label></li>
                                        <li><label><input type="checkbox" name="check" class="check11" <?php if (isset($_GET['check11'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> <b> Optimization </b> <label></li>
                                        <li><label><input type="checkbox" name="check" class="check12" <?php if (isset($_GET['check12'])) {
                                                                                                            echo 'checked';
                                                                                                        } ?>> <b> System and admin fees </b> <label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="IORguide" class="col-md-6" style="background-color: #ffc033; border-radius: 25px;">
                <div class="col-md-12 col-12">
                    <div id="jbsetup" style="display:none;">

                        <div class="row" id="content-other-services" style="display:none;">
                            <div class="col-md-12 col-12 text-center">
                                <h3>Get in touch and we’ll get back to you as soon as we can.</h3>
                                <br>
                                <i>We look forward to hearing from you! </i>
                                <br><br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12 text-center">
                                <div class="form-group">
                                    <div style="height:10px;"></div>
                                    <a href="https://www.covue.com/contact/" class="btn btn-block btn-dark-blue btn-lg"><strong>Contact Us</strong></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="ior_result" <?php if ($_GET['category'] != 'Importer of Record (IOR)') {
                                                echo "style=display:none;";
                                            } ?>>
                        <div id="category_result"></div>
                        <div id="ior_label_total"></div>
                        <div id="ior_shipping_fees"></div>
                        <div style="height:40px;"></div>
                        <a href="<?php echo base_url(); ?>home/signup" class="btn btn-block btn-dark-blue btn-lg">Register Now</a>
                    </div>
                    <div id="ecommerce_result" <?php if ($_GET['category'] != 'e-Commerce') {
                                                    echo "style=display:none;";
                                                } ?>>
                        <table id="table_amazon_ior" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                            echo "style=display:none;";
                                                        } else {
                                                            echo "style=width:100%;";
                                                        } ?>>
                            <tr>
                                <td>
                                    <h4>IOR REGISTRATION FEES</h4>
                                </td>
                                <td style="text-align:right;">
                                    <h4>USD </h4>
                                </td>
                            </tr>
                            <tr class="spaceUnder">
                                <td><i>*You must need to register your company <br> under our IOR License to avail Amazon Services</i></td>
                                <td style="text-align:right;"> </td>
                            </tr>
                            <tr>
                                <td>One Time IOR Registration Fee</td>
                                <td style="text-align:right;"> <?php echo $ior = 78.75; ?></td>
                            </tr>
                            <tr class="spaceUnder">
                                <td>Product Liability Insurance per year</td>
                                <td style="text-align:right;"> <?php echo $pli = 100.00; ?></td>
                            </tr>


                        </table>
                        <table id="table_amazon" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                        echo "style=display:none;";
                                                    } else {
                                                        echo "style=width:100%;";
                                                    } ?>>
                            <tr>
                                <td>
                                    <h4> AMAZON FEES </h4>
                                </td>
                                <td style="text-align:right;"> </td>
                            </tr>
                            <tr id="check1" <?php if (!isset($_GET['check1'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td> Account set-up </td>
                                <td style="text-align:right;"> 750.00 </td>
                            </tr>
                            <tr id="check2" <?php if (!isset($_GET['check2'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td> Brand registry </td>
                                <td style="text-align:right;"> 500.00 </td>
                            </tr>
                            <tr id="check3" <?php if (!isset($_GET['check3'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td> Primary contact person </td>
                                <td style="text-align:right;"> 500.00 / Year </td>
                            </tr>
                            <tr id="check4" <?php if (!isset($_GET['check4'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td> Amazon Product Listing Translation & Upload in Japanese </td>
                                <td style="text-align:right;">225.00 <br> <i>( per 100 Products) </i></td>
                            </tr>
                            <tr id="check5" <?php if (!isset($_GET['check5'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td>Amazon SEO-Optimized Product Listing in Japanese</td>
                                <td style="text-align:right;">675.00 <br> <i>( per 100 Products) </i></td>
                            </tr>
                            <tr id="check13" <?php if (!isset($_GET['check13'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td>Amazon Product Listing Japanese Listing Optimization</td>
                                <td style="text-align:right;">450.00 <br> <i>( per 100 Products) </i></td>
                            </tr>
                            <tr id="check14" <?php if (!isset($_GET['check14'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td>Amazon Optimized A+/EBC Design and creation in Japanese</td>
                                <td style="text-align:right;">540.00 <br> <i>( per 100 Products) </i></td>
                            </tr>
                            <tr id="check15" <?php if (!isset($_GET['check15'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td>Amazon Optimized Brand Store Design and Build in Japanese</td>
                                <td style="text-align:right;">1050.00 <br><i>(per Store up to 5 Pages)</i></td>
                            </tr>
                            <tr id="check6" <?php if (!isset($_GET['check6'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td>Amazon Account Management</td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>
                            <tr id="check7" <?php if (!isset($_GET['check7'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td>Amazon Account Operation Management</td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>
                            <tr id="check8" <?php if (!isset($_GET['check8'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td>Customer Service</td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>

                        </table>

                        <table id="table_rakuten" <?php if ($_GET['ecommerce_platform'] != 'Rakuten') {
                                                        echo "style=display:none;";
                                                    } else {
                                                        echo "style=width:100%;";
                                                    } ?>>
                            <tr id="check9" <?php if (!isset($_GET['check9'])) {
                                                echo "style=display:none;";
                                            } ?>>
                                <td>Rakuten Account Set-Up </td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>
                            <tr id="check10" <?php if (!isset($_GET['check10'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td> Store Design and construction </td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>
                            <tr id="check11" <?php if (!isset($_GET['check11'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td> Optimization </td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>
                            <tr id="check12" <?php if (!isset($_GET['check12'])) {
                                                    echo "style=display:none;";
                                                } ?>>
                                <td>System and admin fees </td>
                                <td style="text-align:right;"> <a href="https://www.covue.com/contact/" target="_blank">Contact Us</a></td>
                            </tr>

                        </table>
                        <div style="height:40px;"></div>
                        <table style="width:100%" id="totalamazon" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                                        echo "style=display:none;";
                                                                    } ?>>
                            <tr id="total_amazon" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                        echo "style=display:none;";
                                                    } ?>>
                                <td><b>
                                        <h3> TOTAL </h3>
                                    </b></td>
                                <td style="text-align:right;font-size:25px;">
                                    <h3>
                                        <div id="amazon_total">
                                            <?php
                                            if (isset($_GET['check1'])) {
                                                $check1 = 750;
                                            } else {
                                                $check1 = 0;
                                            }
                                            if (isset($_GET['check2'])) {
                                                $check2 = 500;
                                            } else {
                                                $check2 = 0;
                                            }
                                            if (isset($_GET['check3'])) {
                                                $check3 = 500;
                                            } else {
                                                $check3 = 0;
                                            }
                                            if (isset($_GET['check4'])) {
                                                $check4 = 225;
                                            } else {
                                                $check4 = 0;
                                            }
                                            if (isset($_GET['check5'])) {
                                                $check5 = 675;
                                            } else {
                                                $check5 = 0;
                                            }
                                            if (isset($_GET['check6'])) {
                                                $check6 = 0;
                                            } else {
                                                $check6 = 0;
                                            }
                                            if (isset($_GET['check7'])) {
                                                $check7 = 0;
                                            } else {
                                                $check7 = 0;
                                            }
                                            if (isset($_GET['check8'])) {
                                                $check8 = 0;
                                            } else {
                                                $check8 = 0;
                                            }
                                            if (isset($_GET['check13'])) {
                                                $check13 = 450;
                                            } else {
                                                $check13 = 0;
                                            }
                                            if (isset($_GET['check14'])) {
                                                $check14 = 540;
                                            } else {
                                                $check14 = 0;
                                            }
                                            if (isset($_GET['check15'])) {
                                                $check15 = 1050;
                                            } else {
                                                $check15 = 0;
                                            }
                                            $total = $check1 + $check2 + $check3 + $check4 + $check5 + $check6 + $check7 + $check8 + $check13 + $check14 + $check15 + $ior + $pli;
                                            if ($total != 0) {
                                                echo "$ " . number_format($total, 2);
                                            } else {
                                                echo 0;
                                            }
                                            ?>
                                        </div>
                                    </h3>
                                </td>
                            </tr>
                        </table>

                        <div style="height:40px;"></div>
                        <a href="<?php echo base_url(); ?>home/signup" class="btn btn-block btn-dark-blue btn-lg" id="register_btn" <?php if ($_GET['ecommerce_platform'] != 'Amazon') {
                                                                                                                                        echo "style=display:none;";
                                                                                                                                    } ?>>Register Now</a>
                        <a href="https://www.covue.com/contact/" class="btn btn-block btn-dark-blue btn-lg" id="contact_btn" <?php if ($_GET['ecommerce_platform'] != 'Rakuten') {
                                                                                                                                    echo "style=display:none;";
                                                                                                                                } ?>><strong>Contact Us</strong></a>
                    </div>
                </div>


            </div>

        </div>

    </div>
</div>