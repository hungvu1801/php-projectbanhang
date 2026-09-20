<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Product'); ?>">Sản phẩm</a>
        / <strong><?php echo htmlspecialchars($product->name ?? 'Chi tiết', ENT_QUOTES, 'UTF-8'); ?></strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Chi tiết sản phẩm</h1>
            <p>Thông tin đầy đủ về sản phẩm.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">← Danh sách</a>
    </div>

    <div class="admin-panel">
        <?php if ($product): ?>
            <div class="product-detail">
                <?php if (!empty($product->image)): ?>
                    <img class="product-detail__img" src="<?php echo htmlspecialchars(url($product->image), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                <?php else: ?>
                    <div class="product-detail__img product-detail__img--empty">Chưa có ảnh</div>
                <?php endif; ?>
                <div>
                    <h2 class="product-detail__name"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="product-detail__price"><?php echo number_format((float) $product->price, 0, ',', '.'); ?>₫</div>
                    <div class="product-detail__meta">
                        Danh mục: <strong><?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa phân loại'; ?></strong>
                    </div>
                    <div class="product-detail__desc"><?php echo nl2br(htmlspecialchars($product->description ?: 'Chưa có mô tả.', ENT_QUOTES, 'UTF-8')); ?></div>
                    <div class="admin-toolbar" style="margin-top:20px">
                        <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/addToCart/' . $product->id); ?>">Thêm vào giỏ hàng</a>
                        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Xem thêm sản phẩm</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="admin-empty">
                <h4>Không tìm thấy sản phẩm!</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
