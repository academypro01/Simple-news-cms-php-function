<?php
pageGuard();

if (isset($_GET['user_id'])) {
    $user_id = filter_var($_GET['user_id'], FILTER_SANITIZE_NUMBER_INT);
    deleteUser($user_id);
    header("Location: index.php?page=userList");
    die;
}
