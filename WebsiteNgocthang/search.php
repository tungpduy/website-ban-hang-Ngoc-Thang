<?php
require_once 'includes/header.php';

// Kiểm tra xem có từ khóa tìm kiếm không
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Kết nối cơ sở dữ liệu
require_once 'config/database.php';

// Truy vấn tìm kiếm sản phẩm
if (!empty($search)) {
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}
?>

<div class="container py-5">
    <h1 class="mb-4">Kết quả tìm kiếm cho "<?php echo htmlspecialchars($search); ?>"</h1>
    
    <?php if (empty($products)): ?>
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($search); ?>".
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text text-primary fw-bold">
                                <?php echo number_format($product['price']); ?>₫
                            </p>
                            <a href="<?php echo get_path('/product.php?id=' . $product['id']); ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
