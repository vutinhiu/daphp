<?php
ob_start();
include_once "../layout/header.php";
?>
<?php
/**
 * 
 * Chuyển đổi chuỗi ký tự thành dạng slug dùng cho việc tạo friendly url.
 * 
 * @access public
 * @param string
 * @return string
 */
if (!function_exists('price')) {
    function price($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "$suffix";
        }
    }
}
?>
<?php
// Số lượng khách hàng ( loại bỏ trùng lặp)
$sql = "SELECT DISTINCT user_id FROM `order` WHERE order_stt='Giao hàng thành công' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$customer = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo count($customer);
// echo "<pre>";
// var_dump($customer); die;
?>

<?php
//sản phẩm đã bán hôm nay
date_default_timezone_set("Asia/Ho_Chi_Minh");
$now = date('Y-m-d', time());
$sql = "SELECT order_date FROM `order` WHERE order_date = '$now' AND order_stt='Giao hàng thành công'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sum_sold = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//doanh thu trong ngày
$sql = "SELECT SUM(order_price) FROM `order` WHERE order_date = '$now' AND order_stt='Giao hàng thành công'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sum_price = $stmt->fetch(PDO::FETCH_ASSOC);
// echo "<pre>";
// var_dump($sum_price); die;
$s = $sum_price["SUM(order_price)"];
?>
<div class="content" style="padding: 0 30px;">
    <?php if (isset($_SESSION['alert']['warning'])) : ?>
        <div class="alert alert-warning d-flex justify-content-between" role="alert">
            <span><?= $_SESSION['alert']['warning']; ?></span>
            <span><i class="fas fa-exclamation-triangle" style="color: yellow; font-size: 25px;"></i></span>
        </div>
        <?php unset($_SESSION['alert']['warning']); ?>
    <?php endif; ?>
</div>
<div>
    <h4 style="text-align: center;">THỐNG KÊ CỬA HÀNG</h4>
</div>
<div class="row mt-3 prome" style="
    padding-bottom: 100px; padding: 0 30px 70px 30px;">
    <div class="col-md-4">
        <div class="bg-prome" style="text-align: center; background-color: #ffd900;color: white;">
            <div style="padding: 20px 0;">
                <span style="font-size: 70px;font-weight: bold;"><?php echo count($sum_sold)  ?></span>
                <p> Sản Phẩm Đã Bán Hôm Nay</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="text-align: center; background-color: #fa8072;color: white;">
            <div style="padding: 20px 0;">
                <span style="font-size: 50px;font-weight: bold;">
                    <?php if ($s > 0) : ?>
                        <?php echo price($s) ?>
                </span>

                <span class="" style="font-size: 50px;font-weight: bold;color: black;">
                <?php else : ?>
                    0đ
                <?php endif; ?>
                </span>


                <p style=" padding-top: 30px;"> Doanh Thu Hôm Nay</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="text-align: center; background-color: #4abebd;color: white;">
            <div style="padding: 20px 0;">
                <span style="font-size: 70px;font-weight: bold;">
                    <?php echo count($customer) ?></span>
                <p>Số Lượng Khách Hàng</p>
            </div>
        </div>
    </div>
</div>

<?php
include_once "../layout/footer.php";
?>