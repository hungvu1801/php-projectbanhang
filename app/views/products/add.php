<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Product'); ?>">Admin / Sản phẩm</a>
        / <strong>Thêm mới</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Thêm sản phẩm</h1>
            <p>Nhập thông tin sản phẩm mới.</p>
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
        <form method="POST" action="<?php echo url('Product/save'); ?>" class="admin-form" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: iPhone 17 Pro Max" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Giá (₫)</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>">
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Ảnh sản phẩm</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Thêm sản phẩm</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
