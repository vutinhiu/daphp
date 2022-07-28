<?php
ob_start();
?>
<?php
include_once "../layout/header.php";
?>
<?php
$pro_id = $_GET['pro_id'];
if(isset($_POST['btnLuu'])){
    extract($_REQUEST);
    $sql = "INSERT INTO products_detail (pro_id,size,quantity) VALUE('$pro_id' ,'$size','$quantity')";
    //echo $sql; die;
    $stmt= $conn->prepare($sql);
    if($stmt->execute()){
        header("location: list_detail.php?pro_id=$pro_id&message=Thêm Dữ Liệu Thành Công");
    } else{
        header("location: list_detail.php?pro_id=$pro_id&message=Thêm Dữ Liệu Thất Bại");  
    }
}
?>

<div class="content" style="padding: 0 30px;">
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="pro_id" value="<?php echo $pro_id?>">
        <label for="">Size</label>
        <br>
        <input class="form-control" type="text" name="size" id="" required>
        <br>
        <label for="">Số Lượng</label>
        <br>
        <input class="form-control" type="number" name="quantity" id="" required>
        <br>
        <button class="btn-dark btn mt-3" type="submit" name="btnLuu">Thêm mới</button>
    </form>
    <br>
    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php";
?>