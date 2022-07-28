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
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $sql = "SELECT * FROM `order_detail` WHERE order_id = $order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $order_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "Select * from `order` Where order_id=$order_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $order_1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $us_id = $order_1['user_id'];

    $sql = "SELECT * FROM users WHERE user_id = $us_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users_detail WHERE user_id = $us_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ud = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['btnSave'])) {
        extract($_REQUEST);
        if ($order_stt == "Giao hàng thành công") {
            foreach ($order_detail as $o) {
                /*Hiển thị 1 sản phẩm có id và size trùng*/
                $sql = "Select * from products_detail Where pro_id=" . $o['pro_id'] . " AND size = '" . $o['size'] . "' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $pd_1 = $stmt->fetch(PDO::FETCH_ASSOC);
                /*Lấy đã bán, số lượng hiện tại trên db*/
                $sold_old = $pd_1['sold'];
                $qty_old = $pd_1['quantity'];
                /**đã bán+sl, sl-sl */
                $sold_new = $sold_old + $o['orderdt_qty'];
                $qty_new = $qty_old - $o['orderdt_qty'];

                /**Cập nhật lại đã bán và số lượng */
                $sql = "update `products_detail` set sold='$sold_new', quantity='$qty_new' Where pro_id=" . $o['pro_id'] . " AND size = '" . $o['size'] . "' ";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }
        }
        $sql = "update `order` set order_stt='$order_stt' where order_id=$order_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        header("location:list.php?message=Cập nhật dữ liệu thành công!");
        die;
    }
} else {
    header("location:list.php");
    die;
}

?>

<style>
    .content p {
        margin: 0;
    }
</style>
<div class="content" style="padding: 0 30px;">
    <div>
        <form action="" method="post">
            <div class="d-flex justify-content-between align-items-center">
                <input type="hidden" name="order_id" value="<?= $order_1['order_id'] ?>">
                <div>
                    <label for="">Tài khoản đặt hàng</label>
                    <p>
                        <?php if ($order_1['user_id'] == $us_id) : ?>
                            <?= $users['user_name'] ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div>
                    <label for="">Tổng tiền thanh toán</label>
                    <p><?= price($order_1['order_price']) ?></p>
                </div>
                <div>
                    <label for="">Thời gian đặt hàng</label>
                    <p><?= date('d-m-Y', strtotime($order_1['order_date'])); ?></p>
                </div>
                <div>
                    <label for="">Trạng thái đơn hàng</label>
                    <br>
                    <select name="order_stt">
                        <?php if ($order_1['order_stt'] == 'Đang chờ xử lý') : ?>
                            <option value="Đang chờ xử lý" selected>Đang chờ xử lý</option>
                            <option value="Đang giao hàng">Đang giao hàng</option>
                            <option value="Giao hàng thành công">Giao hàng thành công</option>
                            <option value="Đã hủy">Đã hủy</option>
                        <?php elseif ($order_1['order_stt'] == 'Đang giao hàng') : ?>
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
                </div>
                <?php if ($order_1['order_stt'] == 'Giao hàng thành công' || $order_1['order_stt'] == 'Đã hủy') : ?>
                <?php else : ?>
                    <div>
                        <button type="submit" name="btnSave" class="btn btn-success">Cập nhật</button>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4" style="border-right: 1px solid gray;">
            <h3 style="padding: 20px 0;">Thông tin khách hàng</h3>
            <div>
                <div>
                    <label for="">Họ Tên:</label>
                    <p><?= $ud['fullname'] ?></p>
                </div>
                <hr>
                <div>
                    <label for="">Số điện thoại:</label>
                    <p><?= $ud['user_phone'] ?></p>
                </div>
                <hr>
                <div>
                    <label for="">Địa chỉ nhận hàng:</label>
                    <p><?= $ud['user_add'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3 style="padding: 20px 0;">Chi tiết đơn hàng</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ID đơn hàng</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Size</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php foreach ($order_detail as $o) : ?>
                        <tr>
                            <td><?= $o['orderdt_id'] ?></td>
                            <td><?= $o['order_id'] ?></td>
                            <td>
                                <?php foreach ($pro as $p) : ?>
                                    <?php if ($o['pro_id'] == $p['pro_id']) : ?>
                                        <?= $p['pro_name'] ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                            <td><?= $o['size'] ?></td>
                            <td><?= $o['orderdt_qty'] ?></td>
                            <td><?= price($o['orderdt_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>

<?php
include_once "../layout/footer.php";
?>