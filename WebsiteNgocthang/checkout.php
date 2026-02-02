<?php
session_start();
require_once 'config/database.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Lưu URL hiện tại để redirect sau khi đăng nhập
    $_SESSION['redirect_after_login'] = 'checkout.php';
    echo "<script>alert('Bạn cần đăng nhập để thanh toán!'); window.location.href='auth/login.php';</script>";
    exit;
}

// Kiểm tra giỏ hàng trống
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Xử lý thanh toán khi form được gửi
if (isset($_POST['place_order'])) {
    if (!isset($_SESSION['user_id'])) {
        // Không có user_id, chuyển về trang đăng nhập
        echo "<script>alert('Bạn cần đăng nhập để đặt hàng!'); window.location.href='auth/login.php';</script>";
        exit;
    }
    $user_id = $_SESSION['user_id'];
    // Tính tổng tiền
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    // Thêm đơn hàng vào bảng orders
    $status = 'pending'; // Trạng thái mặc định: đang xử lý
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    $sql = "INSERT INTO orders (user_id, total, status, note, order_date) VALUES (?, ?, ?, ?, NOW())";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "idss", $user_id, $total, $status, $note);
        
        if (mysqli_stmt_execute($stmt)) {
            $order_id = mysqli_insert_id($conn);
            
            // Thêm chi tiết đơn hàng vào bảng order_items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                foreach ($_SESSION['cart'] as $item) {
                    mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                    mysqli_stmt_execute($stmt);
                }
                
                // Xóa giỏ hàng sau khi đặt hàng thành công
                $_SESSION['cart'] = array();
                // Hiện thông báo và chuyển về trang chủ
                echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php';</script>";
                exit;
            } else {
                $error = "Có lỗi khi thêm chi tiết đơn hàng.";
            }
        } else {
            $error = "Có lỗi khi tạo đơn hàng.";
        }
    } else {
        $error = "Có lỗi khi chuẩn bị câu lệnh SQL.";
    }
}

// Không cần lấy thông tin người dùng vì đã xóa các trường thông tin cá nhân

// Tính tổng tiền giỏ hàng
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Set page title
$page_title = "Thanh Toán - Ngọc Thắng";

// Include header
require_once 'includes/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">Thanh Toán</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="checkout.php">
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thởi gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                        </div>
                        <a href="coming-soon.php" class="btn btn-primary">Đặt hàng</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Đơn hàng của bạn</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($item['name']); ?> 
                                        <small class="d-block text-muted">x<?php echo $item['quantity']; ?></small>
                                    </td>
                                    <td class="text-end"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tổng cộng:</th>
                                    <th class="text-end"><?php echo number_format($total, 0, ',', '.'); ?> đ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
