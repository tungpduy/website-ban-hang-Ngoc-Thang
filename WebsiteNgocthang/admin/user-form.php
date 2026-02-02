<?php
// Initialize the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("location: ../auth/admin-login.php");
    exit;
}

require_once "../config/database.php";

// Khởi tạo biến
$id = $username = $full_name = $email = $phone = $address = "";
$password = $confirm_password = "";
$username_err = $full_name_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";
$is_edit_mode = false;

// Xử lý form khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy ID người dùng nếu đang ở chế độ chỉnh sửa
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        $id = $_POST["id"];
        $is_edit_mode = true;
    }
    
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Vui lòng nhập tên đăng nhập.";
    } else {
        // Kiểm tra xem username đã tồn tại chưa
        $sql = "SELECT id FROM users WHERE username = ? AND id != ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_username, $param_id);
            $param_username = trim($_POST["username"]);
            $param_id = $is_edit_mode ? $id : 0;
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Tên đăng nhập này đã được sử dụng.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate full name
    if (empty(trim($_POST["full_name"]))) {
        $full_name_err = "Vui lòng nhập họ tên.";
    } else {
        $full_name = trim($_POST["full_name"]);
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Vui lòng nhập email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Email không hợp lệ.";
    } else {
        // Kiểm tra xem email đã tồn tại chưa
        $sql = "SELECT id FROM users WHERE email = ? AND id != ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_email, $param_id);
            $param_email = trim($_POST["email"]);
            $param_id = $is_edit_mode ? $id : 0;
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "Email này đã được sử dụng.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate phone
    $phone = trim($_POST["phone"]);
    
    // Validate address
    $address = trim($_POST["address"]);
    
    // Validate password nếu đang thêm mới hoặc có nhập password khi chỉnh sửa
    if (!$is_edit_mode || (!empty(trim($_POST["password"])))) {
        if (empty(trim($_POST["password"]))) {
            $password_err = "Vui lòng nhập mật khẩu.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Mật khẩu phải có ít nhất 6 ký tự.";
        } else {
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Vui lòng xác nhận mật khẩu.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Mật khẩu không khớp.";
            }
        }
    }
    
    // Kiểm tra lỗi trước khi thêm vào database
    if (empty($username_err) && empty($full_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        if ($is_edit_mode) {
            // Cập nhật người dùng
            if (!empty($password)) {
                // Cập nhật cả mật khẩu
                $sql = "UPDATE users SET username = ?, full_name = ?, email = ?, phone = ?, address = ?, password = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssssi", $param_username, $param_full_name, $param_email, $param_phone, $param_address, $param_password, $param_id);
                    $param_username = $username;
                    $param_full_name = $full_name;
                    $param_email = $email;
                    $param_phone = $phone;
                    $param_address = $address;
                    $param_password = password_hash($password, PASSWORD_DEFAULT);
                    $param_id = $id;
                }
            } else {
                // Không cập nhật mật khẩu
                $sql = "UPDATE users SET username = ?, full_name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssi", $param_username, $param_full_name, $param_email, $param_phone, $param_address, $param_id);
                    $param_username = $username;
                    $param_full_name = $full_name;
                    $param_email = $email;
                    $param_phone = $phone;
                    $param_address = $address;
                    $param_id = $id;
                }
            }
        } else {
            // Thêm người dùng mới
            $sql = "INSERT INTO users (username, full_name, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_full_name, $param_email, $param_phone, $param_address, $param_password);
                $param_username = $username;
                $param_full_name = $full_name;
                $param_email = $email;
                $param_phone = $phone;
                $param_address = $address;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
        
        // Thực thi câu lệnh
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = $is_edit_mode ? "Người dùng đã được cập nhật thành công." : "Người dùng đã được thêm thành công.";
            header("location: users.php");
            exit();
        } else {
            echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }
        
        // Đóng statement
        mysqli_stmt_close($stmt);
    }
}

// Lấy thông tin người dùng nếu đang chỉnh sửa
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $is_edit_mode = true;
    
    $sql = "SELECT * FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $username = $row["username"];
                $full_name = $row["full_name"];
                $email = $row["email"];
                $phone = $row["phone"];
                $address = $row["address"];
            } else {
                header("location: users.php");
                exit();
            }
        } else {
            echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit_mode ? "Chỉnh Sửa" : "Thêm"; ?> Người Dùng - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="users.php"><i class="fas fa-users me-2"></i>Quản lý người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php"><i class="fas fa-box-open me-2"></i>Quản lý sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orders.php"><i class="fas fa-file-invoice me-2"></i>Quản lý đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/admin-logout.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $is_edit_mode ? "Chỉnh Sửa" : "Thêm"; ?> Người Dùng</h1>
                    <a href="users.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $is_edit_mode ? "Chỉnh sửa thông tin người dùng" : "Thêm người dùng mới"; ?></h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <?php if ($is_edit_mode): ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <div class="invalid-feedback"><?php echo $username_err; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ tên</label>
                                <input type="text" name="full_name" id="full_name" class="form-control <?php echo (!empty($full_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $full_name; ?>">
                                <div class="invalid-feedback"><?php echo $full_name_err; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                <div class="invalid-feedback"><?php echo $email_err; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $phone; ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea name="address" id="address" class="form-control" rows="3"><?php echo $address; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu<?php echo $is_edit_mode ? " (để trống nếu không thay đổi)" : ""; ?></label>
                                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <div class="invalid-feedback"><?php echo $password_err; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <div class="invalid-feedback"><?php echo $confirm_password_err; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="users.php" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
