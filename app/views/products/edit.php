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
            <p>Cập nhật thông tin: <strong id="product-title"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        </div>
        <a class="btn-tgdd btn-tgdd-ghost" href="<?php echo url('Product'); ?>">Quay lại danh sách</a>
    </div>

    <div class="admin-panel">
        <div id="form-errors" class="text-danger" style="display:none;margin-bottom:14px;"></div>
        <form id="edit-product-form" class="admin-form" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id" value="<?php echo (int) $product->id; ?>">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="form-control" required>
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
                <input type="hidden" id="existing_image" name="existing_image">
                <div id="current-image" style="display:none;margin-bottom:10px;">
                    <img id="current-image-tag" alt="Product Image"
                        style="width:120px;height:120px;object-fit:contain;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                </div>
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

<script>
    const BASE_URL = <?php echo json_encode(rtrim(BASE_URL, '/')); ?>;
    const productId = <?php echo (int) $product->id; ?>;

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
        const authHeaders = { 'Authorization': 'Bearer ' + token };

        Promise.all([
            fetch(BASE_URL + '/api/product/' + productId, { headers: authHeaders }).then(response => response.json()),
            fetch(BASE_URL + '/api/category', { headers: authHeaders }).then(response => response.json())
        ]).then(([product, categories]) => {
            if (!product || !product.id) {
                showErrors(['Không tìm thấy sản phẩm']);
                return;
            }

            document.getElementById('id').value = product.id;
            document.getElementById('name').value = product.name || '';
            document.getElementById('description').value = product.description || '';
            document.getElementById('price').value = product.price || '';
            document.getElementById('existing_image').value = product.image || '';
            document.getElementById('product-title').textContent = product.name || '';

            const imageWrap = document.getElementById('current-image');
            const imageTag = document.getElementById('current-image-tag');
            if (product.image) {
                imageTag.src = BASE_URL + '/' + product.image;
                imageWrap.style.display = 'block';
            }

            const categorySelect = document.getElementById('category_id');
            if (Array.isArray(categories)) {
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            }
            categorySelect.value = product.category_id || '';
        }).catch(() => showErrors(['Không thể tải dữ liệu sản phẩm.']));

        document.getElementById('edit-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch(BASE_URL + '/api/product/' + productId, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                })
                .then(response => response.json().then(data => ({ ok: response.ok, data })))
                .then(({ ok, data }) => {
                    if (ok && data.message === 'Product updated successfully') {
                        location.href = BASE_URL + '/Product';
                        return;
                    }
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        showErrors([data.message || 'Cập nhật sản phẩm thất bại']);
                    }
                })
                .catch(() => showErrors(['Không thể kết nối tới máy chủ.']));
        });
    });
</script>
