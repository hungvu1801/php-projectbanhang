<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Sản phẩm</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Sản phẩm</h1>
            <p>Khám phá các sản phẩm đang bán.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/add'); ?>">+ Thêm sản phẩm</a>
    </div>

    <div class="admin-panel">
        <?php if (empty($products)): ?>
            <div class="admin-empty">
                <p>Hiện chưa có sản phẩm nào.</p>
                <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/add'); ?>">Thêm sản phẩm đầu tiên</a>
            </div>
        <?php else: ?>
            <div class="shop-grid">
                <?php foreach ($products as $product): ?>
                    <div class="shop-card">
                        <a href="<?php echo url('Product/show/' . $product->id); ?>" style="text-decoration:none;color:inherit;">
                            <?php if (!empty($product->image)): ?>
                                <img class="shop-card__img" src="<?php echo htmlspecialchars(url($product->image), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php else: ?>
                                <div class="shop-card__img shop-card__img--empty">Chưa có ảnh</div>
                            <?php endif; ?>
                            <h3 class="shop-card__name"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <div class="shop-card__cate"><?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại', ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="shop-card__price"><?php echo number_format((float) $product->price, 0, ',', '.'); ?>₫</div>
                        </a>
                        <div class="shop-card__actions">
                            <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product/edit/' . $product->id); ?>">Sửa</a>
                            <a class="btn-tgdd btn-tgdd-danger" href="<?php echo url('Product/delete/' . $product->id); ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/addToCart/' . $product->id); ?>">Thêm vào giỏ</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
