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
                    <a class="header__link" <?php
                            if (SessionHelper::isLoggedIn()) {
                                echo "<a class='nav link'>" . $_SESSION['username'] . "</a>";
                            } else {
                                echo  "<a class='nav-link' href='/ProjectBanHang/Account/login'>Đăng Nhập</a>";
                            }?></li>
                        <li class="nav-item">
                    </a>
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo  "<a class='nav-link' href='/ProjectBanHang/account/logout'>Đăng Thoát</a>";
                    } ?> </a>
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
    <main class="tgdd-main">