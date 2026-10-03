<?php include 'app/views/shares/header.php'; ?>

<div class="admin-wrap">
    <div class="admin-breadcrumb">
        <a href="<?php echo url(); ?>">Trang chủ</a>
        / <strong>Sản phẩm</strong>
    </div>

    <div class="admin-hero">
        <div class="admin-hero__text">
            <h1>Sản phẩm</h1>
            <p>Khám phá các sản phẩm đang bán.</p>
        </div>
        <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/add'); ?>">+ Thêm sản phẩm</a>
    </div>

    <div class="admin-panel">
        <div id="product-empty" class="admin-empty" style="display: none;">
            <p>Hiện chưa có sản phẩm nào.</p>
            <a class="btn-tgdd btn-tgdd-primary" href="<?php echo url('Product/add'); ?>">Thêm sản phẩm đầu tiên</a>
        </div>
        <div id="product-list" class="shop-grid"></div>
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

    function formatPrice(price) {
        return Number(price).toLocaleString('vi-VN') + '₫';
    }

    function productCard(product) {
        const id = Number(product.id);
        const name = escapeHtml(product.name);
        const category = escapeHtml(product.category_name || 'Chưa phân loại');
        const image = product.image
            ? `<img class="shop-card__img" src="${escapeHtml(BASE_URL + '/' + product.image)}" alt="${name}">`
            : `<div class="shop-card__img shop-card__img--empty">Chưa có ảnh</div>`;

        return `
            <div class="shop-card">
                <a href="${BASE_URL}/Product/show/${id}" style="text-decoration:none;color:inherit;">
                    ${image}
                    <h3 class="shop-card__name">${name}</h3>
                    <div class="shop-card__cate">${category}</div>
                    <div class="shop-card__price">${formatPrice(product.price)}</div>
                </a>
                <div class="shop-card__actions">
                    <a class="btn-tgdd btn-tgdd-ghost" href="${BASE_URL}/Product/edit/${id}">Sửa</a>
                    <button type="button" class="btn-tgdd btn-tgdd-danger" onclick="deleteProduct(${id})">Xóa</button>
                    <a class="btn-tgdd btn-tgdd-primary" href="${BASE_URL}/Product/addToCart/${id}">Thêm vào giỏ</a>
                </div>
            </div>
        `;
    }

    function loadProducts() {
        const productList = document.getElementById('product-list');
        const emptyState = document.getElementById('product-empty');

        const token = localStorage.getItem('jwtToken');
        fetch(BASE_URL + '/api/product', {
                headers: token ? { 'Authorization': 'Bearer ' + token } : {}
            })
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    productList.innerHTML = '';
                    emptyState.style.display = 'block';
                    return;
                }
                emptyState.style.display = 'none';
                productList.innerHTML = data.map(productCard).join('');
            })
            .catch(() => {
                productList.innerHTML = '';
                emptyState.style.display = 'block';
            });
    }

    function deleteProduct(id) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            return;
        }
        const token = localStorage.getItem('jwtToken');
        fetch(BASE_URL + '/api/product/' + id, {
                method: 'DELETE',
                headers: token ? { 'Authorization': 'Bearer ' + token } : {}
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product deleted successfully') {
                    loadProducts();
                } else {
                    alert('Xóa sản phẩm thất bại');
                }
            })
            .catch(() => alert('Xóa sản phẩm thất bại'));
    }

    document.addEventListener('DOMContentLoaded', loadProducts);
</script>
<script> 
document.addEventListener("DOMContentLoaded", function() { 
    const token = localStorage.getItem('jwtToken'); 
    if (!token) { 
        alert('Vui lòng đăng nhập'); 
        location.href = '/webbanhang/account/login'; // Điều hướng đến trang đăng nhập 
        return; 
    } 
    fetch('/webbanhang/api/product', { 
        method: 'GET', 
        headers: { 
            'Content-Type': 'application/json', 
            'Authorization': 'Bearer ' + token 
        } 
    }) 
        .then(response => response.json()) 
        .then(data => { 
const productList = document.getElementById('product-list'); 
            data.forEach(product => { 
                const productItem = document.createElement('li'); 
                productItem.className = 'list-group-item'; 
                productItem.innerHTML = ` 
                    <h2><a href="/webbanhang/Product/show/${product.id}">${product.name}</a></h2> 
                    <p>${product.description}</p> 
                    <p>Giá: ${product.price} VND</p> 
                    <p>Danh mục: ${product.category_name}</p> 
                    <a href="/webbanhang/Product/edit/${product.id}" class="btn btn-warning">Sửa</a> 
                    <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Xóa</button> 
                `; 
                productList.appendChild(productItem); 
            }); 
        }); 
}); 
function deleteProduct(id) { 
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) { 
        fetch(`/webbanhang/api/product/${id}`, { 
            method: 'DELETE' 
        }) 
        .then(response => response.json()) 
        .then(data => { 
            if (data.message === 'Product deleted successfully') { 
                location.reload(); 
            } else { 
                alert('Xóa sản phẩm thất bại'); 
            } 
        }); 
    } 
} 
</script>