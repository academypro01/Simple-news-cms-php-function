<?php
pageGuard();

if(isset($_GET['message_id'])) {
    $message_id = filter_var($_GET['message_id'], FILTER_SANITIZE_NUMBER_INT);
    deleteSingleMessage($message_id);
}