<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <a href="<?php echo url('Category/list'); ?>">Admin / Danh mục</a>
        / <strong>Thêm mới</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Thêm danh mục</h1>
            <p>Nhập thông tin danh mục mới.</p>
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
        <form method="POST" action="<?php echo url('Category/save'); ?>" class="admin-form">
            <div class="form-group">
                <label for="name">Tên danh mục</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Điện thoại" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Thêm danh mục</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Category/list'); ?>">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
