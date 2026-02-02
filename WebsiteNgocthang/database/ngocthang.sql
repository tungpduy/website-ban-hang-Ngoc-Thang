-- Tạo database
CREATE DATABASE IF NOT EXISTS ngocthang_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ngocthang_db;

-- Bảng người dùng
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng danh mục sản phẩm
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    parent_id INT DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Bảng sản phẩm
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    image VARCHAR(255),
    features TEXT,
    is_service BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Bảng đơn hàng
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    payment_status ENUM('unpaid', 'paid') DEFAULT 'unpaid',
    shipping_address TEXT,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng chi tiết đơn hàng
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Bảng giỏ hàng
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Thêm dữ liệu mẫu cho danh mục
INSERT INTO categories (name, slug, description) VALUES
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

-- Tạo tài khoản admin mặc định (password: admin123)
INSERT INTO users (username, password, email, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@ngocthang.vn', 'Administrator', 'admin'); 