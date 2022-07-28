<?php
ob_start();
include_once "header.php";
?>

<?php
if (!isset($_SESSION['user'])) {
    header("location:user/login.php");
    die;
}

$sql = "SELECT * FROM `order` where user_id='$user_id' ORDER BY order_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM order_detail";
$stmt = $conn->prepare($sql);
$stmt->execute();
$order_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
if (isset($_POST['btnUpdate'])) {
    $order_id = $_POST['order_id'];
    $sql = "update `order` set order_stt='Đã hủy' where order_id=$order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("location:order.php");
    die;
}

/*if (isset($_POST['btnDelete'])) {
    $order_id = $_POST['order_id'];
    $sql = "Delete from order where order_id=$order_id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $sql1 = "Delete from order_detail where order_id=$order_id";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        header("location:order.php");
        die;
    }
}*/
?>

<div class="content container-fluid">
    <div class="header-page text text-center">
        <h1>Đơn hàng của bạn</h1>
        <p>Có <span><?= count($order); ?> đơn hàng</span> trong tài khoản của bạn.</p>
        <div class="hr mx-auto"></div>
    </div>
    <?php if (isset($_SESSION['alert']['suc_order'])) : ?>
        <div class="alert alert-success d-flex justify-content-between" role="alert">
            <span><?= $_SESSION['alert']['suc_order']; ?></span>
            <span><i class="far fa-check-circle" style="color: green; font-size: 25px;"></i></span>
        </div>
        <?php unset($_SESSION['alert']['suc_order']); ?>
    <?php endif; ?>
    <div class="content-order">
        <table class="table">
            <thead class="text">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tất cả sản phẩm</th>
                    <th scope="col">Thành tiền</th>
                    <th scope="col">Thời gian đặt hàng</th>
                    <th scope="col">Trạng thái đơn hàng</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order as $o) : ?>
                    <tr>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
                            <td><?= $o['order_id'] ?></td>
                            <td>
                                <?php foreach ($order_detail as $od) : ?>
                                    <?php if ($o['order_id'] == $od['order_id']) : ?>
                                        <?php foreach ($pro as $p) : ?>
                                            <?php if ($od['pro_id'] == $p['pro_id']) : ?>
                                                <p><?= $p['pro_name'] ?> (x<?= $od['orderdt_qty'] ?>) <span style="float: right; font-size: 12px;"><?= price($od['orderdt_price'] * $od['orderdt_qty']) ?></span></p>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <span style="float: right; font-size: 12px; color:green;">Phí vận chuyển: <?= price(20000) ?></span>
                            </td>
                            <td><span style="color: red; font-weight: bold;"><?= price($o['order_price'] + 20000); ?></span></td>
                            <td><?= date('d-m-Y', strtotime($o['order_date'])); ?></td>
                            <td>
                                <?php if ($o['order_stt'] == "Đang chờ xử lý") : ?>
                                    <div class="text-warning">
                                        <i class="far fa-clock text-warning"></i> Đang chờ xử lý
                                    </div>
                                <?php elseif ($o['order_stt'] == "Đang giao hàng") : ?>
                                    <div class="text-primary">
                                        <i class="fas fa-truck-moving text-primary"></i> Đang giao hàng
                                    </div>
                                <?php elseif ($o['order_stt'] == "Giao hàng thành công") : ?>
                                    <div class="text-success">
                                        <i class="fas fa-check text-success"></i> Giao hàng thành công
                                    </div>
                                <?php elseif ($o['order_stt'] == "Đã hủy") : ?>
                                    <div class="text-danger">
                                        <i class="fas fa-times text-danger"></i> Đã hủy
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($o['order_stt'] == "Đang chờ xử lý") : ?>
                                    <button type="submit" name="btnUpdate" style="border: none; background: none;">Hủy</button>
                                <?php endif; ?>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include_once "footer.php";
?>