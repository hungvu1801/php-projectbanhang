<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Danh mục</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Danh sách danh mục</h1>
            <p>Các nhóm sản phẩm trong cửa hàng.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Category/add'); ?>">+ Thêm danh mục</a>
    </div>

    <div class="admin-panel">
        <?php if (empty($categories)): ?>
            <div class="admin-empty">
                <p>Chưa có danh mục nào.</p>
                <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Category/add'); ?>">Thêm danh mục đầu tiên</a>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars($category->description ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
