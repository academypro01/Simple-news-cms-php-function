<?php
pageGuard();

if(isset($_GET['news_id'])) {
    $news_id = filter_var($_GET['news_id'], FILTER_SANITIZE_NUMBER_INT);
    deleteNews($news_id);
}