<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                <span class="dropdown-header">Status Notifications</span>
                <div class="dropdown-divider"></div>
                <div class="regulated-status"><a class="dropdown-item" id="no_new_notif" style="cursor: pointer;"><i class="fas fa-bell-slash mr-2"></i>No New Notifications</a></div>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown">
                <i class="far fa-user mr-2"></i>
                <?php echo $user_details->contact_person; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                <span class="dropdown-header">Profile</span>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url() .'japan-ior/edit-profile/'. $user_details->id; ?>" class="dropdown-item"><i class="fas fa-user-edit mr-2"></i>Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url(); ?>japan-ior/logout" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside id="japan_ior_sidebar" class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>japan-ior/dashboard" class="brand-link mb-5">
        <img src="<?php echo base_url(); ?>assets/img/covue_logo.png" alt="Covue IOR Online Logo" class="brand-image">
        <!-- <span class="brand-text font-weight-light">Covue Online</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/dashboard" class="nav-link <?php echo ($active_page == 'japan-ior/dashboard') ? 'active' : '';
                                                                                            ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url() . 'japan-ior/edit-profile/' . $this->session->userdata('user_id'); ?>" class="nav-link <?php echo ($active_page == 'user_profile') ? 'active' : '';
                                                                                                                                            ?>">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            User Profile
                        </p>
                    </a>
                </li>
                <?php if($user_details->user_role_id == 2): ?>
                <li class="nav-item">
                    <a href="https://www.covue.com/product-eligibility/" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p>
                            Product Eligibility
                        </p>
                    </a>
                </li>
                 <?php endif ?>
                <li class="nav-item has-treeview <?php echo ($active_page == 'product_registrations') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo ($active_page == 'product_registrations') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Product Registrations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>japan-ior/products-list" class="nav-link <?php echo ($active_url == 'japan-ior/products-list') ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon text-secondary"></i>
                                <p>Products List</p>
                            </a>
                        </li>
                        <?php if($user_details->user_role_id == 2): ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>japan-ior/product-labels" class="nav-link <?php echo ($active_url == 'japan-ior/product-labels') ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon text-secondary"></i>
                                <p>Product Labels List</p>
                            </a>
                        </li>
                        <?php endif ?>
                        <?php
                        if ($user_details->ior_registered == 1) {
                            if ($user_details->user_id >= 106 || $user_details->user_id == 7 || $user_details->user_id == 65 || $user_details->user_id == 67 || $user_details->user_id == 68 || $user_details->user_id == 74 || $user_details->user_id == 77 || $user_details->user_id == 78 || $user_details->user_id == 80 || $user_details->user_id == 81 || $user_details->user_id == 82 || $user_details->user_id == 85 || $user_details->user_id == 90 || $user_details->user_id == 91 || $user_details->user_id == 93 || $user_details->user_id == 95 || $user_details->user_id == 96 || $user_details->user_id == 98 || $user_details->user_id == 99 || $user_details->user_id == 100 || $user_details->user_id == 103) {
                        ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url() ?>japan-ior/product-registrations" class="nav-link <?php echo ($active_url == 'japan-ior/product-registrations') ? 'active' : ''; ?> " class="nav-link">
                                        <i class="far fa-circle nav-icon text-secondary"></i>
                                        <p>Add New Product</p>
                                    </a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url() ?>japan-ior/product-registration" class="nav-link <?php echo ($active_url == 'japan-ior/product-registration') ? 'active' : ''; ?> '" class="nav-link">
                                        <i class="far fa-circle nav-icon text-secondary"></i>
                                        <p>Add New Product</p>
                                    </a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/shipping-invoices" class="nav-link <?php echo ($active_page == 'shipping_invoices') ? 'active' : '';
                                                                                                    ?>">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Shipping Invoices
                        </p>
                    </a>
                </li>
                <?php if($user_details->user_role_id == 2): ?>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/regulated-applications" class="nav-link <?php echo ($active_page == 'regulated_applications') ? 'active' : '';
                                                                                                                    ?>">
                        <i class="nav-icon fas fa-gavel"></i>
                        <p>
                            Regulated Applications
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/import-logistics" class="nav-link <?php echo ($active_page == 'import_logistics') ? 'active' : '';
                                                                                                                    ?>">
                        <i class="nav-icon fas fa-file-import"></i>
                        <p>
                            Import Logistics
                        </p>
                    </a>
                </li>
                <?php endif ?>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/billing-invoices" class="nav-link <?php echo ($active_page == 'billing_invoices') ? 'active' : '';
                                                                                                    ?>">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Billing Invoices
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/helpful-links" class="nav-link <?php echo ($active_page == 'helpful_links') ? 'active' : '';
                                                                                                ?>">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            Helpful Links
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>japan-ior/terms-agreement" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Terms and Conditions
                        </p>
                    </a>
                </li>
            </ul>

            <br>

            <!-- <p class="text-center"><a href="<?php //echo base_url(); 
                                                    ?>home/dashboard" class="dark-yellow-link-sidebar">
                    << BACK to COVUE Online</a>
            </p> -->
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>