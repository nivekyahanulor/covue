<div class="row contentIORreg mb-5">
    <div class="container">

        <br>

        <div class="row">
            <div class="col-md-12 col-12">
                <a href="<?php echo base_url() ?>home/login" class="dark-blue-link"><i class="fas fa-arrow-left mr-2"></i>Back to Login</a>
            </div>
        </div>

        <div class="row">
            <div id="IORform" class="col-md-6 offset-md-3">

                <br>

                <?php if (isset($errors)) : ?>

                    <?php if ($errors == 0) : ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Successfully sent login credentials!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php else : ?>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email address is not found.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                    <?php endif ?>

                <?php endif ?>

                <h4 class="dark-blue-title text-center">Forgot Password</h4>

                <br>

                <form action="" method="POST" id="forgot_password" role="form">

                    <div class="form-group">
                        <label for="email"><strong>Email address:</strong></label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email address">
                    </div>

                    <button type="submit" name="submit" class="btn btn-block btn-outline-dark-blue"><i class="fas fa-lock mr-2"></i>Send Password</button>
                </form>

            </div>
        </div>
    </div>
</div>