<?php
ob_start();
include_once "../layout/header.php";
?>

<?php
$cate_id = $_GET['id'];
$sql = "DELETE FROM categories where cate_id=$cate_id";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    header("location: list.php?message=Xóa dữ liệu thành công!");
} else {
    header("location: list.php?message=Xóa dữ liệu thất bại!");
}
