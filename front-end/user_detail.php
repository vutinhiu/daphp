<?php
session_start();
require_once "../back-end/db.php";
if (isset($_SESSION['user'])) {
    $id = $_SESSION['user']['user_id'];
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
$sql = "select * from users_detail where user_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$u = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "select * from users where user_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$u_1 = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['btnSave'])) {
    extract($_REQUEST);
    if ($_FILES['avatar']['size'] > 0) {
        $avatar = $_FILES['avatar']['name'];
    }
    $sql = "update users set email='$email', avatar='$avatar' where user_id=$id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        if (!empty($avatar)) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], "../back-end/img/" . $avatar);
        }
        $sql = "update users_detail set fullname='$fullname', user_add='$user_add', user_phone='$user_phone' where user_id=$id";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            header("location:user_detail.php?message=Sửa dữ liệu thành công!");
            die;
        } else {
            header("location:user_detail.php?message=Sửa dữ liệu thất bại!");
            die;
        }
    } else {
        header("location:user_detail.php?message=Sửa dữ liệu thất bại!");
        die;
    }
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
    <title>Thông tin cá nhân</title>


</head>

<body>
    <div class="container">
        <div class="row text checkout">
            <div class="mx-auto">
                <div class="main-header">
                    <a href="index.php">
                        <h1 class="logo-text">Thời Trang Routine</h1>
                    </a>
                </div>
                <h2>Cập nhật thông tin cá nhân</h2>
                <hr>
                <span>Tài khoản: <?= $u_1['user_name']; ?></span>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="section" style="margin-top: 10px; color: gray">
                        <label for="" style="margin-bottom: 0;">Họ tên</label>
                        <input type="text" name="fullname" id="" value="<?= $u['fullname'] ?>" style="margin-top: 0;">
                        <div class="d-flex justify-content-between">
                            <div style="width: 65%;">
                                <label for="" style="margin-bottom: 0;">Email</label>
                                <input type="text" name="email" id="" value="<?= $u_1['email']; ?>" style="margin-top: 0;">
                            </div>
                            <div style="width: 30%">
                                <label for="" style="margin-bottom: 0;">Số điện thoại</label>
                                <input type="text" name="user_phone" id="" value="<?= $u['user_phone'] ?>" style="margin-top: 0;">
                            </div>
                        </div>
                        <label for="" style="margin-bottom: 0;">Địa chỉ</label>
                        <input type="text" name="user_add" id="" value="<?= $u['user_add'] ?>" style="margin-top: 0;">
                        <div class="position-relative">
                            <label for="">Ảnh đại diện</label>
                            <br>
                            <input type="file" name="avatar" id="file-avatar" style="display: none;">
                            <label for="file-avatar" style="margin-bottom: 0;">
                            <input type="hidden" name="avatar" value="<?= $u_1['avatar']?>">
                                <img src="../back-end/img/<?= $u_1['avatar']; ?>" alt="" style="max-height: 200px; max-width: 200px;">
                            </label>
                            <span id="file-name" class="position-absolute" style="bottom: 0; font-size: 20px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                <?= $u_1['avatar']; ?>
                            </span>
                            <script>
                                let inputAvt = document.getElementById('file-avatar');
                                let inputName = document.getElementById('file-name');
                                inputAvt.addEventListener('change', function(event) {
                                    let upFileName = event.target.files[0].name;
                                    inputName.textContent = upFileName;
                                });
                            </script>
                            <button type="submit" name="btnSave" class="submit position-absolute" style="border: none; right: 0; bottom: 0;">Cập nhật</button>
                        </div>
                    </div>
                </form>
                <?php if (isset($_GET['message'])) : ?>
                    <div class="alert alert-dark mt-3" role="alert">
                        <?= $_GET['message'] ?>
                    </div>
                <?php endif; ?>
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