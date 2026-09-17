<?php
session_start();
require_once "Ketnoi.php";

/* KIỂM TRA ĐĂNG NHẬP */
if (!isset($_SESSION["user_id"]) && !isset($_SESSION["ma_nguoi_dung"])) {
    header("Location: dangnhap.php");
    exit;
}

/* LẤY ID NGƯỜI DÙNG */
$user_id = $_SESSION["user_id"] ?? $_SESSION["ma_nguoi_dung"];

/* LẤY THÔNG TIN TÀI KHOẢN */
$sql = "SELECT id, username, fullname, email, phone, address, role, status, created_at
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* KHÔNG TÌM THẤY TÀI KHOẢN */
if (!$user) {
    session_destroy();
    header("Location: dangnhap.php");
    exit;
}

/* DỮ LIỆU HIỂN THỊ */
$fullname = $user["fullname"] ?? "";
$email    = $user["email"] ?? "";
$phone    = $user["phone"] ?? "";
$address  = $user["address"] ?? "";
$role     = $user["role"] ?? "Khách hàng";
$status   = $user["status"] ?? "";

/* ĐẾM GIỎ HÀNG */
$cart_count = 0;

if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $cart_count += (int)($item["quantity"] ?? 0);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Thông tin tài khoản - Trái Cây Miền Nam</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="Style.css"
    >
</head>

<body>

<!-- THANH THÔNG BÁO -->
<div class="top-notice">
    Miễn phí giao hàng cho đơn hàng từ 500.000đ
</div>


<!-- HEADER -->
<header class="main-header">

    <div class="header-content">

        <!-- LOGO -->
        <a href="index.php" class="main-logo">
            <img
                src="images/logo.png"
                alt="Trái Cây Miền Nam"
            >
        </a>


        <!-- TÌM KIẾM -->
        <form
            class="header-search"
            action="sanpham.php"
            method="GET"
        >
            <input
                type="text"
                name="search"
                placeholder="Tìm kiếm sản phẩm..."
            >

            <button
                type="submit"
                class="search-button"
                aria-label="Tìm kiếm"
            >
                <img
                    src="images/timkiem.png"
                    alt=""
                >
            </button>
        </form>


        <!-- GIỎ HÀNG -->
        <a href="giohang.php" class="cart-header">

            <div class="cart-icon-box">

                <img
                    src="images/giohang.png"
                    alt="Giỏ hàng"
                >

                <span class="cart-count">
                    <?php echo $cart_count; ?>
                </span>

            </div>

            <span class="cart-text">
                Giỏ hàng
            </span>

        </a>


        <!-- TÀI KHOẢN -->
        <div class="account-box">

            <button
                class="account-button"
                type="button"
                aria-expanded="false"
            >
                <img
                    src="images/taikhoan.png"
                    alt=""
                    class="header-icon-img"
                >

                <span>
                    <?php echo htmlspecialchars($fullname); ?>
                </span>
            </button>


            <!-- DROPDOWN TÀI KHOẢN -->
            <div class="account-dropdown">

                <h4>THÔNG TIN TÀI KHOẢN</h4>

                <p>
                    Xin chào,
                    <strong>
                        <?php echo htmlspecialchars($fullname); ?>
                    </strong>
                </p>

                <div class="account-links">

                    <p>
                        <a href="taikhoan.php">
                            Thông tin tài khoản
                        </a>
                    </p>

                    <p>
                        <a href="order_history.php">
                            Đơn hàng của tôi
                        </a>
                    </p>

                    <p>
                        <a href="logout.php">
                            Đăng xuất
                        </a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</header>


<!-- NỘI DUNG TÀI KHOẢN -->
<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4 p-md-5">

                    <h2 class="fw-bold mb-4">
                        THÔNG TIN TÀI KHOẢN
                    </h2>


                    <!-- HỌ VÀ TÊN -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Họ và tên
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?php echo htmlspecialchars($fullname); ?>"
                            readonly
                        >

                    </div>


                    <!-- EMAIL -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            value="<?php echo htmlspecialchars($email); ?>"
                            readonly
                        >

                    </div>


                    <!-- SỐ ĐIỆN THOẠI -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Số điện thoại
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?php echo htmlspecialchars($phone); ?>"
                            readonly
                        >

                    </div>


                    <!-- ĐỊA CHỈ -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Địa chỉ
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?php echo htmlspecialchars($address); ?>"
                            readonly
                        >

                    </div>


                    <!-- LOẠI TÀI KHOẢN -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Loại tài khoản
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?php echo htmlspecialchars($role); ?>"
                            readonly
                        >

                    </div>


                    <!-- TRẠNG THÁI -->
                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Trạng thái
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?php echo htmlspecialchars($status); ?>"
                            readonly
                        >

                    </div>


                    <!-- NÚT CHỨC NĂNG -->
                    <div class="d-flex gap-2 flex-wrap">

                        <a
                            href="order_history.php"
                            class="btn btn-danger"
                        >
                            Xem đơn hàng của tôi
                        </a>

                        <a
                            href="index.php"
                            class="btn btn-outline-secondary"
                        >
                            Về trang chủ
                        </a>

                        <a
                            href="logout.php"
                            class="btn btn-outline-danger"
                        >
                            Đăng xuất
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>


<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- MENU + TÀI KHOẢN -->
<script src="index.js"></script>

</body>

</html>