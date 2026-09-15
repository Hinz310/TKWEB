<?php
include "Ketnoi.php";

$sql = "SELECT * FROM san_pham ORDER BY ma_san_pham DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Cửa hàng trái cây miền Nam</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="Style.css">
</head>

<body>

<!-- THANH THÔNG BÁO -->
<div class="top-notice">
    Giảm <strong>25.000đ</strong> phí ship cho đơn hàng trên <strong>600.000đ</strong>
</div>


<!-- HEADER CHÍNH -->
<header class="main-header">
    <div class="container">

        <div class="header-content">

            <!-- MENU -->
<div class="menu-wrapper">

    <!-- NÚT MỞ MENU -->
    <button class="menu-button" type="button">
        <span class="menu-icon">☰</span>
        <span class="menu-text">MENU</span>
    </button>


    <!-- MENU XỔ BÊN TRÁI -->
    <div class="side-menu">

        <!-- TRANG CHỦ -->
        <a href="index.php" class="side-menu-home">
            <img src="images/home.png" alt="Trang chủ">
        </a>

        <!-- CÁC MỤC MENU -->
        <a href="index.php">
            TRANG CHỦ
        </a>

        <a href="sanpham.php?category=trai-cay-viet-nam">
            TRÁI CÂY VIỆT NAM
        </a>

        <a href="sanpham.php?category=trai-cay-nhap-khau">
            TRÁI CÂY NHẬP KHẨU
        </a>

        <a href="#trai-ngon-moi-ngay">
            TRÁI NGON MỖI NGÀY
        </a>

        <a href="#lien-he">
            LIÊN HỆ
        </a>


        <!-- HỖ TRỢ -->
        <div class="menu-support">

            <p>BẠN CẦN HỖ TRỢ</p>

            <!-- HOTLINE -->
            <div class="support-item">
                <img src="images/hotline.png" alt="Hotline">
                <span>0123 456 789</span>
            </div>

            <!-- EMAIL -->
            <div class="support-item">
                <img src="images/email.png" alt="Email">
                <span>hello@traicaymiennam.com.vn</span>
            </div>

        </div>

    </div>

</div>

            <!-- TÌM KIẾM -->
            <form class="header-search" action="sanpham.php" method="GET">

                <input
                    type="text"
                    name="search"
                    placeholder="Tìm kiếm sản phẩm..."
                >

            <button type="submit" class="search-button">
                <img src="images/timkiem.png" alt="Tìm kiếm">
            </button>

            </form>

            <!-- HOTLINE -->
            <div class="header-action hotline">

                <img 
                src="images/hotline.png" 
                alt="Hotline"
                class="header-icon-img"
                >

    <div>
        <small>Hotline</small>
        <strong>0123 456 789</strong>
    </div>

</div>

            <<!-- TÀI KHOẢN -->
<div class="account-box">

    <button class="account-button" type="button">

        <img
            src="images/taikhoan.png"
            alt="Tài khoản"
            class="header-icon-img"
        >

        <span>Tài khoản</span>

    </button>


    <!-- HỘP ĐĂNG NHẬP -->
    <div class="account-dropdown">

        <h4>ĐĂNG NHẬP TÀI KHOẢN</h4>

        <p>Nhập email và mật khẩu của bạn:</p>

        <form action="dangnhap.php" method="POST">

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Mật khẩu"
                required
            >

            <button type="submit" class="login-button">
                ĐĂNG NHẬP
            </button>

        </form>

        <div class="account-links">
            <p>
                Khách hàng mới?
                <a href="dangky.php">Tạo tài khoản</a>
            </p>

            <p>
                Quên mật khẩu?
                <a href="#">Khôi phục mật khẩu</a>
            </p>
        </div>

    </div>

</div>

    <!-- GIỎ HÀNG -->
    <a href="giohang.php" class="cart-header">

    <div class="cart-icon-box">
        <img
            src="images/giohang.png"
            alt="Giỏ hàng"
            class="header-icon-img"
        >

        <span class="cart-count">0</span>
    </div>

    <span class="cart-text">Giỏ hàng</span>

</a>

<!-- THANH DANH MỤC -->
<nav class="category-nav">

    <div class="container">

        <div class="category-content">

            <!-- TRANG CHỦ -->
            <a href="index.php" class="category-item active">
                TRANG CHỦ
            </a>

            <!-- TRÁI CÂY VIỆT NAM -->
            <a href="sanpham.php?category=trai-cay-viet-nam"
               class="category-item">
                TRÁI CÂY VIỆT NAM
            </a>

            <!-- TRÁI CÂY NHẬP KHẨU -->
            <a href="sanpham.php?category=trai-cay-nhap-khau"
               class="category-item">
                TRÁI CÂY NHẬP KHẨU
            </a>

            <!-- TRÁI NGON MỖI NGÀY -->
            <a href="#trai-ngon-moi-ngay"
               class="category-item">
                TRÁI NGON MỖI NGÀY
            </a>

            <!-- LIÊN HỆ -->
            <a href="#lien-he"
               class="category-item">
                LIÊN HỆ
            </a>

        </div>

    </div>

</nav>

<!-- BANNER / SLIDER -->
<section class="home-banner">

    <div id="fruitBanner"
         class="carousel slide"
         data-bs-ride="carousel">

        <!-- CÁC CHẤM CHUYỂN SLIDE -->
        <div class="carousel-indicators">

            <button type="button"
                    data-bs-target="#fruitBanner"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Banner 1">
            </button>

            <button type="button"
                    data-bs-target="#fruitBanner"
                    data-bs-slide-to="1"
                    aria-label="Banner 2">
            </button>

            <button type="button"
                    data-bs-target="#fruitBanner"
                    data-bs-slide-to="2"
                    aria-label="Banner 3">
            </button>

        </div>


        <!-- ẢNH BANNER -->
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="images/banner1.jpg"
                     class="d-block w-100"
                     alt="Trái cây tươi">
            </div>

            <div class="carousel-item">
                <img src="images/banner2.jpg"
                     class="d-block w-100"
                     alt="Trái cây Việt Nam">
            </div>

            <div class="carousel-item">
                <img src="images/banner3.jpg"
                     class="d-block w-100"
                     alt="Trái cây nhập khẩu">
            </div>

        </div>


        <!-- NÚT TRÁI -->
        <button class="carousel-control-prev"
                type="button"
                data-bs-target="#fruitBanner"
                data-bs-slide="prev">

            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Trước</span>

        </button>


        <!-- NÚT PHẢI -->
        <button class="carousel-control-next"
                type="button"
                data-bs-target="#fruitBanner"
                data-bs-slide="next">

            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Sau</span>

        </button>

    </div>

</section>

<!-- HERO BANNER -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">

            <div class="col-lg-6">
                <p class="hero-subtitle">TRÁI CÂY TƯƠI MỖI NGÀY</p>

                <h1 class="hero-title">
                    Tươi ngon từ vườn<br>
                    đến tận tay bạn
                </h1>

                <p class="hero-description">
                    Chọn mua các loại trái cây tươi ngon,
                    chất lượng và có nguồn gốc rõ ràng.
                </p>

                <a href="sanpham.php" class="btn btn-success btn-lg">
                    Mua ngay
                </a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="images/banner-fruit.png"
                     class="img-fluid hero-image"
                     alt="Trái cây tươi">
            </div>

        </div>
    </div>
</section>

    <main id="san-pham">

    <h2>Danh sách sản phẩm</h2>

        <div class="san-pham-container">

            <?php
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
            ?>

                    <div class="san-pham">

                        <img 
                            src="images/<?php echo htmlspecialchars($row['hinh_anh']); ?>" 
                            alt="<?php echo htmlspecialchars($row['ten_san_pham']); ?>"
                        >

                        <h3>
                            <?php echo htmlspecialchars($row['ten_san_pham']); ?>
                        </h3>

                        <p>
                            <strong>
                                <?php echo number_format($row['gia']); ?> VNĐ
                            </strong>
                        </p>

                        <p>
                            Xuất xứ:
                            <?php echo htmlspecialchars($row['xuat_xu']); ?>
                        </p>

                        <p>
                            Còn:
                            <?php echo $row['so_luong_ton']; ?>
                            sản phẩm
                        </p>

                        <button>
                            Thêm vào giỏ hàng
                        </button>

                    </div>

            <?php
                }

            } else {
                echo "<p>Chưa có sản phẩm.</p>";
            }
            ?>

        </div>

    </main>

<!-- GIỚI THIỆU -->
<section id="gioi-thieu" class="about-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <h2>Về chúng tôi</h2>

                <p>
                    Trái Cây Miền Nam cung cấp các loại trái cây tươi ngon,
                    được chọn lọc kỹ và có nguồn gốc rõ ràng.
                </p>

                <p>
                    Chúng tôi mong muốn mang đến sản phẩm chất lượng,
                    an toàn và thuận tiện cho khách hàng mỗi ngày.
                </p>

                <a href="sanpham.php" class="btn btn-success">
                    Xem sản phẩm
                </a>
            </div>

            <div class="col-lg-6 text-center">
                <div class="about-box">
                    🍎 🍊 🥭 🍉
                </div>
            </div>

        </div>
    </div>
</section>
    
<!-- LIÊN HỆ -->
<section id="lien-he" class="contact-section">
    <div class="container">

        <div class="text-center mb-5">
            <h2>Liên hệ với chúng tôi</h2>
            <p>
                Bạn cần hỗ trợ hoặc muốn biết thêm thông tin?
                Hãy gửi tin nhắn cho chúng tôi.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-lg-5">
                <div class="contact-info">
                    <h4>Thông tin liên hệ</h4>

                    <p>📍 TP. Hồ Chí Minh</p>
                    <p>📞 0123 456 789</p>
                    <p>✉️ traicaymiennam@gmail.com</p>
                    <p>🕒 08:00 - 21:00 mỗi ngày</p>
                </div>
            </div>

            <div class="col-lg-7">
                <form class="contact-form">

                    <input type="text"
                           class="form-control"
                           placeholder="Họ và tên"
                           required>

                    <input type="email"
                           class="form-control"
                           placeholder="Email"
                           required>

                    <textarea class="form-control"
                              rows="5"
                              placeholder="Nội dung"
                              required></textarea>

                    <button type="submit" class="btn btn-success">
                        Gửi liên hệ
                    </button>

                </form>
            </div>

        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 mb-4 mb-lg-0">
                <h4>🍊 TRÁI CÂY MIỀN NAM</h4>
                <p>
                    Trái cây tươi ngon, được chọn lọc
                    và giao đến tận tay khách hàng.
                </p>
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5>Liên kết</h5>
                <a href="index.php">Trang chủ</a>
                <a href="sanpham.php">Sản phẩm</a>
                <a href="#gioi-thieu">Giới thiệu</a>
                <a href="#lien-he">Liên hệ</a>
            </div>

            <div class="col-lg-4">
                <h5>Liên hệ</h5>
                <p>📍 TP. Hồ Chí Minh</p>
                <p>📞 0123 456 789</p>
                <p>✉️ traicaymiennam@gmail.com</p>
            </div>

        </div>

        <hr>

        <p class="footer-bottom">
           Copyright © 2026 Trái Cây Miền Nam. All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>