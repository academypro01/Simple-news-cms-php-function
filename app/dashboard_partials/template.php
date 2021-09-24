<?php
pageGuard();
if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = $_POST['frm'];
    $favicon = $_FILES['favicon'];
    $about_image = $_FILES['aboutphoto'];
    editTemplate($inputs, $favicon, $about_image);
}

$template_data = getTemplate();
?>
<div class="col-12 col-sm-12 col-md-12">
  <?php sessionStatus(); ?>
    <h4>Edit Website Template</h4>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Template</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?page=template"); ?>' method='POST' enctype='multipart/form-data'>
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input value="<?php echo $template_data['title']; ?>" type="text" name='frm[title]' class="form-control" id="title" placeholder="Enter website title" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input value="<?php echo $template_data['name']; ?>"  type="text" name='frm[name]' class="form-control" id="name" placeholder="Enter website name" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">website Favicon</label>
                    <img src="../public/<?php echo $template_data['favicon']; ?>" class="img-thumbnail" style="width:150px !important;" alt="...">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="hidden" name="frm[favicon_default]" required value="<?php echo $template_data['favicon']; ?>">
                        <input name='favicon' type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="footer">Footer</label>
                    <textarea name="frm[footer]" id="footer" class='form-control' cols="30" rows="10" placeholder='website footer here...' required><?php echo $template_data['footer']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="about_title">About Title</label>
                    <input value="<?php echo $template_data['about_title']; ?>"  type="text" name='frm[about_title]' class="form-control" id="about_title" placeholder="Enter website about title" required>
                  </div>
                  <div class="form-group">
                    <label for="about_message">About Message</label>
                    <textarea name="frm[about_message]" id="about_message" class='form-control' cols="30" rows="10" placeholder='website about message here...' required><?php echo $template_data['about_message']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">About Image</label>
                    <img src="../public/<?php echo $template_data['about_image']; ?>" class="img-thumbnail" style="width:150px !important;" alt="About Image">
                    <div class="input-group">
                      <div class="custom-file">
                      <input type="hidden" name="frm[about_image_default]" required value="<?php echo $template_data['about_image']; ?>">
                        <input name='aboutphoto' type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button name='btn' type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>