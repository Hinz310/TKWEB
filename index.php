

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

        <span>
            <?php
            if (isset($_SESSION["ma_nguoi_dung"])) {
                echo htmlspecialchars($_SESSION["ho_ten"]);
            } else {
                echo "Tài khoản";
            }
            ?>
        </span>

    </button>


    <div class="account-dropdown">

        <?php if (isset($_SESSION["ma_nguoi_dung"])) { ?>

            <!-- ĐÃ ĐĂNG NHẬP -->

            <h4>THÔNG TIN TÀI KHOẢN</h4>

            <p>
                Xin chào,
                <strong>
                    <?php
                    echo htmlspecialchars($_SESSION["ho_ten"]);
                    ?>
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


        <?php } else { ?>

            <!-- CHƯA ĐĂNG NHẬP -->

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
                    name="mat_khau"
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
                    <a href="dangky.php">
                        Tạo tài khoản
                    </a>
                </p>

                <p>
                    Quên mật khẩu?
                    <a href="mat-khau.php">
                        Khôi phục mật khẩu
                    </a>
                </p>

            </div>

        <?php } ?>

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

            <a href="index.php" class="category-item active">
                TRANG CHỦ
            </a>

            <a href="sanpham.php?category=trai-cay-viet-nam" class="category-item">
                TRÁI CÂY VIỆT NAM
            </a>

            <a href="sanpham.php?category=trai-cay-nhap-khau" class="category-item">
                TRÁI CÂY NHẬP KHẨU
            </a>

            <a href="lienhe.php" class="category-item">
                LIÊN HỆ
            </a>

        </div>
    </div>
</nav>

<!-- BANNER -->
<section class="home-banner">

    <div
        id="fruitBanner"
        class="carousel slide"
        data-bs-ride="carousel"
    >

        <div class="carousel-indicators">

            <button
                type="button"
                data-bs-target="#fruitBanner"
                data-bs-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Banner 1"
            ></button>

            <button
                type="button"
                data-bs-target="#fruitBanner"
                data-bs-slide-to="1"
                aria-label="Banner 2"
            ></button>

        </div>


        <div class="carousel-inner">

            <div class="carousel-item active">
                <img
                    src="images/banner1.png"
                    class="d-block w-100"
                    alt="Banner trái cây 1"
                >
            </div>

            <div class="carousel-item">
                <img
                    src="images/banner2.png"
                    class="d-block w-100"
                    alt="Banner trái cây 2"
                >
            </div>

        </div>


        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#fruitBanner"
            data-bs-slide="prev"
        >
            <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
            ></span>

            <span class="visually-hidden">Trước</span>
        </button>


        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#fruitBanner"
            data-bs-slide="next"
        >
            <span
                class="carousel-control-next-icon"
                aria-hidden="true"
            ></span>

            <span class="visually-hidden">Sau</span>
        </button>

    </div>

</section>


<!-- NỘI DUNG -->
<main>

    <!-- TRÁI CÂY VIỆT NAM -->
    <section class="home-product-section">

        <div class="container">

            <div class="home-product-title">
                TRÁI CÂY VIỆT NAM
            </div>

            <div class="home-product-grid">

                <!-- SẢN PHẨM 1 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/BuoiDaXanh.jpg" alt="Bưởi Da Xanh">
                    </div>

                    <h3>Bưởi Da Xanh</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 2 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/CamCaoPhong.jpg" alt="Cam Cao Phong">
                    </div>

                    <h3>Cam Cao Phong</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 3 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/CamSanh.jpg" alt="Cam Sành">
                    </div>

                    <h3>Cam Sành</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 4 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/ChomChom.jpg" alt="Chôm Chôm">
                    </div>

                    <h3>Chôm Chôm</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 5 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/DuaXiem.jpg" alt="Dừa Xiêm">
                    </div>

                    <h3>Dừa Xiêm</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 6 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/NhanTieu.jpg" alt="Nhãn Tiêu">
                    </div>

                    <h3>Nhãn Tiêu</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 7 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/SauRieng.jpg" alt="Sầu Riêng">
                    </div>

                    <h3>Sầu Riêng</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

                <!-- SẢN PHẨM 8 -->
                <div class="home-product-card">
                    <div class="product-image-box">
                        <img src="images/ThanhLong.jpg" alt="Thanh Long">
                    </div>

                    <h3>Thanh Long</h3>
                    <p class="product-price">giá</p>

                    <button class="choose-product">
                        🛒 CHỌN MUA
                    </button>
                </div>

            </div>

            <!-- XEM THÊM -->
            <div class="view-more-products">
                <a href="sanpham.php?category=trai-cay-viet-nam">
                    Xem thêm sản phẩm trái cây Việt Nam
                </a>
            </div>

        </div>

    </section>

<!-- TRÁI CÂY NHẬP KHẨU -->
<section class="home-product-section">

    <div class="container">

        <!-- TIÊU ĐỀ -->
        <div class="home-product-title">
            TRÁI CÂY NHẬP KHẨU
        </div>

        <!-- DANH SÁCH SẢN PHẨM -->
        <div class="home-product-grid">

            <!-- SẢN PHẨM 1 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/BonBonThai.jpg" alt="Bòn Bon Thái">
                </div>

                <h3>Bòn Bon Thái</h3>
                <p class="product-price">95.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 2 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/CocThai.jpg" alt="Cóc Thái">
                </div>

                <h3>Cóc Thái</h3>
                <p class="product-price">60.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 3 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/MeThai.jpg" alt="Me Thái">
                </div>

                <h3>Me Thái</h3>
                <p class="product-price">85.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 4 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/MitThai.jpg" alt="Mít Thái">
                </div>

                <h3>Mít Thái</h3>
                <p class="product-price">75.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 5 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/DauTay.jpg" alt="Dâu Tây">
                </div>

                <h3>Dâu Tây</h3>
                <p class="product-price">180.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 6 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/HongXiem.jpg" alt="Hồng Xiêm">
                </div>

                <h3>Hồng Xiêm</h3>
                <p class="product-price">90.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 7 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/MangCut.jpg" alt="Măng Cụt">
                </div>

                <h3>Măng Cụt</h3>
                <p class="product-price">120.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>


            <!-- SẢN PHẨM 8 -->
            <div class="home-product-card">
                <div class="product-image-box">
                    <img src="images/VuSua.jpg" alt="Vú Sữa">
                </div>

                <h3>Vú Sữa</h3>
                <p class="product-price">110.000₫ / kg</p>

                <button class="choose-product">
                    🛒 CHỌN MUA
                </button>
            </div>

        </div>


        <!-- XEM THÊM -->
        <div class="view-more-products">
            <a href="sanpham.php?category=trai-cay-nhap-khau">
                Xem thêm sản phẩm trái cây nhập khẩu
            </a>
        </div>

    </div>

</section>

</main>

<!--FOOTER -->
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