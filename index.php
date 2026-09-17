<?php
session_start();
require_once "Ketnoi.php";

/* LẤY TẤT CẢ SẢN PHẨM TỪ DATABASE */
$sql = "SELECT * FROM san_pham ORDER BY ma_san_pham ASC";
$result = $conn->query($sql);

if (!$result) {
    $sql = "SELECT * FROM products ORDER BY id ASC";
    $result = $conn->query($sql);
}

if (!$result) {
    die("Lỗi SQL: " . $conn->error);
}

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$half = (int) ceil(count($products) / 2);
$allVietNamProducts = array_slice($products, 0, $half);
$allNhapKhauProducts = array_slice($products, $half);

$vietNamProducts = array_slice($allVietNamProducts, 0, 8);
$nhapKhauProducts = array_slice($allNhapKhauProducts, 0, 8);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trái Cây Miền Nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <style>
        /* Tùy chỉnh Modal Popup giống App E-Commerce */
        .modal-quick-buy .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        .modal-quick-buy .btn-qty {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #ff4d4f;
            color: #ff4d4f;
            font-weight: bold;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            cursor: pointer;
        }
        .modal-quick-buy .btn-add-cart {
            background-color: #ff4d4f;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            width: 100%;
            transition: background 0.2s;
        }
        .modal-quick-buy .btn-add-cart:hover {
            background-color: #e03e3e;
        }
    </style>
</head>

<body>

<!-- THANH THÔNG BÁO -->
<div class="top-notice">
    Giảm <strong>20.000đ</strong> cho đơn hàng khi nhập voucher <strong>TRAICAY20K</strong>
</div>

<!-- THÔNG BÁO KHI THÊM GIỎ HÀNG THÀNH CÔNG -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 z-3 shadow" role="alert">
        ✅ <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- HEADER -->
<header class="main-header">
    <div class="container">
        <div class="header-content">

            <!-- MENU -->
            <div class="menu-wrapper">
                <button class="menu-button" type="button" aria-label="Mở menu" aria-expanded="false">
                    <span class="menu-icon">☰</span>
                    <span class="menu-text">MENU</span>
                </button>

                <div class="side-menu">
                    <a href="index.php" class="side-menu-link">TRANG CHỦ</a>

                    <div class="side-menu-category">
                        <button class="category-toggle" type="button" aria-expanded="false">DANH MỤC TRÁI CÂY</button>
                        <div class="category-submenu">
                            <a href="sanpham.php?category=trai-cay-viet-nam">TRÁI CÂY VIỆT NAM</a>
                            <a href="sanpham.php?category=trai-cay-nhap-khau">TRÁI CÂY NHẬP KHẨU</a>
                        </div>
                    </div>

                    <a href="lienhe.php" class="side-menu-link">LIÊN HỆ</a>

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

            <!-- TÌM KIẾM TRANG CHỦ -->
<form class="header-search" action="sanpham.php" method="GET">

    <!-- Báo cho sanpham.php biết: tìm trên toàn bộ sản phẩm -->
    <input
        type="hidden"
        name="scope"
        value="all"
    >

    <input
        type="text"
        name="search"
        placeholder="Tìm kiếm sản phẩm..."
        required
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
                <img src="images/hotline.png" alt="" class="header-icon-img">
                <div>
                    <small>Hotline:</small>
                    <strong>0123 456 789</strong>
                </div>
            </div>

            <!-- TÀI KHOẢN -->
            <div class="account-box">
                <button class="account-button" type="button" aria-expanded="false">
                    <img src="images/taikhoan.png" alt="" class="header-icon-img">
                    <span>
                        <?php
                        if (isset($_SESSION["ma_nguoi_dung"])) {
                            echo htmlspecialchars($_SESSION["ho_ten"] ?? "Tài khoản");
                        } elseif (isset($_SESSION["user_id"])) {
                            echo htmlspecialchars($_SESSION["fullname"] ?? "Tài khoản");
                        } else {
                            echo "Tài khoản";
                        }
                        ?>
                    </span>
                </button>

                <div class="account-dropdown">
                    <?php if (isset($_SESSION["ma_nguoi_dung"]) || isset($_SESSION["user_id"])) { ?>
                        <h4>THÔNG TIN TÀI KHOẢN</h4>
                        <p>Xin chào, <strong><?php echo htmlspecialchars($_SESSION["ho_ten"] ?? $_SESSION["fullname"] ?? "Khách hàng"); ?></strong></p>
                        <div class="account-links">
                            <p><a href="taikhoan.php">Thông tin tài khoản</a></p>
                            <p><a href="order_history.php">Đơn hàng của tôi</a></p>
                            <p><a href="logout.php">Đăng xuất</a></p>
                        </div>
                    <?php } else { ?>
                        <h4>ĐĂNG NHẬP TÀI KHOẢN</h4>
                        <p>Nhập email và mật khẩu của bạn:</p>
                        <form action="dangnhap.php" method="POST">
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="password" name="mat_khau" placeholder="Mật khẩu" required>
                            <button type="submit" class="login-button">ĐĂNG NHẬP</button>
                        </form>
                        <div class="account-links">
                            <p>Khách hàng mới? <a href="dangky.php">Tạo tài khoản</a></p>
                            <p>Quên mật khẩu? <a href="mat-khau.php">Khôi phục mật khẩu</a></p>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- GIỎ HÀNG -->
            <a href="giohang.php" class="cart-header">
                <div class="cart-icon-box">
                    <img src="images/giohang.png" alt="" class="header-icon-img">
                    <span class="cart-count">
                        <?php 
                        $cart_count = 0;
                        if (!empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $cart_count += $item['quantity'];
                            }
                        }
                        echo $cart_count;
                        ?>
                    </span>
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
            <a href="index.php" class="category-item active">TRANG CHỦ</a>
            <a href="sanpham.php?category=trai-cay-viet-nam" class="category-item">TRÁI CÂY VIỆT NAM</a>
            <a href="sanpham.php?category=trai-cay-nhap-khau" class="category-item">TRÁI CÂY NHẬP KHẨU</a>
            <a href="lienhe.php" class="category-item">LIÊN HỆ</a>
        </div>
    </div>
</nav>

<!-- BANNER -->
<section class="home-banner">
    <div id="fruitBanner" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#fruitBanner" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Banner 1"></button>
            <button type="button" data-bs-target="#fruitBanner" data-bs-slide-to="1" aria-label="Banner 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/banner1.png" class="d-block w-100" alt="Banner trái cây 1">
            </div>
            <div class="carousel-item">
                <img src="images/banner2.png" class="d-block w-100" alt="Banner trái cây 2">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#fruitBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#fruitBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>
</section>

<!-- NỘI DUNG -->
<main>

    <!-- TRÁI CÂY VIỆT NAM -->
    <section class="home-product-section">
        <div class="container">
            <div class="home-product-title">TRÁI CÂY VIỆT NAM</div>
            <div class="home-product-grid">

                <?php
                foreach ($vietNamProducts as $product) {
                    $id = (int)($product['ma_san_pham'] ?? $product['id'] ?? 0);
                    $name = htmlspecialchars($product['ten_san_pham'] ?? $product['name'] ?? 'Trái cây');
                    $image = htmlspecialchars($product['hinh_anh'] ?? $product['image'] ?? 'default.jpg');
                    $rawPrice = (float)($product['gia'] ?? $product['price'] ?? 0);
                    $price = number_format($rawPrice, 0, ',', '.');
                ?>

                    <div class="home-product-card">
                        <div class="product-image-box">
                            <img src="images/<?php echo $image; ?>" alt="<?php echo $name; ?>">
                        </div>
                        <h3><?php echo $name; ?></h3>
                        <p class="product-price"><?php echo $price; ?>₫ / kg</p>

                        <!-- NÚT MỞ POPUP CHỌN SỐ LƯỢNG -->
                        <button type="button" 
                                class="choose-product btn-open-popup"
                                data-id="<?php echo $id; ?>"
                                data-name="<?php echo $name; ?>"
                                data-price="<?php echo $rawPrice; ?>"
                                data-image="<?php echo $image; ?>">
                            🛒 CHỌN MUA
                        </button>
                    </div>

                <?php } ?>

            </div>

            <div class="view-more-products">
                <a href="sanpham.php?category=trai-cay-viet-nam">Xem thêm sản phẩm trái cây Việt Nam</a>
            </div>
        </div>
    </section>

    <!-- TRÁI CÂY NHẬP KHẨU -->
    <section class="home-product-section">
        <div class="container">
            <div class="home-product-title">TRÁI CÂY NHẬP KHẨU</div>
            <div class="home-product-grid">

                <?php
                foreach ($nhapKhauProducts as $product) {
                    $id = (int)($product['ma_san_pham'] ?? $product['id'] ?? 0);
                    $name = htmlspecialchars($product['ten_san_pham'] ?? $product['name'] ?? 'Trái cây');
                    $image = htmlspecialchars($product['hinh_anh'] ?? $product['image'] ?? 'default.jpg');
                    $rawPrice = (float)($product['gia'] ?? $product['price'] ?? 0);
                    $price = number_format($rawPrice, 0, ',', '.');
                ?>

                    <div class="home-product-card">
                        <div class="product-image-box">
                            <img src="images/<?php echo $image; ?>" alt="<?php echo $name; ?>">
                        </div>
                        <h3><?php echo $name; ?></h3>
                        <p class="product-price"><?php echo $price; ?>₫ / kg</p>

                        <!-- NÚT MỞ POPUP CHỌN SỐ LƯỢNG -->
                        <button type="button" 
                                class="choose-product btn-open-popup"
                                data-id="<?php echo $id; ?>"
                                data-name="<?php echo $name; ?>"
                                data-price="<?php echo $rawPrice; ?>"
                                data-image="<?php echo $image; ?>">
                            🛒 CHỌN MUA
                        </button>
                    </div>

                <?php } ?>

            </div>

            <div class="view-more-products">
                <a href="sanpham.php?category=trai-cay-nhap-khau">Xem thêm sản phẩm trái cây nhập khẩu</a>
            </div>
        </div>
    </section>

</main>

<!-- MODAL POPUP CHỌN SỐ LƯỢNG (GIỐNG APP BÁN HÀNG) -->
<div class="modal fade modal-quick-buy" id="quickBuyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-0 px-4 pb-4">
                <img id="modalProductImg" src="" alt="" class="img-fluid mb-3" style="max-height: 160px; object-fit: contain;">
                <h5 id="modalProductName" class="fw-bold text-dark mb-2"></h5>
                <p id="modalProductPrice" class="fs-4 fw-bold text-danger mb-3"></p>

                <form action="cart_actions.php?action=add" method="POST">
                    <input type="hidden" name="product_id" id="modalProductId" value="">
                    <input type="hidden" name="quantity" id="modalQuantityInput" value="1">

                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <!-- TĂNG GIẢM SỐ LƯỢNG -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-qty" id="btnMinus">-</button>
                            <span id="modalQuantityDisplay" class="fw-bold fs-5 px-2">1</span>
                            <button type="button" class="btn-qty" id="btnPlus">+</button>
                        </div>

                        <!-- NÚT XÁC NHẬN THÊM VÀO GIỎ -->
                        <div class="flex-grow-1 ms-3">
                            <button type="submit" class="btn-add-cart">
                                <span id="modalTotalPrice">0</span>₫
                                <div style="font-size: 0.75rem; font-weight: normal;">THÊM VÀO GIỎ HÀNG</div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-column">
                <h3>Về Trái Cây Miền Nam</h3>
                <p class="footer-description">
                    Trái Cây Miền Nam là thương hiệu trái cây tươi chất lượng cao, với đa dạng sản phẩm phục vụ mọi nhu cầu: đặc sản vùng miền Việt Nam và trái cây nhập khẩu.
                </p>
            </div>

            <div class="footer-column">
                <h3>Thông tin liên hệ</h3>
                <p><strong>Chi nhánh 1:</strong> 458/3F Nguyễn Hữu Thọ, phường Tân Hưng</p>
                <p><strong>Điện thoại:</strong> 0865 660 775</p>
                <p><strong>Email:</strong> hello@traicaymiennam.com.vn</p>
            </div>

            <div class="footer-column footer-care">
                <h3>Chăm sóc khách hàng</h3>
                <div class="footer-phone">
                    <img src="images/hotline.png" alt="Hotline" class="footer-phone-icon">
                    <div class="footer-contact-text">
                        <a href="tel:0865660775" class="footer-phone-number">0865 660 775</a>
                        <a href="mailto:hello@traicaymiennam.com.vn" class="footer-email">hello@traicaymiennam.com.vn</a>
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

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- JAVASCRIPT MENU + TÀI KHOẢN -->
<script src="index.js"></script>

<!-- JAVASCRIPT XỬ LÝ POPUP CHỌN MUA -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let currentPrice = 0;
    let currentQty = 1;

    const quickBuyModalEl = document.getElementById('quickBuyModal');
    const modal = new bootstrap.Modal(quickBuyModalEl);

    const modalProductId = document.getElementById('modalProductId');
    const modalProductImg = document.getElementById('modalProductImg');
    const modalProductName = document.getElementById('modalProductName');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalQuantityDisplay = document.getElementById('modalQuantityDisplay');
    const modalQuantityInput = document.getElementById('modalQuantityInput');
    const modalTotalPrice = document.getElementById('modalTotalPrice');

    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');

    // Mở Popup khi bấm nút CHỌN MUA
    document.querySelectorAll('.btn-open-popup').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price')) || 0;
            const image = this.getAttribute('data-image');

            currentPrice = price;
            currentQty = 1;

            modalProductId.value = id;
            modalProductName.textContent = name;
            modalProductImg.src = 'images/' + image;
            modalProductPrice.textContent = price.toLocaleString('vi-VN') + '₫ / kg';

            updateModalUI();
            modal.show();
        });
    });

    function updateModalUI() {
        modalQuantityDisplay.textContent = currentQty;
        modalQuantityInput.value = currentQty;
        const total = currentPrice * currentQty;
        modalTotalPrice.textContent = total.toLocaleString('vi-VN');
    }

    btnMinus.addEventListener('click', function () {
        if (currentQty > 1) {
            currentQty--;
            updateModalUI();
        }
    });

    btnPlus.addEventListener('click', function () {
        currentQty++;
        updateModalUI();
    });
});
</script>

</body>
</html>