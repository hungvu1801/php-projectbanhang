<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Đăng ký</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Đăng ký</h1>
            <p>Tạo tài khoản mới để mua sắm.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Account/login'); ?>">Đăng nhập</a>
    </div>

    <div class="admin-panel">
        <?php if (!empty($errors)): ?>
            <div class="text-danger" style="margin-bottom:14px;">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo url('Account/save'); ?>" class="admin-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" class="form-control"
                    value="<?php echo htmlspecialchars($_POST['fullname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Xác nhận mật khẩu</label>
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
            </div>
            <div class="admin-toolbar">
                <button type="submit" class="btn-tgdd btn-tgdd-primary">Đăng ký</button>
                <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Account/login'); ?>">Đã có tài khoản?</a>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
