<?php
ob_start();
include_once "../layout/header.php";
?>

<?php

$sql = "SELECT * FROM categories";
$stmt = $conn -> prepare($sql);
$stmt -> execute();
$cate = $stmt -> fetchAll(PDO::FETCH_ASSOC);

$cate_id = $_GET['id'];
$sql = "SELECT * FROM categories Where cate_id=$cate_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate_1 = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);

    $sql = "UPDATE categories set cate_name='$cate_name', cate_pr ='$cate_pr' where cate_id=$cate_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt -> execute()){
        header("location:list.php?message=Cập nhật dữ liệu thành công!");
    }
    else{
        header("location:list.php?message=Cập nhật dữ liệu thất bại!");
    
    }
    die;
}
?>


<!--Content-->
<div class="content" style="padding: 0 30px;">
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="">Tên danh mục</label>
        <p><input type="text" class="form-control" name="cate_name" value="<?= $cate_1['cate_name'] ?>"></p>
        <label for="">Quyền</label>
        <br>
        <select name="cate_pr" class="form-control">
            <?php if ($user_1['role'] == 0) : ?>
                <?php foreach($cate as $key => $item){ ?>
                <option value="<?php echo $item['cate_id'] ?>"><?php echo $item['cate_name']?></option>
            <?php } ?>
            <?php elseif ($user_1['role'] == 1) : ?>
                <?php foreach($cate as $key => $item){ ?>
                <option value="<?php echo $item['cate_id'] ?>"><?php echo $item['cate_name']?></option>
            <?php } ?>
            
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