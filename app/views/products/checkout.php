<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Product/cart'); ?>">Giỏ hàng</a>
        / <strong>Thanh toán</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Thanh toán</h1>
            <p>Nhập thông tin giao hàng.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product/cart'); ?>">Quay lại giỏ hàng</a>
    </div>

    <div class="admin-panel">
        <form method="POST" action="<?php echo url('Product/processCheckout'); ?>" class="admin-form">
            <div class="form-group">
                <label for="name">Họ tên</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Thanh toán</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product/cart'); ?>">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
