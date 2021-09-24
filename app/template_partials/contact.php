<?php
if(isset($_POST['contact_btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['frm'];
    contacts($data);
}
?>
<div class="card card-info">
<?php sessionStatus(); ?>
              <div class="card-header bg-dark text-light">
                <h3 class="card-title">Contact Us Form</h3>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method='POST' action="<?php echo $_SERVER['PHP_SELF']."?page=contact"; ?>">
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-sm-10 mx-auto">
                      <input type="email" name='frm[email]' class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-10 mx-auto">
                      <textarea placeholder='type your message here...' name="frm[message]" class='form-control' id="" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-sm-10 mx-auto">
                      <input name='contact_btn' type="submit" value="Send" class='btn btn-dark form-control'>
                      </div>
                  </div>
                </div>
              </form>
            </div>