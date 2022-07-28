<?php
ob_start();
require_once "../db.php";

$sql = "SELECT DISTINCT user_id FROM comments";

// echo $sql;die;
$stmt = $conn->prepare($sql);
$stmt->execute();
$cmt_pr = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Ngày comment</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($cmt_pr as $key => $item) {
                $id_user = $item['user_id'];
                $sql = "SELECT * FROM users WHERE user_id = $id_user";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $cmt_user = $stmt->fetchAll(PDO::FETCH_ASSOC);


                if (isset($_GET['pro_id'])) {
                    $pro_id = $_GET['pro_id'];
                    $sql = "SELECT * FROM comments WHERE pro_id = $pro_id AND user_id = $id_user";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $cmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            ?>
                <?php foreach ($cmt as $key => $item) { ?>
                    <tr>
                        <td><?= $stt++; ?></td>
                        <?php foreach ($cmt_user as $key => $c) { ?>
                            <?php if ($item['user_id'] == $c['user_id']) { ?>
                                <td><?= $c['user_name'] ?></td>
                            <?php } ?>
                        <?php } ?>
                        <td><?php echo $item['cmt_content'] ?></td>
                        <td><?php echo $item['cmt_date'] ?></td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="delete.php?id=<?= $item['cmt_id'] ?>"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>


<?php require_once "../layout/footer.php"; ?>