<?php
require_once 'includes/header.php';
require_once 'config/database.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>
<div class="container py-5">
    <?php if ($product): ?>
        <div class="row">
            <div class="col-md-5">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid mb-3">
            </div>
            <div class="col-md-7">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="text-primary fw-bold h4 mb-3">
                    <?php echo number_format($product['price']); ?>₫
                </p>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <?php if (!empty($product['features'])): ?>
                    <ul>
                        <?php foreach (json_decode($product['features'], true) as $feature): ?>
                            <li><?php echo htmlspecialchars($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p id="product-name-<?php echo $product['id']; ?>" class="d-none"><?php echo htmlspecialchars($product['name']); ?></p>
<p id="product-price-<?php echo $product['id']; ?>" class="d-none" data-price="<?php echo $product['price']; ?>"></p>
<p id="product-description-<?php echo $product['id']; ?>" class="d-none"><?php echo htmlspecialchars($product['description']); ?></p>
<img id="product-image-<?php echo $product['id']; ?>" src="<?php echo htmlspecialchars($product['image']); ?>" class="d-none" alt="<?php echo htmlspecialchars($product['name']); ?>">
<button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-primary mt-3">Thêm vào giỏ hàng</button>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Không tìm thấy sản phẩm.</div>
    <?php endif; ?>
</div>
<?php require_once 'includes/footer.php'; ?>
