<?php
require_once "../db.php";
$theme_id = $_GET['id'];
$sql = "DELETE FROM theme WHERE theme_id = $theme_id";
$stmt = $conn->prepare($sql);
if($stmt->execute()){
    header("location: list.php?message=xóa dữ liệu thành công");
} else{
    header("location: list.php?message=xóa dữ liệu thất bại");
}