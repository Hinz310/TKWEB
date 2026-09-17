<?php

session_start();
require_once "Ketnoi.php";


/* LẤY THAM SỐ URL*/

$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'default';
$category = $_GET['category'] ?? 'trai-cay-viet-nam';
$scope = $_GET['scope'] ?? 'category';


/* XÁC ĐỊNH DANH MỤC*/

if ($category === 'trai-cay-nhap-khau') {

    $title = 'TRÁI CÂY NHẬP KHẨU';

} else {

    $category = 'trai-cay-viet-nam';
    $title = 'TRÁI CÂY VIỆT NAM';

}


/* LẤY SẢN PHẨM DATABASE*/

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


/* CHIA 2 DANH MỤC*/

$half = (int) ceil(count($products) / 2);

$vietNamProducts = array_slice(
    $products,
    0,
    $half
);

$nhapKhauProducts = array_slice(
    $products,
    $half
);


/* CHỌN DANH MỤC HIỆN TẠI*/

if ($category === 'trai-cay-nhap-khau') {

    $categoryProducts = $nhapKhauProducts;

} else {

    $categoryProducts = $vietNamProducts;

}


/* TÌM KIẾM SẢN PHẨM*/

if ($search !== '') {

    $displayProducts = [];

    // Tìm từ TRANG CHỦ
    // => tìm toàn bộ Việt Nam + nhập khẩu
    if ($scope === 'all') {

        $searchProducts = $products;

    } else {

        // Tìm trong DANH MỤC hiện tại
        $searchProducts = $categoryProducts;

    }


    foreach ($searchProducts as $product) {

        $productName = $product['ten_san_pham'] ?? '';

        if (stripos($productName, $search) !== false) {

            $displayProducts[] = $product;

        }

    }

    $title = 'KẾT QUẢ TÌM KIẾM';

} else {

    $displayProducts = $categoryProducts;

}


/* SẮP XẾP SẢN PHẨM*/

switch ($sort) {

    case 'price-asc':

        usort(
            $displayProducts,
            function ($a, $b) {

                return (float)$a['gia']
                    <=> (float)$b['gia'];

            }
        );

        break;


    case 'price-desc':

        usort(
            $displayProducts,
            function ($a, $b) {

                return (float)$b['gia']
                    <=> (float)$a['gia'];

            }
        );

        break;


    case 'name-asc':

        usort(
            $displayProducts,
            function ($a, $b) {

                return strcasecmp(
                    $a['ten_san_pham'],
                    $b['ten_san_pham']
                );

            }
        );

        break;


    case 'name-desc':

        usort(
            $displayProducts,
            function ($a, $b) {

                return strcasecmp(
                    $b['ten_san_pham'],
                    $a['ten_san_pham']
                );

            }
        );

        break;

}


/* ĐẾM GIỎ HÀNG*/

$cart_count = 0;

if (
    isset($_SESSION['cart']) &&
    is_array($_SESSION['cart'])
) {

    foreach ($_SESSION['cart'] as $item) {

        $cart_count +=
            (int)($item['quantity'] ?? 0);

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

    <title>
        <?php echo htmlspecialchars($title); ?>
        - Trái Cây Miền Nam
    </title>


    <!-- BOOTSTRAP -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- CSS CHÍNH -->

    <link
        rel="stylesheet"
        href="Style.css"
    >

</head>


<body>


<!--THÔNG BÁO GIỎ HÀNG-->

<?php if (isset($_SESSION['message'])) { ?>

    <div
        class="alert alert-success alert-dismissible fade show position-fixed"
        style="
            top: 15px;
            right: 15px;
            z-index: 99999;
            min-width: 300px;
        "
    >

        ✅
        <?php
        echo htmlspecialchars(
            $_SESSION['message']
        );
        ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        >
        </button>

    </div>

    <?php unset($_SESSION['message']); ?>

<?php } ?>


<!--THANH THÔNG BÁO-->

<div class="top-notice">

    Giảm <strong>20.000đ</strong>
    cho đơn hàng khi nhập voucher
    <strong>TRAICAY20K</strong>

</div>


<!--HEADER-->

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


                    <a
                        href="index.php"
                        class="side-menu-link"
                    >
                        TRANG CHỦ
                    </a>


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


                    <a
                        href="lienhe.php"
                        class="side-menu-link"
                    >
                        LIÊN HỆ
                    </a>


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
                    type="hidden"
                    name="category"
                    value="<?php echo htmlspecialchars($category); ?>"
                >
                <input
                    type="hidden"
                    name="scope"
                    value="category"
                >
                <input
                    type="text"
                    name="search"
                    placeholder="Tìm kiếm sản phẩm..."
                    value="<?php echo htmlspecialchars($search); ?>"
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

                        if (
                            isset($_SESSION["ma_nguoi_dung"]) ||
                            isset($_SESSION["user_id"])
                        ) {

                            echo htmlspecialchars(
                                $_SESSION["ho_ten"]
                                ?? $_SESSION["fullname"]
                                ?? "Tài khoản"
                            );

                        } else {

                            echo "Tài khoản";

                        }

                        ?>

                    </span>

                </button>


                <!-- DROPDOWN TÀI KHOẢN -->

                <div class="account-dropdown">

                    <?php

                    if (
                        isset($_SESSION["ma_nguoi_dung"]) ||
                        isset($_SESSION["user_id"])
                    ) {

                    ?>

                        <h4>
                            THÔNG TIN TÀI KHOẢN
                        </h4>

                        <p>

                            Xin chào,

                            <strong>

                                <?php

                                echo htmlspecialchars(
                                    $_SESSION["ho_ten"]
                                    ?? $_SESSION["fullname"]
                                    ?? "Khách hàng"
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
                        alt="Giỏ hàng"
                        class="header-icon-img"
                    >

                    <span class="cart-count">
                        <?php echo $cart_count; ?>
                    </span>

                </div>

                <span class="cart-text">
                    Giỏ hàng
                </span>

            </a>


        </div>

    </div>

</header>


<!-- THANH DANH MỤC-->

<nav class="category-nav">

    <div class="container">

        <div class="category-content">


            <a
    href="index.php"
    class="category-item <?php echo $scope === 'all' ? 'active' : ''; ?>"
>
    TRANG CHỦ
</a>

<a
    href="sanpham.php?category=trai-cay-viet-nam"
    class="category-item <?php echo ($scope !== 'all' && $category === 'trai-cay-viet-nam') ? 'active' : ''; ?>"
>
    TRÁI CÂY VIỆT NAM
</a>

<a
    href="sanpham.php?category=trai-cay-nhap-khau"
    class="category-item <?php echo ($scope !== 'all' && $category === 'trai-cay-nhap-khau') ? 'active' : ''; ?>"
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


<!-- TRANG SẢN PHẨM-->

<main class="product-category-page">

    <div class="container">


        <!-- BREADCRUMB -->

        <div class="contact-breadcrumb">

            <a href="index.php">
                Trang chủ
            </a>

            <span>
                /
            </span>

            <span>

                <?php

                if ($search !== '') {

                    echo 'Kết quả tìm kiếm';

                } else {

                    echo $category === 'trai-cay-viet-nam'
                        ? 'Trái cây Việt Nam'
                        : 'Trái cây nhập khẩu';

                }

                ?>

            </span>

        </div>


        <!-- BANNER -->

        <?php if ($search === '') { ?>

            <div class="category-banner">

                <img
                    src="images/banner1.png"
                    alt="<?php echo htmlspecialchars($title); ?>"
                >

            </div>

        <?php } ?>


        <!--TIÊU ĐỀ + BỘ LỌC-->

        <div class="product-toolbar">


            <h2 class="product-category-name">

                <?php if ($search !== '') { ?>

                    Kết quả tìm kiếm cho:
                    "<?php echo htmlspecialchars($search); ?>"

                <?php } else { ?>

                    <?php

                    echo $category === 'trai-cay-viet-nam'
                        ? 'Trái cây Việt Nam'
                        : 'Trái cây nhập khẩu';

                    ?>

                <?php } ?>

            </h2>


            <!-- BỘ LỌC SẮP XẾP -->

            <div class="product-sort-area">

                <form
                    action="sanpham.php"
                    method="GET"
                    class="product-sort-form"
                >

                    <!-- GIỮ DANH MỤC -->

                    <input
                        type="hidden"
                        name="category"
                        value="<?php echo htmlspecialchars($category); ?>"
                    >


                    <!-- GIỮ TỪ KHÓA TÌM KIẾM -->

                    <?php if ($search !== '') { ?>

                        <input
                            type="hidden"
                            name="search"
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                    <?php } ?>


                    <!-- SẮP XẾP -->

                    <select
    name="sort"
    id="productSort"
    class="product-sort-select"
    onchange="this.form.submit()"
>

                        <option
                            value="default"
                            <?php echo $sort === 'default' ? 'selected' : ''; ?>
                        >
                            ↕ Sắp xếp
                        </option>


                        <option
                            value="price-asc"
                            <?php echo $sort === 'price-asc' ? 'selected' : ''; ?>
                        >
                            Giá: Tăng dần
                        </option>


                        <option
                            value="price-desc"
                            <?php echo $sort === 'price-desc' ? 'selected' : ''; ?>
                        >
                            Giá: Giảm dần
                        </option>


                        <option
                            value="name-asc"
                            <?php echo $sort === 'name-asc' ? 'selected' : ''; ?>
                        >
                            Tên: A-Z
                        </option>


                        <option
                            value="name-desc"
                            <?php echo $sort === 'name-desc' ? 'selected' : ''; ?>
                        >
                            Tên: Z-A
                        </option>

                    </select>

                </form>

            </div>

        </div>


        <!-- DANH SÁCH SẢN PHẨM-->

        <div
            class="home-product-grid"
            id="productList"
        >

            <?php if (count($displayProducts) > 0) { ?>


                <?php foreach ($displayProducts as $product) { ?>


                    <div class="home-product-card category-product">


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
                            class="choose-product btn-open-popup"

                            data-id="<?php
                                echo (int)$product['ma_san_pham'];
                            ?>"

                            data-name="<?php
                                echo htmlspecialchars(
                                    $product['ten_san_pham']
                                );
                            ?>"

                            data-price="<?php
                                echo (float)$product['gia'];
                            ?>"

                            data-image="<?php
                                echo htmlspecialchars(
                                    $product['hinh_anh']
                                );
                            ?>"
                        >
                            🛒 CHỌN MUA
                        </button>


                    </div>


                <?php } ?>


            <?php } else { ?>


                <p class="no-product">

                    <?php if ($search !== '') { ?>

                        Không tìm thấy sản phẩm phù hợp với
                        "<strong><?php echo htmlspecialchars($search); ?></strong>".

                    <?php } else { ?>

                        Không có sản phẩm.

                    <?php } ?>

                </p>


            <?php } ?>

        </div>


        <!-- XEM THÊM -->

        <?php if (count($displayProducts) > 8) { ?>

            <div class="load-more-wrapper">

                <button
                    type="button"
                    id="loadMoreBtn"
                    class="load-more-btn"
                >
                    XEM THÊM
                </button>

            </div>

        <?php } ?>


    </div>

</main>


<!--POPUP CHỌN SỐ LƯỢNG-->

<div
    class="modal fade modal-quick-buy"
    id="quickBuyModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <div class="modal-header border-0 pb-0">

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                </button>

            </div>


            <div class="modal-body text-center pt-0 px-4 pb-4">


                <!-- ẢNH -->

                <img
                    id="modalProductImg"
                    src=""
                    alt=""
                    class="img-fluid mb-3"
                    style="
                        max-height: 160px;
                        object-fit: contain;
                    "
                >


                <!-- TÊN -->

                <h5
                    id="modalProductName"
                    class="fw-bold text-dark mb-2"
                >
                </h5>


                <!-- GIÁ -->

                <p
                    id="modalProductPrice"
                    class="fs-4 fw-bold text-danger mb-3"
                >
                </p>


                <!-- FORM THÊM GIỎ -->

                <form
                    action="cart_actions.php?action=add"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        id="modalProductId"
                        value=""
                    >

                    <input
                        type="hidden"
                        name="quantity"
                        id="modalQuantityInput"
                        value="1"
                    >


                    <div
                        class="d-flex align-items-center justify-content-between pt-3 border-top"
                    >


                        <!-- SỐ LƯỢNG -->

                        <div class="d-flex align-items-center gap-2">

                            <button
                                type="button"
                                class="btn-qty"
                                id="btnMinus"
                            >
                                -
                            </button>


                            <span
                                id="modalQuantityDisplay"
                                class="fw-bold fs-5 px-2"
                            >
                                1
                            </span>


                            <button
                                type="button"
                                class="btn-qty"
                                id="btnPlus"
                            >
                                +
                            </button>

                        </div>


                        <!-- THÊM GIỎ -->

                        <div class="flex-grow-1 ms-3">

                            <button
                                type="submit"
                                class="btn-add-cart"
                            >

                                <span id="modalTotalPrice">
                                    0
                                </span>₫

                                <div
                                    style="
                                        font-size: 0.75rem;
                                        font-weight: normal;
                                    "
                                >
                                    THÊM VÀO GIỎ HÀNG
                                </div>

                            </button>

                        </div>


                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<!--FOOTER-->

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


    <div class="footer-bottom">

        <div class="container">

            © 2026 Trái Cây Miền Nam.
            All rights reserved.

        </div>

    </div>

</footer>


<!-- JAVASCRIPT-->

<script src="js/jquery-3.3.1.js"></script>

<script src="index.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
>
</script>


</script>

Đoạn này nằm sau:

<script src="js/jquery-3.3.1.js"></script>

<script src="index.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
>
</script>

và trước:

<!-- POPUP CHỌN MUA-->

Đúng vị trí trong file bạn gửi là khoảng dòng 1381–1422.

👉 Xóa nguyên đoạn AJAX cũ đó rồi dán đoạn AJAX mới bạn vừa gửi vào đúng vị trí đó.

Không thay trong ajaxtest.php.

Cấu trúc cuối sanpham.php phải thành:

<script src="js/jquery-3.3.1.js"></script>

<script src="index.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
>
</script>


<!-- AJAX SẮP XẾP SẢN PHẨM -->

<script>

$(document).ready(function () {

    /* CHẶN FORM SUBMIT */
    $(".product-sort-form").on("submit", function (event) {

        event.preventDefault();

        return false;

    });


    /* KHI ĐỔI SẮP XẾP */
    $("#productSort").on("change", function (event) {

        event.preventDefault();

        var sort = $(this).val();


        $.ajax({

            url: "ajaxtest.php",

            type: "GET",

            data: {

                category: <?php echo json_encode($category); ?>,

                scope: <?php echo json_encode($scope); ?>,

                search: <?php echo json_encode($search); ?>,

                sort: sort

            },

            success: function (data) {

                $("#productList").html(data);

            },

            error: function () {

                alert("Lỗi tải sản phẩm!");

            }

        });

        return false;

    });

});

</script>


<!-- POPUP CHỌN MUA-->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        let currentPrice = 0;
        let currentQty = 1;


        const quickBuyModalEl =
            document.getElementById(
                "quickBuyModal"
            );

        const modal =
            new bootstrap.Modal(
                quickBuyModalEl
            );


        const modalProductId =
            document.getElementById(
                "modalProductId"
            );

        const modalProductImg =
            document.getElementById(
                "modalProductImg"
            );

        const modalProductName =
            document.getElementById(
                "modalProductName"
            );

        const modalProductPrice =
            document.getElementById(
                "modalProductPrice"
            );

        const modalQuantityDisplay =
            document.getElementById(
                "modalQuantityDisplay"
            );

        const modalQuantityInput =
            document.getElementById(
                "modalQuantityInput"
            );

        const modalTotalPrice =
            document.getElementById(
                "modalTotalPrice"
            );

        const btnMinus =
            document.getElementById(
                "btnMinus"
            );

        const btnPlus =
            document.getElementById(
                "btnPlus"
            );


        /*MỞ POPUP*/

        document.addEventListener(
            "click",
            function (event) {

                const button =
                    event.target.closest(
                        ".btn-open-popup"
                    );

                if (!button) {

                    return;

                }


                const id =
                    button.getAttribute(
                        "data-id"
                    );

                const name =
                    button.getAttribute(
                        "data-name"
                    );

                const price =
                    parseFloat(
                        button.getAttribute(
                            "data-price"
                        )
                    ) || 0;

                const image =
                    button.getAttribute(
                        "data-image"
                    );


                currentPrice = price;
                currentQty = 1;


                modalProductId.value =
                    id;

                modalProductName.textContent =
                    name;

                modalProductImg.src =
                    "images/" + image;

                modalProductPrice.textContent =
                    price.toLocaleString(
                        "vi-VN"
                    ) + "₫ / kg";


                updateModalUI();

                modal.show();

            }
        );


        /* CẬP NHẬT POPUP*/

        function updateModalUI() {

            modalQuantityDisplay.textContent =
                currentQty;

            modalQuantityInput.value =
                currentQty;


            const total =
                currentPrice * currentQty;


            modalTotalPrice.textContent =
                total.toLocaleString(
                    "vi-VN"
                );

        }


        /* GIẢM SỐ LƯỢNG*/

        btnMinus.addEventListener(
            "click",
            function () {

                if (currentQty > 1) {

                    currentQty--;

                    updateModalUI();

                }

            }
        );


        /* TĂNG SỐ LƯỢNG */

        btnPlus.addEventListener(
            "click",
            function () {

                currentQty++;

                updateModalUI();

            }
        );

    }
);

</script>


</body>

</html>