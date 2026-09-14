<?php
// process_checkout.php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id          = $_SESSION['user_id'] ?? null;
    $customer_name    = trim($_POST['customer_name'] ?? '');
    $customer_phone   = trim($_POST['customer_phone'] ?? '');
    $shipping_address = trim($_POST['shipping_address'] ?? '');
    $payment_method   = $_POST['payment_method'] ?? 'COD';

    if (!$user_id) {
        die("Vui lòng đăng nhập tài khoản để thực hiện đặt hàng.");
    }

    if (empty($_SESSION['cart'])) {
        die("Giỏ hàng của bạn hiện đang rỗng.");
    }

    if (empty($customer_name) || empty($customer_phone) || empty($shipping_address)) {
        die("Vui lòng điền đầy đủ thông tin giao hàng.");
    }

    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $voucher_id      = null;
    $discount_amount = 0;
    if (isset($_SESSION['applied_voucher'])) {
        $voucher_id      = $_SESSION['applied_voucher']['id'];
        $discount_amount = $_SESSION['applied_voucher']['discount_amount'];
    }

    $final_amount = $subtotal - $discount_amount;
    if ($final_amount < 0) {
        $final_amount = 0;
    }

    $order_code = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);

    try {
        $pdo->beginTransaction();

        $stmtOrder = $pdo->prepare("
            INSERT INTO orders (order_code, user_id, customer_name, customer_phone, shipping_address, subtotal, voucher_id, discount_amount, final_amount, payment_method, order_status)
            VALUES (:order_code, :user_id, :customer_name, :customer_phone, :shipping_address, :subtotal, :voucher_id, :discount_amount, :final_amount, :payment_method, 'Chờ xử lý')
        ");
        $stmtOrder->execute([
            'order_code'       => $order_code,
            'user_id'          => $user_id,
            'customer_name'    => $customer_name,
            'customer_phone'   => $customer_phone,
            'shipping_address' => $shipping_address,
            'subtotal'         => $subtotal,
            'voucher_id'       => $voucher_id,
            'discount_amount'  => $discount_amount,
            'final_amount'     => $final_amount,
            'payment_method'   => $payment_method
        ]);

        $order_id = $pdo->lastInsertId();

        $stmtDetail = $pdo->prepare("
            INSERT INTO order_details (order_id, product_id, product_name, price, quantity, total_price)
            VALUES (:order_id, :product_id, :product_name, :price, :quantity, :total_price)
        ");

        $stmtUpdateStock = $pdo->prepare("
            UPDATE products 
            SET stock_quantity = stock_quantity - :qty 
            WHERE id = :product_id AND stock_quantity >= :qty
        ");

        foreach ($_SESSION['cart'] as $product_id => $item) {
            $item_total = $item['price'] * $item['quantity'];

            $stmtDetail->execute([
                'order_id'     => $order_id,
                'product_id'   => $product_id,
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['quantity'],
                'total_price'  => $item_total
            ]);

            $stmtUpdateStock->execute([
                'qty'        => $item['quantity'],
                'product_id' => $product_id
            ]);

            if ($stmtUpdateStock->rowCount() === 0) {
                throw new Exception("Sản phẩm '" . $item['name'] . "' không đủ số lượng tồn kho!");
            }
        }

        if ($voucher_id) {
            $stmtVoucher = $pdo->prepare("
                UPDATE vouchers 
                SET used_count = used_count + 1 
                WHERE id = :voucher_id
            ");
            $stmtVoucher->execute(['voucher_id' => $voucher_id]);
        }

        $pdo->commit();

        unset($_SESSION['cart']);
        unset($_SESSION['applied_voucher']);

        header("Location: order_success.php?code=" . $order_code);
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Lỗi xử lý đơn hàng: " . $e->getMessage());
    }
}
?>