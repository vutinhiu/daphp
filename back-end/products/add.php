<?php
ob_start();
?>
<?php
include_once "../layout/header.php"
?>

<?php
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);
    //Câu Lệnh Bắt Lỗi Trung Tên
    $sql = "SELECT * FROM products WHERE pro_name='$pro_name'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($pro_name) ; die;
    if (empty($pro_name)) {
        $nameErr = "<p style='color: red;font-size:10px'>Vui Lòng Nhập Tên Sản Phẩm</p>";
    } else if (count($pro) > 0) {
        $name_exit = "<p style='color: red;font-size:10px'>Sản Phẩm Đã Tồn Tại</p>";
    } else if(empty($pro_price)){
        $price_exit = "<p style='color: red;font-size:10px'>Vui Lòng Nhập Giá Sản Phẩm</p>";
    } else {
        if ($_FILES['pro_image']['size'] > 0) {
            $pro_image = $_FILES['pro_image']['name'];
        } else {
            $pro_image = "";
        }

        //Viết Câu Lệnh SQL thể thêm dữ liệu cho bảng sản phẩm (products)
        $sql = "INSERT INTO products(cate_id, pro_name, pro_image, pro_price, pro_sale, pro_intro, pro_view) 
        VALUES('$cate_id','$pro_name','$pro_image','$pro_price','$pro_sale','$pro_intro','$pro_view')";
        //Chuẩn bị thực hiện
        $stmt = $conn->prepare($sql);
        //Thực thi
        $stmt->execute();
        if (!empty($pro_image)) {
            move_uploaded_file($_FILES['pro_image']['tmp_name'], "../img/" . $pro_image);
        }
        header("location:list.php?message=Thêm Dữ Liệu Thành Công");
        die;
    }
}
?>
<?php
//Lấy Tất Cả Dữ Liệu Trong Bảng Products
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <form class="add-pro" action="" method="post" enctype="multipart/form-data">
        <div class="col-12">
            <label for="">Chọn Mã Danh Mục</label>
            <br>
            <select style="width: 100%; height:38px" name="cate_id" id="">
                <?php foreach ($cate as $c) : ?>
                    <option value="<?= $c['cate_id'] ?>"><?= $c['cate_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <br>
            <label for="">Tên Sản Phẩm</label>
            <br>
            <?php if(empty($pro_name)) :?>
            <input class="form-control" type="text" name="pro_name" id="">
            <?php else :?>
                <input class="form-control" type="text" name="pro_name" value="<?php echo $pro_name?>" id="">
            <?php endif; ?>
            <?php if(isset($nameErr)) : ?>
                <?= $nameErr?>
            <?php endif; ?>
            <?php if(isset($name_exit)) : ?>
                <span><?= $name_exit?></span>
            <?php endif; ?>
            <br>
            <label for="">Hình Ảnh</label>
            <br>
            <input class="" type="file" name="pro_image" id="" >
            <br>
            <br>
            <label for="">Giá Sản Phẩm</label>
            <?php if(empty($pro_price)) :?>
            <input class="form-control" type="number" name="pro_price" id="">
            <?php else : ?>
                <input class="form-control" type="number" name="pro_price" value="<?php echo $pro_price ?>" id="">
            <?php endif; ?>
            <?php if(isset($price_exit))  :?>
                <span><?= $price_exit?></span>
            <?php endif; ?>
            <br>
            <label for="">Giá SaLe</label>
            <input class="form-control" type="number" name="pro_sale" id="">
            <br>
        </div>
        <div class="col-12">
            <label for="">Giới Thiệu</label>
            <textarea id="editor1" name="pro_intro" cols="80" rows="10"></textarea>
            <br>
        </div>
        <button style="width: 30%; margin:12px" class="btn-dark btn mt-3" type="submit" name="btnLuu">Thêm mới</button>
        <script>
            CKEDITOR.replace('editor1');
        </script>
    </form>

    <br>
    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php"
?>