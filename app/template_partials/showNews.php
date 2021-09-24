<?php
if(!isset($_GET['news_id']) || !filter_var($_GET['news_id'], FILTER_VALIDATE_INT)){
    echo 'Sorry! news not found, you redirect to home page after 10 seonds!';
    header("refresh:10;url=index.php");die;
}
$news_id = abs(filter_var($_GET['news_id'], FILTER_SANITIZE_NUMBER_INT));
$news = getSingleNews($news_id);
if($news == false) {
    echo 'Sorry! news not found, you redirect to home page after 10 seonds!';
    header("refresh:10;url=index.php");die;
}
?>
<div style="font-family:arial,sans-serif;">
    <h1 style="text-align:center;"><?php echo $news['title']; ?></h1>
    <hr>
    <div class="imageNews">
        <div style="width:100%;margin-bottom:20px;">
            <img style="display:block;margin-left:auto;margin-right:auto;border-radius:10px;" src="<?php echo str_replace("../",'./',$news['image']); ?>" alt="">
        </div>
    </div>
    <div class="mainNews">
        <p style="text-align:justify; color:#222;"><?php echo $news['content']; ?></p>
    </div>
    <div class="date" style="color:gray;">
        <?php echo $news['date']; ?>
    </div>
</div>