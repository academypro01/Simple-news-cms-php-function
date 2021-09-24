<?php
if($badPageCounter) {
  echo '<div class="alert alert-danger" role="alert">
    Not Valid Page Number!, you redirect to page 1 <b>after 5</b> seconds!
  </div>';
    header("refresh:5;url=index.php",true,303);die;
}
?>
<div class="container">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php
    while($news = mysqli_fetch_assoc($allNews[0])):
    $news_image = str_replace("../",'./',$news['image']);
    ?>
       <div class="card">
        <div class="card-image-wrapper">
          <img style="width:470px;height:350px;" src="<?php echo $news_image;?>" class="card-img-top img-fluid" alt="...">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $news['title']; ?></h5>
          <p class="card-text"><?php echo  mb_strimwidth($news['content'],0,200,'...') ?></p>
          <a href="index.php?page=showNews&news_id=<?php echo $news['id']; ?>" class="btn btn-primary">Read more</a>
        </div>
      </div>
    <?php
    endwhile;
    ?>
  </div>
  </div>

  <!-- Pagination -->
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="index.php?page=index&count=<?php echo $prev; ?>" class="w3-bar-item w3-button w3-hover-black" <?php echo ($prev < 1) ? 'hidden' : "";  ?>>«</a>
      
      
      <?php
      for($i=1; $i<=$allNews[2]; $i++):
      ?>
      <a href="index.php?page=index&count=<?php echo $i; ?>" class="w3-bar-item w3-black w3-button"><?php echo $i; ?></a>
      <?php
      endfor;
      ?>
      <a href="index.php?page=index&count=<?php echo $next; ?>" class="w3-bar-item w3-button w3-hover-black" <?php 
                            if($count >= $allNews[2]) {
                                echo 'hidden';
                            }
                            ?>>»</a>
    </div>
  </div>