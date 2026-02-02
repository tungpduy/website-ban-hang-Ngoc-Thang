<?php
session_start();
// Include database connection
require_once 'config/database.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle remove item from cart (POST)
if (isset($_POST['remove']) && isset($_SESSION['cart'][$_POST['remove']])) {
    unset($_SESSION['cart'][$_POST['remove']]);
    header('Location: cart.php');
    exit;
}
// Handle remove item from cart (GET, fallback for old links)
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

// Handle clear cart
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = array();
    header('Location: cart.php');
    exit;
}

// Handle update quantity
if (isset($_POST['update_cart'])) {
    // Xóa giỏ hàng cũ
    $_SESSION['cart'] = array();
    
    // Tạo giỏ hàng mới với thông tin cập nhật
    foreach ($_POST['product_id'] as $id => $productId) {
        if (isset($_POST['quantity'][$id]) && intval($_POST['quantity'][$id]) > 0) {
            $_SESSION['cart'][$productId] = array(
                'id' => $productId,
                'name' => $_POST['product_name'][$id],
                'price' => floatval($_POST['product_price'][$id]),
                'quantity' => intval($_POST['quantity'][$id]),
                'image' => $_POST['product_image'][$id],
                'description' => $_POST['product_description'][$id]
            );
        }
    }
    header('Location: cart.php');
    exit;
}

// Set page title
$page_title = "Giỏ Hàng - Ngọc Thắng";

// Include header
require_once 'includes/header.php';

?>

<div class="container py-5">
    <h1 class="mb-4">Giỏ Hàng</h1>
    
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. <a href="<?php echo get_path('/'); ?>">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <form method="post" action="cart.php">
        <!-- Giữ lại tất cả thông tin sản phẩm -->
        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
            <input type="hidden" name="product_id[<?php echo $id; ?>]" value="<?php echo $id; ?>">
            <input type="hidden" name="product_name[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['name']); ?>">
            <input type="hidden" name="product_price[<?php echo $id; ?>]" value="<?php echo $item['price']; ?>">
            <input type="hidden" name="product_image[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['image']); ?>">
            <input type="hidden" name="product_description[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['description']); ?>">
        <?php endforeach; ?>
    <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $id => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($item['description']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                            <td>
    <div class="input-group" style="width: 120px;">
        <button type="button" class="btn btn-outline-secondary btn-qty" onclick="changeQuantity(<?php echo $id; ?>, 'decrease')">-</button>
        <input type="text" name="quantity[<?php echo $id; ?>]" id="qty-<?php echo $id; ?>" value="<?php echo $item['quantity']; ?>" class="form-control text-center" style="width: 40px;" readonly>
        <button type="button" class="btn btn-outline-secondary btn-qty" onclick="changeQuantity(<?php echo $id; ?>, 'increase')">+</button>
    </div>
</td>
                            <td id="item-total-<?php echo $id; ?>"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                            <td>
                                <form method="post" action="cart.php" style="display:inline;">
                                    <input type="hidden" name="remove" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong id="cart-total-main"><?php echo number_format($total, 0, ',', '.'); ?> đ</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

    </div>
</form>
<div class="mt-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="<?php echo get_path('/'); ?>" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
        </a>
    </div>
    <div>
        <form method="post" action="cart.php" style="display:inline;">
            <button type="submit" name="clear_cart" class="btn btn-outline-danger me-2" onclick="return confirm('Bạn có chắc muốn xóa hết giỏ hàng?');">
                <i class="fas fa-trash"></i> Xóa hết
            </button>
        </form>
        <a href="checkout.php" class="btn btn-primary">
            <i class="fas fa-credit-card"></i> Thanh toán
        </a>
    </div>
</div>
    <?php endif; ?>
</div>
<script>
function changeQuantity(productId, action) {
    let qtyInput = document.getElementById('qty-' + productId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty;
    if (action === 'increase') newQty++;
    if (action === 'decrease' && currentQty > 1) newQty--;
    
    fetch('update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            product_id: productId,
            action: 'set',
            quantity: newQty
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = newQty;
            document.getElementById('item-total-' + productId).textContent = parseFloat(data.item_total).toLocaleString('vi-VN') + ' đ';
            // Cập nhật tổng tiền
            // Cập nhật tổng tiền giỏ hàng
            let totalEl = document.getElementById('cart-total-main');
            if (totalEl) totalEl.textContent = parseFloat(data.total).toLocaleString('vi-VN') + ' đ';
        }
    });
}
</script>
<?php require_once 'includes/footer.php'; ?>