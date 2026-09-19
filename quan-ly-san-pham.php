<?php
session_start();
include "Ketnoi.php";

// Kiểm tra quyền Admin / Quản lý
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && strtolower($_SESSION['role']) !== 'quản lý' && strtolower($_SESSION['role']) !== 'quan ly')) {
    header("Location: dangnhap.php");
    exit();
}

$msg = "";

// XỬ LÝ CẬP NHẬT SẢN PHẨM (Giá, Tồn kho, Hạn sử dụng)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_update'])) {
    $product_id  = intval($_POST['product_id']);
    $new_price   = floatval($_POST['price']);
    $add_stock   = intval($_POST['add_stock']); // Số lượng nhập thêm
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL;

    // 1. Lấy thông tin sản phẩm hiện tại bằng SELECT * (Tránh lỗi Unknown column)
    $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
    if (!$res || $res->num_rows == 0) { 
        $res = $conn->query("SELECT * FROM san_pham WHERE id = $product_id"); 
    }
    
    $row_curr = $res ? $res->fetch_assoc() : null;
    
    // Tự động lấy tồn kho từ bất kỳ cột nào có sẵn
    $current_stock = $row_curr ? intval($row_curr['stock'] ?? $row_curr['stock_quantity'] ?? $row_curr['so_luong'] ?? $row_curr['so_luong_ton'] ?? 0) : 0;
    $final_stock   = $current_stock + $add_stock; // Cộng dồn tồn kho mới

    // 2. Tự động thử Cập nhật vào đúng tên cột tồn kho trong DB
    $updated = false;
    $possible_stock_cols = ['stock_quantity', 'so_luong', 'stock', 'so_luong_ton'];

    foreach ($possible_stock_cols as $col) {
        $sql_update = "UPDATE products SET price = ?, $col = ?, expiry_date = ? WHERE id = ?";
        $stmt = @$conn->prepare($sql_update);
        if ($stmt) {
            $stmt->bind_param("disi", $new_price, $final_stock, $expiry_date, $product_id);
            if (@$stmt->execute()) {
                $updated = true;
                break;
            }
        }
    }

    // Nếu bảng chính không được, thử với bảng ảo san_pham
    if (!$updated) {
        foreach ($possible_stock_cols as $col) {
            $sql_update = "UPDATE san_pham SET gia = ?, $col = ?, han_su_dung = ? WHERE id = ?";
            $stmt = @$conn->prepare($sql_update);
            if ($stmt) {
                $stmt->bind_param("disi", $new_price, $final_stock, $expiry_date, $product_id);
                if (@$stmt->execute()) {
                    $updated = true;
                    break;
                }
            }
        }
    }

    if ($updated) {
        $msg = "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle me-2'></i>Cập nhật sản phẩm #$product_id thành công! (Số lượng tồn kho mới: <strong>$final_stock</strong>)<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    } else {
        $msg = "<div class='alert alert-danger'>Lỗi cập nhật CSDL: " . $conn->error . "</div>";
    }
}

// XỬ LÝ THÊM SẢN PHẨM MỚI
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_add'])) {
    $name        = trim($_POST['name']);
    $price       = floatval($_POST['price']);
    $stock       = intval($_POST['stock']);
    $image       = trim($_POST['image'] ?? 'default.jpg');
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL;

    // Thử thêm vào products với các tên cột tồn kho khác nhau
    $added = false;
    $stock_cols = ['stock_quantity', 'so_luong', 'stock'];
    
    foreach ($stock_cols as $col) {
        $stmt = @$conn->prepare("INSERT INTO products (name, price, $col, image, expiry_date) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sdiss", $name, $price, $stock, $image, $expiry_date);
            if (@$stmt->execute()) {
                $added = true;
                break;
            }
        }
    }

    if ($added) {
        $msg = "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle me-2'></i>Thêm mới trái cây <strong>$name</strong> thành công!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    }
}

// Truy vấn danh sách sản phẩm hiển thị ra Bảng
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
if (!$result) {
    $result = $conn->query("SELECT * FROM san_pham ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm & Hạn Sử Dụng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<!-- NAVBAR ADMIN -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand text-success fw-bold" href="don-hang.php"><i class="bi bi-shield-check me-1"></i> ADMIN TRÁI CÂY</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-white" href="don-hang.php">📦 Quản lý Đơn hàng</a></li>
        <li class="nav-item"><a class="nav-link active fw-bold text-warning" href="quan-ly-san-pham.php">🍎 Quản lý Trái cây & Kho</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="quan-ly-voucher.php">🎟️ Quản lý Voucher</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="dangky.php">👤 Thêm Nhân viên / Admin</a></li>
      </ul>
      <div class="text-white">
        <span class="me-3 fs-6">Xin chào, <strong class="text-warning"><?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['ho_ten'] ?? 'Quản lý'); ?></strong></span>
        <a href="index.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-shop"></i>Xem Web</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-4 mb-5">
    <?php echo $msg; ?>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold text-success"><i class="bi bi-box-seam me-2"></i>QUẢN LÝ SẢN PHẨM & HẠN SỬ DỤNG</h4>
            <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                <i class="bi bi-plus-circle me-1"></i> Thêm Trái Cây Mới
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá (VNĐ)</th>
                            <th>Số lượng tồn</th>
                            <th>Hạn sử dụng</th>
                            <th>Trạng thái kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($item = $result->fetch_assoc()): 
                            // Tự động nhận diện tên cột số lượng, giá và tên
                            $stock       = $item['stock'] ?? $item['stock_quantity'] ?? $item['so_luong'] ?? $item['so_luong_ton'] ?? 0;
                            $price       = $item['price'] ?? $item['sale_price'] ?? $item['gia'] ?? 0;
                            $name        = $item['name'] ?? $item['ten_san_pham'] ?? 'Trái cây';
                            $img         = $item['image'] ?? $item['hinh_anh'] ?? 'default.jpg';
                            $expiry_date = $item['expiry_date'] ?? $item['han_su_dung'] ?? null;
                            
                            // Kiểm tra quá hạn sử dụng
                            $is_expired = false;
                            if ($expiry_date && strtotime($expiry_date) < strtotime(date('Y-m-d'))) {
                                $is_expired = true;
                            }
                        ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $item['id']; ?></td>
                            <td>
                                <img src="images/<?php echo htmlspecialchars($img); ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover;" class="rounded border"
                                     onerror="this.src='https://via.placeholder.com/50';">
                            </td>
                            <td class="fw-bold text-start"><?php echo htmlspecialchars($name); ?></td>
                            <td class="text-success fw-bold"><?php echo number_format($price, 0, ',', '.'); ?> VNĐ</td>
                            <td class="fw-bold fs-6"><?php echo $stock; ?> kg/hộp</td>
                            <td>
                                <?php if ($expiry_date): ?>
                                    <span class="<?php echo $is_expired ? 'text-danger fw-bold' : 'text-dark'; ?>">
                                        <?php echo date('d/m/Y', strtotime($expiry_date)); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Chưa cập nhật</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($is_expired): ?>
                                    <span class="badge bg-danger">Đã hết hạn</span>
                                <?php elseif ($stock <= 0): ?>
                                    <span class="badge bg-secondary">Hết hàng</span>
                                <?php elseif ($stock <= 10): ?>
                                    <span class="badge bg-warning text-dark">Sắp hết</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Còn hàng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Nút Bấm Mở Modal Chỉnh Sửa Trực Tiếp -->
                                <button class="btn btn-sm btn-primary fw-bold" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit<?php echo $item['id']; ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Cập nhật
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL CẬP NHẬT SẢN PHẨM -->
                        <div class="modal fade" id="modalEdit<?php echo $item['id']; ?>" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form method="POST">
                                <input type="hidden" name="action_update" value="1">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <div class="modal-header bg-primary text-white">
                                  <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> Cập Nhật - <?php echo htmlspecialchars($name); ?></h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                  <div class="mb-3">
                                    <label class="form-label fw-bold">Đơn giá mới (VNĐ)</label>
                                    <input type="number" step="1000" class="form-control" name="price" value="<?php echo $price; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label fw-bold">Số lượng hiện tại trong kho</label>
                                    <input type="text" class="form-control bg-light" value="<?php echo $stock; ?> kg" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Nhập thêm số lượng (+kg/hộp)</label>
                                    <input type="number" class="form-control" name="add_stock" value="0" placeholder="Nhập số lượng nhập thêm" required>
                                    <small class="text-muted">Nhập số dương để cộng dồn (VD: nhập 20 sẽ cộng thêm 20kg vào kho).</small>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">Hạn sử dụng (Expiry Date)</label>
                                    <input type="date" class="form-control" name="expiry_date" value="<?php echo $expiry_date; ?>">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                  <button type="submit" class="btn btn-primary fw-bold">Lưu Cập Nhật</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="py-4 text-muted">Chưa có sản phẩm trong CSDL.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL THÊM SẢN PHẨM MỚI -->
<div class="modal fade" id="modalAddProduct" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="action_add" value="1">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-1"></i> Thêm Trái Cây Mới</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label fw-bold">Tên trái cây</label>
            <input type="text" class="form-control" name="name" placeholder="VD: Măng Cụt Bến Tre" required>
          </div>
          <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Đơn giá (VNĐ)</label>
                <input type="number" step="1000" class="form-control" name="price" placeholder="80000" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Số lượng nhập kho</label>
                <input type="number" class="form-control" name="stock" placeholder="100" required>
              </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Tên tệp ảnh</label>
            <input type="text" class="form-control" name="image" placeholder="mang-cut.jpg" value="default.jpg">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Hạn sử dụng</label>
            <input type="date" class="form-control" name="expiry_date">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-success fw-bold">Thêm Vào Kho</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>