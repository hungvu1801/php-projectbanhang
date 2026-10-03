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
        <div id="category-empty" class="admin-empty" style="display: none;">
            <p>Chưa có danh mục nào.</p>
            <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Category/add'); ?>">Thêm danh mục đầu tiên</a>
        </div>
        <table id="category-table" class="admin-table" style="display: none;">
            <thead>
                <tr>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="category-list"></tbody>
        </table>
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

    function authHeaders() {
        const token = localStorage.getItem('jwtToken');
        return token ? { 'Authorization': 'Bearer ' + token } : {};
    }

    function requireToken() {
        const token = localStorage.getItem('jwtToken');
        if (!token) {
            alert('Vui lòng đăng nhập');
            location.href = BASE_URL + '/Account/login';
            return false;
        }
        return true;
    }

    function categoryRow(category) {
        const id = Number(category.id);
        const name = escapeHtml(category.name);
        const description = escapeHtml(category.description || '');

        return `
            <tr>
                <td><strong>${name}</strong></td>
                <td>${description}</td>
                <td>
                    <div class="admin-actions">
                        <a href="${BASE_URL}/Category/edit/${id}">Sửa</a>
                        <a class="is-danger" href="#" onclick="deleteCategory(${id}); return false;">Xóa</a>
                    </div>
                </td>
            </tr>
        `;
    }

    function loadCategories() {
        if (!requireToken()) {
            return;
        }

        const categoryList = document.getElementById('category-list');
        const emptyState = document.getElementById('category-empty');
        const table = document.getElementById('category-table');

        fetch(BASE_URL + '/api/category', {
                headers: authHeaders()
            })
            .then(response => {
                if (response.status === 401) {
                    alert('Vui lòng đăng nhập');
                    location.href = BASE_URL + '/Account/login';
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    return;
                }
                if (!Array.isArray(data) || data.length === 0) {
                    categoryList.innerHTML = '';
                    table.style.display = 'none';
                    emptyState.style.display = 'block';
                    return;
                }
                emptyState.style.display = 'none';
                table.style.display = '';
                categoryList.innerHTML = data.map(categoryRow).join('');
            })
            .catch(() => {
                categoryList.innerHTML = '';
                table.style.display = 'none';
                emptyState.style.display = 'block';
            });
    }

    function deleteCategory(id) {
        if (!confirm('Bạn có chắc chắn muốn xóa danh mục này? Các sản phẩm thuộc danh mục cũng sẽ bị xóa.')) {
            return;
        }
        if (!requireToken()) {
            return;
        }

        fetch(BASE_URL + '/api/category/' + id, {
                method: 'DELETE',
                headers: authHeaders()
            })
            .then(response => response.json().then(data => ({ ok: response.ok, data })))
            .then(({ ok, data }) => {
                if (ok && data.message === 'Category deleted successfully') {
                    loadCategories();
                } else {
                    alert(data.message || 'Xóa danh mục thất bại');
                }
            })
            .catch(() => alert('Xóa danh mục thất bại'));
    }

    document.addEventListener('DOMContentLoaded', loadCategories);
</script>
