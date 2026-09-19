<?php
session_start();

// 1. Chốt bảo vệ: Chỉ Admin hoặc Quản lý mới được truy cập
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && strtolower($_SESSION['role']) !== 'quản lý' && strtolower($_SESSION['role']) !== 'quan ly')) {
    header("Location: dangnhap.php");
    exit();
}

include "Ketnoi.php";

// 2. Truy vấn danh sách đơn hàng (Dùng LEFT JOIN để tránh mất dữ liệu khách)
$sql = "
SELECT 
    don_hang.ma_don_hang,
    COALESCE(nguoi_dung.ho_va_ten, don_hang.ho_ten, 'Khách hàng') AS ho_va_ten,
    don_hang.tong_tien,
    don_hang.dia_chi_giao,
    don_hang.so_dien_thoai,
    don_hang.trang_thai,
    don_hang.ngay_dat
FROM don_hang
LEFT JOIN nguoi_dung
    ON don_hang.ma_nguoi_dung = nguoi_dung.ma_nguoi_dung
ORDER BY don_hang.ma_don_hang DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("LỖI SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng - Admin Panel</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

<!-- THANH NAVBAR ADMIN CHUẨN TRÊN DON-HANG.PHP -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand text-success fw-bold" href="don-hang.php">
      <i class="bi bi-shield-check me-1"></i> ADMIN TRÁI CÂY
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- 1. Quản lý Đơn hàng -->
        <li class="nav-item">
          <a class="nav-link active fw-bold text-warning" href="don-hang.php">
            📦 Quản lý & Duyệt đơn hàng
          </a>
        </li>
        <!-- 2. Quản lý Sản phẩm & Tồn kho (Trỏ về file mới quan-ly-san-pham.php) -->
        <li class="nav-item">
          <a class="nav-link text-white" href="quan-ly-san-pham.php">
            🍎 Quản lý Trái cây & Kho
          </a>
        </li>
        <!-- 3. Quản lý Voucher (Trỏ về quan-ly-voucher.php) -->
        <li class="nav-item">
          <a class="nav-link text-white" href="quan-ly-voucher.php">
            🎟️ Quản lý Voucher
          </a>
        </li>
        <!-- 4. Phân quyền / Thêm Admin mới -->
        <li class="nav-item">
          <a class="nav-link text-white" href="dangky.php">
            👤 Thêm Nhân viên / Admin
          </a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center text-white">
        <span class="me-3 fs-6">Xin chào, <strong class="text-warning"><?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['ho_ten'] ?? 'Quản lý'); ?></strong></span>
        <a href="index.php" class="btn btn-outline-light btn-sm me-2"><i class="bi bi-shop"></i> Xem Website</a>
        <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>

<!-- BẢNG DANH SÁCH ĐƠN HÀNG -->
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold text-success"><i class="bi bi-receipt me-2"></i>QUẢN LÝ VÀ DUYỆT ĐƠN HÀNG</h4>
            <span class="badge bg-secondary fs-6">Tổng đơn: <?php echo $result ? $result->num_rows : 0; ?></span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle m-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ giao</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Gán màu sắc Badge tương ứng với trạng thái đơn hàng
                            $status = trim($row["trang_thai"]);
                            $badge_class = "bg-warning text-dark"; // Mặc định Chờ xử lý
                            if ($status === "Đang giao" || $status === "Đang vận chuyển") {
                                $badge_class = "bg-primary";
                            } elseif ($status === "Đã giao" || $status === "Hoàn thành") {
                                $badge_class = "bg-success";
                            } elseif ($status === "Đã hủy" || $status === "Hủy đơn") {
                                $badge_class = "bg-danger";
                            }
                    ?>
                        <tr>
                            <td class="fw-bold text-primary">#<?php echo $row["ma_don_hang"]; ?></td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($row["ho_va_ten"]); ?></td>
                            <td><?php echo htmlspecialchars($row["so_dien_thoai"] ?? 'N/A'); ?></td>
                            <td class="text-start" style="max-width: 250px;"><?php echo htmlspecialchars($row["dia_chi_giao"] ?? 'N/A'); ?></td>
                            <td class="fw-bold text-success"><?php echo number_format($row["tong_tien"], 0, ',', '.'); ?> VNĐ</td>
                            <td>
                                <span class="badge <?php echo $badge_class; ?> px-3 py-2 fs-6">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="text-muted small">
                                <?php echo !empty($row["ngay_dat"]) ? date('d/m/Y H:i', strtotime($row["ngay_dat"])) : 'N/A'; ?>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary fw-semibold" 
                                   href="cap-nhat-don-hang.php?id=<?php echo $row["ma_don_hang"]; ?>">
                                    <i class="bi bi-pencil-square me-1"></i> Cập nhật
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted fs-5">
                                <i class="bi bi-inbox me-2"></i> Chưa có đơn hàng nào trong hệ thống.
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>