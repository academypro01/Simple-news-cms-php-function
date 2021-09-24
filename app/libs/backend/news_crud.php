<?php
$salt = SALT;

// add new news from user
function addNews($inputs, $photo) {
    $user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

    $title = filter_var($inputs['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($inputs['content'], FILTER_SANITIZE_STRING);

    if(array_key_exists('isActive', $inputs) && isAdmin()){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    $photo = uploadFile($photo);

    if ($photo == false) {
        $_SESSION['status'] = 'upload photo failed';
        header("Location: index.php?page=newsCreate");
        die;
    }

    $date = date("Y/m/d H:i:s");

    $connection = dbs();

    $sql = "INSERT INTO news_tbl (user_id, title, image, content, date, isActive) VALUES ('$user_id', '$title', '$photo','$content','$date','$isActive')";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'news Added Successfully!';
        // header("Location: index.php?page=newsList");
    }else{
        $_SESSION['status'] = 'news Added Failed!';
        // header("Location: index.php?page=newsList");
    }
}


// get user news
function getUserNews($page) {
    $page = abs(filter_var($page, FILTER_SANITIZE_NUMBER_INT));

    $perpage = 20;

    $calculate = $perpage * $page;
    $start     = $calculate - $perpage;

    $connection = dbs();

    $current_user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM news_tbl WHERE user_id='$current_user_id' ORDER BY id DESC LIMIT $start, $perpage";

    $result = mysqli_query($connection, $sql);

    $sql2 = "SELECT * FROM news_tbl WHERE user_id='$current_user_id'";
    $result2 = mysqli_query($connection, $sql2);
    $total = mysqli_num_rows($result2);

    $totalPages = ceil($total / $perpage);

    return [$result,$total,$totalPages];

}

function getAllNews($page) {
    $page = abs(filter_var($page, FILTER_SANITIZE_NUMBER_INT));

    $perpage = 20;

    $calculate = $perpage * $page;
    $start     = $calculate - $perpage;

    $connection = dbs();

    $sql = "SELECT * FROM news_tbl ORDER BY id DESC LIMIT $start, $perpage";

    $result = mysqli_query($connection, $sql);

    $sql2 = "SELECT * FROM news_tbl";
    $result2 = mysqli_query($connection, $sql2);
    $total = mysqli_num_rows($result2);

    $totalPages = ceil($total / $perpage);

    return [$result,$total,$totalPages];

}

// get writer name
function getWriter($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "SELECT username FROM users_tbl WHERE id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
}

// delete news
function deleteNews($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "DELETE FROM news_tbl WHERE id='$id'";
    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'news deleted successfully!';
        header("Location: index.php?page=adminNewsList");die;
    }else{
        $_SESSION['status'] = 'news deleted failed!';
        header("Location: index.php?page=adminNewsList");die;
    }
}

// get single news
function getSingleNews($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "SELECT * FROM news_tbl WHERE id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}


// update news
function updateNews($inputs, $photo, $news_id) {
    $title = filter_var($inputs['title'], FILTER_SANITIZE_STRING);
    $content = filter_var($inputs['content'], FILTER_SANITIZE_STRING);

    if(array_key_exists('isActive', $inputs) && isAdmin()){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    if($photo['error'] != '0' || $photo['size'] == '0'){
        $photo = filter_var($inputs['news_photo_default'], FILTER_SANITIZE_STRING);
    }else{
        $photo = uploadFile($photo);
        if ($photo == false) {
            $_SESSION['status'] = 'upload photo failed';
            header("Location: index.php?page=adminNewsEdit&news_id=$news_id");
            die;
        }
    }

    $connection = dbs();

    $sql = "UPDATE news_tbl SET title='$title', content='$content', image='$photo', isActive='$isActive' WHERE id='$news_id'";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'news successfully Updated';
        header("Location: index.php?page=adminNewsList");
        die;
    }else{
        $_SESSION['status'] = 'news updated failed';
        header("Location: index.php?page=adminNewsList");
        die;
    }

}