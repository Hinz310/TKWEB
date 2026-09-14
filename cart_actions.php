<?php
// cart_actions.php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity   = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT) ?? 1;

        if ($product_id && $quantity > 0) {
            $stmt = $pdo->prepare("SELECT id, name, price, sale_price, stock_quantity, image FROM products WHERE id = :id AND status = 'Đang bán'");
            $stmt->execute(['id' => $product_id]);
            $product = $stmt->fetch();

            if ($product) {
                $current_qty = $_SESSION['cart'][$product_id]['quantity'] ?? 0;
                $new_qty     = $current_qty + $quantity;

                if ($new_qty <= $product['stock_quantity']) {
                    $unit_price = ($product['sale_price'] !== null && $product['sale_price'] > 0) ? $product['sale_price'] : $product['price'];

                    $_SESSION['cart'][$product_id] = [
                        'id'       => $product['id'],
                        'name'     => $product['name'],
                        'price'    => $unit_price,
                        'image'    => $product['image'],
                        'quantity' => $new_qty
                    ];
                    $_SESSION['message'] = "Thêm vào giỏ hàng thành công!";
                } else {
                    $_SESSION['error'] = "Số lượng tồn kho không đủ đáp ứng!";
                }
            }
        }
        header("Location: cart.php");
        exit;

    case 'update':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity   = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($product_id && isset($_SESSION['cart'][$product_id])) {
            if ($quantity > 0) {
                $stmt = $pdo->prepare("SELECT stock_quantity FROM products WHERE id = :id");
                $stmt->execute(['id' => $product_id]);
                $stock = $stmt->fetchColumn();

                if ($quantity <= $stock) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    $_SESSION['message'] = "Cập nhật giỏ hàng thành công!";
                } else {
                    $_SESSION['error'] = "Số lượng tồn kho chỉ còn " . $stock . " sản phẩm!";
                }
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        header("Location: cart.php");
        exit;

    case 'delete':
        $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($product_id && isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['message'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
        }
        header("Location: cart.php");
        exit;

    case 'clear':
        unset($_SESSION['cart']);
        unset($_SESSION['applied_voucher']);
        header("Location: cart.php");
        exit;
}
?>