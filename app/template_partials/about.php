<?php
$about_image = str_replace("../",'./',$data['about_image']);
?>
<div class="w3-container w3-padding-32 w3-center">  
    <h3><?php echo $data['about_title']; ?></h3><br>
    <img src="<?php echo $about_image; ?>" alt="<?php echo $data['title']; ?>" class="w3-image" title="<?php echo $data['title']; ?>" style="display:block;margin:auto" width="800" height="533">
    <div class="w3-padding-32">
      <p><?php echo $data['about_message']; ?></p>
    </div>

</div><hr>