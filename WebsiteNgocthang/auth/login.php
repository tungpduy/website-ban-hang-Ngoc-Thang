<?php ob_start(); ?>
<?php
require_once '../includes/header.php';

// Include database connection
require_once '../config/database.php';

// Initialize the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: /WebsiteNgocthang/index.php");
    exit;
}

// Define variables and initialize with empty values
$email = $password = "";
$errors = [];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $errors[] = "Vui lòng nhập email.";
    } else{
        $email = trim($_POST["email"]);
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
        $sql = "SELECT id, password, full_name, email FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                $result = mysqli_stmt_get_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_num_rows($result) == 1){                    
                    // Bind result variables
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($password, $row['password'])){
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $row['id'];
                        $_SESSION["id"] = $row['id'];
                                                $_SESSION["full_name"] = $row['full_name'];
                        $_SESSION["email"] = $row['email'];
                        
                        // Redirect user to welcome page
                        header("Location: /WebsiteNgocthang/index.php");
                        exit();
                    } else{
                        // Password is not valid
                        $errors[] = "Email hoặc mật khẩu không đúng.";
                    }
                } else{
                    // Email doesn't exist
                    $errors[] = "Email hoặc mật khẩu không đúng.";
                }
            } else{
                $errors[] = "Có lỗi xảy ra. Vui lòng thử lại sau.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4">Đăng nhập</h2>
                            
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <p class="mb-0"><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                                
                                <div class="text-center mt-4">
                                    <p class="mb-0">
                                        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
                                    </p>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once '../includes/footer.php'; ?>
</body>
</html> 