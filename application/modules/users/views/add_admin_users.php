<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New Admin User</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>product-registrations">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>users/admin-users">Admin Users</a></li>
            <li class="breadcrumb-item active">Add New Admin User</li>
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
                        Successfully Added New Admin User!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>

                    <?php else : ?>

                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Some Errors Found. Please contact your administrator.
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

                  <form action="" method="POST" id="add_admin_users" role="form">

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control <?php if (form_error('username')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" class="form-control <?php if (form_error('password')) {
                                                                        echo 'is_invalid';
                                                                      } ?>" id="password" name="password" placeholder="Password">
                          <span toggle="#password" class="fas fa-eye field-icon toggle-password"></span>
                        </div>
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="contact_person">Name</label>
                          <input type="text" class="form-control <?php if (form_error('contact_person')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="contact_person" name="contact_person" placeholder="Name" value="<?php echo set_value('contact_person'); ?>">
                        </div>
                      </div>

                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control <?php if (form_error('email')) {
                                                                    echo 'is_invalid';
                                                                  } ?>" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="department">Department</label>
                          <select class="form-control <?php if (form_error('department')) {
                                                        echo 'is_invalid';
                                                      } ?>" id="department" name="department">
                            <option value=""> - Select Department - </option>
                            <?php foreach ($department as $val) { ?>
                              <option value="<?php echo $val->department_id; ?>"> <?php echo $val->department_name; ?> </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="department_head">Department Head</label>
                          <select class="form-control" id="department_head" name="department_head">
                            <option value="0">Not Applicable</option>
                            <?php foreach ($users as $val) {
                              if ($val->contact_person != 'Administrator' && $val->contact_person != 'IOR Japan') {
                            ?>
                                <option value="<?php echo $val->user_id; ?>"> <?php echo $val->contact_person; ?> </option>
                            <?php }
                            } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="user_level"> User Access Level </label>
                          <select class="form-control <?php if (form_error('user_level')) {
                                                        echo 'is_invalid';
                                                      } ?>" id="user_level" name="user_level">
                            <option value=""> - Select User Level - </option>
                            <option value="1"> Administrator </option>
                            <option value="2"> Manager </option>
                            <option value="3"> Staff </option>
                          </select>
                        </div>
                      </div>

                    </div>

                    <div class="row justify-content-end">

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <button type="submit" name="submit" class="btn btn-block btn-success"><i class="fas fa-save mr-2"></i>Submit</button>
                        </div>
                      </div>

                      <div class="col-md-2 col-12">
                        <div class="form-group">
                          <a href="<?php echo base_url(); ?>users/admin-users" class="btn btn-block btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back</a>
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