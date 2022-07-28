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
$user_id = $_GET['id'];
$sql = "Select * from users Where user_id=$user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$user_1 = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);
    $sql = "update users set role='$role' where user_id=$user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("location:list.php?message=Cập nhật dữ liệu thành công!");
    die;
}
?>


<!--Content-->
<div class="content" style="padding: 0 30px;">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?= $user_1['user_id'] ?>">
        <label for="">Tên tài khoản</label>
        <p><?= $user_1['user_name'] ?></p>
        <label for="">Quyền</label>
        <br>
        <select name="role" class="form-control">
            <?php if ($user_1['role'] == 0) : ?>
                <option value="0" selected>Khách hàng</option>
                <option value="1" >Nhân viên</option>
                <option value="2">Admin</option>
                 <?php elseif ($user_1['role'] == 1) : ?>
                <option value="0" >Khách hàng</option>
                <option value="1" >Nhân viên</option>
                <option value="2">Admin</option>
            <?php elseif ($user_1['role'] == 2) : ?>
                <option value="0">Khách hàng</option>
                <option value="1" >Nhân viên</option>
                <option value="2" selected>Admin</option>
            <?php endif; ?>
        </select>
        <button class="btn-dark btn mt-3" type="submit" name="btnLuu">Lưu lại</button>
    </form>
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