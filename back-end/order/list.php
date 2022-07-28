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
$sql = "SELECT * FROM `order` ORDER BY order_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content" style="padding: 0 30px;">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Tổng tiền thanh toán</th>
                <th scope="col">Thời gian đặt hàng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Chi tiết</th>
                <th scope="col">Tác vụ</th>
            </tr>
        </thead>
        <tbody class="tbody">
            <?php foreach ($order as $o) : ?>
                <tr>
                    <td><?= $o['order_id'] ?></td>
                    <td>
                        <?php foreach ($users as $u) : ?>
                            <?php if ($o['user_id'] == $u['user_id']) : ?>
                                <?= $u['user_name'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td><?= price($o['order_price']); ?></td>
                    <td><?= date('d-m-Y', strtotime($o['order_date'])); ?></td>
                    <td><?= $o['order_stt'] ?></td>
                    <td><a href="list_detail.php?id=<?= $o['order_id'] ?>">Chi tiết</a></td>
                    <td>
                        <a onclick="return confirm('Đơn hàng: #<?= $o['order_id'] ?> sẽ bị xóa vĩnh viễn. Tiếp tục xóa?')" href="delete.php?id=<?= $o['order_id'] ?>"><i class="far fa-trash-alt"></i></a>
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