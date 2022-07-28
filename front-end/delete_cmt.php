<?php
require_once "../back-end/db.php";
    $cmt_id = $_GET['cmt_id'];
    $cate_id = $_GET['cate_id'];
    $pro_id = $_GET['pro_id'];
    $sql = "DELETE FROM comments WHERE cmt_id = $cmt_id";
    // echo $sql; die;
    $stmt = $conn->prepare($sql);
    if($stmt->execute()){
        header("location: detail.php?cate_id=$cate_id&pro_id=$pro_id&message= Xóa thành công");
    } else{
        header("location: detail.php?message= Xóa thất bại");
    }
?>
