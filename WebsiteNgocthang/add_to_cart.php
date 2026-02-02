<?php
session_start();
header('Content-Type: application/json');

// Kiểm tra nếu request là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ POST
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Kiểm tra dữ liệu hợp lệ
    if ($product_id > 0 && $quantity > 0) {
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if (isset($_SESSION['cart'][$product_id])) {
            // Cập nhật số lượng nếu sản phẩm đã có
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $product = array(
                'id' => $product_id,
                'name' => $_POST['product_name'],
                'price' => floatval($_POST['product_price']),
                'image' => $_POST['product_image'],
                'description' => $_POST['product_description'],
                'quantity' => $quantity
            );
            
            $_SESSION['cart'][$product_id] = $product;
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => count($_SESSION['cart'])
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Dữ liệu không hợp lệ hoặc phương thức không được hỗ trợ'
]);
exit; 