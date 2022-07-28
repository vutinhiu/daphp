<?php
ob_start();
include_once "../layout/header.php";

?>
<?php
$sql = "SELECT * FROM theme";
$stmt = $conn->prepare($sql);
$stmt->execute();
$theme = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content" style="padding: 0 30px;">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Logo</th>
                <th scope="col">số điện thoại</th>
                <th scope="col">email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($theme as $c) : ?>
                <tr>
                    <td><?= $c['theme_id'] ?></td>
                    <td>
                        <img src="../img/<?= $c['theme_logo'] ?>" alt="" width="120" height="80">
                    </td>
                    <td><?= $c['theme_phone'] ?></td>
                    <td><?= $c['theme_email'] ?></td>
                    <td><?= $c['theme_add'] ?></td>
                    <td style="width: 70px;">
                        <a href="edit.php?id=<?= $c['theme_id'] ?>"><i class="far fa-edit"></i></a>
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