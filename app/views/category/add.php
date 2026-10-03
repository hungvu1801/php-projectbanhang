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
        <div id="form-errors" class="text-danger" style="display:none;margin-bottom:14px;"></div>
        <form id="add-category-form" class="admin-form">
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

<script>
    const BASE_URL = <?php echo json_encode(rtrim(BASE_URL, '/')); ?>;

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function showErrors(errors) {
        const box = document.getElementById('form-errors');
        const messages = Array.isArray(errors) ? errors : Object.values(errors || {});
        if (!messages.length) {
            box.style.display = 'none';
            box.innerHTML = '';
            return;
        }
        box.innerHTML = '<ul>' + messages.map(item => '<li>' + escapeHtml(item) + '</li>').join('') + '</ul>';
        box.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const token = localStorage.getItem('jwtToken');
        if (!token) {
            alert('Vui lòng đăng nhập');
            location.href = BASE_URL + '/Account/login';
            return;
        }
        const authHeaders = {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        };

        document.getElementById('add-category-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            fetch(BASE_URL + '/api/category', {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify(jsonData)
                })
                .then(response => response.json().then(data => ({ ok: response.ok, data })))
                .then(({ ok, data }) => {
                    if (ok && data.message === 'Category created successfully') {
                        location.href = BASE_URL + '/Category/list';
                        return;
                    }
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        showErrors([data.message || 'Thêm danh mục thất bại']);
                    }
                })
                .catch(() => showErrors(['Không thể kết nối tới máy chủ.']));
        });
    });
</script>
