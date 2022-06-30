<!-- <?php var_dump($amazon_products) ?> -->
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
<div id="" class="row">
  <div class="container">
    <br>
    <div style="display: -webkit-flex; justify-content: center; -webkit-justify-content: center; ">
      <h1 style="color: #012d60; margin-top: 10px; "><img src="<?php echo base_url(); ?>assets/img/amazon.png"> Services</h1>
    </div>
    <div class="row">
      <div class="col-md-6 wrap" style="padding-right: 2rem">
        <div style=" background-color: #012d60; display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-orient: vertical;-webkit-box-direction: normal; -ms-flex-direction: column; flex-direction: column; max-width: 100%; /*padding-top: 40px;*/ padding-bottom: 40px; padding-left: 60px; padding-right: 60px; border-radius: 15px;">
          <br>

          <form>
            <h4 style="color: #f1c40f">Amazon Account Set-Up </h4>

            <br>
            <!-- <label id="cb1">
                    <input type="checkbox" name="checkbox" id="acc_set_btn">
<<<<<<< HEAD
                    <span>Account Setups</span>
                  </label> -->
            <!--      <span style="color: #fff;">Account Setups</span>
                  </label>
                  <br> -->
            <!-- <label>
                    <input disabled type="checkbox" name="" id="checkbox2">
                    <span>Primary contact person</span>
                  </label> -->
            <!-- <label>
                    <input disabled type="checkbox">
<<<<<<< HEAD
                    <span>Brand Registry</span>
                  </label> -->
            <?php foreach ($amazon_products as $key => $value) {
              if ($amazon_account_setup_count == 0) {

            ?>
                <label id="cb1">
                  <input type="checkbox" name="checkbox" class="prod_purch_cb mr-2" data-price="<?= $value->price; ?>">
                  <span style="color: #fff"><?php echo $value->name; ?></span>
                </label>
                <br>
            <?php
              }
            } ?>
            <!-- =======
                    <span style="color: #fff;">Brand Registry</span>
                  </label>
>>>>>>> 1c962164820c2b499c457e4f1c010227b5230af5 -->
            <br><br>
            <h4 style="color: #ffc033">Product Set-Up</h4>
            <br>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Product Listing Translation & Upload in Japanese</span>
            </label>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon SEO-Optimized Product Listing in Japanese</span>
            </label>

            <br><br>
            <h4 style="color: #ffc033">Brand And Optimization</h4>
            <br>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Product Listing Japanese Listing Optimization</span>
            </label>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Optimized A+/EBC Design and creation in Japanese</span>
            </label>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Optimized Brand Store Design and Build in Japanese</span>
            </label>

            <br><br>
            <h4 style="color: #ffc033">Account Management</h4>
            <br>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Account Management</span>
            </label>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Amazon Account Operation Management</span>
            </label>
            <label>
              <input class="other_cb mr-2" type="checkbox">
              <span style="color: #fff;">Customer Service</span>
            </label>
        </div>
        </form>
      </div>

      <div id="" class="col-md-6" style="background-color:#ffff;  border-radius: 15px; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0,0.1);">
        <div class="col-md-12 col-12">
          <h1 style="margin-top: 10px">Payment Summary <span> ($)</span></h1>
          <br>
          <input type="hidden" id="is_reg" value="<?= $user_details->ior_registered ?>">
          <input type="hidden" id="pd_pli" value="<?= $user_details->pli ?>">
          <input type="hidden" id="reg_fee" value="<?= $ior_reg_fee->price ?>">
          <ul class="list-group" id="purch_con">

          </ul>
          <hr>
          <ul class="list-group" id="purch_con2">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              Subtotal
              <span class=badge style="font-size: 1.2rem" id="sub_total">0</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              JCT 10%
              <span class=badge style="font-size: 1.2rem" id="jct">0</span>
            </li>
          </ul>
          <hr>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <h2>TOTAL</h2>
            <span class=badge style="font-size: 1.2rem" id="purch_total">0</span>
          </li>
          <div id="ior_result">
            <div id="category_result">
              <div class="col-md-12 col-12"></div>
            </div>
            <div style="height:40px;"></div>
            <center><button id="con_btn" disabled onclick="gotoPreCheckForm()" class="btn btn-dark-blue btn-lg">Continue</button></center>
            <!--  <a style="display: none" href="#" id="btn_product_services" data-toggle="modal" data-target="#modal_billing_checkout" class="btn btn-dark-blue btn-lg"><i class="fa fa-shopping-cart mr-2"></i>Checkout</a> -->
          </div>

        </div>


      </div>
    </div>

  </div>
</div>
</div>

<div class="modal fade" id="pre_check_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <!-- <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PRE CHECK FORM (Check Eligibility)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-12">

              <div class="settings">
                <br>

                <form>
                    <h4 style="color: #f1c40f">Customer Requirements</h4>
                    <br>
                  <label id="cb1">
                    <input class="pre_check_inp" type="checkbox" name="" id="test">
                    <span>Are you a Resident in the following countries (link to list of countries)? </span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have a Legal business name?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have a Legal business address?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have Legal contact info?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have a Credit card that can be used overseas & has valid billing address?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have Phone numbers to contact during registration process?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have Tax payment info?</span>
                  </label>
                  <label>
                    <input class="pre_check_inp" type="checkbox">
                    <span>Do you have Additional identification docs (utility bill, credit card, bank statements)?</span>
                  </label>
                 
                 
                 
                </div>
             
             
          </div>
        </div> -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Requirements</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p><strong>All list are required</strong> for you to purchase amazon account.</p>
        <br>
        <ul>
          <li><span>Are you a Resident in the following countries (link to list of countries)? </span></li>
          <li><span>Do you have a Legal business name? </span></li>
          <li><span>Do you have a Legal business address?</span></li>
          <li><span>Do you have Legal contact info?</span></li>
          <li><span>Do you have a Credit card that can be used overseas & has valid billing address?</span></li>
          <li><span>Do you have Phone numbers to contact during registration process?</span></li>
          <li><span>Do you have Tax payment info?</span></li>
          <li><span>Do you have Additional identification docs (utility bill, credit card, bank statements)?</span></li>

        </ul>
        <div class="">
          <!--     <input type="checkbox" class="custom-control-input" id="precheck_terms" name="billing_checkout_terms">
                      <label class="custom-control-label" for="billing_checkout_terms" style="font-weight: normal;"><strong>I fully read and understand. I completed all required on the list.</strong></label> -->
          <input type="checkbox" name="checkbox" id="precheck_terms">
          <label class="" for="billing_checkout_terms" style="font-weight: normal;"><strong>I fully read and understand. I completed all required on the list.</strong></label>
        </div>

      </div>
      <div class="modal-footer" style="text-align: center;">
        <center>
          <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Close</button>
          <button id="pre_check_btn" disabled type="button" class="btn btn-dark-blue btn-lg" onclick="submitPreCheck()">Submit</button>
        </center>

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

</div>
</div>
</div>
<div class="modal fade" id="modal_billing_checkout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Important Notice!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p><strong>Billing Invoice</strong> will be created.</p>
        <p>You need to <strong>pay</strong> it first before creating another invoice.</p>
        <br>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="billing_checkout_terms" name="billing_checkout_terms" value="1">
          <label class="custom-control-label" for="billing_checkout_terms" style="font-weight: normal;"><strong>I fully read and understand.</strong></label>
        </div>

      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" id="" onclick="submit_purchase()" class="btn btn-dark-blue btn-lg">Proceed to Checkout</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<br><br>

<script>
  $(document).ready(function() {
    getRegFee();
  })
</script>