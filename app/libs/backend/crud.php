<?php

$salt = SALT;

function generateToken($username) {
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $ip       = htmlspecialchars($_SERVER['REMOTE_ADDR']);
    $userAgent= htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
    global $salt;
    $token = md5($username.$ip.$userAgent.$salt);
    return $token;
}

// check username
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

// check email address
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

// get user full name
function getFullName($user_id) {
    $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
    $connection = dbs();
    $sql = "SELECT firstname,lastname FROM users_tbl WHERE id='$user_id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $fullName = $row['firstname']." ".$row['lastname'];
    return $fullName;
}

// get user profile photo
function getUserProfilePhoto() {
    $user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "SELECT photo FROM users_tbl WHERE id='$user_id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['photo'];

}

// upload photo function
function uploadFile($file) {
    $root_directory = "../public/uploads/";

    $valid_ext = ['png','jpg','jpeg'];

    $name = filter_var($file['name'], FILTER_SANITIZE_STRING);
    $array = explode('.', $name);
    $ext = strtolower(end($array));

    if(!in_array($ext, $valid_ext)) {
        return false;
    }

    $random_name = uniqid("upload__").rand();
    $new_name = $random_name.".".$ext;
    $fullPath = $root_directory.$new_name;

    if(move_uploaded_file($file['tmp_name'], $fullPath)) {
        return $fullPath;
    }else{
        return false;
    }
}

// edit template data
function editTemplate($inputs, $favicon, $about_image) {
    $title = filter_var($inputs['title'], FILTER_SANITIZE_STRING);
    $name = filter_var($inputs['name'], FILTER_SANITIZE_STRING);
    $footer = filter_var($inputs['footer'], FILTER_SANITIZE_STRING);
    $about_title = filter_var($inputs['about_title'], FILTER_SANITIZE_STRING);
    $about_message = filter_var($inputs['about_message'], FILTER_SANITIZE_STRING);


    // upload favicon
    if($favicon['error'] != '0' || $favicon['size'] == '0'){
        $favicon = filter_var($inputs['favicon_default'], FILTER_SANITIZE_STRING);
    }else{
        $favicon = uploadFile($favicon);
        if ($favicon == false) {
            $_SESSION['status'] = 'upload favicon failed';
            header("Location: index.php");
            die;
        }
    }

    // upload about image
    if($about_image['error'] != '0' || $about_image['size'] == '0'){
        $about_image = filter_var($inputs['about_image_default'], FILTER_SANITIZE_STRING);
    }else{
        $about_image = uploadFile($about_image);
        if ($about_image == false) {
            $_SESSION['status'] = 'upload about image failed';
            header("Location: index.php");
            die;
        }
    }

    $connection = dbs();
    $sql = "UPDATE template_tbl SET title='$title', name='$name', favicon='$favicon', footer='$footer', about_title='$about_title', about_message='$about_message', about_image='$about_image' WHERE id='1'";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'template updated successfully!';
        // echo 'upload successfully';
    }else{
        $_SESSION['status'] = 'template updated failed!';
        // echo "upload failed";
    }

}

// get template data
function getTemplate() {
    $connection = dbs();
    $sql = "SELECT * FROM template_tbl limit 0,1";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}


// is Admin function
function isAdmin() {
    $user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_STRING);
    $connection = dbs();

    $sql = "SELECT isAdmin FROM users_tbl WHERE id='$user_id'";

    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['isAdmin'] == '1') {
        return true;
    }else {
        return false;
    }
}

// check Admin Access for pages
function pageGuard() {
    $user_token = (isset($_SESSION['token']) ? $_SESSION['token'] : NULL);
    if(!isAdmin() && generateToken($_SESSION['username']) == $user_token){
        die("You dont have admin access!");
    }
}

// check token
function checkToken() {
    $user_token = (isset($_SESSION['token']) ? $_SESSION['token'] : NULL);
    if(generateToken($_SESSION['username']) != $user_token){
        die("You dont have access, please login first!");
    }
}

// show session message status
function sessionStatus() {
    if(isset($_SESSION['status']) && $_SESSION['status'] != NULL) {
        echo  '<div class="alert alert-info" role="alert">';
        echo $_SESSION['status'];
        echo '</div>';

        $_SESSION['status'] = NULL;
        unset($_SESSION['status']);
    }
}

// get random quotes
function randomQuote() {
    $request = file_get_contents("https://api.quotable.io/random");
    $result = json_decode($request, true);
    return $result;
}

// get all users by limit
/*
select * from users_tbl limit 0,5

majid99 -> 99
*/
function getUsers($page) {
    $page = abs(filter_var($page, FILTER_SANITIZE_NUMBER_INT));

    $perpage = 20;

    $calculate = $perpage * $page;
    $start     = $calculate - $perpage;

    $connection = dbs();

    $sql = "SELECT * FROM users_tbl ORDER BY id DESC LIMIT $start, $perpage";

    $result = mysqli_query($connection, $sql);

    $sql2 = "SELECT * FROM users_tbl";
    $result2 = mysqli_query($connection, $sql2);
    $total = mysqli_num_rows($result2);

    $totalPages = ceil($total / $perpage);

    return [$result,$total,$totalPages];

}


//delete users
function deleteUser($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "DELETE FROM users_tbl WHERE id='$id'";
    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'user successfully Deleted!';
        // header("Location: index.php?page=userList");die;
    }else{
        $_SESSION['status'] = 'user delete failed!';
        // header("Location: index.php?page=userList");die;
    }
}

// create new user 
function createUser($data, $photo) {
    $firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
    $lastname  = filter_var($data['lastname'] , FILTER_SANITIZE_STRING);
    $username  = filter_var($data['username'] , FILTER_SANITIZE_STRING);
    $email     = filter_var($data['email'],     FILTER_SANITIZE_STRING);
    $password  = filter_var($data['password'] , FILTER_SANITIZE_STRING);
    $repeat_password = filter_var($data['repeat_password'], FILTER_SANITIZE_STRING);

    if(array_key_exists('isAdmin', $data)){
        $isAdmin = 1;
    }else{
        $isAdmin = 0;
    }

    if(array_key_exists('isActive', $data)){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    if($password != $repeat_password) {
        $_SESSION['status'] = 'passwords does not matched!';
        header("Location: index.php?page=userCreate");die;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'email not valid!';
        header("Location: index.php?page=userCreate");die;
    }

    if(checkUsername($username)) {
        $_SESSION['status'] = 'username exist, pick another one!';
        header("Location: index.php?page=userCreaet");die;
    }

    if(checkEmail($email)) {
        $_SESSION['status'] = 'E-mail exist, pick another one!';
        header("Location: index.php?page=userCreaet");die;
    }

    $date = date("Y/m/d H:i:s");
    global $salt;
    $password = sha1($password.$salt);


    $photo = uploadFile($photo);

    if ($photo == false) {
        $_SESSION['status'] = 'upload photo failed';
        header("Location: index.php?page=userCreate");
        die;
    }


    $connection = dbs();
    
    $sql = "INSERT INTO users_tbl (firstname, lastname, username, email, photo, password, date) VALUES ('$firstname', '$lastname', '$username', '$email','$photo', '$password', '$date')";

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'new user submitted successfully!';
        header("Location: index.php?page=userList");die;
    }else{
        $_SESSION['status'] = 'submit failed, tray again!';
        header("Location: index.php?page=userList");die;
    }
}

// show single user
function showSingleUser($id) {
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $connection = dbs();
    $sql = "SELECT * FROM users_tbl WHERE id='$id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

// update single user
function updateSingleUser($inputs, $photo, $id) {
    $firstname = filter_var($inputs['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($inputs['lastname'], FILTER_SANITIZE_STRING);
    $password = filter_var($inputs['password'], FILTER_SANITIZE_STRING);
    $repeat_password = filter_var($inputs['repeat_password'], FILTER_SANITIZE_STRING);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if(array_key_exists('isAdmin', $inputs)){
        $isAdmin = 1;
    }else{
        $isAdmin = 0;
    }

    if(array_key_exists('isActive', $inputs)){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    global $salt;

    $updatePassword = false;

    if($password != NULL) {
        if($password != $repeat_password) {
            $_SESSION['status'] = 'passwords not matched';
            return false;
        }else{
            $password = sha1($password.$salt);
            $updatePassword = true;
        }
    }

    if($photo['error'] != '0' || $photo['size'] == '0'){
        $photo = filter_var($inputs['user_photo_default'], FILTER_SANITIZE_STRING);
    }else{
        $photo = uploadFile($photo);
        if ($photo == false) {
            $_SESSION['status'] = 'upload photo failed';
            return false;
        }
    }

    $connection = dbs();

    if($updatePassword) {
        $sql = "UPDATE users_tbl SET firstname='$firstname', lastname='$lastname', password='$password', photo='$photo', isAdmin='$isAdmin', isActive='$isActive' WHERE id='$id'";
    }else{
        $sql = "UPDATE users_tbl SET firstname='$firstname', lastname='$lastname', photo='$photo', isAdmin='$isAdmin', isActive='$isActive' WHERE id='$id'";
    }

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'User updated successfully';
        header("Location: index.php?page=userEdit&user_id=$id");die;
    }else{
        $_SESSION['status'] = 'user update failed';
        header("Location: index.php?page=userEdit&user_id=$id");die;
    }

    
}
function updateProfileInformation($inputs, $photo, $id) {
    $firstname = filter_var($inputs['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($inputs['lastname'], FILTER_SANITIZE_STRING);
    $password = filter_var($inputs['password'], FILTER_SANITIZE_STRING);
    $repeat_password = filter_var($inputs['repeat_password'], FILTER_SANITIZE_STRING);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if(array_key_exists('isAdmin', $inputs)){
        $isAdmin = 1;
    }else{
        $isAdmin = 0;
    }

    if(array_key_exists('isActive', $inputs)){
        $isActive = 1;
    }else{
        $isActive = 0;
    }

    global $salt;

    $updatePassword = false;

    if($password != NULL) {
        if($password != $repeat_password) {
            $_SESSION['status'] = 'passwords not matched';
            return false;
        }else{
            $password = sha1($password.$salt);
            $updatePassword = true;
        }
    }

    if($photo['error'] != '0' || $photo['size'] == '0'){
        $photo = filter_var($inputs['user_photo_default'], FILTER_SANITIZE_STRING);
    }else{
        $photo = uploadFile($photo);
        if ($photo == false) {
            $_SESSION['status'] = 'upload photo failed';
            return false;
        }
    }

    $connection = dbs();

    if($updatePassword) {
        $sql = "UPDATE users_tbl SET firstname='$firstname', lastname='$lastname', password='$password', photo='$photo', isAdmin='$isAdmin', isActive='$isActive' WHERE id='$id'";
    }else{
        $sql = "UPDATE users_tbl SET firstname='$firstname', lastname='$lastname', photo='$photo', isAdmin='$isAdmin', isActive='$isActive' WHERE id='$id'";
    }

    if(mysqli_query($connection, $sql)) {
        $_SESSION['status'] = 'User updated successfully';
        header("Location: index.php?page=editProfile");die;
    }else{
        $_SESSION['status'] = 'user update failed';
        header("Location: index.php?page=editProfile");die;
    }

    
}