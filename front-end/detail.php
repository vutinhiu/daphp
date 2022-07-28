<!--Phần Header -->
<?php
ob_start();
include_once "header.php";
?>

<!--Kết Thúc Header-->
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
require_once "../back-end/db.php";
//Lấy Id trên url
$pro_id = $_GET['pro_id'];
//Lấy Sản Phẩm Trong Bảng products
$sql = "SELECT * FROM products WHERE pro_id=$pro_id ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($products);
?>
<?php
$sql = "SELECT pro_view FROM products WHERE pro_id=$pro_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$view = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($view); die;

?>
<?php
//Câu Lệnh Update View
$v = $view['pro_view'];
$sql = "UPDATE products SET pro_view= $v + 1 WHERE pro_id=$pro_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
?>
<?php
//Lấy cate_id trên url
$cate_id = $_GET['cate_id'];
$sql = "SELECT * FROM products WHERE cate_id=$cate_id EXCEPT SELECT * FROM products WHERE pro_id=$pro_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resual = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!--Lấy Comment-->
<?php
$sql = "SELECT comments.cmt_id, users.user_id, users.user_name, users.avatar, comments.cmt_content, comments.cmt_date FROM users LEFT OUTER JOIN comments ON users.user_id = comments.user_id WHERE comments.pro_id=$pro_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($cmt); die;
?>
<!--Thêm Comment-->
<?php
if (isset($_POST['Cmt'])) {
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $now = date('Y-m-d H:i:s', time());
    $cmt_content = $_POST['cmt_content'];
    $sql = "INSERT INTO comments(user_id, pro_id, cmt_content, cmt_date) VALUES('$user_id','$pro_id','$cmt_content','$now')";
    //echo $sql; die;
    //Chuẩn bị thực hiện
    $stmt = $conn->prepare($sql);
    //Thực thi
    if ($stmt->execute()) {
        header("location: detail.php?cate_id=$cate_id&pro_id=$pro_id");
    }
}
?>
<?php
$sql = "SELECT * FROM products_detail WHERE pro_id=$pro_id ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$sql = "SELECT * FROM products_detail";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_detailAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
if (isset($_POST['LoginCmt'])) {

    header("location: user/login.php?pro_id=$pro_id&cate_id=$cate_id");
}
?>
<?php
if (isset($_POST['btnCart'])) {
    if (!isset($_SESSION['user'])) {
        $_SESSION['alert']['err_user'] = "Bạn chưa đăng nhập!";
        header("location: detail.php?cate_id=$cate_id&pro_id=$pro_id");
        die;
    }

    if ($_POST['size'] == '') {
        $_SESSION['alert']['err_size'] = "Bạn chưa chọn size!";
        header("location: detail.php?cate_id=$cate_id&pro_id=$pro_id");
        die;
    }

    $qty = $_POST['quantity'];
    $size = $_POST['size'];
    $cart_id = $pro_id;

    $sql = "Select * from products where pro_id=$cart_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $cart_1 = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_1['pro_sale'] > 0) {
        $price = $cart_1['pro_sale'];
    } else {
        $price = $cart_1['pro_price'];
    }

    $item = [
        'id' => $cart_1['pro_id'],
        'name' => $cart_1['pro_name'],
        'pr' => $price,
        'qty' => $qty,
        'size' => $size
    ];

    $_SESSION['cart'][$user_id][$cart_id] = $item;
    $cart = $_SESSION['cart'][$user_id];

    $_SESSION['alert']['suc_cart'] = "Thành công! Sản phẩm này đã được thêm vào giỏ hàng của bạn.";
    header("location: detail.php?cate_id=$cate_id&pro_id=$pro_id");
    die;
}
?>
<?php
if (isset($_POST['btnCart'])) {
    if (!isset($_SESSION['user'])) {
        header("location: user/login.php");
        die;
    }

    $qty = $_POST['quantity'];
    $size = $_POST['size'];
    $cart_id = $pro_id;

    $sql = "Select * from products where pro_id=$cart_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $cart_1 = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_1['pro_sale'] > 0) {
        $price = $cart_1['pro_sale'];
    } else {
        $price = $cart_1['pro_price'];
    }

    $item = [
        'id' => $cart_1['pro_id'],
        'name' => $cart_1['pro_name'],
        'pr' => $price,
        'qty' => $qty,
        'size' => $size
    ];

    $_SESSION['cart'][$user_id][$cart_id] = $item;
    $cart = $_SESSION['cart'][$user_id];
}
?>
<!--Phần Nội Dung-->

<article>
    <div class="container-fluid">
        <div class="row" style="padding: 30px 0;">
            <!--Image Sản Phẩm-->
            <div class="col-md-7">
                <a href="">
                    <img src="../back-end/img/<?= $products['pro_image'] ?>" alt="" class="w-100">
                </a>
            </div>
            <!--End Image Sản Phẩm-->
            <!--Thông Tin Sản Phẩm-->
            <div class="col-md-5">
                <div>
                    <form action="" method="post">
                        <div>
                            <h1 class="titles text"><?= $products['pro_name'] ?></h1>
                            <p class="id-prducts text">SKU: 10F20JAC002/ TOASTED COCONUT</p>
                            <hr>
                            <?php if ($products['pro_sale'] > 0) : ?>
                            <p class="price text" style="font-weight: bold; font-size:20px"><?= price($products['pro_sale']) ?></p>
                            <?php else : ?>
                            <p class="price text" style="font-weight: bold; font-size:20px"><?= price($products['pro_price']) ?></p>
                            <?php endif; ?>
                            <hr>
                            <?php
                            $sum_qty = 0;
                            foreach ($pro_detail as $p) {
                                $sum_qty += $p['quantity'];
                            }

                            ?>
                            <p class="text">Kho Hàng:
                                <span>
                                    <?= $sum_qty; ?>
                                </span></p>
                            <hr>
                            <div class="text">
                            Size: <span id="size_1">...</span> còn <span id="qty_1">...</span> sản phẩm
                            </div>
                            <hr>
                            <div class="size">
                                <?php foreach ($pro_detail as $p) : ?>
                                <?php if($p['quantity']>0) : ?>
                                    <input type="radio" style="display: none;" id="size_<?= $p['size'] ?>" name="size" value="<?= $p['size'] ?>">
                                    <label onclick="check_quantity_<?= $p['size'] ?>()" for="size_<?= $p['size'] ?>"><?= $p['size'] ?></label>
                                    <?php else :?>
                                <?php endif; ?>
                                
                                <script>
                                        function check_quantity_<?= $p['size'] ?>() {
                                            document.getElementById("qty").value = 1;
                                            var x = document.getElementById("size_<?= $p['size'] ?>").value;
                                            document.getElementById("size_1").innerHTML = x;
                                            document.getElementById("qty_1").innerHTML = <?= $p['quantity'] ?>;
                                        }
                                    </script>
                                <?php endforeach; ?>
                            </div>
                            <hr>

                            <div class="input_qty">
                                <input class="button_qty" id="tru" type="button" value="-" onclick="tru()">
                                <input class="qty" name="quantity" max="50" type="number" min="1" value="1" id="qty">
                                <input class="button_qty" id="cong" type="button" value="+">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <button class="add-cart text w-100" name="btnCart">THÊM VÀO GIỎ HÀNG</button>
                            </div>

                            <?php if (isset($_SESSION['alert']['suc_cart'])) : ?>
                                <div class="alert alert-success d-flex justify-content-between" role="alert">
                                    <span><?= $_SESSION['alert']['suc_cart']; ?></span>
                                    <span><i class="far fa-check-circle" style="color: green; font-size: 25px;"></i></span>
                                </div>
                                <?php unset($_SESSION['alert']['suc_cart']); ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['alert']['err_size'])) : ?>
                                <div class="alert alert-warning d-flex justify-content-between" role="alert">
                                    <span><?= $_SESSION['alert']['err_size']; ?></span>
                                    <span><i class="fas fa-exclamation-triangle" style="color: yellow; font-size: 25px;"></i></span>
                                </div>
                                <?php unset($_SESSION['alert']['err_size']); ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['alert']['err_user'])) : ?>
                                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                                    <span><?= $_SESSION['alert']['err_user']; ?></span>
                                    <span><i class="far fa-times-circle" style="color: red; font-size: 25px;"></i></span>
                                </div>
                                <?php unset($_SESSION['alert']['err_user']); ?>
                            <?php endif; ?>

                            <div style="margin: 20px 0">
                                <label for="" class="text" style="font-weight: bold; font-size: 14px;">Mô Tả: </label>
                                <div class="description text" style="font-size: 14px;">
                                    <p><?= $products['pro_intro'] ?></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                var btnCong = document.querySelector("#cong");
                btnCong.onclick = function() {
                    var qty = document.getElementById("qty").value;
                    var qty_size = document.getElementById("qty_1").innerHTML;
                    qty++;
                    document.getElementById("qty").value = qty;
                    if (qty >= qty_size) {
                        document.getElementById("qty").value = qty_size;
                    }
                }

                var onChange = document.querySelector("#qty");
                onChange.onchange = function() {
                    var qty = document.getElementById("qty").value;
                    var qty_size = document.getElementById("qty_1").innerHTML;
                    if (qty <= 1) {
                        document.getElementById("qty").value = 1;
                    }
                    if (qty >= qty_size) {
                        document.getElementById("qty").value = qty_size;
                    }
                }

                var btnTru = document.querySelector("#tru");
                btnTru.onclick = function() {
                    var qty = document.getElementById("qty").value;
                    if (qty <= 1) {
                        document.getElementById("qty").value = 1;
                    } else {
                        qty--;
                        document.getElementById("qty").value = qty;
                    }
                }
            </script>
            <!--End Thông Tin Sản Phẩm-->
        </div>
        <div class="row">
            <div class="title-comment text" style="margin: 0 auto;">
                <h2 style="font-weight: bold; font-size: 28px;">NHẬN XÉT KHÁCH HÀNG</h2>
            </div>
        </div>
        <!--COMMENT-->
        <div class="row">
            <div class="col-md-6">
                <!--Comment 1-->
                <?php foreach ($cmt  as $c) : ?>
                    <div class="comment">
                        <div class="avatar">
                            <img src="../back-end/img/<?= $c['avatar'] ?>" style="border-radius: 50%;" width="50px" height="50px" alt="">
                        </div>
                        <div class="user text " style="font-weight: bold;">
                            <?= $c['user_name'] ?> <br>
                            <span><?= $c['cmt_date'] ?></span>
                        </div>
                    </div>
                    <div class="container-comment">
                        <p class="text" style="margin: 10px 0 0 60px;font-size: 14px;"><?= $c['cmt_content'] ?>
                            <span style="float: right;">
                                <?php if (isset($_SESSION['user'])) : ?>
                                    <?php if ($c['user_id'] == $user_id) : ?>
                                    <a onclick="return confirm('Bạn Có Chắc Chắn Muốn Xóa Không')" href="delete_cmt.php?cmt_id=<?= $c['cmt_id']?>&cate_id=<?= $products['cate_id']?>&pro_id=<?= $products['pro_id']?>"><i class="fas fa-trash-alt" style="font-size:15px; color:red"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </span></p>

                    </div>
                <?php endforeach; ?>
                <!--END comment 1-->
                <!--Comment 2-->

                <!--END comment 2-->
                <!--Comment 3-->

                <!--END comment 3-->
                <?php if (!isset($_SESSION['user'])) : ?>
                    <form action="" method="POST" style="text-align:center">
                        <p style="color: red;">Vui Lòng Đăng Nhập Để Nhận Xét</p>
                        <button type="submit" name="LoginCmt" class="btn btn-outline-danger">Đăng Nhập</button>
                    </form>
                <?php else : ?>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-10">
                                    <textarea style="width:100%" name="cmt_content" id="" cols="100" rows="3" class="h-10" placeholder="Viết Nhận Xét Của Bạn..."></textarea>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn-cmt" name="Cmt"><i class="far fa-paper-plane" style="color: white; border: none"></i></button>
                                </div>
                            </div>
                        </form>
                    <?php else : ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!--END-COMMENT-->
        <div class="row">
            <div class="title-comment text" style="margin: 50px auto 0 auto;">
                <h2 style="font-weight: bold; font-size: 28px;">SẢN PHẨM TƯƠNG TỰ</h2>
            </div>
        </div>
        <div class="row mb-5">
            <!--Sản Phảm Liên Quan 1-->
            <?php foreach ($resual as $c) : ?>
                <div class="col-md-2">
                    <div class="product-hover mt-5">
                        <div class="produc-img">
                            <a href="detail.php?cate_id=<?= $c['cate_id'] ?>&pro_id=<?= $c['pro_id'] ?>"><img src="../back-end/img/<?= $c['pro_image'] ?>" style="padding: 5px 5px; width: 100%;" alt=""></a>
                        </div>
                        <div class="item">
                            <a href="detail.php?cate_id=<?= $c['cate_id'] ?>&pro_id=<?= $c['pro_id'] ?>">
                                <p class="mb-0"><?= $c['pro_name'] ?></p>
                            </a>
                            <?php if ($c['pro_sale'] > 0) : ?>
                                <div class="price">
                                    <div class="price">
                                        <label for="" style="line-height: 2px;"><?= price($c['pro_sale']) ?> <del style="color: red; font-size: 8px;"><?= price($c['pro_price']) ?></del></label>
                                    </div>
                                </div>
                            <?php else : ?>
                                <label for="" style="line-height: 2px;"><?= price($c['pro_price']) ?></label>
                            <?php endif; ?>
                            <div class="view">
                                <label for="" style="line-height: 2px;">View: <span><?= $c['pro_view'] ?></span></label>
                            </div>
                            <div class="quantity">
                                <?php $sum_qty = 0; ?>
                                <?php foreach ($pro_detailAll as $p) : ?>
                                    <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                                        <?php $sum_qty += $p['quantity']; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <label for="" style="line-height: 2px;">Số Lượng: <span><?= $sum_qty ?></span> </label>
                            </div>
                            <div class="">
                                <?php $sold = 0; ?>
                                <?php foreach ($pro_detailAll as $p) : ?>
                                    <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                                        <?php $sold += $p['sold'] ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <label for="" style="line-height: 2px;">Đã Bán: <span><?= $sold ?></span></label>
                            </div>
                            <div class="sizes">
                                <label for="" style="line-height: 2px;">Size:
                                    <?php foreach ($pro_detailAll as $p) : ?>
                                        <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                                            <span><?= $p['size'] ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </label>

                            </div>

                        </div>
                    </div>
                    <div class="taitle mt-3">
                        <a href="detail.php?cate_id=<?= $c['cate_id'] ?>&pro_id=<?= $c['pro_id'] ?>" style="color: black;text-decoration: none; font-size: 12px;">
                            <p><?= $c['pro_name'] ?></p>
                        </a>
                        <?php if ($c['pro_sale'] > 0) : ?>
                            <div class="price">
                                <label for="">Giá:</label>
                                <?= price($c['pro_sale']) ?>
                            </div>
                        <?php else : ?>
                            <div class="price">
                                <label for="">Giá:</label>
                                <?= price($c['pro_price']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <!--END Sản Phẩm Liên Quan 1-->

            <!--Sản Phảm Liên Quan 2-->

            <!--END Sản Phẩm Liên Quan 2-->

            <!--Sản Phảm Liên Quan 3-->

            <!--END Sản Phẩm Liên Quan 3-->

            <!--Sản Phảm Liên Quan 4-->

            <!--END Sản Phẩm Liên Quan 4-->

            <!--Sản Phảm Liên Quan 5-->

            <!--END Sản Phẩm Liên Quan 5-->

            <!--Sản Phảm Liên Quan 6-->

            <!--END Sản Phẩm Liên Quan 6-->
        </div>
    </div>
</article>
<!--Phần Footer-->
<?php
include_once "footer.php";
?>
        