<?php
session_start();

// Trả về số lượng sản phẩm trong giỏ hàng
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Trả về JSON response
header('Content-Type: application/json');
echo json_encode([
    'cart_count' => $cart_count
]);
?> 