<?php
ob_start();
include_once "../layout/header.php"
?>
<?php
if (isset($_POST['btnluu'])){
    extract($_REQUEST);
    //nếu người dùng upload mới
    if($_FILES['slide_image']['size']>0){
        $slide_image = $_FILES['slide_image']['name'];
    }
    //câu lệnh sql update
    $sql = "UPDATE slides SET  slide_image = '$slide_image', slide_link = '$slide_link' , slide_pr = '$slide_pr' WHERE slide_id=$slide_id";
    //chuẩn bị
    $stmt = $conn->prepare($sql);
    //thực thi
    if($stmt->execute()){
        //upload file nếu có
        if($_FILES['slide_image']['size']>0){
            move_uploaded_file($_FILES['slide_image']['tmp_name'], "../img/" . $slide_image);
        }
        header("location:list.php?message=Cập nhật dữ liệu thành công!");
    }else{
            header("location:list.php?message=Cập nhật dữ liệu thất bại!!!");
        }
}
$slide_id=$_GET['id'];
//câu lệnh select với điều kiện cate_id
$sql= "SELECT * FROM slides WHERE slide_id = $slide_id";
//chuẩn bị
$stmt= $conn->prepare($sql);
//thực thi
$stmt->execute();
//lấy 1 dòng dữ liệu
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="content" style="padding: 0 30px;">
<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="slide_id" value="<?=$result['slide_id']?>">
    <br><br>
        <label for="">Ảnh slide</label>
        <br>
        <input type="file" name="slide_image" id="">
        <br>
        <?php if(!empty($result['slide_image'])) : ?>
        <input type="hidden"  name="slide_image" value="<?=$result['slide_image']?>" id="">
        <br>
        <img src="../img/<?=$result['slide_image']?>" width="120" height="150" alt="">
        <?php endif; ?>
        <br><br>
        <label for="">Link slide</label>
        <br>
        <input type="text" name="slide_link" class="form-control" placeholder="slider_link" value="<?=$result['slide_link']?>"  aria-describedby="basic-addon1">
        <br><br>
        <label for="">PR slide</label>
        <br>
        <select class="custom-select" name="slide_pr" id="inputGroupSelect01">
        <?php  if($result['slide_pr'] == 1) : ?>
            <option name="slide_pr" value="1" selected>One</option>
            <option name="slide_pr" value="2">Two</option>
            <?php elseif($result['slide_pr'] == 2) : ?>
            <option name="slide_pr" value="1">One</option>
            <option name="slide_pr" value="2" selected>Two</option>
                <?php endif; ?>
        </select>
        <br><br>
        <button type="submit" class="btn btn-secondary" name="btnluu">Lưu</button>
    </form>

    <?php if (isset($_GET['message'])) : ?>
        <div class="alert alert-dark" role="alert">
            <?= $_GET['message'] ?>
        </div>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php"
?>