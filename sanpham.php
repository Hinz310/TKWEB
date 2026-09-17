<?php

session_start();
require_once "Ketnoi.php";


/* LẤY DANH MỤC TRÊN URL */

$category = $_GET['category'] ?? 'trai-cay-viet-nam';


if ($category === 'trai-cay-nhap-khau') {

    $title = 'TRÁI CÂY NHẬP KHẨU';

} else {

    $category = 'trai-cay-viet-nam';
    $title = 'TRÁI CÂY VIỆT NAM';

}


/*  TẤT CẢ SẢN PHẨM
   CÙNG THỨ TỰ VỚI TRANG CHỦ*/

$sql = "SELECT * FROM san_pham ORDER BY ma_san_pham ASC";

$result = $conn->query($sql);


if (!$result) {

    die("Lỗi SQL: " . $conn->error);

}


/* ĐƯA SẢN PHẨM VÀO MẢNG*/

$products = [];


while ($row = $result->fetch_assoc()) {

    $products[] = $row;

}


/* CHIA ĐÔI SẢN PHẨM GIỐNG TRANG CHỦ */

$half = (int) ceil(count($products) / 2);


/* NỬA ĐẦU */
$vietNamProducts = array_slice(
    $products,
    0,
    $half
);


/* NỬA SAU */
$nhapKhauProducts = array_slice(
    $products,
    $half
);


/* CHỌN DANH SÁCH CẦN HIỂN THỊ */

if ($category === 'trai-cay-nhap-khau') {

    $displayProducts = $nhapKhauProducts;

} else {

    $displayProducts = $vietNamProducts;

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


    <title>
        <?php echo $title; ?> - Trái Cây Miền Nam
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
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

    Giảm <strong>25.000đ</strong>
    phí ship cho đơn hàng trên

    <strong>600.000đ</strong>

</div>



<!-- HEADER-->

<header class="main-header">


    <div class="container">


        <div class="header-content">


            <!-- MENU-->

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



                    <!-- DANH MỤC -->

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



            <!--TÌM KIẾM-->

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



            <!--HOTLINE-->

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



            <!-- TÀI KHOẢN-->

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



<!--THANH DANH MỤC-->

<nav class="category-nav">


    <div class="container">


        <div class="category-content">


            <!-- TRANG CHỦ -->

            <a
                href="index.php"
                class="category-item"
            >

                TRANG CHỦ

            </a>



            <!-- VIỆT NAM -->

            <a
                href="sanpham.php?category=trai-cay-viet-nam"
                class="category-item <?php echo $category === 'trai-cay-viet-nam' ? 'active' : ''; ?>"
            >

                TRÁI CÂY VIỆT NAM

            </a>



            <!-- NHẬP KHẨU -->

            <a
                href="sanpham.php?category=trai-cay-nhap-khau"
                class="category-item <?php echo $category === 'trai-cay-nhap-khau' ? 'active' : ''; ?>"
            >

                TRÁI CÂY NHẬP KHẨU

            </a>



            <!-- LIÊN HỆ -->

            <a
                href="lienhe.php"
                class="category-item"
            >

                LIÊN HỆ

            </a>


        </div>


    </div>


</nav>



<!-- TRANG DANH MỤC SẢN PHẨM -->

<main class="product-category-page">


    <div class="container">



        <!--  BREADCRUMB -->

        <div class="contact-breadcrumb">


            <a href="index.php">
                Trang chủ
            </a>


            <span>
                /
            </span>


            <span>

                <?php

                echo $category === 'trai-cay-viet-nam'
                    ? 'Trái cây Việt Nam'
                    : 'Trái cây nhập khẩu';

                ?>

            </span>


        </div>



        <!-- BANNER DANH MỤC-->

        <div class="category-banner">


            <img
                src="images/banner1.png"
                alt="<?php echo $title; ?>"
            >


        </div>



        <!-- TIÊU ĐỀ-->

        <div class="product-toolbar">


            <h2 class="product-category-name">

                <?php

                echo $category === 'trai-cay-viet-nam'
                    ? 'Trái cây Việt Nam'
                    : 'Trái cây nhập khẩu';

                ?>

            </h2>



            <div class="product-sort-area">

                <!-- SAU NÀY THÊM SẮP XẾP / LỌC -->

            </div>


        </div>



        <!--  SÁCH SẢN PHẨM-->

        <div
            class="home-product-grid"
            id="productList"
        >


            <?php if (count($displayProducts) > 0) { ?>


                <?php foreach ($displayProducts as $product) { ?>


                    <div
                        class="home-product-card category-product"
                    >


                        <!-- ẢNH -->

                        <div class="product-image-box">


                            <img
                                src="images/<?php echo htmlspecialchars($product['hinh_anh']); ?>"
                                alt="<?php echo htmlspecialchars($product['ten_san_pham']); ?>"
                            >


                        </div>



                        <!-- TÊN -->

                        <h3>

                            <?php

                            echo htmlspecialchars(
                                $product['ten_san_pham']
                            );

                            ?>

                        </h3>



                        <!-- GIÁ -->

                        <p class="product-price">

                            <?php

                            echo number_format(
                                $product['gia'],
                                0,
                                ',',
                                '.'
                            );

                            ?>₫ / kg

                        </p>



                        <!-- CHỌN MUA -->

                        <button
                            type="button"
                            class="choose-product"
                            data-id="<?php echo $product['ma_san_pham']; ?>"
                        >

                            🛒 CHỌN MUA

                        </button>


                    </div>


                <?php } ?>


            <?php } else { ?>


                <p>
                    Không có sản phẩm.
                </p>


            <?php } ?>


        </div>



        <!-- XEM THÊM-->

        <div class="load-more-wrapper">


            <button
                type="button"
                id="loadMoreBtn"
                class="load-more-btn"
            >

                XEM THÊM

            </button>


        </div>


    </div>


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


<script src="index.js"></script>


</body>

</html>