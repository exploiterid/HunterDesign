<script src="assets/libs/sweetalert/sweetalert.min.js"></script>
<style type="text/css">
    *{
        font-family: sans-serif;
    }
</style>
<?php 

    include 'auth/inc/config.php';
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta');

    if (isset($_POST['register']) == true) {
        $level = 'users';
        // $code_activation = md5(uniqid(rand()));
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $tgl = htmlspecialchars($_POST['tgl']);
        $ip = $_POST['ip'];
        $active = 'off';
        $password = htmlspecialchars(mysqli_real_escape_string($link, $_POST['password']));
        $confirm_password = htmlspecialchars(mysqli_real_escape_string($link, $_POST['confirm_password']));

        //captcha
        $secret = '6Lcgt9UUAAAAAJKvlULr01Vm4yRkaP_RzOaMqP-O';
        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseKeys = json_decode($verify);
        if ($responseKeys->success) {
           if ($confirm_password !== $password) {
            $errorConfirm = true;
            echo '<meta http-equiv="refresh" content="3; url=register">';
            return false;
        }


        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (id, username, email, tgl_active, password, ip, active, level) VALUES ('', '$username', '$email', '$tgl', '$password', '$ip', '$active', '$level')";
        $result = mysqli_query($link, $query);

        if (mysqli_affected_rows($link) > 0) {
            $success = true;
            echo '<meta http-equiv="refresh" content="3; url=login">';
        }else{
            $error = true;
        }
    }else{
        $error_captcha = true;
    }        
}


 ?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ExploiterID - Register Page">
    <meta name="author" content="NubyChan - www.codecrime.net">
    <meta name="keywords" content="ExploiterID">
    <link rel="icon" href="assets/libs/images/exploiterid.png">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->

    <link href="assets/libs/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <!-- Captcha -->

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Bootstrap CSS-->
    <link href="assets/libs/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="assets/libs/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/libs/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/libs/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="assets/libs/images/exploiterid.png" alt="ExploiterID">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger">Oppss, the data you enter failed</div>
                                    <?php endif ?>
                                    <?php if (isset($error_captcha) === true): ?>
                                        <div class="alert alert-danger">Captcha Error, you must click captcha if you not a robot!</div>
                                    <?php endif ?>
                                    <?php if (isset($success)): ?>
                                        <div class="alert alert-success">Your data was succesfully added</div>  
                                    <?php endif ?>

                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tgl" value="<?= date('F j, Y H:i'); ?>" class="form-control">
                                </div>
                                <input type="hidden" name="ip" id='ip' value="<?= $_SERVER['REMOTE_ADDR']; ?>">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input class="au-input au-input--full" type="text" name="username" placeholder="Username" required="" autofocus="" autocomplete="off" name="username" id="username" minlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email" required="" autocomplete="off" name="email" id="email">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required="" autocomplete="off" name="password" id="password" minlength="6">
                                </div>
                                <div class="form-group">
                                    <label for="password">Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="confirm_password" placeholder="Confirm Password" required="" autocomplete="off" name="confirm_password" id="confirm_password">
                                </div>
                                <div class="g-recaptcha" 
data-sitekey="6Lcgt9UUAAAAAGxEKLikPoFzRi49QAb9hgROp7QR"></div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="agree" checked>Agree the terms and policy
                                    </label>
                                </div>
                                <button type="submit" name="register" class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="login">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="assets/libs/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="assets/libs/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/libs/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="assets/libs/vendor/slick/slick.min.js">
    </script>

    <script src="assets/libs/vendor/wow/wow.min.js"></script>
    <script src="assets/libs/vendor/animsition/animsition.min.js"></script>
    <script src="assets/libs/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="assets/libs/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/libs/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="assets/libs/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="assets/libs/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/libs/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/libs/vendor/select2/select2.min.js">
    </script>
    <script src="assets/libs/vendor/bootstrap-validate/bootstrap-validate.js"></script>

    <!-- Bootstrap Validate Main -->
    <script>
        bootstrapValidate('#username', 'min:5:Enter at least 5 characters');
        bootstrapValidate('#username', 'regex:^[a-zA-Z0-9]+$:Please fulfill my regex (Letters And Number)');
        bootstrapValidate('#email', 'email:Enter a valid email address');
        bootstrapValidate('#password', 'min:6:Enter password more than 6 characters');
        bootstrapValidate('#confirm_password', 'matches:#password: Your password shoulds match!');
    </script>
    

    <!-- Main JS-->
    <script src="assets/libs/js/main.js"></script>

</body>

</html>
<!-- end document-->
