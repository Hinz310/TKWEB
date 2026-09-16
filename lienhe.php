
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trái Cây Miền Nam</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="Style.css">
</head>

<body>

<!-- THANH THÔNG BÁO -->
<div class="top-notice">
    Giảm <strong>25.000đ</strong> phí ship cho đơn hàng trên
    <strong>600.000đ</strong>
</div>


<!-- HEADER -->
<header class="main-header">

    <div class="container">

        <div class="header-content">

            <!-- MENU -->
            <div class="menu-wrapper">

                <button
                    class="menu-button"
                    type="button"
                    aria-label="Mở menu"
                    aria-expanded="false"
                >
                    <span class="menu-icon">☰</span>
                    <span class="menu-text">MENU</span>
                </button>


                <!-- MENU XỔ -->
                <div class="side-menu">


                    <!-- TRANG CHỦ -->
                    <a href="index.php" class="side-menu-link">
                        TRANG CHỦ
                    </a>


                    <!-- DANH MỤC TRÁI CÂY -->
                    <div class="side-menu-category">

                        <button
                            class="category-toggle"
                            type="button"
                            aria-expanded="false"
                        >
                            DANH MỤC TRÁI CÂY
                        </button>


                        <div class="category-submenu">

                            <a href="sanpham.php?category=trai-cay-viet-nam">
                                TRÁI CÂY VIỆT NAM
                            </a>

                            <a href="sanpham.php?category=trai-cay-nhap-khau">
                                TRÁI CÂY NHẬP KHẨU
                            </a>

                        </div>

                    </div>


                    <!-- LIÊN HỆ -->
                    <a href="lienhe.php" class="side-menu-link">
                        LIÊN HỆ
                    </a>


                    <!-- HỖ TRỢ -->
                    <div class="menu-support">

                        <p>BẠN CẦN HỖ TRỢ</p>

                        <div class="support-item">
                            <img src="images/hotline.png" alt="Hotline">
                            <span>0123 456 789</span>
                        </div>

                        <div class="support-item">
                            <img src="images/email.png" alt="Email">
                            <span>hello@traicaymiennam.com.vn</span>
                        </div>

                    </div>

                </div>

            </div>


            <!-- LOGO -->
            <a href="index.php" class="main-logo">
                <img src="images/logo.png" alt="Trái Cây Miền Nam">
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
                    <img src="images/timkiem.png" alt="">
                </button>

            </form>


            <!-- HOTLINE -->
            <div class="header-action hotline">

                <img
                    src="images/hotline.png"
                    alt=""
                    class="header-icon-img"
                >

                <div>
                    <small>Hotline:</small>
                    <strong>0123 456 789</strong>
                </div>

            </div>


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

                    <span>Tài khoản</span>

                </button>


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

                        <button
                            type="submit"
                            class="login-button"
                        >
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
                        alt=""
                        class="header-icon-img"
                    >

                    <span class="cart-count">0</span>

                </div>

                <span class="cart-text">Giỏ hàng</span>

            </a>

        </div>

    </div>

</header>


<!-- THANH DANH MỤC -->
<nav class="category-nav">

    <div class="container">

        <div class="category-content">

            <a href="index.php" class="category-item">
                TRANG CHỦ
            </a>

            <a href="sanpham.php" class="category-item">
                DANH MỤC TRÁI CÂY
            </a>

            <a href="lienhe.php" class="category-item active">
                LIÊN HỆ
            </a>

        </div>

    </div>

</nav>

<!-- TRANG LIÊN HỆ -->
<main class="contact-page">

    <div class="container contact-container">

        <!-- ĐƯỜNG DẪN -->
        <div class="contact-breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <span>Liên hệ</span>
        </div>


        <!-- BẢN ĐỒ -->
<div class="contact-map">

    <iframe
        src="https://www.google.com/maps?q=Trường+Đại+học+Nguyễn+Tất+Thành+Quận+7+TP+Hồ+Chí+Minh&output=embed"
        loading="lazy"
        allowfullscreen=""
        referrerpolicy="no-referrer-when-downgrade"
        title="Bản đồ Trường Đại học Nguyễn Tất Thành Quận 7">
    </iframe>

</div>


        <!-- THÔNG TIN + FORM -->
        <div class="contact-content">


            <!-- BÊN TRÁI -->
            <section class="contact-information">

                <h2>Thông tin liên hệ</h2>


                <div class="contact-info-item">

                    <span class="contact-icon">⌖</span>

                    <div>
                        <strong>Địa chỉ</strong>

                        <p>
                            Nguyễn Tất Thành University<br>
                            Quận 7, TP. Hồ Chí Minh
                        </p>
                    </div>

                </div>


                <div class="contact-info-item">

                    <span class="contact-icon">✉</span>

                    <div>
                        <strong>Email</strong>
                        <p>hello@traicaymiennam.com.vn</p>
                    </div>

                </div>


                <div class="contact-info-item">

                    <span class="contact-icon">☎</span>

                    <div>
                        <strong>Điện thoại</strong>
                        <p>Hotline: 0123 456 789</p>
                    </div>

                </div>


                <div class="contact-info-item">

                    <span class="contact-icon">◷</span>

                    <div>
                        <strong>Thời gian làm việc</strong>
                        <p>Thứ 2 - Chủ nhật: 08:00 - 21:00</p>
                    </div>

                </div>

            </section>


            <!-- BÊN PHẢI -->
            <section class="contact-form-section">

                <h2>Liên hệ với chúng tôi</h2>

                <p class="contact-description">
                    Nếu bạn có thắc mắc, hãy gửi yêu cầu cho chúng tôi.
                    Chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.
                </p>


                <form id="contactForm">

                    <!-- TÊN -->
                    <input
                        type="text"
                        id="contactName"
                        name="name"
                        placeholder="Tên của bạn"
                        required
                    >


                    <!-- EMAIL + SĐT -->
                    <div class="contact-form-row">

                        <input
                            type="email"
                            id="contactEmail"
                            name="email"
                            placeholder="Email của bạn"
                            required
                        >

                        <input
                            type="tel"
                            id="contactPhone"
                            name="phone"
                            placeholder="Số điện thoại của bạn"
                            required
                        >

                    </div>


                    <!-- NỘI DUNG -->
                    <textarea
                        id="contactMessage"
                        name="message"
                        placeholder="Nội dung"
                        required
                    ></textarea>


                    <button
                        type="submit"
                        class="contact-submit"
                    >
                        GỬI CHO CHÚNG TÔI
                    </button>

                </form>

            </section>

        </div>

    </div>

</main>

<!-- ==================================================
     FOOTER
================================================== -->
<footer class="site-footer">

    <div class="container">

        <div class="footer-grid">

            <!-- VỀ TRÁI CÂY MIỀN NAM -->
            <div class="footer-column">

                <h3>Về Trái Cây Miền Nam</h3>

                <p class="footer-description">
                    Trái Cây Miền Nam là thương hiệu trái cây tươi
                    chất lượng cao, với đa dạng sản phẩm phục vụ
                    mọi nhu cầu: đặc sản vùng miền Việt Nam và
                    trái cây nhập khẩu.
                </p>

            </div>


            <!-- THÔNG TIN LIÊN HỆ -->
            <div class="footer-column">

                <h3>Thông tin liên hệ</h3>

                <p>
                    <strong>Chi nhánh 1:</strong>
                    458/3F Nguyễn Hữu Thọ, phường Tân Hưng
                </p>

                <p>
                    <strong>Điện thoại:</strong>
                    0865 660 775
                </p>

                <p>
                    <strong>Email:</strong>
                    hello@traicaymiennam.com.vn
                </p>

            </div>

            <!-- CHĂM SÓC KHÁCH HÀNG -->
            <div class="footer-column footer-care">

                <h3>Chăm sóc khách hàng</h3>

                <div class="footer-phone">

                    <img
                        src="images/hotline.png"
                        alt="Hotline"
                        class="footer-phone-icon"
                    >

                    <div class="footer-contact-text">

                        <a
                            href="tel:0865660775"
                            class="footer-phone-number"
                        >
                            0865 660 775
                        </a>

                        <a
                            href="mailto:hello@traicaymiennam.com.vn"
                            class="footer-email"
                        >
                            hello@traicaymiennam.com.vn
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="footer-bottom">

        <div class="container">
            © 2026 Trái Cây Miền Nam. All rights reserved.
        </div>

    </div>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="index.js"></script>

</body>
</html>