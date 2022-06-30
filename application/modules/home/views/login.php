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

                <?php if ($this->session->flashdata('success') != null) : ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle mr-2"></i>Registration Success!</h4>
                        <hr>
                        <p class="mb-0"><?php echo $this->session->flashdata('success'); ?></p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endif ?>

                <?php if (isset($_GET['error'])) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Login Failed!</h4>
                        <hr>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p class="mb-0">Username and/or Password do not match.</p>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('noaccess') != null) : ?>

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Access Denied!</h4>
                        <hr>
                        <p class="mb-0"><?php echo $this->session->flashdata('noaccess'); ?></p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                <?php endif ?>

                <h4 class="dark-blue-title text-center">Covue IOR Online Login</h4>

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
                                <button type="submit" name="submit" class="btn btn-block btn-dark-blue"><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login</button>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group text-center">
                                Don't have an account? <a href="<?php echo base_url(); ?>home/signup" class="dark-blue-link">Sign Up</a>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group text-center">
                                <a href="<?php echo base_url(); ?>home/forgot-password" class="dark-blue-link">Forgot your password?</a>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>