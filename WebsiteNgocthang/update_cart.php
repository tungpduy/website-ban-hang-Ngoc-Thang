<?php
session_start();

// Kiểm tra nếu request là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ POST
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    // Kiểm tra dữ liệu hợp lệ
    if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
        switch ($action) {
            case 'increase':
                $_SESSION['cart'][$product_id]['quantity']++;
                break;
            case 'decrease':
                if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                    $_SESSION['cart'][$product_id]['quantity']--;
                }
                break;
            case 'set':
                $_SESSION['cart'][$product_id]['quantity'] = max(1, $quantity);
                break;
            case 'remove':
                unset($_SESSION['cart'][$product_id]);
                break;
            default:
                // Nếu không có action, cập nhật số lượng trực tiếp
                $_SESSION['cart'][$product_id]['quantity'] = max(1, $quantity);
        }
        
        // Tính toán tổng tiền
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Trả về kết quả thành công
        $response = array(
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng',
            'cart_count' => count($_SESSION['cart']),
            'total' => $total,
            'item_total' => isset($_SESSION['cart'][$product_id]) ? 
                $_SESSION['cart'][$product_id]['price'] * $_SESSION['cart'][$product_id]['quantity'] : 0
        );
    } else {
        // Trả về lỗi nếu dữ liệu không hợp lệ
        $response = array(
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ'
        );
    }
    
    // Trả về JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Nếu không phải POST request, chuyển hướng về trang chủ
header('Location: /');
exit; 