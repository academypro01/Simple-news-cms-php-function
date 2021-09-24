<?php
checkToken();

if(isset($_POST['btn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = $_POST['frm'];
    $photo = $_FILES['news_photo'];
    addNews($inputs, $photo);
}
?>
<div class="col-12 col-sm-12 col-md-12">
    <h4>Add News</h4>
    <?php sessionStatus(); ?>
<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add News</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']."?page=newsCreate"); ?>' method='POST' enctype='multipart/form-data'>
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input require type="text" name='frm[title]' class="form-control" id="title" placeholder="Enter title" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="frm[content]" class='form-control' id="content" cols="30" rows="10" required placeholder='type your news...'></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputFile">News Photo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input required name='news_photo' type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <?php
                    if(isAdmin()):
                  ?>
                <div class="custom-control custom-checkbox">
                    <input name='frm[isActive]' class="custom-control-input" type="checkbox" id="customCheckbox2" value="1">
                    <label for="customCheckbox2" class="custom-control-label">Active News</label>
                </div>
                <?php
                endif;
                ?>
            
                <div class="card-footer">
                  <button name='btn' type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            </div>