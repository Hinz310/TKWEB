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

<!-- HEADER -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">

        <!-- Logo / Tên cửa hàng -->
        <a class="navbar-brand fw-bold" href="index.php">
            🍊 TRÁI CÂY MIỀN NAM
        </a>

        <!-- Nút menu trên điện thoại -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Mở menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        Trang chủ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#san-pham">
                        Sản phẩm
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#gioi-thieu">
                        Giới thiệu
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#lien-he">
                        Liên hệ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="giohang.php">
                        🛒 Giỏ hàng
                    </a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="btn btn-outline-success" href="dangnhap.php">
                        Đăng nhập
                    </a>
                </li>

                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-success" href="dangky.php">
                        Đăng ký
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

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

                <a href="#san-pham" class="btn btn-success btn-lg">
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

                <a href="#san-pham" class="btn btn-success">
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
                <a href="#san-pham">Sản phẩm</a>
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
            © 2026 Trái Cây Miền Nam. All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>