<?php

// get template information
function getTemplateData() {
    $connection = dbs();
    $sql = "SELECT * FROM template_tbl LIMIT 0,1";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// get news for template
function getNews($page) {
    $page = abs(filter_var($page, FILTER_SANITIZE_NUMBER_INT));

    $perpage = 9;

    $calculate = $perpage * $page;
    $start     = $calculate - $perpage;

    $connection = dbs();

    $sql = "SELECT * FROM news_tbl WHERE isActive='1' ORDER BY id DESC LIMIT $start, $perpage";

    $result = mysqli_query($connection, $sql);

    $sql2 = "SELECT * FROM news_tbl WHERE isActive='1'";
    $result2 = mysqli_query($connection, $sql2);
    $total = mysqli_num_rows($result2);

    $totalPages = ceil($total / $perpage);

    return [$result,$total,$totalPages];

}

function getTotalPage($perpage){
    $sql2 = "SELECT * FROM news_tbl WHERE isActive='1'";
    $connection = dbs();
    $result2 = mysqli_query($connection, $sql2);
    $total = mysqli_num_rows($result2);
    $perpage = filter_var($perpage, FILTER_SANITIZE_NUMBER_INT);
    $totalPages = ceil($total / $perpage);
    return $totalPages;
}

// get single news
function getSingleNews($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "SELECT * FROM news_tbl WHERE id='$id'";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }else{
        return false;
    }

}