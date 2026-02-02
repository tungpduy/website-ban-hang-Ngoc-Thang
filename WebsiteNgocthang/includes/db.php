<?php
$db_host = 'localhost';
$db_name = 'websitengocthang';
$db_user = 'root';
$db_pass = '';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Kết nối database thất bại: " . $e->getMessage());
}

// Hàm lấy sản phẩm theo danh mục
function getProductsByCategory($category_slug) {
    global $db;
    $stmt = $db->prepare("
        SELECT p.* 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.slug = ? AND p.status = 'active'
    ");
    $stmt->execute([$category_slug]);
    return $stmt->fetchAll();
}

// Hàm lấy chi tiết sản phẩm theo slug
function getProductBySlug($slug) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM products WHERE slug = ? AND status = 'active'");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// Hàm lấy danh mục theo slug
function getCategoryBySlug($slug) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = ? AND status = 'active'");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// Hàm lấy giỏ hàng của người dùng
function getUserCart($user_id) {
    global $db;
    $stmt = $db->prepare("
        SELECT c.*, p.name, p.price, p.image 
        FROM cart_items c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Hàm thêm sản phẩm vào giỏ hàng
function addToCart($user_id, $product_id, $quantity = 1) {
    global $db;
    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $stmt = $db->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $item = $stmt->fetch();

    if ($item) {
        // Nếu có rồi thì cập nhật số lượng
        $stmt = $db->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE id = ?");
        return $stmt->execute([$quantity, $item['id']]);
    } else {
        // Nếu chưa có thì thêm mới
        $stmt = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $product_id, $quantity]);
    }
}

// Hàm cập nhật số lượng trong giỏ hàng
function updateCartQuantity($user_id, $product_id, $quantity) {
    global $db;
    if ($quantity > 0) {
        $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$quantity, $user_id, $product_id]);
    } else {
        return removeFromCart($user_id, $product_id);
    }
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeFromCart($user_id, $product_id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$user_id, $product_id]);
}
?> 