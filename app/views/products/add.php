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
        <div id="form-errors" class="text-danger" style="display:none;margin-bottom:14px;"></div>
        <form id="add-product-form" class="admin-form" enctype="multipart/form-data">
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
        fetch(BASE_URL + '/api/category')
            .then(response => response.json())
            .then(data => {
                const categorySelect = document.getElementById('category_id');
                if (!Array.isArray(data)) {
                    return;
                }
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            });

        document.getElementById('add-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(BASE_URL + '/api/product', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json().then(data => ({ ok: response.ok, data })))
                .then(({ ok, data }) => {
                    if (ok && data.message === 'Product created successfully') {
                        location.href = BASE_URL + '/Product';
                        return;
                    }
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        showErrors([data.message || 'Thêm sản phẩm thất bại']);
                    }
                })
                .catch(() => showErrors(['Không thể kết nối tới máy chủ.']));
        });
    });
</script>
