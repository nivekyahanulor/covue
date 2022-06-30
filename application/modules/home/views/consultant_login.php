<div class="row contentIORreg">
    <div class="container">

        <br>

        <div class="row">
            <div class="col-md-12 col-12">
                <a href="<?php echo base_url() ?>home" class="dark-blue-link"><i class="fas fa-arrow-left mr-2"></i>Back to Homepage</a>
            </div>
        </div>

        <div class="row">
            <div id="IORform" class="col-md-6 offset-md-3">

                <br>

                <?php if ($this->session->flashdata('success') != null) : ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span><?php echo $this->session->flashdata('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endif ?>

                <?php if (isset($_GET['loginattempt'])) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Username and Password doesn't match or doesn't exist.
                    </div>
                <?php endif; ?>

                <h4 class="orange-title text-center">Consultant Partner Login</h4>

                <br>

                <form action="" method="POST" id="login" role="form">

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="username"><strong>Username:</strong></label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="company_name"><strong>Password:</strong></label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-block orange-btn"><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login</button>
                            </div>
                        </div>
						<div class="col-12">
                            <div class="form-group text-center">
                                Don't have an account? <a href="<?php echo base_url(); ?>home/consultant-signup" class="dark-blue-link-o">Sign Up</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group text-center">
                                <a href="<?php echo base_url(); ?>home/consultant-forgot-password" class="orange-link">Forgot your password?</a>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>