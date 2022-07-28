<?php
include_once "../layout/header.php"
?>
<?php
$list_page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$from = ($page - 1) * $list_page;
//Lấy Tất Cả Dữ Liệu Trong Bảng Products
$sql = "SELECT * FROM products LIMIT $from, $list_page";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//Lấy Dữ Liệu Trong Bảng Chi Tiết Sản Phẩm (products_detail)
$sql = "SELECT * FROM products_detail";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//Lấy Tất Cả Dữ Liệu Trong Bảng Danh Mục
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content" style="padding: 0 30px;">
    <table class="table" style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên DM</th>
                <th scope="col">Tên Sản phẩm</th>
                <th scope="col">Hình Ảnh</th>
                <th scope="col">Giá</th>
                <th scope="col">SaLe</th>
                <th scope="col">SL</th>
                <th scope="col">Đã Bán</th>
                <!-- <th scope="col">Giới Thiệu</th> -->
                <th scope="col">View</th>
                <th scope="col">TV</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($pro as $c) : ?>
                <tr>
                    <td><?= $c['pro_id'] ?></td>
                    <?php foreach ($cate as $t) : ?>
                        <?php if ($c['cate_id'] == $t['cate_id']) : ?>
                            <td style="width: 100px"><?= $t['cate_name'] ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td style="width: 130px;text-align:left"><?= $c['pro_name'] ?></td>
                    <td>
                        <img src="../img/<?= $c['pro_image'] ?>" width="100px" height="100px" alt="">
                    </td>
                    <td><?= price($c['pro_price']) ?></td>
                    <td><?= price($c['pro_sale'])  ?></td>
                    <?php $sum_qty = 0; ?>
                    <?php foreach ($pro_detail as $p) : ?>
                        <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                            <?php $sum_qty += $p['quantity']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?= $sum_qty ?></td>
                    <?php $sum_sold = 0; ?>
                    <?php foreach ($pro_detail as $p) : ?>
                        <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                            <?php $sum_sold += $p['sold'] ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td><?= $sum_sold ?></td>
                    <!-- <td class="intro" style="width: 150px; text-align:left"><?= $c['pro_intro'] ?></td> -->
                    <td style="width: 10px"><?= $c['pro_view'] ?></td>
                    <td style="width: 150px;">
                        <a href="add_detail.php?pro_id=<?= $c['pro_id'] ?>"><i class="fas fa-folder-plus"></i></a>
                        <a href="edit.php?id=<?= $c['pro_id'] ?>"><i class="far fa-edit"></i></a>
                        <a onclick="return confirm('Sản Phẩm: #<?= $c['pro_name'] ?> sẽ bị xóa vĩnh viễn. Tiếp tục xóa?')" href="delete.php?id=<?= $c['pro_id'] ?>"><i class="far fa-trash-alt"></i></a>
                        <a href="list_detail.php?pro_id=<?= $c['pro_id'] ?>"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <?php
        $sql = "SELECT pro_id FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $x = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Tổng số Sản Phẩm
        $tongsotin = count($x);
        //Tổng số trang
        $tongsotrang = ceil($tongsotin / $list_page);
        ?>
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" style="position: absolute;bottom: 0;right: 0; margin-bottom: 10px" role="group" aria-label="First group">
                <?php
                for ($t = 1; $t <= $tongsotrang; $t++) {
                    echo "<button type='button' class='btn btn-secondary'><a style='color: white;' href='list.php?page=$t'</button>$t</a>";
                }
                ?>
            </div>
        </div> 
    </div>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" style="width:50%" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php"
?>