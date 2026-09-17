<?php
// process_checkout.php
session_start();

// Kiểm tra và kết nối CSDL PDO
if (file_exists('config/db.php')) {
    require_once 'config/db.php';
} elseif (file_exists('db.php')) {
    require_once 'db.php';
} else {
    die("Lỗi kết nối CSDL!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tự động nhận diện tài khoản (nếu chưa đăng nhập thì mặc định gán cho Khách hàng mẫu ID = 1)
    $user_id = $_SESSION['user_id'] ?? $_SESSION['ma_nguoi_dung'] ?? 1;

    $customer_name    = trim($_POST['customer_name'] ?? '');
    $customer_phone   = trim($_POST['customer_phone'] ?? '');
    $shipping_address = trim($_POST['shipping_address'] ?? '');
    $payment_method   = $_POST['payment_method'] ?? 'COD';

    if (empty($_SESSION['cart'])) {
        $_SESSION['error'] = "Giỏ hàng của bạn hiện đang rỗng!";
        header("Location: giohang.php");
        exit;
    }

    if (empty($customer_name) || empty($customer_phone) || empty($shipping_address)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin giao hàng!";
        header("Location: giohang.php");
        exit;
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

    $final_amount = max(0, $subtotal - $discount_amount);
    $order_code   = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);

    try {
        $pdo->beginTransaction();

        // 1. Chèn đơn hàng vào bảng orders
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

        // 2. Chèn từng mặt hàng vào order_details và cập nhật số lượng tồn kho
        $stmtDetail = $pdo->prepare("
            INSERT INTO order_details (order_id, product_id, product_name, price, quantity, total_price)
            VALUES (:order_id, :product_id, :product_name, :price, :quantity, :total_price)
        ");

        $stmtUpdateStock = $pdo->prepare("
            UPDATE products 
            SET stock_quantity = stock_quantity - :qty 
            WHERE id = :product_id
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
        }

        // 3. Tăng số lượt đã sử dụng của Voucher (nếu có)
        if ($voucher_id) {
            $stmtVoucher = $pdo->prepare("
                UPDATE vouchers 
                SET used_count = used_count + 1 
                WHERE id = :voucher_id
            ");
            $stmtVoucher->execute(['voucher_id' => $voucher_id]);
        }

        $pdo->commit();

        // Xóa giỏ hàng sau khi đặt thành công
        unset($_SESSION['cart']);
        unset($_SESSION['applied_voucher']);

        // Lưu thông báo thành công và chuyển sang trang Lịch sử đơn hàng
        $_SESSION['message'] = "🎉 Đặt hàng thành công! Mã đơn hàng của bạn là: " . $order_code;
        header("Location: order_history.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Lỗi xử lý đơn hàng: " . $e->getMessage());
    }
}
?>