<?php
ob_start();
require_once "header.php";
?>
<?php
require_once "../back-end/db.php";
$sql3 = "SELECT * FROM slides WHERE slide_pr = 1 ORDER BY slide_id ASC LIMIT 1 ";
// echo $sql3;
// die;
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$slide_1 = $stmt3->fetch(PDO::FETCH_ASSOC);
$slide_active = $slide_1['slide_id'];


$sql3 = "SELECT  * FROM slides WHERE slide_id != $slide_active AND slide_pr = 1";
// echo $sql3;
// die;
$stmt3 = $conn->prepare($sql3);
$stmt3->execute();
$slide = $stmt3->fetchAll(PDO::FETCH_ASSOC);
// lấy ra thông tin sản phẩm
$sql = "SELECT * FROM products_detail";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_detailAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
// lấy ra danh sách sản phẩm
$sql  = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products =  $stmt->fetchAll(PDO::FETCH_ASSOC);

// $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 6";
$sql = "SELECT * FROM products ORDER BY pro_id DESC LIMIT 6";
// echo $sql;
// die;
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro =  $stmt->fetchAll(PDO::FETCH_ASSOC);
// lấy ra lượt xem sản phẩm
$sql = "SELECT * FROM products ORDER BY pro_view DESC LIMIT 12";
// echo $sql;
// die;
$stmt = $conn->prepare($sql);
$stmt->execute();
$resual =  $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT products.*, SUM(products_detail.sold) AS sum FROM products INNER JOIN products_detail ON products.pro_id = products_detail.pro_id GROUP BY products_detail.pro_id ORDER BY sum DESC LIMIT 0,12";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_sold = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM slides WHERE slide_pr = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$slide_pr =  $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM slides WHERE slide_pr = 2";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_slide =  $stmt->fetchAll(PDO::FETCH_ASSOC);




?>
<!-- carousel -->
<div class="container-fluid">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php if (isset($slide_active)) : ?>
                <div class="carousel-item active">
                    <a href="<?= $slide_1['slide_link'] ?>"><img src="../back-end/img/<?= $slide_1['slide_image'] ?>" class="d-block w-100" alt="..."></a>
                </div>
            <?php endif; ?>
            <?php foreach ($slide as $s) { ?>
                <?php //if($lide_id!=$slide_active){ 
                ?>
                <div class="carousel-item">
                    <a href="<?= $s['slide_link'] ?>"><img src="../back-end/img/<?= $s['slide_image'] ?>" class="d-block w-100" alt="..."></a>
                </div>
                <?php //} 
                ?>
            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div> <!-- End Slide show -->
<!-- Testimonials -->


<div class="slider">
    <div >
        <h3 class="text-center mt-5 mb-5  font-weight-bold text-uppercase" style="font-size: 28px; font-family:Quicksand, sans-serif;">
            Bộ Sưu Tập
        </h3>
        <div class="row autoplay">
            <?php foreach ($pro_slide as $c) : ?>
                <div class="col-md-4" style="padding-left: 0; padding-right: 0;">
                    <div class="product-hover">
                        <div class="produc-img" style="position: relative;">
                            <a href="<?= $c['slide_link']?>"><img src="../back-end/img/<?= $c['slide_image'] ?>" width="100%" alt=""></a>
                            <div style=" height: 100px;position: absolute; bottom:0px; background-color: rgba(0, 0, 0, 0.5); width:100%;text-align: left;">
                            <p class="text mt-2" style="margin-left: 20px;font-weight: bold;color: white;">Bộ Sưu Tập Routine</p>    
                            <a class="text" style="color: black;background-color: #ffffff;margin-left: 20px; padding: 5px;" href="<?= $c['slide_link']?>">Xem Ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>





<div class="slider">
    <div class="container-fluid">
        <h3 class="text-center mt-5 mb-5 font-weight-bold text-uppercase" style="font-size: 28px; font-family:Quicksand, sans-serif;">
            Sản Phẩm Nhiều View
        </h3>
        <div class="row your-class">
            <?php foreach ($resual as $c) : ?>
                <div class="col-md-2" >
                    <div class="product-hover">
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
        </div>
    </div>
</div>
<div class="list-slide">
    <div class="container-fluid">
        <h3 class="text-center pt-4 pb-4 font-weight-bold text-uppercase" style="font-size: 28px; font-family:Quicksand, sans-serif;">
            sản phẩm mới
        </h3>
        <div class="row">
            <?php foreach ($pro as $key => $item) {
                $pro_id_pr = $item['pro_id'];


                $sql = "SELECT * FROM products_detail where pro_id = $pro_id_pr";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $pro_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $sql = "SELECT SUM(quantity) as summ FROM products_detail where pro_id = $pro_id_pr";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $new_pro =  $stmt->fetch(PDO::FETCH_ASSOC);

                $sql = "SELECT SUM(sold) as summ_sold FROM products_detail where pro_id = $pro_id_pr";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $new_pro_2 =  $stmt->fetch(PDO::FETCH_ASSOC);

            ?>

                <div class="col-md-2">
                    <div class="product-hover">
                        <div class="produc-img">
                            <a href="detail.php?cate_id=<?= $item['cate_id'] ?>&pro_id=<?= $item['pro_id'] ?>"><img src="../back-end/img/<?php echo $item['pro_image'] ?>" style="padding: 5px 5px; width: 100%;" alt=""></a>
                        </div>
                        <div class="item">
                            <a href="detail.php?cate_id=<?= $item['cate_id'] ?>&pro_id=<?= $item['pro_id'] ?>">
                                <p class="mb-0"><?php echo $item['pro_name'] ?></p>
                            </a>
                            <?php if ($item['pro_sale'] > 0) : ?>
                                <div class="price">
                                    <label for="" style="line-height: 2px;">Giá: <?php echo price($item['pro_sale'])  ?> <del style="color: red; font-size: 8px;"><?php echo price($item['pro_price'])  ?></del></label>
                                </div>
                            <?php else : ?>
                                <label for="" style="line-height: 2px;">Giá: <?php echo price($item['pro_price'])  ?></label>
                            <?php endif; ?>
                            <div class="view">
                                <label for="" style="line-height: 2px;">View: <span><?php echo $item['pro_view'] ?></span></label>
                            </div>
                            <div class="quantity">
                                <label for="" style="line-height: 2px;">Số Lượng: <span><?php echo $new_pro['summ'] ?></span> </label>
                            </div>
                            <div class="">
                                <label for="" style="line-height: 2px;">Đã Bán: <span><?php echo $new_pro_2['summ_sold'] ?></span></label>
                            </div>

                            <div class="sizes">
                                <label for="" style="line-height: 2px;">Size: <?php foreach ($pro_detail as $key => $size) { ?><span class="mr-1"><?php echo $size['size'] ?></span><?php } ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="taitle mt-3">
                        <a href="detail.php?cate_id=<?= $item['cate_id'] ?>&pro_id=<?= $item['pro_id'] ?>" style="color: black;text-decoration: none; font-size: 12px;">
                            <p><?php echo $item['pro_name'] ?></p>
                        </a>
                        <?php if ($item['pro_sale'] > 0) : ?>
                            <div class="price">
                                <label for="">Giá:</label>
                                <?php echo price($item['pro_sale'])  ?>
                            </div>
                        <?php else : ?>
                            <div class="price">
                                <label for="">Giá:</label>
                                <?php echo price($item['pro_price'])  ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end list-slide -->
<!-- card -->
<div class="products">
    <div class="container-fluid">
        <h3 class="text-center pt-4 pb-4 font-weight-bold text-uppercase" style="font-size: 28px; font-family:Quicksand, sans-serif;">
            Sản phẩm bán chạy
        </h3>
        <div class="row">
        <?php foreach ($pro_sold as $c) : ?>
                <div class="col-md-2" >
                    <div class="product-hover">
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
        </div>

    </div>
</div>

<!-- end card -->



<!--SCRIPTS SLiCK-->

<?php
require_once "footer.php";
?>