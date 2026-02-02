<?php


// Initialize the session
session_start();

// Check if the user is already logged in as admin
if(isset($_SESSION["admin_loggedin"]) && $_SESSION["admin_loggedin"] === true){
    header("location: /WebsiteNgocthang/admin/dashboard.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$errors = [];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Include database connection
    require_once '../config/database.php';
    
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $errors[] = "Vui lòng nhập tên đăng nhập.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $errors[] = "Vui lòng nhập mật khẩu.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($errors)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, role FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            // Store data in session variables
                            $_SESSION["admin_loggedin"] = true;
                            $_SESSION["admin_id"] = $id;
                            $_SESSION["admin_username"] = $username;
                            $_SESSION["admin_role"] = $role;
                            
                            // Log the successful login
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                            $log_sql = "INSERT INTO admin_login_logs (admin_id, ip_address, success) VALUES (?, ?, 1)";
                            if($log_stmt = mysqli_prepare($conn, $log_sql)){
                                mysqli_stmt_bind_param($log_stmt, "is", $id, $ip_address);
                                mysqli_stmt_execute($log_stmt);
                                mysqli_stmt_close($log_stmt);
                            }
                            
                            // Redirect user to admin dashboard
                            header("location: /WebsiteNgocthang/admin/dashboard.php");
                            exit();
                        } else{
                            // Password is not valid
                            $errors[] = "Tên đăng nhập hoặc mật khẩu không đúng.";
                            
                            // Log the failed login attempt
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                            $log_sql = "INSERT INTO admin_login_logs (ip_address, username, success) VALUES (?, ?, 0)";
                            if($log_stmt = mysqli_prepare($conn, $log_sql)){
                                mysqli_stmt_bind_param($log_stmt, "ss", $ip_address, $username);
                                mysqli_stmt_execute($log_stmt);
                                mysqli_stmt_close($log_stmt);
                            }
                        }
                    }
                } else{
                    // Username doesn't exist
                    $errors[] = "Tên đăng nhập hoặc mật khẩu không đúng.";
                    
                    // Log the failed login attempt
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $log_sql = "INSERT INTO admin_login_logs (ip_address, username, success) VALUES (?, ?, 0)";
                    if($log_stmt = mysqli_prepare($conn, $log_sql)){
                        mysqli_stmt_bind_param($log_stmt, "ss", $ip_address, $username);
                        mysqli_stmt_execute($log_stmt);
                        mysqli_stmt_close($log_stmt);
                    }
                }
            } else{
                $errors[] = "Có lỗi xảy ra. Vui lòng thử lại sau.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; }
        .auth-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 1rem; }
        .auth-logo { display: flex; justify-content: center; margin-bottom: 1.5rem; }
        .auth-logo img { max-width: 120px; }
    </style>
</head>
<body>
<div class="auth-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Đăng Nhập Quản Trị</h2>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p class="mb-0"><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                            
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
