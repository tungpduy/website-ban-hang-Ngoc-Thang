<?php
session_start();
header('Content-Type: application/json');

if (empty($_POST['domain']) || empty($_POST['price'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin tên miền hoặc giá']);
    exit;
}
$domain = trim(strtolower($_POST['domain']));
$price = intval($_POST['price']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra nếu tên miền đã có trong giỏ hàng
foreach ($_SESSION['cart'] as $item) {
    if (isset($item['type']) && $item['type'] === 'domain' && $item['domain'] === $domain) {
        echo json_encode(['success' => false, 'message' => 'Tên miền đã có trong giỏ hàng']);
        exit;
    }
}
// Xác định đường dẫn ảnh đại diện
$image = isset($_POST['product_image']) && !empty($_POST['product_image'])
    ? $_POST['product_image']
    : '/WebsiteNgocthang/assets/images/domain/domain-' . pathinfo($domain, PATHINFO_EXTENSION) . '.png';

// Thêm vào giỏ hàng
$_SESSION['cart'][] = [
    'type' => 'domain',
    'domain' => $domain,
    'price' => $price,
    'qty' => 1,
    'image' => $image
];
echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
