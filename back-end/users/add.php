<?php
ob_start();
include_once "../layout/header.php";
if ($_SESSION['user']['role'] < 2) {
    $_SESSION['alert']['warning'] = "Quản trị tài khoản chỉ dành cho admin!";
    header("location: ../index/index.php");
    die;
}
?>

<?php
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);
    if ($_FILES['avatar']['size'] > 0) {
        $avatar = $_FILES['avatar']['name'];
    } else {
        $avatar = 'none.png';
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (user_name, email, password, avatar, role) Values('$user_name','$email','$password','$avatar','$role')";
    $stmt = $conn->prepare($sql);
    $sql1 = "select * from users where user_name='$user_name' or email='$email'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $user_err = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    if (count($user_err) > 0) {
        header("location:add.php?message=Thêm dữ liệu thất bại! Username hoặc email đã tồn tại!");
        die;
    } else {
        if ($stmt->execute()) {
            if ($_FILES['avatar']['size'] > 0) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], "../img/" . $avatar);
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

            header("location:list.php?message=Thêm dữ liệu thành công!");
            die;
        } else {
            header("location:list.php?message=Thêm dữ liệu thất bại!");
            die;
        }
    }
}
?>
<!--Content-->
<div class="content" style="padding: 0 30px;">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="">Tên tài khoản</label>
        <br>
        <input class="form-control" type="text" name="user_name" id="" required>
        <br>
        <label for="">Email</label>
        <br>
        <input class="form-control" type="email" name="email" id="" required>
        <br>
        <label for="">Mật khẩu</label>
        <br>
        <input class="form-control" type="text" name="password" id="" required>
        <br>
        <label for="">Hình ảnh</label>
        <input class="mb-3" type="file" name="avatar" id="">
        <br>
        <label for="">Quyền tài khoản</label>
        <select name="role" class="form-control">
            <option value="0">Khách hàng</option>
            <option value="2">Admin</option>
        </select>
        <button class="btn-dark btn mt-3" type="submit" name="btnLuu">Thêm mới</button>
    </form>
    <br>
    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<!--End Content-->

<?php
include_once "../layout/footer.php";
?>