<?php
ob_start();
?>
<?php
include_once "../layout/header.php";
?>
<?php
$pro_id = $_GET['pro_id'];
$prodt_id= $_GET['prodt_id'];
if(isset($_POST['btnLuu'])){
    extract($_REQUEST);
    $sql = "UPDATE products_detail SET size='$size', quantity='$quantity' WHERE prodt_id=$prodt_id ";
    //echo $sql; die;
    $stmt= $conn->prepare($sql);
    if($stmt->execute()){
        header("location: list_detail.php?pro_id=$pro_id&message=Sửa Dữ Liệu Thành Công");
    } else{
        header("location: list_detail.php?pro_id=$pro_id&message=Sửa Dữ Liệu Thất Bại");  
    }
}
$sql = "SELECT * FROM products_detail WHERE prodt_id=$prodt_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_dt = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="content" style="padding: 0 30px;">
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="prodt_id" value="<?= $pro_dt['prodt_id']?>">
    <input type="hidden" name="pro_id" value="<?php echo $pro_id?>">
        <label for="">Size</label>
        <br>
        <input class="form-control" type="text" name="size" id=""value="<?= $pro_dt['size']?>" required>
        <br>
        <label for="">Số Lượng</label>
        <br>
        <input class="form-control" type="number" name="quantity" id="qty_<?= $pro_dt['quantity']?>" value="<?= $pro_dt['quantity']?>" required>
        <script> 
          function pr_<?= $pro_dt['quantity']; ?>() {
                                            var qty = document.getElementById("qty_<?= $pro_dt['quantity'] ?>").value;
                                            if (qty <= 1) {
                                                document.getElementById("qty_<?= $pro_dt['quantity'] ?>").value = qty;
                                            } else {
                                                qty--;
                                                document.getElementById("qty_<?= $pro_dt['quantity'] ?>").value = qty;
                                            }
                                            document.getElementById("price_<?= $pro_dt['quantity'] ?>").value = qty * <?= $c['pr']; ?>;
                                        }
        </script>
        <br>
        <button class="btn-dark btn mt-3" type="submit" name="btnLuu">Sửa</button>
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