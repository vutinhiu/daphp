<?php
ob_start();
?>
<?php
ob_start();
include_once "../layout/header.php";
?>
<?php
if (isset($_POST['btnluu'])) {
    if ($_FILES['slide_image']['size'] > 0) {
        $slide_image = $_FILES['slide_image']['name'];
    } else {
        $slide_image = "";
    }
    $slide_link = $_POST['slide_link'];
    $slide_pr = $_POST['slide_pr'];
    $sql = "INSERT INTO slides(slide_image,slide_link,slide_pr) Values('$slide_image','$slide_link','$slide_pr')";
    //chuẩn bị 
    $stmt = $conn->prepare($sql);
    //thực thi
    $stmt->execute();

    if (!empty($slide_image)) {
        move_uploaded_file($_FILES['slide_image']['tmp_name'], "../img/" . $slide_image);
    }
    header("location: list.php?message=Thêm dữ liệu thành công");
    die;
}
?>
<div class="content" style="padding: 0 30px;">
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="">Ảnh slide</label>
        <br>
        <input type="file" class="input" name="slide_image" id="">
        <br><br>
        <label for="">Link slide</label>
        <br>
        <input type="text" name="slide_link" class="form-control" placeholder="slider_link" aria-describedby="basic-addon1">
        <br>
        <label for="">PR slide</label>
        <br>
        <select class="custom-select" name="slide_pr" class="input" id="inputGroupSelect01">
            <option name="slide_pr" class="input" value="1" selected>One</option>
            <option name="slide_pr" class="input" value="2">Two</option>
        </select>
        <br> <br>
        <button type="submit" name="btnluu" class="btn btn-secondary">Thêm mới</button>
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