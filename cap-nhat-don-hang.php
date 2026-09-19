<?php
session_start();

// 1. Chốt bảo vệ: Chỉ Admin / Quản lý mới được truy cập
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && strtolower($_SESSION['role']) !== 'quản lý' && strtolower($_SESSION['role']) !== 'quan ly')) {
    header("Location: dangnhap.php");
    exit();
}

// 2. Nhúng kết nối CSDL (Đã sửa đường dẫn chuẩn)
include "Ketnoi.php";

$ma_don = intval($_GET['id'] ?? 0);
$msg = "";

if ($ma_don <= 0) {
    header("Location: don-hang.php");
    exit();
}

// 3. Xử lý khi Admin bấm Lưu cập nhật trạng thái
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['trang_thai_moi'])) {
    $trang_thai_moi = trim($_POST['trang_thai_moi']);

    // Tự động cập nhật bảng orders hoặc view don_hang
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    if (!$stmt) {
        $stmt = $conn->prepare("UPDATE don_hang SET trang_thai = ? WHERE ma_don_hang = ?");
    }

    if ($stmt) {
        $stmt->bind_param("si", $trang_thai_moi, $ma_don);
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle me-1'></i> Cập nhật trạng thái đơn hàng <strong>#$ma_don</strong> thành <strong>$trang_thai_moi</strong> thành công!<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        } else {
            $msg = "<div class='alert alert-danger'>Lỗi cập nhật: " . $conn->error . "</div>";
        }
    }
}

// 4. Lấy thông tin đơn hàng hiện tại
$res = $conn->query("SELECT * FROM don_hang WHERE ma_don_hang = $ma_don");
if (!$res || $res->num_rows == 0) {
    $res = $conn->query("SELECT *, id AS ma_don_hang, order_status AS trang_thai, final_amount AS tong_tien, customer_name AS ho_ten FROM orders WHERE id = $ma_don");
}

$don_hang = $res ? $res->fetch_assoc() : null;

if (!$don_hang) {
    die("<div class='container mt-5 alert alert-danger'>Không tìm thấy đơn hàng #$ma_don! <a href='don-hang.php'>Quay lại</a></div>");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Đơn Hàng #<?php echo $ma_don; ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand text-success fw-bold" href="don-hang.php">
      <i class="bi bi-arrow-left-circle me-1"></i> Quay lại Danh sách Đơn hàng
    </a>
    <span class="text-white fs-6">Hệ Thống Quản Lý Đơn Hàng</span>
  </div>
</nav>

<div class="container" style="max-width: 600px;">
    <?php echo $msg; ?>

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="m-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG #<?php echo $ma_don; ?></h5>
        </div>
        <div class="card-body p-4">
            <div class="mb-3">
                <label class="form-label text-muted">Khách hàng:</label>
                <div class="fw-bold fs-5"><?php echo htmlspecialchars($don_hang['ho_va_ten'] ?? $don_hang['ho_ten'] ?? $don_hang['customer_name'] ?? 'Khách hàng'); ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Tổng tiền hóa đơn:</label>
                <div class="fw-bold text-success fs-5"><?php echo number_format($don_hang['tong_tien'] ?? $don_hang['final_amount'] ?? 0, 0, ',', '.'); ?> VNĐ</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Trạng thái hiện tại:</label>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                        <?php echo htmlspecialchars($don_hang['trang_thai'] ?? $don_hang['order_status'] ?? 'Chờ xử lý'); ?>
                    </span>
                </div>
            </div>

            <hr class="my-4">

            <!-- FORM CẬP NHẬT -->
            <form method="POST">
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Chọn trạng thái mới (*):</label>
                    <select name="trang_thai_moi" class="form-select form-select-lg fw-semibold" required>
                        <option value="Chờ xử lý" <?php if(($don_hang['trang_thai']??'') == 'Chờ xử lý') echo 'selected'; ?>>🟡 Chờ xử lý</option>
                        <option value="Đang giao" <?php if(($don_hang['trang_thai']??'') == 'Đang giao') echo 'selected'; ?>>🔵 Đang giao hàng</option>
                        <option value="Đã giao" <?php if(($don_hang['trang_thai']??'') == 'Đã giao') echo 'selected'; ?>>🟢 Đã giao hàng (Hoàn thành)</option>
                        <option value="Đã hủy" <?php if(($don_hang['trang_thai']??'') == 'Đã hủy') echo 'selected'; ?>>🔴 Hủy đơn hàng</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        <i class="bi bi-save me-1"></i> Lưu Cập Nhật
                    </button>
                    <a href="don-hang.php" class="btn btn-outline-secondary">Hủy bỏ / Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>