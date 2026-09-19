<?php
session_start();
include "Ketnoi.php";

// Kiểm tra quyền Admin / Quản lý
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && strtolower($_SESSION['role']) !== 'quản lý' && strtolower($_SESSION['role']) !== 'quan ly')) {
    header("Location: dangnhap.php");
    exit();
}

$msg = "";

// 1. TỰ ĐỘNG ĐỌC CẤU TRÚC CỘT THỰC TẾ TRONG BẢNG VOUCHERS
$voucher_cols = [];
$res_cols = $conn->query("SHOW COLUMNS FROM vouchers");
if ($res_cols) {
    while ($c = $res_cols->fetch_assoc()) {
        $voucher_cols[] = $c['Field'];
    }
}

// 2. NHẬN DIỆN CHÍNH XÁC TÊN CỘT ĐANG CÓ TRONG CSDL
$code_col = in_array('code', $voucher_cols) ? 'code' : (in_array('ma_voucher', $voucher_cols) ? 'ma_voucher' : 'code');

// Tìm cột số tiền giảm
$disc_col = 'discount_amount';
if (in_array('discount_amount', $voucher_cols)) { $disc_col = 'discount_amount'; }
elseif (in_array('discount_value', $voucher_cols)) { $disc_col = 'discount_value'; }
elseif (in_array('discount', $voucher_cols)) { $disc_col = 'discount'; }
elseif (in_array('value', $voucher_cols)) { $disc_col = 'value'; }

// Tìm cột giá trị đơn hàng tối thiểu
$min_col = 'min_order_amount';
if (in_array('min_order_amount', $voucher_cols)) { $min_col = 'min_order_amount'; }
elseif (in_array('min_order_value', $voucher_cols)) { $min_col = 'min_order_value'; }
elseif (in_array('min_order', $voucher_cols)) { $min_col = 'min_order'; }

// XỬ LÝ THÊM MÃ VOUCHER MỚI
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action_add_voucher'])) {
    $code             = strtoupper(trim($_POST['code']));
    $discount_amount  = floatval($_POST['discount_amount']);
    $min_order_amount = floatval($_POST['min_order_amount']);

    // Tạo câu lệnh SQL với đúng tên cột đã nhận diện
    $sql = "INSERT INTO vouchers ($code_col, $disc_col, $min_col) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sdd", $code, $discount_amount, $min_order_amount);
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle me-1'></i>Thêm mã Voucher <strong>$code</strong> thành công!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        } else {
            $msg = "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-exclamation-triangle me-1'></i>Thêm thất bại: " . htmlspecialchars($conn->error) . "<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Lỗi khởi tạo câu lệnh SQL: " . htmlspecialchars($conn->error) . "</div>";
    }
}

// Truy vấn danh sách Voucher
$result = $conn->query("SELECT * FROM vouchers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Voucher - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<!-- THANH NAVBAR ADMIN -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand text-success fw-bold" href="don-hang.php"><i class="bi bi-shield-check me-1"></i> ADMIN TRÁI CÂY</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link text-white" href="don-hang.php">📦 Quản lý & Duyệt đơn hàng</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="quan-ly-san-pham.php">🍎 Quản lý Trái cây & Kho</a></li>
        <li class="nav-item"><a class="nav-link active fw-bold text-warning" href="quan-ly-voucher.php">🎟️ Quản lý Voucher</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="dangky.php">👤 Thêm Nhân viên / Admin</a></li>
      </ul>
      <div class="text-white">
        <span class="me-3 fs-6">Xin chào, <strong class="text-warning"><?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['ho_ten'] ?? 'Quản lý'); ?></strong></span>
        <a href="index.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-shop"></i> Xem Website</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-4 mb-5">
    <?php echo $msg; ?>
    <div class="row">
        <!-- FORM TẠO MÃ VOUCHER MỚI -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fw-bold py-3">
                    <i class="bi bi-plus-circle me-1"></i> TẠO MÃ GIẢM GIÁ MỚI
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action_add_voucher" value="1">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Voucher (Code) (*)</label>
                            <input type="text" name="code" class="form-control text-uppercase" placeholder="VD: TRAICAY30K" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số tiền giảm (VNĐ) (*)</label>
                            <input type="number" step="1000" name="discount_amount" class="form-control" placeholder="VD: 30000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Đơn hàng tối thiểu (VNĐ)</label>
                            <input type="number" step="1000" name="min_order_amount" class="form-control" placeholder="VD: 150000" value="0">
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            <i class="bi bi-check-lg me-1"></i> Thêm Voucher
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- BẢNG DANH SÁCH VOUCHER -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 fw-bold text-success"><i class="bi bi-tags me-2"></i>DANH SÁCH MÃ GIẢM GIÁ</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center m-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã Voucher</th>
                                    <th>Số tiền giảm</th>
                                    <th>Đơn tối thiểu</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($v = $result->fetch_assoc()): 
                                    $code_val = $v['code'] ?? $v['ma_voucher'] ?? 'NO_CODE';
                                    $discount = $v['discount_amount'] ?? $v['discount_value'] ?? $v['discount'] ?? $v['value'] ?? 0;
                                    $min_ord  = $v['min_order_amount'] ?? $v['min_order_value'] ?? $v['min_order'] ?? 0;
                                ?>
                                <tr>
                                    <td>#<?php echo $v['id']; ?></td>
                                    <td><span class="badge bg-warning text-dark fs-6 px-3 py-2"><?php echo htmlspecialchars($code_val); ?></span></td>
                                    <td class="fw-bold text-success">-<?php echo number_format($discount, 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo number_format($min_ord, 0, ',', '.'); ?> VNĐ</td>
                                    <td><span class="badge bg-success">Đang hoạt động</span></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="py-4 text-muted">Chưa có mã voucher nào trong CSDL.</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>