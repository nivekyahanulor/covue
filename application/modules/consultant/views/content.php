<div class="row contentIORreg">
    <div class="container">

        <div class="row">

            <div id="IORform" class="col-12">

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo base_url() ?>home/register_user?consultant=<?php echo urlencode(base64_encode($user_id)); ?>" id="myInput">
                            <div class="input-group-append">
                                <button class="btn orange-btn" type="button" onclick="myFunction()"><i class="fa fa-file mr-2" aria-hidden="true"></i>Copy Link</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                        <h6>Welcome, <strong><?php echo $user_details->company_name; ?></strong> (<a href="<?php echo base_url(); ?>consultant/edit-consultant-info" class="dark-blue-link">Edit Profile</a>, <a href="<?php echo base_url(); ?>consultant/logout" class="dark-blue-link">Logout</a>)</h6>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div id="IORguide" class="col-md-4">
                        <?php if ($this->session->flashdata('success') != null) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span><?php echo $this->session->flashdata('success'); ?></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        <?php endif ?>
                        <div class="text-center">
                            <?php if ($user_details->avatar != null) : ?>
                                <img src="<?php echo base_url(); ?>uploads/consultants/<?php echo $user_details->avatar; ?>" class="img-thumbnail" alt="Landing Page Logo" style="background-color: #eaeaea;">
                            <?php else : ?>
                                <img src="<?php echo base_url(); ?>assets/img/logo-here.png" class="img-thumbnail" alt="Landing Page Logo" style="background-color: #eaeaea;">
                            <?php endif ?>
                        </div>
                        <br><br>

                        <a href="#" class="btn btn-block btn-outline-dark-blue" data-toggle="modal" data-target="#squarespaceModal"><i class="fas fa-file-image mr-2"></i>Upload Logo</a>

                        <br><br>


                    </div>
                    <div class="col-md-8 col-12">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/dashboard'; ?>" data-toggle="tooltip" title="Users Referred"><i class="fas fa-users fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/shipping-companies'; ?>" data-toggle="tooltip" title="Shipping Invoices sent"><i class="fas fa-file-invoice-dollar fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/regulated-application'; ?>" data-toggle="tooltip" title="Regulated Application"><i class="fas fa-clipboard-check fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dark-blue-link" href="<?php echo base_url() . 'consultant/pricing-list'; ?>" data-toggle="tooltip" title="IOR Pricing List"><i class="fas fa-search-dollar fa-2x"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo base_url() . 'consultant/content'; ?>" data-toggle="tooltip" title="Landing Page Customization"><span class="dark-blue-title"><i class="fas fa-sitemap fa-2x"></i><span></a>
                            </li>
                        </ul>

                        <div class="card partner-tab">
                            <div class="card-header">
                                <h3 class="card-title"><span class="dark-blue-title">Customize your Landing Page here</span></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <?php if ($this->session->flashdata('success-logo') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-logo'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('success-banner') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-banner'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('success-background') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-background'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('success-content') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-content'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('success-header-color') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-header-color'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('success-footer-color') != null) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <span><?php echo $this->session->flashdata('success-footer-color'); ?></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <!-- <tr>
                                            <td class="text-center"> Landing Page Logo </td>
                                            <td class="text-center">
                                                <?php //if ($user_details->avatar != null) : ?>
                                                    <img width="300px" src="<?php //echo base_url(); ?>uploads/consultants/<?php //echo $user_details->avatar; ?>" class="img-thumbnail" alt="...">
                                                <?php //else : ?>
                                                    <img width="300px" src="<?php //echo base_url(); ?>assets/img/logo-here.png" class="img-thumbnail" alt="...">
                                                <?php //endif ?>
                                            </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#squarespaceModal"> Update </button></td>
                                        </tr> -->
                                        <tr>
                                            <td class="text-center"> Landing Page Header Title </td>
                                            <td class="text-center"> <?php echo $user_details->landing_page_header_title; ?> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateheadertitle"> Update </button></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"> Landing Page Content </td>
                                            <td class="text-center"> <?php echo $user_details->landing_page_content; ?> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updatecontent"> Update </button></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"> Landing Page Banner </td>
                                            <td class="text-center"> <img src="<?php echo base_url() . 'uploads/consultants/' . $user_details->landing_page_banner; ?>" width="300px"> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateBanner"> Update </button></td>

                                        </tr>
                                        <tr>
                                            <td class="text-center"> Landing Page Background </td>
                                            <td class="text-center"> <img src="<?php echo base_url() . 'uploads/consultants/' . $user_details->landing_page_background; ?>" width="300px"> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updatebackground"> Update </button></td>
                                        </tr>

                                        <tr>
                                            <td class="text-center"> Landing Page Header Color </td>
                                            <td class="text-center" style="background:<?php echo $user_details->header_color; ?>;color:#fff;"> <?php echo $user_details->header_color; ?> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateheadercolor"> Update </button></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"> Landing Page Footer Color </td>
                                            <td class="text-center" style="background:<?php echo $user_details->footer_color; ?>;color:#fff;"> <?php echo $user_details->footer_color; ?> </td>
                                            <td class="text-center"> <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#updatefootercolor"> Update </button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<!--- FOR BANNER -->
<div class="modal fade" id="updateBanner" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Update Banner</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Banner (min. of 600x400):</strong></label>
                        <div class="input-group">
                            <div class="custom-file <?php if (form_error('banner')) {
                                                        echo 'is_invalid';
                                                    } ?>" logo="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" name="banner" value="<?php echo set_value('banner'); ?>" required>
                                <label class="custom-file-label" for="fosr">Click to upload</label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updatebanner" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END BANNER -->
<!--- FOR BACKGROUND -->
<div class="modal fade" id="updatebackground" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Update Background</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Background (min. of 1920x1080):</strong></label>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updatebackground" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END BACKGROUND -->
<!--- FOR CONTENT -->
<div class="modal fade" id="updatecontent" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Update Content</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Content:</strong></label>
                        <div class="input-group">
                            <textarea id="landing-page-content" class="form-control" name="content"><?php echo $user_details->landing_page_content; ?></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updatecontent" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END BACKGROUND -->
<!--- FOR CONTENT -->
<div class="modal fade" id="updateheadertitle" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Update Header Title</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Header Title:</strong></label>
                        <div class="input-group">
                            <input value="<?php echo $user_details->landing_page_header_title; ?>" type="text" id="landing-page-headertitle" class="form-control" name="header_title"></input>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updateheadertitle" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END BACKGROUND -->
<!--- FOR HEADER COLOR -->
<div class="modal fade" id="updateheadercolor" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Header Color </h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Header Color:</strong></label>
                        <div class="input-group">
                            <input type="color" class="form-control" name="header" value="<?php echo $user_details->header_color; ?>">
                        </div>
                    </div>

                    <div class="text-center form-group">
                        -- OR --
                    </div>

                    <div class="form-group">
                        <label for="logo"><strong>Enter a Color (HEX value):</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="header_color" placeholder="#000000">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updateheadercolor" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END HEADER COLOR -->
<!--- FOR FOOTER COLOR -->
<div class="modal fade" id="updatefootercolor" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Footer Color </h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Landing Page Footer Color:</strong></label>
                        <div class="input-group">
                            <input type="color" class="form-control" name="footer" value="<?php echo $user_details->footer_color; ?>">
                        </div>
                    </div>

                    <div class="text-center form-group">
                        -- OR --
                    </div>

                    <div class="form-group">
                        <label for="logo"><strong>Enter a Color (HEX value):</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="footer_color" placeholder="#000000">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="updatefootercolor" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END FOOTER COLOR -->

<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Upload Logo</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="logo"><strong>Company Logo:</strong></label>
                        <div class="input-group">
                            <div class="custom-file <?php if (form_error('logo')) {
                                                        echo 'is_invalid';
                                                    } ?>" logo="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" name="image" value="<?php echo set_value('logo'); ?>" required>
                                <label class="custom-file-label" for="fosr">Click to upload</label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-outline-dark-blue" data-dismiss="modal" role="button">Close</button>
                <button type="submit" name="uploadlogo" class="btn btn-default btn-hover-green btn-dark-blue" data-action="save" role="button">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#landing-page-content').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
            ],
            height: 250,
            width: 1200,
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