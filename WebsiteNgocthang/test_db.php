<?php
require_once 'config/database.php';

if($conn) {
    echo "Kết nối database thành công!";
    
    // Test query
    $result = mysqli_query($conn, "SHOW TABLES");
    if($result) {
        echo "<br>Danh sách các bảng:<br>";
        while($row = mysqli_fetch_array($result)) {
            echo $row[0] . "<br>";
        }
    }
} else {
    echo "Kết nối thất bại: " . mysqli_connect_error();
}
?> 