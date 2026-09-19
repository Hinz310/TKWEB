<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && strtolower($_SESSION['role']) !== 'quản lý')) {
    header("Location: dangnhap.php");
    exit();
}
?>

<!-- Thanh Menu Quản Trị Viên -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
  <div class="container-fluid">
    <a class="navbar-brand text-success fw-bold" href="don-hang.php">
      <i class="bi bi-shield-lock"></i> ADMIN PANEL
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- 1. Quản lý Đơn hàng -->
        <li class="nav-item">
          <a class="nav-link active" href="don-hang.php">
            📦 Quản lý & Duyệt Đơn hàng
          </a>
        </li>
        <!-- 2. Quản lý Sản phẩm & Tồn kho -->
        <li class="nav-item">
          <a class="nav-link text-white" href="sanpham.php">
            🍎 Quản lý Trái cây & Kho
          </a>
        </li>
        <!-- 3. Quản lý Voucher -->
        <li class="nav-item">
          <a class="nav-link text-white" href="apply_voucher.php">
            🎟️ Quản lý Voucher
          </a>
        </li>
        <!-- 4. Phân quyền / Tạo Admin mới -->
        <li class="nav-item">
          <a class="nav-link text-white" href="dangky.php">
            👤 Quản lý & Tạo Tài khoản
          </a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center text-white">
        <span class="me-3">Xin chào, <strong><?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Admin'); ?></strong></span>
        <a href="index.php" class="btn btn-outline-light btn-sm me-2">Trang bán hàng</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>