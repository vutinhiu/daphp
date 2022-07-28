
<?php
session_start();
require_once "../../back-end/db.php";
if (isset($_POST['btnSignUp'])) {
    extract($_REQUEST);//trích xuất yêu cầu
    if (isset($username)) {
        $pattern = '/^[a-z0-9]{5,20}$/';//Mẫu để tìm kiếm, dưới dạng một chuỗi.
        $subject = $username;//Chuỗi đầu vào.
        if (preg_match($pattern, $subject) == false) { // trả về 1 nếu cácpattern phù hợp đã chosubject, 0 nếu không khớp hoặcfalsekhông thành công.
            $_SESSION['alert']['user']  = "Tài khoản hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:sign-up.php");
            die;
        }
    }
    if (isset($password)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $password;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['pass']  = "Mật khẩu hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:sign-up.php");
            die;
        }
    }
    $password = password_hash($password, PASSWORD_DEFAULT);//tạo mật khẩu băm mới bằng cách sử dụng thuật toán băm một chiều mạnh(Sử dụng thuật toán bcrypt )
    if ($_FILES['avatar']['size'] > 0) {
        $avatar = $_FILES['avatar']['name'];
    } else {
        $avatar = 'none.png';
    }
    $sql1 = "select * from users where user_name='$username' or email='$email'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $user_err = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    if (count($user_err) > 0) {
        $err = "Username hoặc email đã tồn tại!";
    } else {
        $sql = "INSERT INTO users (user_name, email, password, avatar) Values('$username','$email','$password', '$avatar')";
        // echo $sql; die;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($_FILES['avatar']['size'] > 0) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], "../../back-end/img/" . $avatar);
        }

        /*Lấy id user vừa tạo*/
        $sql = "SELECT * FROM users ORDER BY user_id DESC LIMIT 0,1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $k = $user['user_id'];

        $sql = "INSERT INTO `users_detail` (`user_id`, `user_phone`, `user_add`, `fullname`) VALUES ($k, '', '', '');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        header("location:login.php?message=Tài khoản đã được tạo thành công!");
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng Ký</title>
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
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=WfbDNvgE"></script>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" enctype="multipart/form-data">
                    <span class="login100-form-title p-b-30 p-t-40">
                        <a href="../index.php"><img src="../../back-end/img/logo.png" alt="" width="150px"></a>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="text" name="username">
                        <span class="focus-input100" data-placeholder="User name"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <input type="file" name="avatar" id="file-avatar">
                    <label for="file-avatar">Avatar</label>
                    <span id="file-name" style="color: #999999; float: right; margin-top: 10px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                        None
                    </span>
                    <script>
                        let inputAvt = document.getElementById('file-avatar');
                        let inputName = document.getElementById('file-name');
                        inputAvt.addEventListener('change', function(event) {
                            let upFileName = event.target.files[0].name;
                            inputName.textContent = upFileName;
                        });
                    </script>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" name="btnSignUp" class="login100-form-btn">
                                Sign-up
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
                    <div class="text-center p-t-30">
                        <span class="txt1">
                            Do have an account?
                        </span>

                        <a class="txt2" href="login.php">
                            <b>Login</b>
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