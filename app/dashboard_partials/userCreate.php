<?php
pageGuard();
if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = $_POST['frm'];
    $photo  = $_FILES['user_photo'];
    createUser($inputs, $photo);
}
?>
<div class="col-12 col-sm-12 col-md-12">
    <h4>Create new User</h4>
    <?php sessionStatus(); ?>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">create new user</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?page=userCreate"); ?>' method='POST' enctype='multipart/form-data'>
                <div class="card-body">
                  <div class="form-group">
                    <label for="firstname">firstname</label>
                    <input type="text" name='frm[firstname]' class="form-control" id="firstname" placeholder="Enter website firstname" required>
                  </div>
                  <div class="form-group">
                    <label for="lastname">lastname</label>
                    <input type="text" name='frm[lastname]' class="form-control" id="lastname" placeholder="Enter website lastname" required>
                  </div>
                  <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name='frm[username]' class="form-control" id="username" placeholder="Enter website username" required>
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name='frm[email]' class="form-control" id="email" placeholder="Enter website email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name='frm[password]' class="form-control" id="password" placeholder="Enter password" required>
                  </div>
                  <div class="form-group">
                    <label for="confirm_password">confirm password</label>
                    <input type="password" name='frm[repeat_password]' class="form-control" id="confirm_password" placeholder="Enter confirm password" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">user photo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input required name='user_photo' type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="custom-control custom-checkbox">
                    <input name='frm[isAdmin]' class="custom-control-input" type="checkbox" id="customCheckbox1" value="1">
                    <label for="customCheckbox1" class="custom-control-label">Admin Access</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input name='frm[isActive]' checked class="custom-control-input" type="checkbox" id="customCheckbox2" value="1">
                    <label for="customCheckbox2" class="custom-control-label">Active User</label>
                </div>
                
            
                <div class="card-footer">
                  <button name='btn' type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>