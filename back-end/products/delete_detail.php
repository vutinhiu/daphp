<?php
require_once "../db.php";
?>

<?php
$pro_id = $_GET['pro_id'];
$prodt_id = $_GET['prodt_id'];

$sql = "DELETE FROM products_detail WHERE prodt_id=$prodt_id";
$stmt = $conn->prepare($sql);
if($stmt->execute()){
    header("location: list_detail.php?pro_id=$pro_id&message=Xóa Dữ Liệu Thành Công");
} else{
    header("location: list_detail.php?pro_id=$pro_id&message=Xóa Dữ Liệu Thất Bại");
}
?>