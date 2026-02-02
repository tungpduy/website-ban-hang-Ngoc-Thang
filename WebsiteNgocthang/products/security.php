<?php
$page_title = "Bảo Mật Website - Công ty Ngọc Thắng";
require_once '../includes/header.php';
?>
<section class="product-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">Bảo Mật Website</h1>
                <p class="lead">Giải pháp bảo mật website toàn diện: SSL, tường lửa, chống tấn công DDoS, backup dữ liệu tự động.</p>
                <ul class="list-unstyled mb-4">
                    <li><i class="fas fa-check text-success me-2"></i> SSL bảo vệ dữ liệu</li>
                    <li><i class="fas fa-check text-success me-2"></i> Tường lửa ứng dụng web (WAF)</li>
                    <li><i class="fas fa-check text-success me-2"></i> Backup dữ liệu định kỳ</li>
                </ul>
                <a href="#pricing" class="btn btn-primary btn-lg">Xem Bảng Giá</a>
            </div>
            <div class="col-lg-5 text-center">
                <img src="/WebsiteNgocthang/assets/images/security.png" alt="Bảo Mật Website" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<section id="pricing" class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Bảng Giá Bảo Mật Website</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">SSL Comodo</h5>
                        <ul class="list-unstyled mb-3">
                            <li>Bảo vệ 1 tên miền</li>
                            <li>Miễn phí cài đặt</li>
                            <li>Hỗ trợ 24/7</li>
                        </ul>
                        <div class="h4 mb-3 text-primary">350.000đ/năm</div>
                        <a href="#" class="btn btn-outline-primary w-100">Đăng Ký</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-primary">
                    <div class="card-body">
                        <h5 class="card-title">SSL Geotrust</h5>
                        <ul class="list-unstyled mb-3">
                            <li>Bảo vệ nhiều tên miền</li>
                            <li>Bảo hành cao</li>
                            <li>Hỗ trợ 24/7</li>
                        </ul>
                        <div class="h4 mb-3 text-primary">1.200.000đ/năm</div>
                        <a href="#" class="btn btn-primary w-100">Đăng Ký</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Bảo Mật Website</h5>
                        <ul class="list-unstyled mb-3">
                            <li>WAF, chống DDoS</li>
                            <li>Backup tự động</li>
                            <li>Giám sát 24/7</li>
                        </ul>
                        <div class="h4 mb-3 text-primary">Liên hệ</div>
                        <a href="#" class="btn btn-outline-primary w-100">Tư Vấn Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once '../includes/footer.php'; ?>
