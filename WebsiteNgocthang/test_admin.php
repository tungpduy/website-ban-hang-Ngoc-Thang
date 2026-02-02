<?php
// Hiển thị lỗi PHP để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra kết nối database
require_once 'config/database.php';
echo "Kết nối database thành công<br>";

// Kiểm tra cấu trúc bảng admins
echo "Kiểm tra bảng admins:<br>";
$result = mysqli_query($conn, "DESCRIBE admins");
while($row = mysqli_fetch_assoc($result)) {
    echo $row['Field'] . " - " . $row['Type'] . "<br>";
}

// Kiểm tra dữ liệu trong bảng admins
echo "<br>Kiểm tra dữ liệu trong bảng admins:<br>";
$result = mysqli_query($conn, "SELECT * FROM admins");
while($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . "<br>";
    echo "Username: " . $row['username'] . "<br>";
    echo "Password: " . $row['password'] . "<br>";
    echo "Role: " . $row['role'] . "<br><br>";
}

// Kiểm tra mật khẩu
$username = 'admin';
$password = '123456';

$sql = "SELECT password FROM admins WHERE username = ?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hash);
    if(mysqli_stmt_fetch($stmt)){
        echo "Mã hash trong database: " . $hash . "<br>";
        echo "Mật khẩu nhập: " . $password . "<br>";
        if(password_verify($password, $hash)){
            echo "Đăng nhập thành công!";
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Không tìm thấy tài khoản!";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>