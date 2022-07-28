<?php
session_start();
require_once "../../back-end/db.php";
if (isset($_POST['btnLogin'])) {
	extract($_REQUEST);
	extract($_REQUEST);
    if (isset($username)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $username;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['user']  = "Tài khoản hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:login.php");
            die;
        }
    }
    if (isset($password)) {
        $pattern = '/^[a-z0-9]{5,20}$/';
        $subject = $password;
        if (preg_match($pattern, $subject) == false) {
            $_SESSION['alert']['pass']  = "Mật khẩu hợp lệ: 5-20 ký tự a-z 0-9!";
            header("location:login.php");
            die;
        }
    }
	if(isset($_GET['pro_id'])){
		$pro_id= $_GET['pro_id'];
		$cate_id= $_GET['cate_id'];
	}
	$sql = "select * from users where user_name='$username'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$user_1 = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user_1) {
		if (password_verify($password, $user_1['password'])) {
			$_SESSION['user']['user_id'] = $user_1['user_id'];
			$_SESSION['user']['name'] = $username;
			$_SESSION['user']['email'] = $user_1['email'];
			$_SESSION['user']['avatar'] = $user_1['avatar'];
			$_SESSION['user']['role'] = $user_1['role'];
			if(isset($pro_id)){
				header("location: ../detail.php?pro_id=$pro_id&cate_id=$cate_id");
				die;
			} else{
				header("location: ../index.php");
				die;
			}
			
			die;
		} else {
			$err = "Tài khoản hoặc mật khẩu không chính xác!<br>";
		}
	} else {
		$err = "Tài khoản hoặc mật khẩu không chính xác!<br>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Đăng nhập</title>
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
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" name="btnLogin" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>
					<center>
                        <span class="txt1" style="margin-left: 15px; color: red; font-family: Arial, Helvetica, sans-serif;">
                            <?php if (isset($err)) : ?>
                                <?= $err; ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['alert']['user_name'])) : ?>
                                <?= $_SESSION['alert']['user_name']; ?>
                                <?php unset($_SESSION['alert']['user_name']) ?>
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

						<br>

						<span class="txt1">
							or <a class="txt2" href="change.php"><b>changePassword!</b></a>
						</span>
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