<?php
// Include database connection
require_once 'config/database.php';

// Set page title
$page_title = "Công Ty Thiết Kế Website Uy Tín Hà Nội - Dịch vụ Seo Ngọc Thắng";

// Include header
require_once 'includes/header.php'; 

// Add page-specific styles
?>
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/images/hero-bg.jpg');
    background-size: cover;
    background-position: center;
    padding: 100px 0;
    color: white;
}
.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
}
.hero-buttons .btn {
    margin-right: 1rem;
    padding: 0.75rem 1.5rem;
}

/* Service Cards */
.service-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    height: 100%;
    transition: transform 0.3s;
    
}
.service-card:hover {
    transform: translateY(-5px);
}
.service-icon {
    font-size: 2.5rem;
    color: #0066cc;
    margin-bottom: 1.5rem;
}
.service-list {
    list-style: none;
    padding: 0;
}
.service-list li {
    margin-bottom: 0.5rem;
}
.service-list a {
    color: #333;
    text-decoration: none;
}
.service-list a:hover {
    color: #0066cc;
}

/* Promo Cards */
.promo-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.promo-content {
    padding: 1.5rem;
}
.promo-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Hero Banner Ngọc Thắng */
.hero-banner-ngocthang {
    background: #15182b;
    min-height: 330px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    text-align: center;
}
.hero-banner-ngocthang .hero-content {
    position: relative;
    z-index: 2;
}
.hero-banner-ngocthang h1 {
    color: #fff;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: 1px;
}
.hero-banner-ngocthang .green {
    color: #2196f3;
    font-weight: 700;
}
.hero-banner-ngocthang .subtitle {
    color: #fff;
    font-size: 1.1rem;
    font-weight: 400;
    margin-top: 8px;
}
/* Hiệu ứng chấm và đường nối đơn giản */
.hero-banner-ngocthang .bg-dots {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
    background: url('data:image/svg+xml;utf8,<svg width="100%25" height="100%25" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="2" fill="white" opacity="0.15"/><circle cx="60" cy="60" r="2" fill="white" opacity="0.15"/><circle cx="110" cy="40" r="2" fill="white" opacity="0.15"/><circle cx="200" cy="80" r="2" fill="white" opacity="0.15"/><circle cx="300" cy="30" r="2" fill="white" opacity="0.15"/><circle cx="400" cy="120" r="2" fill="white" opacity="0.15"/></svg>');
    background-repeat: repeat;
}
@media (max-width: 600px) {
    .hero-banner-ngocthang h1 { font-size: 1.2rem; }
}
</style>

<!-- Hero Banner Ngọc Thắng -->
<section class="hero-banner-ngocthang">
    <div class="bg-dots"></div>
    <div class="container hero-content">
        <h1>
            Định vị thương hiệu <span class="green">CÔNG TY</span> bạn bằng một <span class="green">WEBSITE</span> chuyên nghiệp
        </h1>
        <div class="subtitle">
            Công Ty TNHH MTV Công Nghệ Và Truyền Thông Ngọc Thắng
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Sản Phẩm Nổi Bật</h2>
        <div class="row">
            <!-- Sản phẩm 1: Tên miền .vn -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Tên miền .vn</h3>
                    <p>Khẳng định thương hiệu Việt với tên miền quốc gia .vn</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Đăng ký nhanh</li>
                        <li><i class="fas fa-check text-success"></i> Quản lý dễ dàng</li>
                        <li><i class="fas fa-check text-success"></i> Hỗ trợ kỹ thuật 24/7</li>
                    </ul>
                    <div class="price mb-3">
                        <p style="visibility:hidden;margin-top:33px">s</p>
                        <p style="visibility:hidden">s</p>
                        <strong>700.000 đ/năm</strong>
                    </div>
                    <p id="product-name-1" class="d-none">Tên miền .vn</p>
<p id="product-price-1" class="d-none" data-price="700000"></p>
<p id="product-description-1" class="d-none">Khẳng định thương hiệu Việt với tên miền quốc gia .vn</p>
<img id="product-image-1" src="/WebsiteNgocthang/assets/images/domain/domain-vn.png" class="d-none" alt="Tên miền .vn">
<button onclick="addToCart(1)" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                </div>
            </div>

            <!-- Sản phẩm 2: Hosting Basic -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>Hosting Basic</h3>
                    <p>Giải pháp lưu trữ website cơ bản</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> 1GB SSD</li>
                        <li><i class="fas fa-check text-success"></i> 1 Website</li>
                        <li><i class="fas fa-check text-success"></i> 1 Email</li>
                    </ul>
                    <div class="price mb-3">
                        <p style="visibility:hidden">s</p>
                        <p style="visibility:hidden">s</p>
                        <p style="visibility:hidden">s</p>
                        <strong>120.000 đ/tháng</strong>
                    </div>
                    <p id="product-name-2" class="d-none">Hosting Basic</p>
<p id="product-price-2" class="d-none" data-price="120000"></p>
<p id="product-description-2" class="d-none">Giải pháp lưu trữ website cơ bản</p>
<img id="product-image-2" src="/WebsiteNgocthang/assets/images/hosting/hosting-basic.png" class="d-none" alt="Hosting Basic">
<button onclick="addToCart(2)" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                </div>
            </div>

            <!-- Sản phẩm 3: Google Workspace Business -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <h3>Google Workspace Business</h3>
                    <p>Bộ công cụ văn phòng chuyên nghiệp của Google cho doanh nghiệp</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Gmail theo tên miền</li>
                        <li><i class="fas fa-check text-success"></i> Google Drive không giới hạn</li>
                        <li><i class="fas fa-check text-success"></i> Họp trực tuyến Meet</li>
                    </ul>
                    <div class="price mb-3">
                        <p style="visibility:hidden">s</p>
                        <strong>69.000 đ/tháng/người</strong>
                    </div>

                    <p id="product-name-3" class="d-none">Google Workspace Business</p>
<p id="product-price-3" class="d-none" data-price="69000"></p>
<p id="product-description-3" class="d-none">Bộ công cụ văn phòng chuyên nghiệp của Google cho doanh nghiệp</p>
<img id="product-image-3" src="/WebsiteNgocthang/assets/images/google-workspace/google-workspace.png" class="d-none" alt="Google Workspace Business">
<button onclick="addToCart(3)" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                </div>
            </div>

            <!-- Sản phẩm 4: SSL Comodo -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>SSL Comodo</h3>
                    <p>Bảo vệ website với chứng chỉ SSL Comodo uy tín</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Mã hóa dữ liệu</li>
                        <li><i class="fas fa-check text-success"></i> Tăng uy tín website</li>
                        <li><i class="fas fa-check text-success"></i> Hỗ trợ HTTPS</li>
                    </ul>
                    <div class="price mb-3">
                    <p style="visibility:hidden;margin-top:33px">s</p>
                        <p style="visibility:hidden">s</p>
                        <strong>499.000 đ/năm</strong>
                    </div>
                    <p id="product-name-4" class="d-none">SSL Comodo</p>
<p id="product-price-4" class="d-none" data-price="499000"></p>
<p id="product-description-4" class="d-none">Bảo vệ website với chứng chỉ SSL Comodo uy tín</p>
<img id="product-image-4" src="/WebsiteNgocthang/assets/images/ssl/ssl-comodo.png" class="d-none" alt="SSL Comodo">
<button onclick="addToCart(4)" class="btn btn-primary w-100">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Promotions Section -->
<section class="promotions bg-light py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Ưu Đãi Đặc Biệt</h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="promo-card">
                    <div class="promo-image">
                    
                    </div>
                    <div class="promo-content">
                        <h3>Khuyến Mãi Dịch Vụ</h3>
                        <p>Nhiều chương trình hấp dẫn đang chờ bạn</p>
                        <a href="coming-soon.php" class="btn btn-outline-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="promo-card">
                    <div class="promo-image">
                        
                    </div>
                    <div class="promo-content">
                        <h3>Ưu Đãi Thẻ Thành Viên</h3>
                        <p>Hạng càng cao, hoàn tiền càng nhiều</p>
                        <a href="coming-soon.php" class="btn btn-outline-primary">Tìm Hiểu Thêm</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="promo-card">
                    <div class="promo-image">
                        
                    </div>
                    <div class="promo-content">
                        <h3>Tích Điểm Đổi Quà</h3>
                        <p>Mua càng nhiều, quà càng lớn</p>
                        <a href="coming-soon.php" class="btn btn-outline-primary">Khám Phá Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="partners py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Đối Tác Của Chúng Tôi</h2>
        <div class="partner-logos">
            <div class="row align-items-center justify-content-center">
                <div class="col-4 col-md-2 mb-4">
                    <img src="assets/images/partners/google-partner.png" alt="Google Partner" class="img-fluid">
                </div>
                <div class="col-4 col-md-2 mb-4">
                    <img src="assets/images/partners/vnnic.png" alt="VNNIC" class="img-fluid">
                </div>
                <div class="col-4 col-md-2 mb-4">
                    <img src="assets/images/partners/icann.png" alt="ICANN" class="img-fluid">
                </div>
                <div class="col-4 col-md-2 mb-4">
                    <img src="assets/images/partners/cpanel.png" alt="cPanel" class="img-fluid">
                </div>
                <div class="col-4 col-md-2 mb-4">
                    <img src="assets/images/partners/cloudlinux.png" alt="CloudLinux" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?> 