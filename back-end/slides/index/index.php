<?php
ob_start();
include_once "../layout/header.php";
?>
<div class="content" style="padding: 0 30px;">
    <?php if (isset($_SESSION['alert']['warning'])) : ?>
        <div class="alert alert-warning d-flex justify-content-between" role="alert">
            <span><?= $_SESSION['alert']['warning']; ?></span>
            <span><i class="fas fa-exclamation-triangle" style="color: yellow; font-size: 25px;"></i></span>
        </div>
        <?php unset($_SESSION['alert']['warning']); ?>
    <?php endif; ?>
</div>
<?php
include_once "../layout/footer.php";
?>