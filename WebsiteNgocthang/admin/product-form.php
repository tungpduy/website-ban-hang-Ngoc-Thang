<?php
// Initialize the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["admin_loggedin"]) || $_SESSION["admin_loggedin"] !== true) {
    header("location: ../auth/admin-login.php");
    exit;
}

require_once "../config/database.php";

// Khởi tạo biến
$id = $name = $description = $price = $image = $category_id = $features = "";
$name_err = $price_err = $category_id_err = "";
$is_edit_mode = false;

// Lấy danh sách danh mục
$categories = array();
$sql = "SELECT * FROM categories ORDER BY name";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    mysqli_free_result($result);
}

// Xử lý form khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy ID sản phẩm nếu đang ở chế độ chỉnh sửa
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        $id = $_POST["id"];
        $is_edit_mode = true;
    }
    
    // Validate tên sản phẩm
    if (empty(trim($_POST["name"]))) {
        $name_err = "Vui lòng nhập tên sản phẩm.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    // Validate giá
    if (empty(trim($_POST["price"]))) {
        $price_err = "Vui lòng nhập giá sản phẩm.";
    } elseif (!is_numeric(trim($_POST["price"])) || floatval(trim($_POST["price"])) <= 0) {
        $price_err = "Giá sản phẩm phải là số dương.";
    } else {
        $price = floatval(trim($_POST["price"]));
    }
    
    // Validate danh mục
    if (empty(trim($_POST["category_id"]))) {
        $category_id_err = "Vui lòng chọn danh mục.";
    } else {
        $category_id = trim($_POST["category_id"]);
    }
    
    // Lấy mô tả
    $description = trim($_POST["description"]);
    
    // Lấy tính năng (features)
    $features_array = array();
    if (!empty($_POST["features"])) {
        $features_array = explode("\n", trim($_POST["features"]));
        $features_array = array_map('trim', $features_array);
        $features_array = array_filter($features_array, function($value) { return !empty($value); });
    }
    $features = json_encode($features_array);
    
    // Xử lý upload ảnh
    $image_path = "";
    if ($is_edit_mode) {
        // Lấy đường dẫn ảnh hiện tại
        $sql = "SELECT image FROM products WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $image_path = $row['image'];
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = array("jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif");
        $file_name = $_FILES["image"]["name"];
        $file_type = $_FILES["image"]["type"];
        $file_size = $_FILES["image"]["size"];
        
        // Verify file extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed_types)) {
            $_SESSION['error'] = "Định dạng file không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG và GIF.";
        } else if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error'] = "Định dạng file không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG và GIF.";
        } else if ($file_size > 5242880) { // 5MB
            $_SESSION['error'] = "Kích thước file quá lớn. Tối đa 5MB.";
        } else {
            // Tạo thư mục nếu chưa tồn tại
            $upload_dir = "../uploads/products/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Tạo tên file mới để tránh trùng lặp
            $new_file_name = uniqid() . "." . $ext;
            $upload_path = $upload_dir . $new_file_name;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path)) {
                // Xóa ảnh cũ nếu đang chỉnh sửa và có ảnh mới
                if ($is_edit_mode && !empty($image_path) && file_exists("../" . $image_path)) {
                    unlink("../" . $image_path);
                }
                $image_path = "uploads/products/" . $new_file_name;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi tải lên ảnh.";
            }
        }
    }
    
    // Kiểm tra lỗi trước khi thêm vào database
    if (empty($name_err) && empty($price_err) && empty($category_id_err) && empty($_SESSION['error'])) {
        if ($is_edit_mode) {
            // Cập nhật sản phẩm
            if (!empty($image_path)) {
                $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ?, category_id = ?, features = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssdsisi", $name, $description, $price, $image_path, $category_id, $features, $id);
                }
            } else {
                $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, features = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssdsii", $name, $description, $price, $category_id, $features, $id);
                }
            }
        } else {
            // Thêm sản phẩm mới
            $sql = "INSERT INTO products (name, description, price, image, category_id, features) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssdssi", $name, $description, $price, $image_path, $category_id, $features);
            }
        }
        
        // Thực thi câu lệnh
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = $is_edit_mode ? "Sản phẩm đã được cập nhật thành công." : "Sản phẩm đã được thêm thành công.";
            header("location: products.php");
            exit();
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }
        
        // Đóng statement
        mysqli_stmt_close($stmt);
    }
}

// Lấy thông tin sản phẩm nếu đang chỉnh sửa
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    $is_edit_mode = true;
    
    $sql = "SELECT * FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $name = $row["name"];
                $description = $row["description"];
                $price = $row["price"];
                $image = $row["image"];
                $category_id = $row["category_id"];
                
                // Chuyển đổi features từ JSON sang text
                $features_array = json_decode($row["features"], true);
                if (is_array($features_array)) {
                    $features = implode("\n", $features_array);
                }
            } else {
                header("location: products.php");
                exit();
            }
        } else {
            echo "Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit_mode ? "Chỉnh Sửa" : "Thêm"; ?> Sản Phẩm - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php"><i class="fas fa-users me-2"></i>Quản lý người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="products.php"><i class="fas fa-box-open me-2"></i>Quản lý sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orders.php"><i class="fas fa-file-invoice me-2"></i>Quản lý đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../auth/admin-logout.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $is_edit_mode ? "Chỉnh Sửa" : "Thêm"; ?> Sản Phẩm</h1>
                    <a href="products.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $is_edit_mode ? "Chỉnh sửa thông tin sản phẩm" : "Thêm sản phẩm mới"; ?></h6>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <?php if ($is_edit_mode): ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                        <input type="text" name="name" id="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                                        <div class="invalid-feedback"><?php echo $name_err; ?></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá</label>
                                        <input type="number" name="price" id="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>" min="0" step="1000">
                                        <div class="invalid-feedback"><?php echo $price_err; ?></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Danh mục</label>
                                        <select name="category_id" id="category_id" class="form-select <?php echo (!empty($category_id_err)) ? 'is-invalid' : ''; ?>">
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"><?php echo $category_id_err; ?></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Ảnh sản phẩm</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                        <small class="form-text text-muted">Định dạng: JPG, JPEG, PNG, GIF. Kích thước tối đa: 5MB.</small>
                                        <?php if (!empty($image)): ?>
                                            <div class="mt-2">
                                                <p>Ảnh hiện tại:</p>
                                                <img src="<?php echo htmlspecialchars('../' . $image); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="preview-image">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô tả</label>
                                        <textarea name="description" id="description" class="form-control" rows="5"><?php echo $description; ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="features" class="form-label">Tính năng</label>
                                        <textarea name="features" id="features" class="form-control" rows="5" placeholder="Mỗi tính năng một dòng"><?php echo $features; ?></textarea>
                                        <small class="form-text text-muted">Mỗi tính năng nhập trên một dòng.</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="products.php" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị ảnh xem trước khi chọn file
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.querySelector('.mt-2') || document.createElement('div');
                    if (!document.querySelector('.mt-2')) {
                        previewContainer.className = 'mt-2';
                        const previewText = document.createElement('p');
                        previewText.textContent = 'Ảnh xem trước:';
                        previewContainer.appendChild(previewText);
                    }
                    
                    let previewImage = previewContainer.querySelector('.preview-image');
                    if (!previewImage) {
                        previewImage = document.createElement('img');
                        previewImage.className = 'preview-image';
                        previewContainer.appendChild(previewImage);
                    }
                    
                    previewImage.src = e.target.result;
                    previewImage.alt = 'Preview';
                    
                    if (!document.querySelector('.mt-2')) {
                        document.getElementById('image').parentNode.appendChild(previewContainer);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
