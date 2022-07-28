<?php
ob_start();
include_once "header.php";
?>

<?php
if (!isset($_SESSION['user'])) {
    header("location:user/login.php");
    die;
}



if (isset($_SESSION['cart'][$user_id])) {
    $cart = $_SESSION['cart'][$user_id];
    $qty_cart = count($_SESSION['cart'][$user_id]);

    $sql = "Select * from products_detail";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pro_dt = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php
if (isset($_POST['update'])) {
    $q = $_POST['quantity'];
    $s = $_POST['size'];
    $cart_id = $_POST['cart_id'];
    $_SESSION['cart'][$user_id][$cart_id]['qty'] = $q;
    $_SESSION['cart'][$user_id][$cart_id]['size'] = $s;
    header("location: cart.php");
}
?>

<?php
if (isset($_POST['btnDelete'])) {
    $cart_id = $_POST['cart_id'];
    unset($_SESSION['cart'][$user_id][$cart_id]);
    header("location: cart.php");
}
?>

<article>
    <div class="location container-fluid text-left">
        <p class="mx-auto m-0 p-2">
            <a href="index.php">Trang chủ</a> /
            <a href="cart.php">Giỏ hàng</a>
        </p>
    </div>

    <div class="content container-fluid">
        <?php if (isset($cart) && $qty_cart > 0) : ?>
            <div class="header-page text text-center">
                <h1>Giỏ hàng của bạn</h1>
                <p>Có <?= $qty_cart ?> sản phẩm trong giỏ hàng.</p>
                <div class="hr mx-auto"></div>
            </div>
            <div class="content-cart">
                <?php foreach ($cart as $c) : ?>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?= $c['id']; ?>">
                        <?php 
                        $sql = "Select * from products where pro_id='" . $c['id'] . "'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $img = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="d-flex">
                            <div class="img-cart">
                                <a href="#"><img src="../back-end/img/<?= $img['pro_image']?>" alt="" width="120px"></a>
                            </div>
                            <div class="text item-cart">
                                <div class="position-relative">
                                    <a href="#">
                                        <h3><?= $c['name']; ?></h3>
                                    </a>
                                    <span>Giá: <?= price($c['pr']); ?></span>
                                    <input type="number" style="display: none;" name="" id="price_pro" value="<?= $c['pr']; ?>">
                                    <br>
                                    <span>
                                        Size:
                                        <select name="size" id="" style="border: none;" onchange="change_<?= $c['id']; ?>()">
                                            <?php foreach ($pro_dt as $p) : ?>
                                                <?php if ($p['pro_id'] == $c['id']) : ?>
                                                    <?php if ($p['size'] == $c['size']) : ?>
                                                        <option value="<?= $p['size'] ?>" selected><?= $p['size'] ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $p['size'] ?>"><?= $p['size'] ?></option>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </span>
                                    <br>
                                    <input type="hidden" name="id" value="<?= $c['id']; ?>">
                                    <div class="input_qty">
                                        <input class="button_qty" id="tru" type="button" value="-" onclick="tru_<?= $c['id']; ?>();change_<?= $c['id']; ?>();pr_<?= $c['id']; ?>();">
                                        <input name="quantity" max="50" type="number" min="1" value="<?= $c['qty']; ?>" id="qty_<?= $c['id']; ?>" oninput="pr_<?= $c['id']; ?>();change_<?= $c['id']; ?>()" style="border: none; text-align: center;" required>
                                        <input class="button_qty" id="cong" type="button" value="+" onclick="cong_<?= $c['id']; ?>();change_<?= $c['id']; ?>();pr_<?= $c['id']; ?>();">
                                    </div>
                                    <script>
                                        function tru_<?= $c['id']; ?>() {
                                            var qty = document.getElementById("qty_<?= $c['id']; ?>").value;
                                            if (qty <= 1) {
                                                document.getElementById("qty_<?= $c['id']; ?>").value = qty;
                                            } else {
                                                qty--;
                                                document.getElementById("qty_<?= $c['id']; ?>").value = qty;
                                            }
                                            document.getElementById("price_<?= $c['id']; ?>").value = qty * <?= $c['pr']; ?>;
                                        }

                                        function cong_<?= $c['id']; ?>() {
                                            var qty = document.getElementById("qty_<?= $c['id']; ?>").value;
                                            qty++;
                                            document.getElementById("qty_<?= $c['id']; ?>").value = qty;
                                            document.getElementById("price_<?= $c['id']; ?>").value = qty * <?= $c['pr']; ?>;
                                        }

                                        function pr_<?= $c['id']; ?>() {
                                            var qty = document.getElementById("qty_<?= $c['id']; ?>").value;
                                            if (qty <= 1) {
                                                document.getElementById("qty_<?= $c['id']; ?>").value = 1;
                                            }
                                            document.getElementById("price_<?= $c['id']; ?>").innerHTML = qty * <?= $c['pr']; ?>;
                                        }

                                        function change_<?= $c['id']; ?>() {

                                            document.getElementById("btn_update_<?= $c['id']; ?>").style.display = "block";
                                        }
                                    </script>
                                    <div class="position-absolute text-right" style="right: 0; top: 0;">
                                        <button type="submit" name="btnDelete" style="border: none; background: none; font-size: 20px;"><i class="fas fa-times"></i></button>
                                        <?php $q = $c['pr'] * $c['qty'] ?>
                                        <p>Tạm tính: <span id="price_<?= $c['id']; ?>"><?= price($q); ?></span></p>
                                    </div>
                                    <button name="update" class="position-absolute btn btn-success" style="display: none; right: 0; bottom: 0;" id="btn_update_<?= $c['id']; ?>" type="submit">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
                <div class="text-right cart-submit text">
                    <?php
                    $money = 0;
                    foreach ($cart as $c) {
                        $money += $c['qty'] * $c['pr'];
                    }
                    ?>
                    <h1>Thành tiền: <?= price($money) ?></h1>
                    <a href="order.php" class="submit">Đơn hàng</a>
                    <a href="checkout.php" class="submit">Thanh toán</a>
                </div>
                </form>
            </div>
        <?php else : ?>
            <div class="header-page text text-center">
                <h1>Giỏ hàng của bạn</h1>
                <p>Không có giỏ hàng nào trong tài khoản của bạn!</p>
                <img src="../back-end/img/empty_cart.jpg" alt="" height="500px">
            </div>
        <?php endif; ?>
    </div>
</article>


<?php
include_once "footer.php"
?>