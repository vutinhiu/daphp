<?php
ob_start();
include_once "../layout/header.php";
?>

<?php
$user_id = $_GET['id'];
$sql = "Delete from users where user_id=$user_id";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    $sql1 = "Delete from comments where user_id=$user_id";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    header("location: list.php?message=Xóa dữ liệu thành công!");
} else {
    header("location: list.php?message=Xóa dữ liệu thất bại!");
}
