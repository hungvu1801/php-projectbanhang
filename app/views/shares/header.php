<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('assets/css/tgdd-chrome.css'); ?>">
    <link rel="stylesheet" href="<?php echo url('assets/css/admin-tgdd.css'); ?>">
</head>

<body>
    <header class="header v2024">
        <div class="header__inner">
            <div class="header__top">
                <a href="<?php echo url(); ?>" class="header__logo" aria-label="logo">
                    quanlybanhang.com
                    <span>Tốt &amp; Nhanh</span>
                </a>
                <form class="header__search" action="<?php echo url('Product'); ?>" method="get">
                    <input type="text" name="q" placeholder="Bạn tìm gì..." maxlength="100">
                    <button type="submit" aria-label="Tìm kiếm">⌕</button>
                </form>
                <div class="header__actions">
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <span class="header__link"><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                    <a id="nav-login" class="header__link" href="<?php echo url('Account/login'); ?>">Đăng nhập</a>
                    <a id="nav-logout" class="header__link" href="<?php echo url('Account/logout'); ?>" onclick="logout(); return false;" style="display:none;">Đăng xuất</a>
                    <a href="<?php echo url('Product/cart'); ?>" class="header__cart">
                        <span class="header__cart-icon">
                            🛒
                            <?php $count = cart_count(); ?>
                            <?php if ($count > 0): ?>
                                <span class="cart-number"><?php echo $count; ?></span>
                            <?php endif; ?>
                        </span>
                        <span>Giỏ hàng</span>
                    </a>
                </div>
            </div>
        </div>
        <nav class="header__main">
            <ul class="main-menu">
                <li><a href="<?php echo url(); ?>">Trang chủ</a></li>
                <li><a href="<?php echo url('Category/list'); ?>">Danh mục</a></li>
                <li><a href="<?php echo url('Category/add'); ?>">Thêm danh mục</a></li>
                <li><a href="<?php echo url('Product/add'); ?>">Thêm sản phẩm</a></li>
                <li><a href="<?php echo url('Product/checkout'); ?>">Thanh toán</a></li>
            </ul>
        </nav>
    </header>
    <script>
        const HEADER_BASE_URL = <?php echo json_encode(rtrim(BASE_URL, '/')); ?>;

        function logout() {
            localStorage.removeItem('jwtToken');
            location.href = HEADER_BASE_URL + '/Account/logout';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('jwtToken');
            const navLogin = document.getElementById('nav-login');
            const navLogout = document.getElementById('nav-logout');
            if (!navLogin || !navLogout) {
                return;
            }
            if (token) {
                navLogin.style.display = 'none';
                navLogout.style.display = '';
            } else {
                navLogin.style.display = '';
                navLogout.style.display = 'none';
            }
        });
    </script>
    <main class="tgdd-main">