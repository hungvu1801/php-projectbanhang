<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Xác nhận đơn hàng</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Xác nhận đơn hàng</h1>
            <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
        </div>
    </div>

    <div class="admin-panel">
        <div class="admin-empty">
            <p>Đơn hàng của bạn đã được ghi nhận.</p>
            <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product'); ?>">Tiếp tục mua sắm</a>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
