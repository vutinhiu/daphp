<?php
ob_start();
require_once "../db.php";
$sql = "SELECT * FROM categories WHERE cate_pr = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM categories WHERE cate_pr !=0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate_pr = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <th scope="col">Tên Danh mục</th>
                <th scope="col">Chi tiết</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($cate as $key => $item) : ?>
                <tr>
                    <td><?= $stt++; ?></td>
                    <td><?= $item['cate_name'] ?></td>
                    <td>
                        <a href="list_detail.php?cate_id=<?php echo $item['cate_id'] ?>">Chi tiết</a>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $item['cate_id'] ?>"><i class="far fa-edit"></i></a>
                        <a onclick="return confirm('Bạn có chức muốn xoá?')" href="delete.php?id=<?= $item['cate_id'] ?>"><i class="far fa-trash-alt"></i></a>
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


<?php require_once "../layout/footer.php"; ?>