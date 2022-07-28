<?php
ob_start();
?>
<?php
include_once "../layout/header.php"
?>
<?php
if (isset($_POST['btnLuu'])) {
    extract($_REQUEST);
    if ($_FILES['pro_image']['size'] > 0) {
        $pro_image = $_FILES['pro_image']['name'];
    }
    //Câu Lệnh QSL UPDATE 
    $sql = "UPDATE products set cate_id='$cate_id', pro_name='$pro_name', pro_image='$pro_image',pro_price='$pro_price', pro_sale='$pro_sale', pro_intro='$pro_intro', pro_view='$pro_view' WHERE pro_id = $pro_id";
    //echo $sql; die;
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        header("location:list.php");
        //Upload file nếu có
        if ($_FILES['pro_image']['size'] > 0) {
            move_uploaded_file($_FILES['pro_image']['tmp_name'], "../img/" . $pro_image);
        }
    } else {
        $message = "Cập Nhật dữ liệu thất bại!!!";
    }
}
$pro_id = $_GET['id'];
//Câu lệnh select với điều kiện pro_id
$sql = "SELECT * FROM products WHERE pro_id=$pro_id";
//Chuẩn bị
$stmt = $conn->prepare($sql);
//Thực thi
$stmt->execute();
//Lấy 1 dòng dữ liệu
$result = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <input type="hidden" name="pro_id" value="<?= $result['pro_id'] ?>">
            <label for="">Chọn Mã Danh Mục</label>
            <br>
            <select style="width: 100%;height: 37px;" name="cate_id" id="">
                <?php foreach ($cate as $c) : ?>
                    <!--Kiểm tra xem sản phẩm đang ở danh mục nào, thì selected danh mục đó-->
                    <?php if ($c['cate_id'] == $result['cate_id']) : ?>
                        <option value="<?= $c['cate_id'] ?>" selected><?= $c['cate_name'] ?></option>
                    <?php else : ?>
                        <option value="<?= $c['cate_id'] ?>"><?= $c['cate_name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <br>

            <br>
            <label for="">Tên Sản Phẩm</label>
            <br>
            <input class="form-control" type="text" name="pro_name" id="" value="<?= $result['pro_name'] ?>" required>
            <br>
            <label for="">Hình Ảnh</label>
            <br>
            <input class="" type="file" name="pro_image" id="" >
            <br>
            <?php if (!empty($result['pro_image'])) : ?>
                <input type="hidden" name="pro_image" value="<?= $result['pro_image'] ?>">
                <br>
                <img src="../img/<?= $result['pro_image'] ?>" width="120" height="150" alt="">
            <?php endif; ?>
            <br>
            <br>
            <label for="">Giá Sản Phẩm</label>
            <input class="form-control" type="number" name="pro_price" id="" value="<?= $result['pro_price'] ?>" >
            <br>
            
        </div>
        <div class="col-12">
        <label for="">Giá SaLe</label>
            <input class="form-control" type="number" name="pro_sale" id="" value="<?= $result['pro_sale'] ?>">
            <br>    
            <label for="">Giới Thiệu</label>
            <textarea id="editor1" name="pro_intro" cols="80" rows="10"><?= $result['pro_intro'] ?></textarea>
            <br>
        </div>
        <button style="width: 30%; margin:12px" class="btn-dark btn mt-3" type="submit" name="btnLuu">Lưu</button>
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