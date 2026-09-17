<?php

session_start();
require_once "Ketnoi.php";

/* LẤY TẤT CẢ SẢN PHẨM TỪ DATABASE */
$sql = "SELECT * FROM san_pham ORDER BY ma_san_pham ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi SQL: " . $conn->error);
}

/* ĐƯA SẢN PHẨM VÀO MẢNG */
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

/* CHIA ĐÔI SẢN PHẨM */
$half = (int) ceil(count($products) / 2);

/* Chia toàn bộ sản phẩm thành 2 nhóm */
$allVietNamProducts = array_slice($products, 0, $half);
$allNhapKhauProducts = array_slice($products, $half);

/* Trang chủ chỉ hiển thị 8 sản phẩm mỗi nhóm */
$vietNamProducts = array_slice($allVietNamProducts, 0, 8);
$nhapKhauProducts = array_slice($allNhapKhauProducts, 0, 8);
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

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

                    <span class="menu-icon">
                        ☰
                    </span>

                    <span class="menu-text">
                        MENU
                    </span>

                </button>



                <!-- MENU XỔ -->

                <div class="side-menu">


                    <!-- TRANG CHỦ -->

                    <a
                        href="index.php"
                        class="side-menu-link"
                    >

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

                            <a
                                href="sanpham.php?category=trai-cay-viet-nam"
                            >

                                TRÁI CÂY VIỆT NAM

                            </a>


                            <a
                                href="sanpham.php?category=trai-cay-nhap-khau"
                            >

                                TRÁI CÂY NHẬP KHẨU

                            </a>

                        </div>

                    </div>



                    <!-- LIÊN HỆ -->

                    <a
                        href="lienhe.php"
                        class="side-menu-link"
                    >

                        LIÊN HỆ

                    </a>



                    <!-- HỖ TRỢ -->

                    <div class="menu-support">

                        <p>
                            BẠN CẦN HỖ TRỢ
                        </p>


                        <div class="support-item">

                            <img
                                src="images/hotline.png"
                                alt="Hotline"
                            >

                            <span>
                                0123 456 789
                            </span>

                        </div>


                        <div class="support-item">

                            <img
                                src="images/email.png"
                                alt="Email"
                            >

                            <span>
                                hello@traicaymiennam.com.vn
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- LOGO -->

            <a
                href="index.php"
                class="main-logo"
            >

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


            <!-- HOTLINE -->

            <div class="header-action hotline">

                <img
                    src="images/hotline.png"
                    alt=""
                    class="header-icon-img"
                >

                <div>

                    <small>
                        Hotline:
                    </small>

                    <strong>
                        0123 456 789
                    </strong>

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

                            echo htmlspecialchars(
                                $_SESSION["ho_ten"]
                            );

                        } else {

                            echo "Tài khoản";

                        }

                        ?>

                    </span>

                </button>



                <!-- DROPDOWN TÀI KHOẢN -->

                <div class="account-dropdown">


                    <?php if (isset($_SESSION["ma_nguoi_dung"])) { ?>


                        <!-- ĐÃ ĐĂNG NHẬP -->

                        <h4>
                            THÔNG TIN TÀI KHOẢN
                        </h4>


                        <p>

                            Xin chào,

                            <strong>

                                <?php

                                echo htmlspecialchars(
                                    $_SESSION["ho_ten"]
                                );

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

                        <h4>
                            ĐĂNG NHẬP TÀI KHOẢN
                        </h4>


                        <p>
                            Nhập email và mật khẩu của bạn:
                        </p>


                        <form
                            action="dangnhap.php"
                            method="POST"
                        >


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
    
            <a
                href="giohang.php"
                class="cart-header"
            >


                <div class="cart-icon-box">

                    <img
                        src="images/giohang.png"
                        alt=""
                        class="header-icon-img"
                    >

                    <span class="cart-count">
                        0
                    </span>

                </div>


                <span class="cart-text">
                    Giỏ hàng
                </span>

            </a>


        </div>

    </div>

</header>


<!-- THANH DANH MỤC -->

<nav class="category-nav">

    <div class="container">

        <div class="category-content">


            <a
                href="index.php"
                class="category-item active"
            >

                TRANG CHỦ

            </a>


            <a
                href="sanpham.php?category=trai-cay-viet-nam"
                class="category-item"
            >

                TRÁI CÂY VIỆT NAM

            </a>


            <a
                href="sanpham.php?category=trai-cay-nhap-khau"
                class="category-item"
            >

                TRÁI CÂY NHẬP KHẨU

            </a>


            <a
                href="lienhe.php"
                class="category-item"
            >

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


        <!-- CHẤM CHUYỂN BANNER -->

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



        <!-- ẢNH BANNER -->

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



        <!-- NÚT TRƯỚC -->

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

            <span class="visually-hidden">
                Trước
            </span>

        </button>



        <!-- NÚT SAU -->

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

            <span class="visually-hidden">
                Sau
            </span>

        </button>


    </div>

</section>


<!-- NỘI DUNG -->

<main>

    <!-- TRÁI CÂY VIỆT NAM -->

    <section class="home-product-section">

        <div class="container">


            <!-- TIÊU ĐỀ -->

            <div class="home-product-title">

                TRÁI CÂY VIỆT NAM

            </div>



            <!-- DANH SÁCH -->

            <div class="home-product-grid">


                <?php

                foreach ($vietNamProducts as $product) {


                    $id = (int)$product['ma_san_pham'];


                    $name = htmlspecialchars(
                        $product['ten_san_pham']
                    );


                    $image = htmlspecialchars(
                        $product['hinh_anh']
                    );


                    $price = number_format(
                        (float)$product['gia'],
                        0,
                        ',',
                        '.'
                    );

                ?>


                    <!-- CARD SẢN PHẨM -->

                    <div class="home-product-card">


                        <!-- ẢNH -->

                        <div class="product-image-box">

                            <img
                                src="images/<?php echo $image; ?>"
                                alt="<?php echo $name; ?>"
                            >

                        </div>



                        <!-- TÊN -->

                        <h3>

                            <?php echo $name; ?>

                        </h3>



                        <!-- GIÁ -->

                        <p class="product-price">

                            <?php echo $price; ?>₫ / kg

                        </p>



                        <!-- CHỌN MUA -->

                        <button
                            type="button"
                            class="choose-product"
                            data-id="<?php echo $id; ?>"
                        >

                            🛒 CHỌN MUA

                        </button>


                    </div>


                <?php

                }

                ?>


            </div>



            <!-- XEM THÊM -->

            <div class="view-more-products">

                <a
                    href="sanpham.php?category=trai-cay-viet-nam"
                >

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



            <!-- DANH SÁCH -->

            <div class="home-product-grid">


                <?php


                foreach ($nhapKhauProducts as $product) {


                    $id = (int)$product['ma_san_pham'];


                    $name = htmlspecialchars(
                        $product['ten_san_pham']
                    );


                    $image = htmlspecialchars(
                        $product['hinh_anh']
                    );


                    $price = number_format(
                        (float)$product['gia'],
                        0,
                        ',',
                        '.'
                    );

                ?>


                    <!-- CARD SẢN PHẨM -->

                    <div class="home-product-card">


                        <!-- ẢNH -->

                        <div class="product-image-box">

                            <img
                                src="images/<?php echo $image; ?>"
                                alt="<?php echo $name; ?>"
                            >

                        </div>



                        <!-- TÊN -->

                        <h3>

                            <?php echo $name; ?>

                        </h3>



                        <!-- GIÁ -->

                        <p class="product-price">

                            <?php echo $price; ?>₫ / kg

                        </p>



                        <!-- CHỌN MUA -->

                        <button
                            type="button"
                            class="choose-product"
                            data-id="<?php echo $id; ?>"
                        >

                            🛒 CHỌN MUA

                        </button>


                    </div>


                <?php

                }

                ?>


            </div>



            <!-- XEM THÊM -->

            <div class="view-more-products">

                <a
                    href="sanpham.php?category=trai-cay-nhap-khau"
                >

                    Xem thêm sản phẩm trái cây nhập khẩu

                </a>

            </div>


        </div>

    </section>


</main>


<!-- FOOTER -->

<footer class="site-footer">


    <div class="container">


        <div class="footer-grid">


            <!-- VỀ TRÁI CÂY MIỀN NAM -->

            <div class="footer-column">


                <h3>
                    Về Trái Cây Miền Nam
                </h3>


                <p class="footer-description">

                    Trái Cây Miền Nam là thương hiệu trái cây tươi
                    chất lượng cao, với đa dạng sản phẩm phục vụ
                    mọi nhu cầu: đặc sản vùng miền Việt Nam và
                    trái cây nhập khẩu.

                </p>


            </div>



            <!-- THÔNG TIN LIÊN HỆ -->

            <div class="footer-column">


                <h3>
                    Thông tin liên hệ
                </h3>


                <p>

                    <strong>
                        Chi nhánh 1:
                    </strong>

                    458/3F Nguyễn Hữu Thọ, phường Tân Hưng

                </p>


                <p>

                    <strong>
                        Điện thoại:
                    </strong>

                    0865 660 775

                </p>


                <p>

                    <strong>
                        Email:
                    </strong>

                    hello@traicaymiennam.com.vn

                </p>


            </div>



            <!-- CHĂM SÓC KHÁCH HÀNG -->

            <div class="footer-column footer-care">


                <h3>
                    Chăm sóc khách hàng
                </h3>


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



    <!-- FOOTER DƯỚI -->

    <div class="footer-bottom">


        <div class="container">

            © 2026 Trái Cây Miền Nam. All rights reserved.

        </div>


    </div>


</footer>



<!-- BOOTSTRAP -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>


<!-- JAVASCRIPT -->

<script src="index.js"></script>


</body>

</html>