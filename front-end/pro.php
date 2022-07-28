<?php
ob_start();
include_once "header.php";
?>
<?php
    $cate_id = $_GET['cate_id'];

    $sql = "SELECT * FROM categories WHERE cate_pr=$cate_id OR cate_id = $cate_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $list_cat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $listIdCat = [];
    foreach($list_cat as $row){
        $listIdCat[] = $row['cate_id'];
    }
    $listIdCat = implode(",", $listIdCat);

    $stmt = $conn->prepare("SELECT * FROM products WHERE cate_id IN ($listIdCat ) ");
    $stmt->execute();
    $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql1= "SELECT * FROM products WHERE cate_id=$cate_id";
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $pro_pr = $stmt->fetch(PDO::FETCH_ASSOC);


    $sql1= "SELECT * FROM categories";
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $cate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql1= "SELECT * FROM categories WHERE cate_id=$cate_id";
    $stmt = $conn->prepare($sql1);
    $stmt->execute();
    $cate1 = $stmt->fetch(PDO::FETCH_ASSOC);
    

    $sql2= "SELECT * FROM products_detail";
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $pro_detailAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    if(isset($_POST['btnSort'])) {
        $sort = $_POST['sort'];
        $_SESSION['sort'] = $sort;
        $sql = "SELECT * FROM categories WHERE cate_pr=$cate_id OR cate_id = $cate_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $list_cat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listIdCat = [];
        foreach($list_cat as $row){
            $listIdCat[] = $row['cate_id'];
        }
        $listIdCat = implode(",", $listIdCat);
        if($sort == 1) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE cate_id IN ($listIdCat ) ORDER BY pro_id DESC LIMIT 0,12");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($sort == 2) {
            $stmt = $conn->prepare("SELECT * FROM products WHERE cate_id IN ($listIdCat ) ORDER BY pro_view DESC LIMIT 0,12");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($sort == 3) {
            $stmt = $conn->prepare("SELECT * FROM products WHERE cate_id IN ($listIdCat ) ORDER BY pro_price DESC LIMIT 0,12");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($sort == 4) {
            $stmt = $conn->prepare("SELECT * FROM products WHERE cate_id IN ($listIdCat ) ORDER BY pro_price ASC LIMIT 0,12");
        $stmt->execute();
        $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
<article>


<div class="title-cate">
   <a href="">Trang chủ</a>  / <a href="">Danh mục</a> / <a href=""><?=$cate1['cate_name']?></a>
</div>

<style> 
.title-cate{
    background-color : #f3f3f3;
    padding-top : 20px;
    padding-bottom : 20px;
    height : 60px
}
.title-cate a{
    color : black;
    font-family: "Quicksand", sans-serif;
    text-align: center ;
}
</style>
<div class="container-fluid">
<br><br>
<div style="float:left;" class="title-pro">
  <h3><?=$cate1['cate_name']?></h3>
</div>
<form action="" method="post">
    <div class="sort">
        <div style="float:right;  width:200px;"  class="input-group">
            <select class="custom-select" style="display: block;
    border-color: transparent;
    border-bottom: 1px solid black;
    outline: 0;"  name='sort' id="inputGroupSelect02">
                <option value='0' selected>------</option>
                <option value='1'>Mới Nhất</option>
                <option value="2">Nhiều Lượt Xem</option>
                <option value="3">Giá giảm dần</option>
                <option value="4">Giá tăng dần</option>
            </select>
            <div class="input-group-append">
            <button style="border-radius:8px;" name="btnSort">Sắp xếp</button> 
            </div>
        </div>
    </div>
    </form>
    <br><br><br>
    <div class="row">
    <?php foreach($pro as $c) : ?>
        <div class="col-md-3">
                <div class="product-hover mt-5">
                    <div class="produc-img">
                        <a href="detail.php?cate_id=<?= $c['cate_id']?>&pro_id=<?= $c['pro_id']?>"><img src="../back-end/img/<?= $c['pro_image'] ?>" style="padding: 5px 5px; width: 100%;" alt=""></a>
                    </div>
                    <div class="item">
                        <a  href="detail.php?cate_id=<?= $c['cate_id']?>&pro_id=<?= $c['pro_id']?>">
                            <p style="color: black;text-decoration: none; font-size: 17px;padding: 10px 5px" class="mb-0"><?= $c['pro_name'] ?></p>
                        </a>
                        <?php if ($c['pro_sale'] > 0) : ?>
                            <div class="price">
                                <div class="price">
                                    <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;"><?= price($c['pro_sale']) ?> <del style="color: red; font-size: 15px;"><?= price($c['pro_price']) ?></del></label>
                                </div>
                            </div>
                        <?php else : ?>
                            <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;"><?= price($c['pro_price']) ?></label>
                        <?php endif; ?>
                        <div class="view">
                            <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;">View: <span><?= $c['pro_view'] ?></span></label>
                        </div>
                        <div class="quantity">
                            <?php $sum_qty = 0; ?>
                            <?php foreach ($pro_detailAll as $p) : ?>
                                <?php if ($c['pro_id'] == $p['pro_id']) : ?>
                                    <?php $sum_qty += $p['quantity']; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;">Số Lượng: <span><?= $sum_qty ?></span> </label>
                        </div>
                        <div class="">
                            <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;">Đã Bán: <span>12</span></label>
                        </div>
                        <div class="sizes">
                            <label for="" style="line-height: 2px;padding: 7px 5px;color: black;text-decoration: none; font-size: 15px;">Size:
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
                    <a href="detail.php?cate_id=<?= $c['cate_id']?>&pro_id=<?= $c['pro_id']?>" style="color: black;text-decoration: none; font-size: 20px;">
                        <p><?= $c['pro_name'] ?></p>
                    </a>
                    <?php if ($c['pro_sale'] > 0) : ?>
                        <div class="price">
                            <label style="color: black;text-decoration: none; font-size: 20px;" for="">Giá:
                            <?= price($c['pro_sale']) ?></label>
                        </div>
                    <?php else : ?>
                        <div class="price">
                            <label for="" style="color: black;text-decoration: none; font-size: 20px;">Giá:
                            <?= price($c['pro_price']) ?></label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
          <?php endforeach; ?>
    </div>
</div>
</article>
<!--Phần Footer-->
<?php
include_once "footer.php";
?>