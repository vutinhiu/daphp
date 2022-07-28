<?php
ob_start();
require_once "../layout/header.php";
?>

<?php
    $sql = "SELECT * FROM categories";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $cate = $stmt -> fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['btnLuu'])) {
    $cate_name = $_POST['cate_name'];
    $cate_pr = $_POST['cate_pr'];
    $sql = "INSERT INTO categories (cate_name, cate_pr) Values('$cate_name','$cate_pr')";
    $stmt = $conn->prepare($sql);
    if($stmt -> execute()){
        header("location: list.php?themdulieuthanhcong");
    }
    else{
        header("location: list.php?themdulieuthatbai");
    }
    
}
?>
<!--Content-->
<div class="content" style="padding: 0 30px;">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="">Tên danh mục</label>
        <br>
        <input class="form-control" type="text" name="cate_name" id="" required>
        <br>
        <label for="">Quyền danh mục</label>
        <select name="cate_pr" class="form-control">
            <option value="0">Danh mục cha</option>
            <?php foreach($cate as $key => $item){ ?>
                <option value="<?php echo $item['cate_id'] ?>"><?php echo $item['cate_name']?></option>
            <?php } ?>
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