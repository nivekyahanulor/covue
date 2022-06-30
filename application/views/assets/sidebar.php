<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: rgba(0,0,0,.5);"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url(); ?>users/notice-addendum" class="nav-link">Update Notice and Addendum</a>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> -->
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

    <li class="nav-item">
      <a href="<?php echo base_url() ?>users/logout" id="logout">Logout</a>
    </li>

  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url(); ?>product-registrations/pending" class="brand-link">
    <img src="<?php echo base_url(); ?>assets/img/admin_logo.png" alt="Covue IOR Online Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Covue IOR Online</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url(); ?>dist/img/admin.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <span class="d-block" style="color: #fff !important;"><?php echo $this->session->userdata('contact_person'); ?></span>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <!-- <li class="nav-item">
          <a href="<?php //echo base_url() 
                    ?>dashboard" class="nav-link <?php //echo ($active_page == 'dashboard') ? 'active' : ''; 
                                                  ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li> -->
        <?php if ($this->session->userdata('user_id') == 1) : ?>
          <li class="nav-item">
            <a href="<?php echo base_url() ?>users/admin-users" class="nav-link <?php echo ($active_page == 'users/admin_users') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Admin Users
              </p>
            </a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>users/consultant-listing" class="nav-link <?php echo ($active_page == 'users/consultant_listing') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-handshake"></i>
            <p>
              Amazon Consultants
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>billing-invoices" class="nav-link <?php echo ($active_page == 'billing_invoices') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-receipt"></i>
            <p>
              Billing Invoices
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>ingredients/list" class="nav-link <?php echo ($active_page == 'ingredients') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-vial"></i>
            <p>
              Ingredients List
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>knowledgebase" class="nav-link <?php echo ($active_page == 'knowledgebase') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Knowledgebase
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>regulated-applications" class="nav-link <?php echo ($active_page == 'regulated_applications') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
              Regulated Applications
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview <?php echo ($active_page == 'product_registrations') ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo ($active_page == 'product_registrations') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>
              Product Registrations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations" class="nav-link <?php echo ($active_url == 'product_registrations') ? 'active' : ''; ?>" class="nav-link">
                <i class="far fa-circle nav-icon text-default"></i>
                <p>All</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/approved" class="nav-link <?php echo ($active_url == 'product_registrations/approved') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-success"></i>
                <p>Approved</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/declined" class="nav-link <?php echo ($active_url == 'product_registrations/declined') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-danger"></i>
                <p>Declined</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/revisions" class="nav-link <?php echo ($active_url == 'product_registrations/revisions') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-warning"></i>
                <p>Needs Revision</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/pending" class="nav-link <?php echo ($active_url == 'product_registrations/pending') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-secondary"></i>
                <p>Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/updated" class="nav-link <?php echo ($active_url == 'product_registrations/updated') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-primary"></i>
                <p>Recently Updated</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-registrations/mailing-products" class="nav-link <?php echo ($active_url == 'product_registrations/mailing_products') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Mailing Products</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>product-registrations/product-labels" class="nav-link <?php echo ($active_page == 'product_registrations/product_labels') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>
              Product Labels
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview <?php echo ($active_page == 'product_sampling') ? 'menu-open' : ''; ?>"">
          <a href=" #" class="nav-link <?php echo ($active_page == 'product_sampling') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-box"></i>
          <p>
            Product Sampling
            <i class="right fas fa-angle-left"></i>
          </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling" class="nav-link <?php echo ($active_url == 'product_sampling') ? 'active' : ''; ?>" class="nav-link">
                <i class="far fa-circle nav-icon text-default"></i>
                <p>All</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling/draft" class="nav-link <?php echo ($active_url == 'product_sampling/draft') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-danger"></i>
                <p>Draft</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling/pending" class="nav-link <?php echo ($active_url == 'product_sampling/pending') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-secondary"></i>
                <p>Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling/accepted" class="nav-link <?php echo ($active_url == 'product_sampling/accepted') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-primary"></i>
                <p>Accepted</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling/revisions" class="nav-link <?php echo ($active_url == 'product_sampling/revisions') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-warning"></i>
                <p>Needs Revision</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>product-sampling/updated" class="nav-link <?php echo ($active_url == 'product_sampling/updated') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Recently Updated</p>
              </a>
            </li>

          </ul>
        </li>

        <?php if ($this->session->userdata('user_id') == 1) : ?>
          <li class="nav-item">
            <!--  has-treeview <?php //echo ($active_page == 'shipping_details') ? 'menu-open' : ''; 
                                ?>" -->
            <a href="<?php echo base_url() ?>shipping-details" class="nav-link <?php echo ($active_page == 'shipping_details') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>
                Shipping Details
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
            <!-- <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details" class="nav-link <?php //echo ($active_url == 'shipping_details') ? 'active' : ''; 
                                                                                      ?>" class="nav-link">
                  <i class="far fa-circle nav-icon text-default"></i>
                  <p>All</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details/pending" class="nav-link <?php //echo ($active_url == 'shipping_details/pending') ? 'active' : ''; 
                                                                                              ?>">
                  <i class="far fa-circle nav-icon text-secondary"></i>
                  <p>Pending</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details/accepted" class="nav-link <?php //echo ($active_url == 'shipping_details/accepted') ? 'active' : ''; 
                                                                                              ?>">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p>Accepted/Paid</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details/revisions" class="nav-link <?php //echo ($active_url == 'shipping_details/revisions') ? 'active' : ''; 
                                                                                                ?>">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Needs Revision</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details/updated" class="nav-link <?php //echo ($active_url == 'shipping_details/updated') ? 'active' : ''; 
                                                                                              ?>">
                  <i class="far fa-circle nav-icon text-primary"></i>
                  <p>Updated</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php //echo base_url() 
                          ?>shipping-details/completed" class="nav-link <?php //echo ($active_url == 'shipping_details/completed') ? 'active' : ''; 
                                                                                                ?>">
                  <i class="far fa-circle nav-icon text-success"></i>
                  <p>Completed</p>
                </a>
              </li>
            </ul> -->
          </li>
        <?php endif; ?>

        <li class="nav-item has-treeview <?php echo ($active_page == 'shipping_invoices') ? 'menu-open' : ''; ?>"">
          <a href=" #" class="nav-link <?php echo ($active_page == 'shipping_invoices') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-file-invoice-dollar"></i>
          <p>
            Shipping Invoices
            <i class="right fas fa-angle-left"></i>
          </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices" class="nav-link <?php echo ($active_url == 'shipping_invoices') ? 'active' : ''; ?>" class="nav-link">
                <i class="far fa-circle nav-icon text-default"></i>
                <p>All</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/draft" class="nav-link <?php echo ($active_url == 'shipping_invoices/draft') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-danger"></i>
                <p>Draft</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/pending" class="nav-link <?php echo ($active_url == 'shipping_invoices/pending') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-secondary"></i>
                <p>Pending</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/accepted" class="nav-link <?php echo ($active_url == 'shipping_invoices/accepted') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-primary"></i>
                <p>Accepted / Paid</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/revisions" class="nav-link <?php echo ($active_url == 'shipping_invoices/revisions') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-warning"></i>
                <p>Needs Revision</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/updated" class="nav-link <?php echo ($active_url == 'shipping_invoices/updated') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Recently Updated</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url() ?>shipping-invoices/completed" class="nav-link <?php echo ($active_url == 'shipping_invoices/completed') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon text-success"></i>
                <p>Completed</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>shipping-companies" class="nav-link <?php echo ($active_page == 'shipping_companies') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-truck-loading"></i>
            <p>
              Shipping Companies
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>helpful-links" class="nav-link <?php echo ($active_page == 'helpful_links') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>
              Helpful Links
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url() ?>users/listing" class="nav-link <?php echo ($active_page == 'users/listing') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>