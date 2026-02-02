-- Tạo bảng danh mục sản phẩm
CREATE TABLE IF NOT EXISTS product_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng sản phẩm
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    features TEXT,
    is_service BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
);

-- Thêm dữ liệu mẫu cho danh mục
INSERT INTO product_categories (name, slug, description) VALUES
('Tên miền', 'ten-mien', 'Dịch vụ đăng ký và quản lý tên miền'),
('Web Hosting', 'web-hosting', 'Dịch vụ lưu trữ website chuyên nghiệp'),
('Email', 'email', 'Dịch vụ email doanh nghiệp'),
('SSL & Bảo mật', 'ssl-bao-mat', 'Giải pháp bảo mật website');

-- Thêm dữ liệu mẫu cho sản phẩm
INSERT INTO products (category_id, name, slug, description, price, image, features, is_service) VALUES
-- Tên miền
(1, 'Tên miền .VN', 'ten-mien-vn', 'Tên miền quốc gia Việt Nam (.VN)', 750000, '/assets/images/domain-vn.png', '["Thời gian đăng ký: 1 năm","Hỗ trợ nameserver miễn phí","Bảo vệ thông tin tên miền"]', false),
(1, 'Tên miền .COM', 'ten-mien-com', 'Tên miền quốc tế phổ biến (.COM)', 250000, '/assets/images/domain-com.png', '["Thời gian đăng ký: 1 năm","Hỗ trợ nameserver miễn phí","Bảo vệ thông tin tên miền"]', false),
(1, 'Tên miền .NET', 'ten-mien-net', 'Tên miền dành cho doanh nghiệp (.NET)', 250000, '/assets/images/domain-net.png', '["Thời gian đăng ký: 1 năm","Hỗ trợ nameserver miễn phí","Bảo vệ thông tin tên miền"]', false),

-- Web Hosting
(2, 'Basic Hosting', 'basic-hosting', 'Gói hosting cơ bản cho website nhỏ', 33000, '/assets/images/hosting-basic.png', '["2GB SSD NVME","Băng thông không giới hạn","10 Email","3 Database","SSL Miễn phí"]', true),
(2, 'Professional Hosting', 'professional-hosting', 'Gói hosting chuyên nghiệp cho doanh nghiệp', 140000, '/assets/images/hosting-pro.png', '["12GB SSD NVME","Băng thông không giới hạn","Email không giới hạn","15 Database","SSL Miễn phí"]', true),
(2, 'Business Hosting', 'business-hosting', 'Gói hosting cao cấp cho doanh nghiệp lớn', 227000, '/assets/images/hosting-business.png', '["16GB SSD NVME","Băng thông không giới hạn","Email không giới hạn","20 Database","SSL Miễn phí"]', true),

-- Email
(3, 'Google Workspace Business', 'google-workspace', 'Giải pháp email doanh nghiệp từ Google', 200000, '/assets/images/google-workspace.png', '["Dung lượng 30GB/user","Gmail doanh nghiệp","Google Meet","Google Drive","Google Calendar"]', true),

-- SSL
(4, 'SSL Comodo', 'ssl-comodo', 'Chứng chỉ bảo mật SSL từ Comodo', 750000, '/assets/images/ssl-comodo.png', '["Mã hóa 256-bit","Hiển thị https và padlock","Bảo hành 1.5 triệu USD","Hỗ trợ cài đặt miễn phí"]', true); 