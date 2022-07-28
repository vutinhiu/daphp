<?php
session_start();
require_once "../back-end/db.php";
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['user_id'];
    $us = $_SESSION['user']['name'];
    $av = $_SESSION['user']['avatar'];
    $ro = $_SESSION['user']['role'];
}
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
$sql = "SELECT * FROM categories WHERE cate_pr=0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate_pr = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*Đếm số lượng cart*/
if (isset($_SESSION['user'])) {
    if (isset($_SESSION['cart'][$user_id])) {
        $cart = $_SESSION['cart'][$user_id];
        $qty_cart = count($_SESSION['cart'][$user_id]);
    } else {
        $qty_cart = 0;
    }
}
?>
<?php
$sql = "SELECT * FROM theme";
$stmt = $conn->prepare($sql);
$stmt->execute();
$theme = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Me CSS -->
    <link rel="stylesheet" href="css/css.css">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Font-family -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400&display=swap" rel="stylesheet">



    <!--Link Slide SLICK-->
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css" />
    <title>Routine</title>


</head>

<body>
    <header style="z-index: 999;">
        <div class="header-top container-fluid text-center">
            <?php foreach ($theme as $t) : ?>
                <p class="mx-auto m-0 p-1">Hotline Mua Hàng: <b><?= $t['theme_phone'] ?></b> | Hotline CSKH: <b>1900 63 65 91</b> - Ext 1 | Email
                    CSKH: <b><?= $t['theme_email'] ?></b> </p>
            <?php endforeach; ?>
        </div>
        <div class="logo text-center py-3 position-relative">
            <a href="index.php"><img src="../back-end/img/<?= $t['theme_logo'] ?>" width="" alt=""></a>
            <div class="position-absolute d-flex icon-cart" style="top: 40%; right: 5%;">
                <?php if (!isset($_SESSION['user'])) : ?>
                    <a href="user/login.php"><i class="fas fa-user mx-2"></i></a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="dropdown">
                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text mx-2" style="font-size: 16px; font-weight: bold; color: black;">Xin chào: @<?= $us; ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php if ($ro > 1) : ?>
                                <a class="dropdown-item" href="../back-end/index/index.php">Vào trang quản trị</a>
                            <?php endif; ?>
                                <a class="dropdown-item" href="user_detail.php">Thông tin cá nhân</a>
                                <a class="dropdown-item" href="order.php">Đơn hàng</a>
                                <a class="dropdown-item" href="user/logout.php">Đăng xuất</a>
                        </div>
                    </div>
                    <a href="cart.php">
                        <i class="fas fa-shopping-cart mx-2 position-relative">
                            <span class="position-absolute text" style="top: 12%; left: 52%; z-index: 2; color:white; font-size: 11px;"><?= $qty_cart ?></span>
                        </i>
                    </a>
                <?php endif; ?>
                <a href="search.php"><i class="fas fa-search mx-2"></i></a>
            </div>
        </div>
    </header>
    <main>
    <nav class="sticky-top"  style="z-index: 99;">
        <ul>
            <?php foreach ($cate_pr as $key => $item) { ?>
                <?php $cate_id = $item['cate_id'] ?>
                <?php
                $sql = "SELECT * FROM categories WHERE cate_pr = $cate_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $cate_chill = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <li>
                    <a href="pro.php?cate_id=<?= $cate_id ?>"><?= $item['cate_name'] ?>
                        <?php if (COUNT($cate_chill) > 0) { ?>
                            <i class="fa fa-chevron-down"></i>
                        <?php } ?>
                    </a>
                    <ul class="mncon">
                        <?php if (isset($cate_chill)) { ?>
                            <?php foreach ($cate_chill as $key => $item) { ?>
                                <li><a href="pro.php?cate_id=<?= $item['cate_id'] ?>"><?= $item['cate_name'] ?></a>
                                </li>
                            <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        <?php } ?>
        </ul>
    </nav>