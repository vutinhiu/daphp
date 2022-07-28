<?php
ob_start();
include_once "../layout/header.php";
?>
<?php
if (isset($_POST['btnluu'])) {
    extract($_REQUEST);
    //nếu người dùng upload mới
    if ($_FILES['theme_logo']['size'] > 0) {
        $theme_logo = $_FILES['theme_logo']['name'];
    }
    //câu lệnh sql update
    $sql = "UPDATE theme SET  theme_logo = '$theme_logo', theme_phone = '$theme_phone', theme_email = '$theme_email', theme_add = '$theme_add' WHERE theme_id=$theme_id";
    // echo $sql; die;
    //chuẩn bị
    $stmt = $conn->prepare($sql);
    //thực thi
    if ($stmt->execute()) {
        header("location:list.php?message=Cập nhật dữ liệu thành công!");
        //upload file nếu có
        if ($_FILES['theme_logo']['size'] > 0) {
            move_uploaded_file($_FILES['theme_logo']['tmp_name'], "../img/" . $theme_logo);
        }
    } else {
        header("location:list.php?message=Cập nhật dữ liệu thất bại!");
    }
}
$theme_id = $_GET['id'];
//câu lệnh select với điều kiện cate_id
$sql = "SELECT * FROM theme WHERE theme_id = $theme_id";
//chuẩn bị
$stmt = $conn->prepare($sql);
//thực thi
$stmt->execute();
//lấy 1 dòng dữ liệu
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content" style="padding: 0 30px;">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="theme_id" value="<?= $result['theme_id'] ?>">
        <label for="">Logo</label>
        <br>
        <input type="file" name="theme_logo" id="">
        <br>
        <?php if (!empty($result['theme_logo'])) : ?>
            <input type="hidden" name="theme_logo" value="<?= $result['theme_logo'] ?>" id="">
            <br>
            <img src="../img/<?= $result['theme_logo'] ?>" width="120" height="150" alt="">
        <?php endif; ?>
        <br>
        <label for="">Số điện thoại</label>
        <br>
        <input type="text" name="theme_phone" class="form-control" placeholder="Số điện thoại" value="<?= $result['theme_phone'] ?>" aria-describedby="basic-addon1">
        <br>
        <label for="">Email</label>
        <br>
        <input type="text" name="theme_email" class="form-control" placeholder="email" value="<?= $result['theme_email'] ?>" aria-describedby="basic-addon1">
        <br>
        <label for="">Địa chỉ</label>
        <br>
        <input type="text" name="theme_add" class="form-control" placeholder="địa chỉ" value="<?= $result['theme_add'] ?>" aria-describedby="basic-addon1">
        <br>
        <button type="submit" class="btn btn-secondary" name="btnluu">Lưu</button>
    </form>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php"
?>