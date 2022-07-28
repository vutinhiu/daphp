<?php
require_once "../db.php";
$slide_id = $_GET['id'];
$sql = "DELETE FROM slides WHERE slide_id = $slide_id";
$stmt = $conn->prepare($sql);
if($stmt->execute()){
    header("location: list.php?message=xóa dữ liệu thành công");
} else{
    header("location: list.php?message=xóa dữ liệu thất bại");
}