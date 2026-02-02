<?php
$current_year = date('Y');
?>
<footer class="footer bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-8 mb-4">
    <h5>Về Ngọc Thắng</h5>
    <p>Chúng tôi cung cấp các giải pháp công nghệ toàn diện cho doanh nghiệp của bạn.</p>
    <div class="contact-info">
        <p><i class="fas fa-map-marker-alt me-2"></i> Số 7, Ngách 121/2, Trần Phú, Hà Đông, Hà Nội</p>
        <p><i class="fas fa-phone-alt me-2"></i> Hotline: 1900 89 21</p>
        <p><i class="fas fa-phone me-2"></i> Điện thoại: 098 148 1368</p>
        <p><i class="fas fa-envelope me-2"></i> Email: lienhe@ngocthang.vn</p>
    </div>
</div>

            <!-- Newsletter -->
            <div class="col-lg-3 mb-4">
                <h5>Đăng Ký Nhận Tin</h5>
                <p>Nhận thông tin mới nhất về sản phẩm và khuyến mãi</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <button class="btn btn-primary" type="submit">Đăng Ký</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="row mt-4 pt-4 border-top">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2024 Ngọc Thắng. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="/chinh-sach-bao-mat">Chính sách bảo mật</a> |
                <a href="/dieu-khoan-su-dung">Điều khoản sử dụng</a>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    font-size: 14px;
}

.footer h5 {
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.footer a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s;
}

.footer a:hover {
    color: #0d6efd;
}

.footer .list-unstyled li {
    margin-bottom: 0.5rem;
}

.footer .contact-info p {
    margin-bottom: 0.5rem;
}

.newsletter-form .input-group {
    margin-top: 1rem;
}

.footer .border-top {
    border-color: rgba(255,255,255,0.1) !important;
}
</style>

</body>
</html> 