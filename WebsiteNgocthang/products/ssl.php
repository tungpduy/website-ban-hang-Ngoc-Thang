<?php
require_once '../includes/db.php';
$page_title = "Chứng Chỉ SSL & Bảo Mật Website - Công ty Ngọc Thắng";
require_once '../includes/header.php';

// Lấy danh sách sản phẩm SSL
$ssl_services = getProductsByCategory('ssl-bao-mat');
?>

<section class="ssl-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">SSL & Bảo Mật Website</h1>
                <p class="hero-subtitle">Bảo vệ website và dữ liệu khách hàng của bạn</p>
                <div class="hero-features mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-lock text-success me-2"></i>
                        <span>Mã hóa dữ liệu SSL 256-bit</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        <span>Chứng chỉ số từ nhà cung cấp uy tín</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Tăng độ tin cậy cho website</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="/WebsiteNgocthang/assets/images/ssl/ssl.png" alt="SSL Services" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<section class="ssl-services py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Giải Pháp SSL</h2>
        <div class="row justify-content-center">
            <?php foreach ($ssl_services as $service): ?>
            <div class="col-md-6 mb-4">
                <div class="service-card h-100">
                    <div class="service-header p-4">
                        <h3 id="product-name-<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p class="price" id="product-price-<?php echo $service['id']; ?>" data-price="<?php echo $service['price']; ?>">
                            <?php echo number_format($service['price'], 0, ',', '.'); ?>đ/năm
                        </p>
                    </div>
                    <div class="service-body p-4">
                        <p class="mb-4"><?php echo htmlspecialchars($service['description']); ?></p>
                        <ul class="list-unstyled mb-4">
                            <?php 
                            $features = json_decode($service['features'], true);
                            foreach ($features as $feature): 
                            ?>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <?php echo htmlspecialchars($feature); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <p id="product-description-<?php echo $service['id']; ?>" class="d-none">
                            <?php echo htmlspecialchars($service['description']); ?>
                        </p>
                        <img id="product-image-<?php echo $service['id']; ?>" 
                             src="<?php echo htmlspecialchars($service['image']); ?>" 
                             class="d-none" 
                             alt="<?php echo htmlspecialchars($service['name']); ?>">
                        <div class="service-actions d-flex justify-content-center gap-3">
                            <button onclick="addToCart(<?php echo $service['id']; ?>)" 
                                    class="btn btn-primary btn-lg mb-2">
                                Thêm vào giỏ hàng
                            </button>
                            <a href="/WebsiteNgocthang/product.php?id=<?php echo $service['id']; ?>" class="btn btn-outline-primary btn-lg">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="ssl-benefits py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Lợi Ích Của SSL</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="benefit-card text-center p-4">
                    <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                    <h4>Bảo Mật Dữ Liệu</h4>
                    <p>Mã hóa thông tin người dùng và dữ liệu truyền tải</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="benefit-card text-center p-4">
                    <i class="fas fa-search fa-3x text-primary mb-3"></i>
                    <h4>Tăng Thứ Hạng SEO</h4>
                    <p>Google ưu tiên các website có chứng chỉ SSL</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="benefit-card text-center p-4">
                    <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                    <h4>Tăng Độ Tin Cậy</h4>
                    <p>Xây dựng niềm tin với khách hàng của bạn</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.service-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.service-header {
    border-bottom: 1px solid #eee;
}

.service-header h3 {
    color: #333;
    margin-bottom: 1rem;
}

.service-header .price {
    font-size: 1.5rem;
    color: #0066cc;
    font-weight: bold;
    margin-bottom: 0;
}

.benefit-card {
    border: 1px solid #eee;
    border-radius: 8px;
    height: 100%;
    transition: transform 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>

<?php require_once '../includes/footer.php'; ?> 