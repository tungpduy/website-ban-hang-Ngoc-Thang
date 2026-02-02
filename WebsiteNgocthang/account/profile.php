<?php
require_once '../includes/header.php';
require_once '../config/database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /WebsiteNgocthang/auth/login.php');
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);
if (!$user_id) {
    // Nếu không có user_id trong session, buộc đăng xuất
    header('Location: /WebsiteNgocthang/auth/logout.php');
    exit();
}
$success = $error = '';

// Lấy thông tin người dùng
$query = "SELECT full_name, email, phone FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Xử lý cập nhật thông tin cá nhân
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    if ($full_name === '' || $phone === '') {
        $error = 'Vui lòng nhập đầy đủ họ tên và số điện thoại.';
    } else {
        $update = "UPDATE users SET full_name=?, phone=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, 'ssi', $full_name, $phone, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Cập nhật thông tin thành công!';
            $_SESSION['full_name'] = $full_name;
            $user['full_name'] = $full_name;
            $user['phone'] = $phone;
        } else {
            $error = 'Cập nhật thất bại!';
        }
    }
}

// Xử lý đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_pass'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    if ($new_pass !== $confirm_pass) {
        $error = 'Mật khẩu mới không khớp.';
    } else {
        $query = "SELECT password FROM users WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if (!password_verify($old_pass, $row['password'])) {
            $error = 'Mật khẩu cũ không đúng.';
        } else {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
            $update = "UPDATE users SET password=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($stmt, 'si', $hashed, $user_id);
            if (mysqli_stmt_execute($stmt)) {
                $success = 'Đổi mật khẩu thành công!';
            } else {
                $error = 'Đổi mật khẩu thất bại!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4"><i class="fas fa-user-circle"></i> Quản lý tài khoản</h2>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <form method="post">
                <h5>Cập nhật thông tin cá nhân</h5>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <button type="submit" name="update_info" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
        <div class="col-md-6">
            <form method="post">
                <h5>Đổi mật khẩu</h5>
                <div class="mb-3">
                    <label for="old_password" class="form-label">Mật khẩu cũ</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="change_pass" class="btn btn-warning">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
    <hr class="my-4">
    <h5><i class="fas fa-box"></i> Đơn hàng của tôi</h5>
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $order_query = "SELECT id, order_date, total, status FROM orders WHERE user_id=? ORDER BY order_date DESC";
        $stmt = mysqli_prepare($conn, $order_query);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($order = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($order['id']) . '</td>';
            echo '<td>' . htmlspecialchars($order['order_date']) . '</td>';
            echo '<td>' . number_format($order['total'], 0, ',', '.') . ' đ</td>';
            echo '<td>';
            if ($order['status'] === 'pending') echo '<span class="badge bg-warning text-dark">Đang xử lý</span>';
            elseif ($order['status'] === 'completed') echo '<span class="badge bg-success">Hoàn thành</span>';
            elseif ($order['status'] === 'cancelled') echo '<span class="badge bg-danger">Đã hủy</span>';
            else echo htmlspecialchars($order['status']);
            echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
