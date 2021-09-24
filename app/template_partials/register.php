<?php
if(isset($_POST['signupBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['frm'];
    signup($data);
}
?>
<section class="signup">

<?php 
    if(isset($_SESSION['status']) && $_SESSION['status'] != NULL):
?>
<div class="alert alert-primary" role="alert">
  <?php echo $_SESSION['status']; ?>
</div>
<?php
$_SESSION['status'] = NULL;
unset($_SESSION['status']);
endif;
?>


    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Sign up</h2>
                <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=register'); ?>' method="POST" class="register-form" id="register-form">
                    <div class="form-group">
                        <label for="firstname"><i class="zmdi zmdi-account-add"></i></label>
                        <input type="text" name="frm[firstname]" id="firstname" placeholder="Your firstname"/>
                    </div>
                    <div class="form-group">
                        <label for="lastname"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="frm[lastname]" id="lastname" placeholder="Your lastname"/>
                    </div>
                    <div class="form-group">
                        <label for="username"><i class="zmdi zmdi-account-circle"></i></label>
                        <input type="text" name="frm[username]" id="username" placeholder="username"/>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" name="frm[email]" id="email" placeholder="Your Email"/>
                    </div>
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="frm[password]" id="pass" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="frm[repeat_password]" id="re_pass" placeholder="Repeat your password"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="frm[agree_terms]" id="agree-term" class="agree-term" value='1' />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signupBtn" id="signup" class="form-submit" value="Register"/>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="public/images/signup-image.jpg" alt="sing up image"></figure>
                <a href="index.php?page=login" class="signup-image-link">I am already member</a>
            </div>
        </div>
    </div>
</section>