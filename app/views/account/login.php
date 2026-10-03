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
        <div id="form-errors" class="text-danger" style="display:none;margin-bottom:14px;"></div>
        <form id="login-form" class="admin-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control" required>
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

<script>
    const BASE_URL = <?php echo json_encode(rtrim(BASE_URL, '/')); ?>;

    function showError(message) {
        const box = document.getElementById('form-errors');
        box.textContent = message;
        box.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            fetch(BASE_URL + '/Account/checkLogin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => response.json().then(data => ({ ok: response.ok, data })))
                .then(({ ok, data }) => {
                    if (ok && data.token) {
                        localStorage.setItem('jwtToken', data.token);
                        location.href = BASE_URL + '/Product';
                        return;
                    }
                    showError(data.message || 'Đăng nhập thất bại');
                })
                .catch(() => showError('Không thể kết nối tới máy chủ.'));
        });
    });
</script>
