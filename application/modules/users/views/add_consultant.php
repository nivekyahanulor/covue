<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Consultant</a></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>users/consultant-listing">Consultant Users</a></li>
                        <li class="breadcrumb-item active">Add New Consultant</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
              <h3 class="card-title">Product Qualification List</h3>
            </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row">

                                <div id="IORform" class="col-md-12">

                                    <?php if (isset($errors)) : ?>

                                        <?php if ($errors == 0) : ?>

                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Successfully Registered New User!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        <?php elseif ($errors == 2) : ?>

                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Email Address Already Registered!
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php else : ?>

                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                Some Errors Found. Please contact administrator.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                        <?php endif ?>

                                    <?php endif ?>

                                    <?php if (!empty(validation_errors())) : ?>

                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <h4 class="alert-heading">Form not yet submitted!</h4>

                                            <hr>

                                            <p class="mb-0"><?php echo validation_errors(); ?></p>

                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <?php endif ?>

                                    <form action="" method="POST" id="signup" role="form" enctype="multipart/form-data">

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="username">Username:</label>
                                                    <input type="text" class="form-control <?php if (form_error('username')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Password:</label>
                                                    <input type="password" class="form-control <?php if (form_error('password')) {
                                                                                                    echo 'is_invalid';
                                                                                                } ?>" id="password" name="password" placeholder="Password">
                                                    <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="company_name">Legal Company Name:</label>
                                                    <input type="text" class="form-control <?php if (form_error('company_name')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo set_value('company_name'); ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="contact_person">Primary Contact Person:</label>
                                                    <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo set_value('contact_person'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control <?php if (form_error('email')) {
                                                                                                echo 'is_invalid';
                                                                                            } ?>" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                                                </div>
                                            </div>





                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country">Country:</label>
                                                    <select class="select2 form-control <?php if (form_error('country')) {
                                                                                            echo 'is_invalid';
                                                                                        } ?>" id="country" name="country" style="width: 100%;">
                                                        <option value="" selected>- Select Country -</option>
                                                        <?php
                                                        foreach ($countries as $row) {
                                                            echo '<option value="' . $row->id . '">' . $row->nicename . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <script>
                                                        $('select#country').val('<?php echo $this->input->post('country'); ?>').trigger('change');
                                                    </script>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Company Logo:</label>
                                                    <div class="input-group">
                                                        <div class="custom-file <?php if (form_error('logo')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>" logo="border-radius: .25rem;">
                                                            <input type="file" class="custom-file-input" id="fosr" name="logo" value="<?php echo set_value('logo'); ?>" required>
                                                            <label class="custom-file-label" for="fosr">Click to upload</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Landing Page Header Title:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="landing-page-header-title" class="form-control <?php if (form_error('header_title')) {
                                                                                                                                    echo 'is_invalid';
                                                                                                                                } ?>" maxlength="1000" name="header_title" placeholder="Landing Page Header Title" value="<?php echo set_value('header_title'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Landing Page Content:
                                                        <div id="content_count" class="text-center"></div>
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea id="landing-page-content" class=" form-control" maxlength="1000" name="content" <?php if (form_error('content')) {
                                                                                                                                                        echo 'is_invalid';
                                                                                                                                                    } ?>><?php echo set_value('content'); ?></textarea>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Landing Page Banner (min. of 600x400):</label>
                                                    <div class="input-group">
                                                        <div class="custom-file <?php if (form_error('banner')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>" logo="border-radius: .25rem;">
                                                            <input type="file" class="custom-file-input" id="fosr" name="banner" value="<?php echo set_value('banner'); ?>" required>
                                                            <label class="custom-file-label" for="fosr">Click to upload</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Form Background Image (min. of 1920x1080):</label>
                                                    <div class="input-group">
                                                        <div class="custom-file <?php if (form_error('background')) {
                                                                                    echo 'is_invalid';
                                                                                } ?>" logo="border-radius: .25rem;">
                                                            <input type="file" class="custom-file-input" name="background" value="<?php echo set_value('background'); ?>" required>
                                                            <label class="custom-file-label" for="fosr">Click to upload</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">


                                            <div class="col-md-6 col-12">
                                                <div class="form-group ">
                                                    <label for="logo">Header Color :</label>
                                                    <div class="input-group">
                                                        <input type="color" value="#012d60" class="form-control" name="header">
                                                        <span class="input-group-text" style="background:none; border:0;"> OR </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group ">
                                                    <label for="logo">Enter a Color (HEX value):</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="header_color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" placeholder="#000000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Footer Color :</label>
                                                    <div class="input-group">
                                                        <input type="color" value="#012d60" class="form-control" name="footer">
                                                        <span class="input-group-text" style="background:none; border:0;"> OR </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo">Enter a Color (HEX value):</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="footer_color" pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" placeholder="#000000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row justify-content-end">

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" id="btnSignUp" class="btn btn-block btn-success"><i class="fas fa-save mr-2"></i>Submit</button>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url(); ?>users/consultant-listing" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        $('#landing-page-content').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
            ],
            height: 250,
            width: '100%',
            placeholder: 'Place your content here ...',
            callbacks: {
                onKeydown: function(e) {
                    var t = e.currentTarget.innerText;
                    if (t.trim().length >= 1000) {
                        //delete keys, arrow keys, copy, cut, select all
                        if (e.keyCode != 8 && !(e.keyCode >= 37 && e.keyCode <= 40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey) && !(e.keyCode == 65 && e.ctrlKey))
                            e.preventDefault();
                    }
                },
                onKeyup: function(e) {
                    var t = e.currentTarget.innerText;
                    var cnt = 1000 - t.trim().length;
                    $('#content_count').text("(" + cnt + " characters remaining)");
                },
                onPaste: function(e) {
                    var t = e.currentTarget.innerText;
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    var maxPaste = bufferText.length;
                    if (t.length + bufferText.length > 1000) {
                        maxPaste = 1000 - t.length;
                    }
                    if (maxPaste > 0) {
                        document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                    }
                    var count_content = 1000 - t.length;
                    $('#content_count').text("(" + count_content + " characters remaining)");
                }
            }
        });
    });
</script>