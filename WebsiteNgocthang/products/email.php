<?php
require_once '../includes/db.php';
$page_title = "Dịch Vụ Email Doanh Nghiệp - Công ty Ngọc Thắng";
require_once '../includes/header.php';

// Lấy danh sách sản phẩm email
$email_services = getProductsByCategory('email');
?>

<section class="email-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Email Doanh Nghiệp</h1>
                <p class="hero-subtitle">Giải pháp email chuyên nghiệp cho doanh nghiệp của bạn</p>
                <div class="hero-features mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Tên miền email riêng của công ty</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Bảo mật cao với mã hóa SSL/TLS</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>Đồng bộ trên mọi thiết bị</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="/WebsiteNgocthang/assets/images/email/email.png" alt="Email Services" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<section class="email-services py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Dịch Vụ Email</h2>
        <div class="row justify-content-center">
            <?php foreach ($email_services as $service): ?>
            <div class="col-md-6 mb-4">
                <div class="service-card h-100">
                    <div class="service-header p-4">
                        <h3 id="product-name-<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p class="price" id="product-price-<?php echo $service['id']; ?>" data-price="<?php echo $service['price']; ?>">
                            <?php echo number_format($service['price'], 0, ',', '.'); ?>đ/tháng/user
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
                        <div class="pricing-body">
                            <ul class="list-unstyled">
                                <?php foreach (json_decode($service['features'], true) as $feature): ?>
                                <li><i class="fas fa-check text-success"></i> <?php echo htmlspecialchars($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p id="product-description-<?php echo $service['id']; ?>" class="d-none"><?php echo htmlspecialchars($service['description']); ?></p>
                            <a href="/WebsiteNgocthang/product.php?id=<?php echo $service['id']; ?>" class="btn btn-outline-secondary btn-block mb-2">Xem chi tiết</a>
                            <button onclick="addToCart(<?php echo $service['id']; ?>)" class="btn btn-primary btn-block">Thêm vào giỏ hàng</button>
                        </div>
                        <img id="product-image-<?php echo $service['id']; ?>" 
                             src="<?php echo htmlspecialchars($service['image']); ?>" 
                             class="d-none" 
                             alt="<?php echo htmlspecialchars($service['name']); ?>">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="email-features py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Tính Năng Nổi Bật</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h4>Bảo Mật Cao Cấp</h4>
                    <p>Bảo vệ email với mã hóa SSL/TLS và chống spam hiệu quả</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-sync fa-3x text-primary mb-3"></i>
                    <h4>Đồng Bộ Đa Thiết Bị</h4>
                    <p>Truy cập email từ máy tính, điện thoại và máy tính bảng</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h4>Hỗ Trợ 24/7</h4>
                    <p>Đội ngũ kỹ thuật hỗ trợ khách hàng mọi lúc</p>
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

.feature-card {
    border: 1px solid #eee;
    border-radius: 8px;
    height: 100%;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>

<?php require_once '../includes/footer.php'; ?> 