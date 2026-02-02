<?php
$page_title = "Cloud Server - Công ty Ngọc Thắng";
require_once '../includes/header.php';
require_once '../config/database.php';

// Tạo bảng products nếu chưa có
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    features TEXT,
    image VARCHAR(255),
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Lấy danh sách cloud server
$products = [];
$sql = "SELECT * FROM products WHERE category_id = 5 AND is_service = 1 ORDER BY price ASC";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>
<section class="product-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">Cloud Server</h1>
                <p class="lead">Dịch vụ máy chủ đám mây hiệu năng cao, linh hoạt, bảo mật và dễ dàng mở rộng cho doanh nghiệp.</p>
                <ul class="list-unstyled mb-4">
                    <li><i class="fas fa-check text-success me-2"></i> Hạ tầng mạnh mẽ, uptime 99.99%</li>
                    <li><i class="fas fa-check text-success me-2"></i> Toàn quyền quản trị</li>
                    <li><i class="fas fa-check text-success me-2"></i> Hỗ trợ kỹ thuật 24/7</li>
                </ul>
                <a href="#pricing" class="btn btn-primary btn-lg">Xem Bảng Giá</a>
            </div>
            <div class="col-lg-5 text-center">
                <img src="/WebsiteNgocthang/assets/images/cloud-server/cloud.png" alt="Cloud Server" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<section id="pricing" class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Bảng Giá Cloud Server</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
    <div class="col-md-4 mb-4">
        <div class="pricing-card">
            <div class="pricing-header">
                <?php
                // Xác định tên ảnh dựa trên tên sản phẩm
                $productName = strtolower($product['name']);
                if (strpos($productName, 'cơ bản') !== false) {
                    $img = "WebsiteNgocthang/assets/images/cloud-server/cloud-basic.png";
                } elseif (strpos($productName, 'cao cấp') !== false) {
                    $img = "WebsiteNgocthang/assets/images/cloud-server/cloud-pro.png";
                } elseif (strpos($productName, 'doanh nghiệp') !== false) {
                    $img = "WebsiteNgocthang/assets/images/cloud-server/cloud-bussiness.png";
                } else {
                    $img = "WebsiteNgocthang/assets/images/cloud-server/cloud-default.png";
                }
                ?>
                <img src="/WebsiteNgocthang/assets/images/cloud-server/<?php echo basename($img); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height:60px;object-fit:contain;" class="mb-2" id="product-image-<?php echo $product['id']; ?>">
                <h3 id="product-name-<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="price" id="product-price-<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>">
                    <?php echo number_format($product['price'], 0, ',', '.'); ?>đ/tháng
                </p>
                <p id="product-description-<?php echo $product['id']; ?>" class="d-none"><?php echo htmlspecialchars($product['description']); ?></p>
            </div>
            <div class="pricing-body">
                <ul class="list-unstyled">
                    <?php 
                    $features = json_decode($product['features'], true);
                    if (is_array($features)) {
                        foreach ($features as $feature): ?>
                        <li><i class="fas fa-check text-success"></i> <?php echo htmlspecialchars($feature); ?></li>
                    <?php endforeach; }
                    ?>
                </ul>
                <p id="product-description-<?php echo $product['id']; ?>" class="d-none"><?php echo htmlspecialchars($product['description']); ?></p>
                <img id="product-image-<?php echo $product['id']; ?>" src="/WebsiteNgocthang/assets/images/cloud-server/<?php echo basename($img); ?>" class="d-none" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-primary btn-block me-2">Thêm vào giỏ hàng</button>
                <a href="/WebsiteNgocthang/product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-block">Xem chi tiết</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
        </div>
    </div>
</section>
<?php require_once '../includes/footer.php'; ?>
