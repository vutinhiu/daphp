<?php
include_once "header.php";
ob_start();
?>

<?php
if (isset($_POST['btnSearch'])) {
    extract($_REQUEST);
    $sql = "SELECT * FROM products WHERE pro_name LIKE  '%$search%'";
    // echo $sql; die;
     $stmt = $conn-> prepare($sql);
     $stmt->execute();
     $search1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php
$sql = "SELECT * FROM products_detail";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pro_detailAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content container-fluid">
    <div class="header-page text-center">
        <h1 class="text">Tìm kiếm</h1>
        <?php if(isset($search)) : ?>
        <?php if (count($search1) > 0) { ?>
            <p class="text mt-2">Có <span><?php echo count($search1) ?></span> sản phẩm cho tìm kiếm</p>
            <?php } ?>
            <?php if (count($search1) == 0) { ?>
                <h5 class="mt-3">Không tìm thấy nội dung yêu cầu</h5>
                <p>Không tìm thấy "<span class="font-weight-bold"><?= $search ?></span>" . Vui lòng kiểm tra chính tả, sử dụng các từ tổng quát hơn và thử lại!</p>
            <?php } ?>
            <?php endif; ?>

        <div class="hr mx-auto"></div>

        <form action="" class="mt-3 d-flex justify-content-start" method="post">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-4"></div>
                    <div class="col-xl-4 d-flex justify-content-start">
                        <input type="text" name="search" class="form-control" value="" required>
                        <button type="submit" name="btnSearch" style="border:none; background: #fff">
                            <a href="#"><i class="fas fa-search mx-2"></i></a>
                        </button>
                    </div>
                    <div class="col-xl-4"></div>
                </div>
            </div>
        </form>


    </div>
    
        <div class="pt-3">
        <?php if(isset($search) && count($search1) > 0) :?>
            Kết quả tìm kiếm cho "<span class="font-weight-bold"><?= $search ?></span>".
            <?php else :?>
            <?php endif;?>
        </div>
    

    <div class="row mt-3">
    <?php if(isset($search)) :?>
        <?php foreach ($search1 as $c) : ?>
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
        <?php else : ?>
                    <?php endif;?>
    </div>
</div>

<?php
include_once "footer.php";
?>