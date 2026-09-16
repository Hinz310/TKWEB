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
                    <a href="#lien-he" class="side-menu-link">
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

            <a href="index.php" class="category-item active">
                TRANG CHỦ
            </a>

            <a href="sanpham.php" class="category-item">
                DANH MỤC TRÁI CÂY
            </a>

            <a href="#lien-he" class="category-item">
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

    <!-- TRÁI NGON HÔM NAY SẼ LÀM Ở ĐÂY -->

</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="index.js"></script>

</body>
</html>