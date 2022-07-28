<?php
include_once "../layout/header.php";
?> 

<?php
$pro_id = $_GET['pro_id'];
 $sql = "SELECT * FROM products_detail WHERE pro_id=$pro_id";
 $stmt = $conn->prepare($sql);
$stmt->execute();
$pro_dt = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//Lấy Tất Cả Dữ Liệu Trong Bảng Products
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content" style="padding: 0 30px;">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Sản Phẩm</th>
                <th scope="col">Size</th>
                <th scope="col">Số Lượng</th>
                <th scope="col">Đã Bán</th>
                <th scope="col">Tác Vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($pro_dt as $c) : ?>
                <tr>
                    <td><?= $c['prodt_id'] ?></td>
                    <?php foreach($pro as $p) : ?>
                    <?php if($c['pro_id']==$p['pro_id']) : ?>
                    <td><?= $p['pro_name'] ?></td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?= $c['size'] ?></td>
                    <td><?= $c['quantity'] ?></td>
                    <td><?= $c['sold'] ?></td>
                    <td>
                        <a href="edit_detail.php?pro_id=<?= $c['pro_id'] ?>&prodt_id=<?= $c['prodt_id']?>"><i class="far fa-edit"></i></a>
                        <a onclick="return confirm('Bạn Có Chắc Chắn Muốn Xóa')" href="delete_detail.php?pro_id=<?= $c['pro_id'] ?>&prodt_id=<?= $c['prodt_id']?>"><i class="far fa-trash-alt"></i></a>
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
include_once "../layout/footer.php";
?> 