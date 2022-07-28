<?php
session_start();
require_once "../back-end/db.php";
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['user_id'];
    $us = $_SESSION['user']['name'];
    $email = $_SESSION['user']['email'];
    $av = $_SESSION['user']['avatar'];
    $ro = $_SESSION['user']['role'];
} else {
    header("location:user/login.php");
    die;
}
?>

<?php

/**
 *
 * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
 *
 * @access    public
 * @param    string
 * @return    string
 */
if (!function_exists('price')) {
    function price($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}
?>

<?php
$sql = "select * from users_detail where user_id='$user_id'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$u = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php
if (isset($_SESSION['cart'][$user_id])) {
    $cart = $_SESSION['cart'][$user_id];

    /*Tính tổng tiền*/
    $money = 0;
    foreach ($cart as $c) {
        $money += $c['qty'] * $c['pr'];
    }
} else {
    header("location:index.php");
    die;
}
?>

<?php
if (isset($_POST['btnSubmit'])) {
    extract($_REQUEST);


        $sql = "update users_detail set fullname='$fullname', user_add='$user_add', user_phone='$phone' where user_id=$user_id";
        $stmt = $conn->prepare($sql);
        $stmt -> execute();

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date('Y-m-d', time());

    /*Thêm đơn hàng*/
    $sql = "INSERT INTO `order` (user_id, order_price, order_date, order_stt) Values($user_id, '$money', '$now', 'Đang chờ xử lý')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    /*Lấy id đơn hàng vừa thêm <đơn cuối cùng>*/
    $sql = "SELECT * FROM `order` ORDER BY order_id DESC LIMIT 0,1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    $o = $order['order_id'];

    foreach ($cart as $c) {
        $sql = "INSERT INTO order_detail (order_id, pro_id, size, orderdt_qty, orderdt_price) VALUES ($o, '" . $c['id'] . "', '" . $c['size'] . "', '" . $c['qty'] . "', '" . $c['pr'] . "');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    unset($_SESSION['cart'][$user_id]);

    $_SESSION['alert']['suc_order'] = "Thành công! Đơn hàng của bạn đã được gửi lên shop.";
    header("location:order.php");
    die;
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Me CSS -->
    <link rel="stylesheet" href="css/css.css">
    <!-- Font-family -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
    <title>Index</title>


</head>

<body>
    <div class="container">
        <div class="row text checkout">
            <div class="col-md-6">
                <div class="main-header">
                    <a href="index.php">
                        <h1 class="logo-text">Thời Trang Routine</h1>
                    </a>
                    <p class="mx-auto m-0">
                        <a href="cart.php">Giỏ hàng</a> /
                        <a href="checkout.php">Thanh toán</a>
                    </p>
                </div>
                <h2>Thông tin giao hàng</h2>
                <p>
                    Bạn muốn cập nhật tài khoản? <a href="user_detail.php" style="color: #50A7F8;">Tài khoản</a>
                </p>
                <form action="" method="POST">
                <div class="section" style="margin-top: 30px; color: gray">
                    <label for="" style="margin-bottom: 0;">Họ tên</label>
                    <input oninput="ck_ip();" type="text" name="fullname" id="" value="<?= $u['fullname'] ?>" style="margin-top: 0;" required>
                    <div class="d-flex justify-content-between">
                        <div style="width: 65%;">
                            <label for="" style="margin-bottom: 0;">Email</label>
                            <input oninput="ck_ip();" type="text" name="email" id="" value="<?= $email; ?>" style="margin-top: 0;" required>
                        </div>
                        <div style="width: 30%">
                            <label for="" style="margin-bottom: 0;">Số điện thoại</label>
                            <input oninput="ck_ip();" type="text" name="phone" id="" value="<?= $u['user_phone'] ?>" style="margin-top: 0;" required>
                        </div>
                    </div>
                    <label for="" style="margin-bottom: 0;">Địa chỉ</label>
                    <input oninput="ck_ip();" type="text" name="user_add" id="" value="<?= $u['user_add'] ?>" style="margin-top: 0;" required>
                </div>
              
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="cart.php"><i class="fas fa-angle-left"></i> Giỏ hàng</a>
                        <button type="submit" name="btnSubmit" class="submit" style="border: none;">Đặt Hàng</button>
                    </div>
                </form>
                <div style="display: none;" id="alert_change">
                    <div class="alert alert-primary d-flex justify-content-between mt-3" role="alert">
                        <span>Nhấn vào <a href="user_detail.php" style="color: red;">ĐÂY</a> để thay đổi thông tin tài khoản!</span> <span><i class="fas fa-info-circle" style="color: blue; font-size: 25px;"></i>
                        </span>
                    </div>
                </div>
                <script>
                    function ck_ip() {
                        document.getElementById("alert_change").style.display = "block";
                    }
                </script>
            </div>
            <div class="col-md-6" style="border-left:1px solid #F3F3F3; background-color: #FAFAFA; padding: 20px; border-radius: 10px;">
                <?php foreach ($cart as $c) : ?>
                    <input type="hidden" name="cart_id" value="<?= $c['id']; ?>">
                    <div class="d-flex">
                    <?php 
                        $sql = "Select * from products where pro_id='" . $c['id'] . "'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $img = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="img-cart">
                        <a href="#"><img src="../back-end/img/<?= $img['pro_image']?>" alt="" width="80px" class="rounded"></a>
                        </div>
                        <div class="text item-cart">
                            <div class="position-relative">
                                <a href="#">
                                    <h3><?= $c['name']; ?></h3>
                                </a>
                                <span>Size: <?= $c['size']; ?></span>
                                <br>
                                <span>Số lượng: <?= $c['qty']; ?></span>
                                <div class="position-absolute text-right" style="right: 0; bottom: 0;">
                                    <span>Tổng giá: <?= price($c['qty'] * $c['pr']) ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div>
                    <div class="d-flex justify-content-between">
                        <p>Tạm tính:</p>
                        <p><?= price($money) ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Phí vận chuyển:</p>
                        <p><?= price(20000) ?></p>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="d-flex justify-content-between">
                        <h4>Tổng cộng:</h4>
                        <h4><?= price($money + 20000) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>
