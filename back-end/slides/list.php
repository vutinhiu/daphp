<?php
ob_start();
include_once "../layout/header.php";
?>
<?php
$sql = "SELECT * FROM slides";
$stmt = $conn->prepare($sql);
$stmt->execute();
$slide = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content" style="padding: 0 30px;">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Ảnh Slide</th>
                <th scope="col">Link slide</th>
                <th scope="col">PR slide</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($slide as $c) : ?>
                <tr>
                    <td><?= $c['slide_id'] ?></td>
                    <td>
                        <img src="../img/<?= $c['slide_image'] ?>" alt="" width="120">
                    </td>
                    <td><?= $c['slide_link'] ?></td>
                    <td><?= $c['slide_pr'] ?></td>
                    <td style="width: 70px;">
                        <a href="edit.php?id=<?= $c['slide_id'] ?>"><i class="far fa-edit"></i></a>
                        <a onclick="return confirm('Đơn hàng: #<?= $c['slide_id'] ?> sẽ bị xóa vĩnh viễn. Tiếp tục xóa?')" href="delete.php?id=<?= $c['slide_id'] ?>"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php"
?>