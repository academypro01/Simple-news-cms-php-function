<?php
if(isset($_POST['signinBtn']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['frm'];
    signin($data);
}
?>
<section class="sign-in">

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
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="public/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="index.php?page=register" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?page=login'); ?>" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input value="<?php echo (isset($_COOKIE['username'])) ? $_COOKIE['username'] : '';  ?>" type="text" name="frm[username]" id="username" placeholder="username" autocomplete='off' required autofocus />
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="frm[password]" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input <?php echo (isset($_COOKIE['username'])) ? 'checked' : '';  ?> value='1' type="checkbox" name="frm[remember]" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signinBtn" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      