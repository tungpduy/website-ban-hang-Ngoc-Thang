<?php
// Xử lý form liên hệ

// Xử lý form liên hệ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);
    
    // Validate input
    $errors = [];
    
    if (empty($fullname)) {
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
    
    if (empty($message)) {
        $errors[] = "Vui lòng nhập nội dung yêu cầu";
    }
    
    if (empty($errors)) {
        // Hiển thị thông báo thành công
        $success = "Chúng tôi đã nhận được yêu cầu của bạn. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.";
        // Xóa các biến sau khi gửi thành công
        unset($fullname, $email, $phone, $message);
        // Redirect để tránh resubmit
        header('Location: /WebsiteNgocthang/contact.php?success=1');
        exit;
    }
}

// Include header
require_once 'includes/header.php';
?>
?>

<div class="container py-5">
    <h1 class="mb-4">Liên Hệ</h1>
    
    <div class="row">
        <!-- Thông tin liên hệ -->
        <div class="col-md-6">
            <div class="contact-info bg-light p-4 rounded-3">
                <h3 class="mb-4">Thông tin liên hệ</h3>
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <strong>Địa chỉ:</strong> Số 7, Ngách 121/2, Trần Phú, Hà Đông, Hà Nội
                </div>
                <div class="mb-3">
                    <i class="fas fa-phone-alt me-2"></i>
                    <strong>Hotline:</strong> 1900 89 21
                </div>
                <div class="mb-3">
                    <i class="fas fa-phone me-2"></i>
                    <strong>Điện thoại:</strong> 098 148 1368
                </div>
                <div class="mb-3">
                    <i class="fas fa-envelope me-2"></i>
                    <strong>Email:</strong> lienhe@ngocthang.vn
                </div>
            </div>
        </div>
        
        <!-- Form liên hệ -->
        <div class="col-md-6">
            <div class="contact-form bg-light p-4 rounded-3">
                <h3 class="mb-4">Gửi yêu cầu hỗ trợ</h3>
                

                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p class="mb-0"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php 
                // Kiểm tra thông báo thành công từ query parameter
                if (isset($_GET['success']) && $_GET['success'] == '1') {
                    echo '<div class="alert alert-success">Chúng tôi đã nhận được yêu cầu của bạn. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</div>';
                }
                ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Bạn cần hỗ trợ gì? Hãy cho chúng tôi biết yêu cầu của bạn để tư vấn</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
