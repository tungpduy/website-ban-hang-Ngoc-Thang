<?php
require_once '../includes/db.php';
$page_title = "Đăng Ký Tên Miền - Công ty Ngọc Thắng";
require_once '../includes/header.php';

// Lấy danh sách tên miền
$domains = getProductsByCategory('ten-mien');
?>

<section class="domain-hero py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Đăng Ký Tên Miền</h1>
                <p class="hero-subtitle">Bảo vệ thương hiệu của bạn với tên miền độc đáo</p>
                <div class="domain-info mt-4">
    <div class="alert alert-info">
        <h4>Chất lượng tên miền tại Ngọc Thắng</h4>
        <ul>
            <li><strong>Uy tín:</strong> Các tên miền được đăng ký qua hệ thống đều đảm bảo pháp lý, minh bạch và bảo vệ quyền sở hữu cho khách hàng.</li>
            <li><strong>Hỗ trợ chuyên nghiệp:</strong> Đội ngũ kỹ thuật sẵn sàng tư vấn, hỗ trợ 24/7 về mọi vấn đề liên quan đến tên miền.</li>
            <li><strong>Bảo mật cao:</strong> Thông tin khách hàng và tên miền luôn được bảo mật tuyệt đối.</li>
            <li><strong>Gia hạn dễ dàng:</strong> Quản lý, gia hạn tên miền nhanh chóng, nhắc nhở trước khi hết hạn.</li>
            <li><strong>Giá cạnh tranh:</strong> Giá đăng ký và duy trì tên miền luôn tốt nhất thị trường, nhiều ưu đãi hấp dẫn.</li>
        </ul>
        <p>Đăng ký tên miền với Ngọc Thắng để khẳng định thương hiệu và phát triển kinh doanh bền vững!</p>
    </div>
</div>
            </div>
            <div class="col-lg-6">
<img src="/WebsiteNgocthang/assets/images/domain/domain-hero.png" alt="Domain Registration" class="img-fluid">                
            </div>
        </div>
    </div>
</section>

<section class="domain-pricing py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Bảng Giá Tên Miền</h2>
        <div class="row">
            <?php foreach ($domains as $domain): ?>
            <div class="col-md-4 mb-4">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <?php
                        $ext = strtolower(pathinfo($domain['name'], PATHINFO_EXTENSION));
                        $img = "assets/images/domain/domain-$ext.png";
$imgPath = $_SERVER['DOCUMENT_ROOT'] . "/WebsiteNgocthang/" . $img;
if (!file_exists($imgPath)) {
    $img = "assets/images/domain/domain-default.png";
}
                        ?>
                        <img src="/WebsiteNgocthang/<?php echo $img; ?>" alt="<?php echo strtoupper($ext); ?> domain" style="height:60px;object-fit:contain;" class="mb-2">
                        <h3 id="product-name-<?php echo $domain['id']; ?>"><?php echo htmlspecialchars($domain['name']); ?></h3>
                        <p class="price" id="product-price-<?php echo $domain['id']; ?>" data-price="<?php echo $domain['price']; ?>">
                            <?php echo number_format($domain['price'], 0, ',', '.'); ?>đ/năm
                        </p>
                    </div>
                    <div class="pricing-body">
                        <ul class="list-unstyled">
                            <?php foreach (json_decode($domain['features'], true) as $feature): ?>
                            <li><i class="fas fa-check text-success"></i> <?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p id="product-description-<?php echo $domain['id']; ?>" class="d-none"><?php echo htmlspecialchars($domain['description']); ?></p>
                        <img id="product-image-<?php echo $domain['id']; ?>" src="/WebsiteNgocthang/<?php echo $img; ?>" class="d-none" alt="<?php echo htmlspecialchars($domain['name']); ?>">
                        <button onclick="addToCart(<?php echo $domain['id']; ?>)" class="btn btn-primary btn-block d-inline-block me-2">Thêm vào giỏ hàng</button>
                        <a href="/WebsiteNgocthang/product.php?id=<?php echo $domain['id']; ?>" class="btn btn-outline-primary btn-block d-inline-block">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="domain-features py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Tính Năng & Ưu Đãi</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h4>Bảo Vệ Thông Tin</h4>
                    <p>Bảo vệ thông tin cá nhân với WHOIS Protection miễn phí</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-server fa-3x text-primary mb-3"></i>
                    <h4>DNS Quản Lý</h4>
                    <p>Quản lý DNS dễ dàng với giao diện thân thiện</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h4>Hỗ Trợ 24/7</h4>
                    <p>Đội ngũ kỹ thuật hỗ trợ mọi lúc mọi nơi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?> 