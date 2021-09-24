<?php
function dbs() {
    $server   = DB_SERVER;
    $username = DB_USER;
    $password = DB_PASS;
    $dbName   = DB_NAME; 

    $connection = mysqli_connect($server, $username, $password, $dbName);

    if(!$connection) {
        die('database connection failed!');
    }

    return $connection;
}