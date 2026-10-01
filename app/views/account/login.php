<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Đăng nhập</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Đăng nhập</h1>
            <p>Nhập tài khoản và mật khẩu để tiếp tục.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Account/register'); ?>">Đăng ký</a>
    </div>

    <div class="admin-panel">
        <?php if (!empty($error)): ?>
            <div class="text-danger" style="margin-bottom:14px;">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('Account/checkLogin'); ?>" class="admin-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Đăng nhập</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Account/register'); ?>">Chưa có tài khoản?</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
