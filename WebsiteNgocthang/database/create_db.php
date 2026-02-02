<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    // Kết nối MySQL
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Xóa database cũ nếu tồn tại
    $pdo->exec("DROP DATABASE IF EXISTS websitengocthang");
    
    // Đọc nội dung file SQL
    $sql = file_get_contents(__DIR__ . '/ngocthang.sql');
    
    // Thay đổi tên database trong file SQL
    $sql = str_replace('ngocthang_db', 'websitengocthang', $sql);
    
    // Thực thi từng câu lệnh SQL
    $pdo->exec($sql);
    
    echo "Đã tạo database và import dữ liệu thành công!";
    
} catch(PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?> 