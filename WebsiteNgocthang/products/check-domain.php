
<?php

// Debug: Ghi lại dữ liệu POST để kiểm tra
file_put_contents(__DIR__ . '/debug_post.txt', print_r($_POST, true));

if (php_sapi_name() !== 'cli') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_POST['domain'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu tên miền']);
    exit;
}
$domain = trim(strtolower($_POST['domain']));

$stmt = $conn->prepare("SELECT COUNT(*) FROM sample_domains WHERE domain_name = ?");
$stmt->bind_param("s", $domain);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo json_encode(['success' => true, 'exists' => true, 'message' => 'Tên miền đã được đăng ký']);
    exit;
}

$ext = strtolower(pathinfo($domain, PATHINFO_EXTENSION));
$prices = [
    'vn' => 760000,
    'com' => 250000,
    'net' => 250000
];
$price = isset($prices[$ext]) ? $prices[$ext] : null;
if ($price === null) {
    echo json_encode(['success' => false, 'exists' => false, 'message' => 'Không hỗ trợ đuôi tên miền này!']);
    exit;
}
echo json_encode([
    'success' => true,
    'exists' => false,
    'price' => $price,
    'ext' => $ext,
    'message' => 'Có thể đăng ký tên miền này!'
]);
