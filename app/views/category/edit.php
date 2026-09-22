<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Category/list'); ?>">Admin / Danh mục</a>
        / <strong>Sửa</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Sửa danh mục</h1>
            <p>Cập nhật thông tin: <strong><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Category/list'); ?>">Quay lại danh sách</a>
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
        <form method="POST" action="<?php echo url('Category/update'); ?>" class="admin-form">
            <input type="hidden" name="id" value="<?php echo $category->id; ?>">
            <div class="form-group">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($category->description ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Cập nhật</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Category/list'); ?>">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
