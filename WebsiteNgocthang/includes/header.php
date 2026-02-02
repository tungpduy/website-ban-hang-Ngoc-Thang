<?php
// Kiểm tra và khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

// Set default page title if not set
if (!isset($page_title)) {
    $page_title = "Công Ty Thiết Kế Website Uy Tín Hà Nội - Dịch vụ Seo Ngọc Thắng";
}

// Hàm helper để xử lý đường dẫn
function get_path($path) {
    $project_folder = '/WebsiteNgocthang'; // Thêm tên thư mục dự án
    
    if ($path == '/') {
        return $project_folder;
    } else {
        return $project_folder . $path;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* Top Bar */
        .top-bar {
            background-color: #0066cc;
            color: white;
            padding: 8px 0;
        }
        .top-bar a {
            color: white;
            text-decoration: none;
        }
        .top-bar a:hover {
            color: #f8f9fa;
        }

        /* Navigation */
        .navbar-brand {
            padding: 0;
        }
        .navbar-brand img {
            height: 60px;
            width: 200px;
            object-fit: fill;
            display: block;
        }
        .nav-link {
            font-weight: 500;
        }
        
        /* Main Navigation */
        .main-nav {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .main-nav .nav-item {
            position: relative;
        }
        .main-nav .nav-link {
            color: #333;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        .main-nav .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        .main-nav .dropdown-menu {
            margin-top: 0;
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-width: 200px;
        }
        .main-nav .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 400;
        }
        .main-nav .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .main-nav .nav-link:hover,
        .main-nav .nav-link:focus {
            color: #0066cc;
        }
    </style>
    <!-- Cart JavaScript -->
    <script>
    function updateCartCount(count) {
        document.getElementById('cartCount').textContent = count || '0';
    }

    function addToCart(productId, quantity = 1) {
        fetch('<?php echo get_path("/add_to_cart.php"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                product_id: productId,
                quantity: quantity,
                product_name: document.getElementById('product-name-' + productId).textContent,
                product_price: document.getElementById('product-price-' + productId).dataset.price,
                product_image: document.getElementById('product-image-' + productId).getAttribute('src'),
                product_description: document.getElementById('product-description-' + productId).textContent
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cart_count);
                alert('Đã thêm sản phẩm vào giỏ hàng');
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
        });
    }

    function updateCart(productId, action, quantity = 1) {
        fetch('<?php echo get_path("/update_cart.php"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                product_id: productId,
                action: action,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cart_count);
                if (window.location.pathname.includes('cart.php')) {
                    document.getElementById('cart-total').textContent = 
                        parseFloat(data.total).toLocaleString('vi-VN') + ' đ';
                    
                    if (action !== 'remove') {
                        document.getElementById('item-total-' + productId).textContent = 
                            parseFloat(data.item_total).toLocaleString('vi-VN') + ' đ';
                    } else {
                        document.getElementById('cart-item-' + productId).remove();
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
        });
    }

    // Cập nhật số lượng giỏ hàng khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        fetch('<?php echo get_path("/cart_count.php"); ?>')
            .then(response => response.json())
            .then(data => {
                updateCartCount(data.cart_count);
            })
            .catch(error => console.error('Error:', error));
    });
    </script>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-phone-alt"></i> Hotline: 1900 89 21
                    <span class="mx-3">|</span>
                    <i class="fas fa-envelope"></i> Email: lienhe@ngocthang.vn
                </div>
                <div class="col-md-6 text-end">
                    <a href="<?php echo get_path('/cart.php'); ?>" class="text-white me-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count badge bg-danger rounded-pill" id="cartCount">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>
                        </span>
                    </a>
                    <?php if($is_logged_in): ?>
                        Xin chào, <?php echo htmlspecialchars($_SESSION["full_name"]); ?>
<a href="/WebsiteNgocthang/account/profile.php" style="color:inherit;"><i class="fas fa-user-circle" style="font-size: 1.2em; margin: 0 8px;"></i></a> |
                        <a href="<?php echo get_path('/auth/logout.php'); ?>">Đăng xuất</a>
                    <?php else: ?>
                        <a href="<?php echo get_path('/auth/login.php'); ?>">Đăng nhập</a> |
                        <a href="<?php echo get_path('/auth/register.php'); ?>">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo and Main Navigation -->
    <nav class="navbar navbar-expand-lg main-nav">
        <div class="container">
            <a class="navbar-brand" href="<?php echo get_path('/'); ?>">
                <img src="<?php echo get_path('/assets/images/logo.png'); ?>" alt="Ngọc Thắng Logo">
            </a>
            
            <!-- Thanh tìm kiếm -->
            <form class="d-flex ms-4" action="<?php echo get_path('/search.php'); ?>" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="domainDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            TÊN MIỀN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="domainDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/domain.php'); ?>">Đăng Ký Tên Miền</a></li>
                            
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="webHostingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            WEB & HOSTING
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="webHostingDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/web-hosting.php'); ?>">Web Hosting</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/cloud-server.php'); ?>">Cloud Server</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/web-design.php'); ?>">Thiết Kế Website</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="emailDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            EMAIL
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="emailDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/email.php'); ?>">Email Doanh Nghiệp</a></li>
                            
                            
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="sslDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            SSL & BẢO MẬT
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="sslDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_path('/products/ssl.php'); ?>">SSL Comodo</a></li>
                            
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo get_path('/contact.php'); ?>">LIÊN HỆ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Initialize Bootstrap components -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
</body>
</html> 