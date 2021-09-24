<?php
include_once 'app/frontend_require.php';
$badPageCounter = false;
$data = getTemplateData();
$validTotalPage = getTotalPage(9);
if(isset($_GET['count']) && filter_var($_GET['count'], FILTER_VALIDATE_INT)) {
  $count = abs(filter_var($_GET['count'], FILTER_SANITIZE_NUMBER_INT));
  if($_GET['count'] > $validTotalPage){
    $badPageCounter = true;
  }
}else{
  $count = 1;
}
$prev = $count-1;
$next = $count+1;
$allNews = getNews($count);
?>
<!DOCTYPE html>
<html>
<title>Home Page | <?php echo $data['title']; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="public/css/w3.css">
 <!-- Font Icon -->
 <link rel="stylesheet" href="public/css/material-design-iconic-font.min.css">
<link rel="shortcut icon" href="<?php echo str_replace("../",'./',$data['favicon']);  ?>" type="image/png">
<!-- Main css -->
<link rel="stylesheet" href="public/css/style.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Arial", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<body>

<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()"
  class="w3-bar-item w3-button">Close Menu</a>
  <a href="index.php?page=index" onclick="w3_close()" class="w3-bar-item w3-button">Home</a>
  <a href="index.php?page=about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
  <?php
    if(checkToken()) {
      echo '<a href="./dashboard/index.php" onclick="w3_close()" class="w3-bar-item w3-button">Dashboard</a>
      <a href="./dashboard/logout.php" onclick="w3_close()" class="w3-bar-item w3-button">Logout</a>';
    }else{
      echo '<a href="index.php?page=register" onclick="w3_close()" class="w3-bar-item w3-button">Register</a>
      <a href="index.php?page=login" onclick="w3_close()" class="w3-bar-item w3-button">Login</a>';
    }
  ?>
  
</nav>

<!-- Top menu -->
<div class="w3-top">
  <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
    <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
    <div class="w3-right w3-padding-16"><a href="index.php?page=contact" style='color:black;text-decoration:none;'>Contact</a></div>
    <div class="w3-center w3-padding-16"><?php echo $data['name']; ?></div>
  </div>
</div>
  
<!-- !PAGE CONTENT! -->
<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

  <!-- First Photo Grid-->
  <?php 
  
  if(isset($_GET['page'])) {
    $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
  }else{
    $page = 'index';
  }

  if(strlen($page) < 1) {
    $page = 'index';
  }
  $array = explode('.',$page);
  $page = $array[0];
  $page = basename($page);
  if(file_exists('app/template_partials/'.$page.'.php')) {
    include_once 'app/template_partials/'.$page.'.php';
  }else{
    header("Location: index.php",303);die;
  }
  
  ?>
  
  <hr id="about">
  
  
  <!-- Footer -->
  <footer class="w3-row-padding w3-padding-32">
    <div class="w3-third">
      <h3>FOOTER</h3>
      <p><?php echo $data['footer']; ?></p>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- End page content -->
</div>
<script src="public/js/jquery.min.js"></script>
    <script src="public/js/main.js"></script>
<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>

</body>
</html>
