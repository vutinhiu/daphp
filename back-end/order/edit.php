<?php
ob_start();
include_once "../layout/header.php";
?>

<?php

/**
 *
 * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
 *
 * @access    public
 * @param    string
 * @return    string
 */
if (!function_exists('price')) {
    function price($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}
?>

<?php
$order_id = $_GET['id'];
$sql = "Select * from `order` Where order_id=$order_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$order_1 = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);
    $sql = "update `order` set order_stt='$order_stt' where order_id=$order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("location:list.php?message=Cập nhật dữ liệu thành công!");
    die;
}
?>


<!--Content-->
<div class="content" style="padding: 0 30px;">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="d-flex justify-content-between">
            <input type="hidden" name="order_id" value="<?= $order_1['order_id'] ?>">
            <div>
                <label for="">Tài khoản đặt hàng</label>
                <p>
                    <?php foreach ($users as $u) : ?>
                        <?php if ($order_1['user_id'] == $u['user_id']) : ?>
                            <?= $u['user_name'] ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            </div>
            <div>
                <label for="">Tổng tiền thanh toán</label>
                <p><?= price($order_1['order_price']) ?></p>
            </div>
            <div>
                <label for="">Thời gian đặt hàng</label>
                <p><?= date('d-m-Y H:i:s', strtotime($order_1['order_date'])); ?></p>
            </div>
        </div>

        <label for="">Trạng thái đơn hàng</label>
        <br>
        <select name="order_stt" class="form-control">
            <?php if ($order_1['order_stt'] == 'Đang chờ xử lý') : ?>
                <option value="Đang chờ xử lý" selected>Đang chờ xử lý</option>
                <option value="Đang giao hàng">Đang giao hàng</option>
                <option value="Giao hàng thành công">Giao hàng thành công</option>
                <option value="Đã hủy">Đã hủy</option>
            <?php elseif ($order_1['order_stt'] == 'Đang giao hàng') : ?>
                <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                <option value="Đang giao hàng" selected>Đang giao hàng</option>
                <option value="Giao hàng thành công">Giao hàng thành công</option>
                <option value="Đã hủy">Đã hủy</option>
            <?php elseif ($order_1['order_stt'] == 'Giao hàng thành công') : ?>
                <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                <option value="Đang giao hàng">Đang giao hàng</option>
                <option value="Giao hàng thành công" selected>Giao hàng thành công</option>
                <option value="Đã hủy">Đã hủy</option>
            <?php elseif ($order_1['order_stt'] == 'Đã hủy') : ?>
                <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                <option value="Đang giao hàng">Đang giao hàng</option>
                <option value="Giao hàng thành công">Giao hàng thành công</option>
                <option value="Đã hủy" selected>Đã hủy</option>
            <?php endif; ?>
        </select>
        <button class="btn-dark btn mt-3" type="submit" name="btnLuu">Cập nhật</button>
    </form>
    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<!--End Content-->

<?php
include_once "../layout/footer.php";
?>