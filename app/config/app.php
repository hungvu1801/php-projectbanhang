<?php

if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDir = rtrim($scriptDir, '/');
    if ($scriptDir === '' || $scriptDir === '.' || $scriptDir === '\\') {
        $scriptDir = '';
    }
    define('BASE_URL', $scriptDir);
}

if (!function_exists('url')) {
    function url($path = '')
    {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('cart_count')) {
    function cart_count()
    {
        if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            return 0;
        }
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += (int) ($item['quantity'] ?? 0);
        }
        return $total;
    }
}
