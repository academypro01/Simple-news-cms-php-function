<?php

// get all messages
function getAllContactsMessage(){
    $connection = dbs();
    $sql = "SELECT * FROM contacts_tbl";
    $result = mysqli_query($connection, $sql);
    return $result;
}

// delete single message
function deleteSingleMessage($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "DELETE FROM contacts_tbl WHERE id='$id'";
    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'message deleted successfully!';
        header("Location: index.php?page=contactMessages");die;
    }else{
        $_SESSION['status'] = 'message deleted failed!';
        header("Location: index.php?page=contactMessages");die;
    }
}