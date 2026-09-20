<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Product'); ?>">Admin / Sản phẩm</a>
        / <strong>Sửa</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Sửa sản phẩm</h1>
            <p>Cập nhật thông tin: <strong><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Quay lại danh sách</a>
    </div>

    <div class="admin-panel">
        <?php if (!empty($errors)): ?>
            <div class="text-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('Product/update'); ?>" class="admin-form" enctype="multipart/form-data" onsubmit="return validateForm();">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá (₫)</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01"
                    value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Ảnh sản phẩm</label>
                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (!empty($product->image)): ?>
                    <div style="margin-bottom:10px;">
                        <img src="<?php echo htmlspecialchars(url($product->image), ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image"
                            style="width:120px;height:120px;object-fit:contain;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color:#777;font-size:12px;">Để trống nếu giữ ảnh hiện tại.</small>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Cập nhật</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
