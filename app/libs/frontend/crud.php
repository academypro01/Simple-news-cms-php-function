<?php
$salt = SALT;

function checkUsername($username) {
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $connection = dbs();
    $sql = "SELECT id FROM users_tbl WHERE username='$username'";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        return true;
    }else {
        return false;
    }
}

function checkEmail($email) {
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $connection = dbs();
    $sql = "SELECT id FROM users_tbl WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0) {
        return true;
    }else {
        return false;
    }
}

function signup($data) {
    $firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
    $lastname  = filter_var($data['lastname'] , FILTER_SANITIZE_STRING);
    $username  = filter_var($data['username'] , FILTER_SANITIZE_STRING);
    $email     = filter_var($data['email'],     FILTER_SANITIZE_STRING);
    $password  = filter_var($data['password'] , FILTER_SANITIZE_STRING);
    $repeat_password = filter_var($data['repeat_password'], FILTER_SANITIZE_STRING);

    if(!array_key_exists('agree_terms', $data)){
        $_SESSION['status'] = 'please agree the terms of this services!';
        header("Location: index.php?page=register");die;
    }

    if($password != $repeat_password) {
        $_SESSION['status'] = 'passwords does not matched!';
        header("Location: index.php?page=register");die;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'email not valid!';
        header("Location: index.php?page=register");die;
    }

    if(checkUsername($username)) {
        $_SESSION['status'] = 'username exist, pick another one!';
        header("Location: index.php?page=register");die;
    }

    if(checkEmail($email)) {
        $_SESSION['status'] = 'E-mail exist, pick another one!';
        header("Location: index.php?page=register");die;
    }

    $date = date("Y/m/d H:i:s");
    global $salt;
    $password = sha1($password.$salt);

    $connection = dbs();
    
    $sql = "INSERT INTO users_tbl (firstname, lastname, username, email, password, date) VALUES ('$firstname', '$lastname', '$username', '$email', '$password', '$date')";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'you are submitted successfully!';
        header("Location: index.php?page=register");die;
    }else{
        $_SESSION['status'] = 'submit failed, tray again!';
        header("Location: index.php?page=register");die;
    }
}

function generateToken($username) {
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $ip       = htmlspecialchars($_SERVER['REMOTE_ADDR']);
    $userAgent= htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
    global $salt;
    $token = md5($username.$ip.$userAgent.$salt);
    return $token;
}

function signin($data) {
    $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
    
    if(!checkUsername($username)) {
        $_SESSION['status'] = 'username or password is incorrect!';
        header("Location: index.php?page=login");die;
    }

    global $salt;
    $password = sha1($password.$salt);

    $connection = dbs();
    $sql = "SELECT * from users_tbl WHERE username='$username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['password'] != $password) {
        $_SESSION['status'] = 'username or password is incorrect!';
        header("Location: index.php?page=login");die;
    }
    if($row['isActive'] == '0') {
        $_SESSION['status'] = 'Your account is not active yet!';
        header("Location: index.php?page=login");die;
    }


    if(array_key_exists('remember', $data) && !isset($_COOKIE['username'])) {
        setcookie('username', $username, time() + (86400 * 30), '/');
    }

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username']= $row['username'];
    $_SESSION['token']   = generateToken($_SESSION['username']);
    
    header("Location: dashboard/index.php");die;
}

// send message to admin from contact form
function contacts($data) {
    $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
    $message = filter_var($data['message'], FILTER_SANITIZE_STRING);

    $date = date("Y/m/d H:i:s");

    $connection = dbs();
    $sql = "INSERT INTO contacts_tbl (email,message,date) VALUES ('$email','$message','$date')";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = "message successfully sent!";
        header("Location: index.php?page=contact");die;
    }else{
        $_SESSION['status'] = "Sending message failed! try again later";
        header("Location: index.php?page=contact");die;
    }
}

// show session messages
function sessionStatus() {
    if(isset($_SESSION['status']) && $_SESSION['status'] != NULL) {
        echo  '<div class="alert alert-info" role="alert">';
        echo $_SESSION['status'];
        echo '</div>';

        $_SESSION['status'] = NULL;
        unset($_SESSION['status']);
    }
}
// check login or not
function checkToken() {
    if (isset($_SESSION['username'])) {
        $user_token = (isset($_SESSION['token']) ? $_SESSION['token'] : null);
        if (generateToken($_SESSION['username']) != $user_token) {
            return false;
        } else {
            return true;
        }
    }
}