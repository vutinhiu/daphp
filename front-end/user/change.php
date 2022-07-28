<?php
session_start();
require_once "../../back-end/db.php";
if (isset($_POST['btnChange'])) {
    extract($_REQUEST);

    if (isset($username)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $username;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['user']  = "Tài khoản hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:change.php");
            die;
        }
    }
    if (isset($passwordold)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $passwordold;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['pass']  = "Mật khẩu hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:change.php");
            die;
        }
    }
    if (isset($passwordnew)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $passwordnew;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['pass']  = "Mật khẩu hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:change.php");
            die;
        }
    }
    $sql1 = "select * from users where user_name='$username'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $user = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $passwordnew = password_hash($passwordnew, PASSWORD_DEFAULT);
        if (password_verify($passwordold, $user['password'])) {
            $sql = "update users set password='$passwordnew' where user_name='$username'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            header("location:login.php?message=Đổi mật khẩu thành công");
            die;
        } else {
            $err = "Đổi mật khẩu thất bại! <br> Mật khẩu không chính xác.";
        }
    } else {
        $err = "Đổi mật khẩu thất bại! Username không tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đổi mật khẩu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title p-b-40 p-t-40">
                        <a href="../index.php"><img src="../../back-end/img/logo.png" alt="" width="150px"></a>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="text" name="username">
                        <span class="focus-input100" data-placeholder="User name"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="passwordold">
                        <span class="focus-input100" data-placeholder="Password old"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="passwordnew">
                        <span class="focus-input100" data-placeholder="Password new"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" name="btnChange" class="login100-form-btn">
                                Change
                            </button>
                        </div>
                    </div>
                    <center>
                        <span class="txt1" style="margin-left: 15px; color: red; font-family: Arial, Helvetica, sans-serif;">
                            <?php if (isset($err)) : ?>
                                <?= $err; ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['alert']['user'])) : ?>
                                <?= $_SESSION['alert']['user']; ?>
                                <?php unset($_SESSION['alert']['user']) ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['alert']['pass'])) : ?>
                                <?= $_SESSION['alert']['pass']; ?>
                                <?php unset($_SESSION['alert']['pass']) ?>
                            <?php endif; ?>
                        </span>
                    </center>
                    <div class="text-center p-t-80">
                        <span class="txt1">
                            Don’t have an account?
                        </span>

                        <a class="txt2" href="sign-up.php">
                            <b>Sign Up</b>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>