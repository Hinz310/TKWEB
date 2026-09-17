<?php
// cart_actions.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Kiểm tra kết nối CSDL
if (file_exists('config/db.php')) {
    require_once 'config/db.php';
} elseif (file_exists('db.php')) {
    require_once 'db.php';
} else {
    die("Lỗi kết nối CSDL!");
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        // 🔒 KIỂM TRA ĐĂNG NHẬP: Nếu chưa đăng nhập -> Đuổi sang dangnhap.php
        $is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['ma_nguoi_dung']);
        if (!$is_logged_in) {
            $_SESSION['error'] = "Vui lòng đăng nhập hoặc đăng ký tài khoản để mua hàng!";
            header("Location: dangnhap.php");
            exit;
        }

        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity   = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT) ?? 1;

        if ($product_id && $quantity > 0) {
            try {
                $product = null;
                // Thử tìm trong bảng products
                try {
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                    $stmt->execute(['id' => $product_id]);
                    $product = $stmt->fetch();
                } catch (Exception $e) {}

                // Thử tìm trong bảng san_pham
                if (!$product) {
                    $stmt = $pdo->prepare("SELECT * FROM san_pham WHERE ma_san_pham = :id OR id = :id");
                    $stmt->execute(['id' => $product_id]);
                    $product = $stmt->fetch();
                }

                if ($product) {
                    $p_id    = $product['id'] ?? $product['ma_san_pham'] ?? $product_id;
                    $p_name  = $product['name'] ?? $product['ten_san_pham'] ?? 'Sản phẩm';
                    $p_price = $product['sale_price'] ?? $product['price'] ?? $product['gia'] ?? 0;
                    $p_stock = $product['stock_quantity'] ?? $product['so_luong_ton'] ?? 99;
                    $p_image = $product['image'] ?? $product['hinh_anh'] ?? 'default.jpg';

                    $current_qty = $_SESSION['cart'][$p_id]['quantity'] ?? 0;
                    $new_qty     = $current_qty + $quantity;

                    if ($new_qty <= $p_stock) {
                        $_SESSION['cart'][$p_id] = [
                            'id'       => $p_id,
                            'name'     => $p_name,
                            'price'    => (float)$p_price,
                            'image'    => $p_image,
                            'quantity' => $new_qty
                        ];
                        $_SESSION['message'] = "Thêm vào giỏ hàng thành công!";
                    } else {
                        $_SESSION['error'] = "Số lượng tồn kho không đủ!";
                    }
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Lỗi xử lý: " . $e->getMessage();
            }
        }

        // Sau khi thêm thành công -> Giữ khách ở lại trang hiện tại
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $redirect);
        exit;

    case 'update':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity   = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($product_id && isset($_SESSION['cart'][$product_id])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        header("Location: giohang.php");
        exit;

    case 'delete':
        $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($product_id && isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header("Location: giohang.php");
        exit;

    case 'clear':
        unset($_SESSION['cart']);
        unset($_SESSION['applied_voucher']);
        header("Location: giohang.php");
        exit;
}
?>