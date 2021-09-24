<?php
pageGuard();

if(isset($_GET['user_id'])) {
    $user_id = filter_var($_GET['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $result = showSingleUser($user_id);
}

if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = $_POST['frm'];
    $photo = $_FILES['user_photo'];
    updateSingleUser($inputs, $photo, $user_id);
}
?>
<div class="col-12 col-sm-12 col-md-12">
    <h4>Edit User: <?php echo $result['username']; ?></h4>
    <?php sessionStatus(); ?>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?page=userEdit&user_id=".$user_id); ?>' method='POST' enctype='multipart/form-data'>
                <div class="card-body">
                  <div class="form-group">
                    <label for="firstname">firstname</label>
                    <input value="<?php echo $result['firstname']; ?>" type="text" name='frm[firstname]' class="form-control" id="firstname" placeholder="Enter website firstname" required>
                  </div>
                  <div class="form-group">
                    <label for="lastname">lastname</label>
                    <input value="<?php echo $result['lastname']; ?>"  type="text" name='frm[lastname]' class="form-control" id="lastname" placeholder="Enter website lastname" required>
                  </div>
                  <div class="form-group">
                    <label for="username">username</label>
                    <input disabled value="<?php echo $result['username']; ?>"  type="text" name='frm[username]' class="form-control" id="username" placeholder="Enter website username" required>
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input disabled value="<?php echo $result['email']; ?>"  type="text" name='frm[email]' class="form-control" id="email" placeholder="Enter website email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name='frm[password]' class="form-control" id="password" placeholder="Enter password">
                  </div>
                  <div class="form-group">
                    <label for="confirm_password">confirm password</label>
                    <input type="password" name='frm[repeat_password]' class="form-control" id="confirm_password" placeholder="Enter confirm password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">user photo</label>
                    <img src="../public/<?php echo ($result['photo'] != NULL) ? $result['photo'] : '../public/images/default_user_profile.png'; ?>" class="img-thumbnail" style="width:150px !important;" alt="About Image">
                    <div class="input-group">
                      <div class="custom-file">
                      <input type="hidden" name="frm[user_photo_default]" required value="<?php echo $result['photo']; ?>">
                        <input name='user_photo' type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>

                <div class="custom-control custom-checkbox">
                    <input name='frm[isAdmin]' class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" <?php echo ($result['isAdmin'] == '1') ? 'checked' : ''; ?>>
                    <label for="customCheckbox1" class="custom-control-label">Admin Access</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input name='frm[isActive]' class="custom-control-input" type="checkbox" id="customCheckbox2" value="1" <?php echo ($result['isActive'] == '1') ? 'checked' : ''; ?>>
                    <label for="customCheckbox2" class="custom-control-label">Active User</label>
                </div>
                
            
                <div class="card-footer">
                  <button name='btn' type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>