<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Product'); ?>">Sản phẩm</a>
        / <strong>Giỏ hàng</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Giỏ hàng</h1>
            <p>Sản phẩm bạn đã chọn.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Tiếp tục mua sắm</a>
    </div>

    <div class="admin-panel">
        <?php if (!empty($cart)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img class="cart-thumb" src="<?php echo htmlspecialchars(url($item['image']), ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                <?php endif; ?>
                                <strong><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                            </td>
                            <td><span class="admin-price"><?php echo number_format((float) $item['price'], 0, ',', '.'); ?>₫</span></td>
                            <td><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="admin-toolbar" style="margin-top:16px">
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Tiếp tục mua sắm</a>
                <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/checkout'); ?>">Thanh toán</a>
            </div>
        <?php else: ?>
            <div class="admin-empty">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product'); ?>">Tiếp tục mua sắm</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
