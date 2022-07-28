<?php
ob_start();
require_once "../db.php";

$sql = "SELECT DISTINCT pro_id FROM comments";

// echo $sql;die
$stmt = $conn->prepare($sql);
$stmt->execute();
$cmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stt = 1;

?>
<?php
require_once "../layout/header.php";
?>

<div class="content" style="padding: 0 30px;">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số comment</th>
                <th scope="col">Chi tiết</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($cmt as $key => $item) {
                $idcmt = $item['pro_id'];
                $sql = "SELECT count(*) FROM comments where pro_id = '$idcmt'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $sum = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $sql = "SELECT * FROM products WHERE pro_id = $idcmt";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $cmt_pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>


                <tr>
                    <td><?= $stt++; ?></td>
                    <?php foreach ($cmt_pro as $key => $item) { ?>
                        <td><?= $item['pro_name'] ?></td>
                    <?php } ?>
                    <?php foreach ($sum as $key => $sl) { ?>
                        <td><?php echo $sl['count(*)'] ?></td>
                    <?php } ?>
                    <td>
                        <a href="list_detail.php?pro_id=<?php echo $item['pro_id'] ?>">Chi tiết</a>
                    </td>

                <?php } ?>
                </tr>
        </tbody>
    </table>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>


<?php require_once "../layout/footer.php"; ?>