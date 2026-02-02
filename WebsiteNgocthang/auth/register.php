<?php
ob_start();
 require_once '../includes/header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once '../config/database.php';
    
    $full_name = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';

    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validate input
    $errors = [];

    // Kiểm tra email đã tồn tại
    $check_sql = "SELECT id FROM users WHERE email = ?";
    if ($check_stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $errors[] = "Email này đã được đăng ký, vui lòng dùng email khác.";
        }
        mysqli_stmt_close($check_stmt);
    }
    
    if (empty($full_name)) {
        $errors[] = "Vui lòng nhập họ tên";
    }
    
    if (empty($email)) {
        $errors[] = "Vui lòng nhập email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    }
    
    if (empty($phone)) {
        $errors[] = "Vui lòng nhập số điện thoại";
    }
    
    if (empty($password)) {
        $errors[] = "Vui lòng nhập mật khẩu";
    } elseif (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Mật khẩu xác nhận không khớp";
    }
    
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into database
        $sql = "INSERT INTO users (full_name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                // Đăng ký thành công, tự động đăng nhập
                $_SESSION['loggedin'] = true;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email;
                header("Location: /WebsiteNgocthang/index.php");
                exit();
            } else {
                $errors[] = "Có lỗi xảy ra. Vui lòng thử lại sau.";
            }
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        $mysqli->close();
    }
}
?>

<div class="auth-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Đăng Ký Tài Khoản</h2>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p class="mb-0"><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                            
                            <p class="text-center mt-4 mb-0">
                                Đã có tài khoản? <a href="login.php">Đăng nhập</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once '../includes/footer.php'; ?> 