<?php require_once '../includes/header.php'; ?>
<link rel="stylesheet" href="/WebsiteNgocthang/assets/css/hosting-custom.css">

<section class="hosting-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Web Hosting Chuyên Nghiệp</h1>
                <p class="hero-subtitle">Giải pháp lưu trữ website tốc độ cao, ổn định và bảo mật</p>
                <div class="hero-buttons mt-4">
                    <a href="#pricing" class="btn btn-primary">Xem Bảng Giá</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="/WebsiteNgocthang/assets/images/web&hosting/hosting.png" alt="Hosting" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<section id="pricing" class="hosting-pricing py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Gói Dịch Vụ Hosting</h2>
        <div class="row">
            <!-- Basic Plan -->
            <div class="col-md-4 mb-4">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <img id="product-image-1" src="/WebsiteNgocthang/assets/images/web&hosting/basic-hosting.png" class="img-fluid mb-2 hosting-img" alt="Basic Hosting">
                        <h3 id="product-name-1">Basic Hosting</h3>
                        <p class="price" id="product-price-1" data-price="33000">33.000đ/tháng</p>
                        <p class="term">Khi đăng ký 3 năm</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> 2GB SSD NVME</li>
                            <li><i class="fas fa-check text-success"></i> Băng thông không giới hạn</li>
                            <li><i class="fas fa-check text-success"></i> 10 Email</li>
                            <li><i class="fas fa-check text-success"></i> 3 Database</li>
                            <li><i class="fas fa-check text-success"></i> SSL Miễn phí</li>
                        </ul>
                        <p id="product-description-1" class="d-none">Gói hosting cơ bản với 2GB SSD NVME, 10 email, 3 database</p>
                        <button onclick="addToCart(1)" class="btn btn-primary btn-block d-inline-block me-2">Thêm vào giỏ hàng</button>
                        <a href="/WebsiteNgocthang/product.php?id=1" class="btn btn-outline-primary btn-block d-inline-block">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            
            <!-- Professional Plan -->
            <div class="col-md-4 mb-4">
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <img id="product-image-2" src="/WebsiteNgocthang/assets/images/web&hosting/professional-hosting.png" class="img-fluid mb-2 hosting-img" alt="Professional Hosting">
                        <h3 id="product-name-2">Professional Hosting</h3>
                        <p class="price" id="product-price-2" data-price="140000">140.000đ/tháng</p>
                        <p class="term">Khi đăng ký 3 năm</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> 12GB SSD NVME</li>
                            <li><i class="fas fa-check text-success"></i> Băng thông không giới hạn</li>
                            <li><i class="fas fa-check text-success"></i> Email không giới hạn</li>
                            <li><i class="fas fa-check text-success"></i> 15 Database</li>
                            <li><i class="fas fa-check text-success"></i> SSL Miễn phí</li>
                        </ul>
                        <p id="product-description-2" class="d-none">Gói hosting chuyên nghiệp với 12GB SSD NVME, email không giới hạn, 15 database</p>
                        <button onclick="addToCart(2)" class="btn btn-primary btn-block d-inline-block me-2">Thêm vào giỏ hàng</button>
                        <a href="/WebsiteNgocthang/product.php?id=2" class="btn btn-outline-primary btn-block d-inline-block">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            
            <!-- Business Plan -->
            <div class="col-md-4 mb-4">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <img id="product-image-3" src="/WebsiteNgocthang/assets/images/web&hosting/business-hosting.png" class="img-fluid mb-2 hosting-img" alt="Business Hosting">
                        <h3 id="product-name-3">Business Hosting</h3>
                        <p class="price" id="product-price-3" data-price="227000">227.000đ/tháng</p>
                        <p class="term">Khi đăng ký 3 năm</p>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> 16GB SSD NVME</li>
                            <li><i class="fas fa-check text-success"></i> Băng thông không giới hạn</li>
                            <li><i class="fas fa-check text-success"></i> Email không giới hạn</li>
                            <li><i class="fas fa-check text-success"></i> 20 Database</li>
                            <li><i class="fas fa-check text-success"></i> SSL Miễn phí</li>
                        </ul>
                        <p id="product-description-3" class="d-none">Gói hosting doanh nghiệp với 16GB SSD NVME, email không giới hạn, 20 database</p>
                        <button onclick="addToCart(3)" class="btn btn-primary btn-block d-inline-block me-2">Thêm vào giỏ hàng</button>
                        <a href="/WebsiteNgocthang/product.php?id=3" class="btn btn-outline-primary btn-block d-inline-block">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hosting-features py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Tính Năng Nổi Bật</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                    <h4>Tốc Độ Cao</h4>
                    <p>SSD NVME với RAID 10, tối ưu hiệu suất và tốc độ truy cập</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h4>Bảo Mật Tối Ưu</h4>
                    <p>Bảo vệ website với tường lửa và SSL miễn phí</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h4>Hỗ Trợ 24/7</h4>
                    <p>Đội ngũ kỹ thuật chuyên nghiệp hỗ trợ mọi lúc</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?> 