<?php
// apply_voucher.php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucher_code = trim($_POST['voucher_code'] ?? '');

    if (empty($voucher_code)) {
        $_SESSION['voucher_error'] = "Vui lòng nhập mã giảm giá!";
        header("Location: cart.php");
        exit;
    }

    $subtotal = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
    }

    if ($subtotal <= 0) {
        $_SESSION['voucher_error'] = "Giỏ hàng rỗng, không thể áp dụng mã!";
        header("Location: cart.php");
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM vouchers 
        WHERE code = :code 
          AND status = 'Hoạt động' 
          AND start_date <= NOW() 
          AND end_date >= NOW()
    ");
    $stmt->execute(['code' => $voucher_code]);
    $voucher = $stmt->fetch();

    if (!$voucher) {
        $_SESSION['voucher_error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn!";
        header("Location: cart.php");
        exit;
    }

    if ($voucher['used_count'] >= $voucher['usage_limit']) {
        $_SESSION['voucher_error'] = "Mã giảm giá này đã hết lượt sử dụng!";
        header("Location: cart.php");
        exit;
    }

    if ($subtotal < $voucher['min_order_amount']) {
        $_SESSION['voucher_error'] = "Giá trị đơn hàng tối thiểu phải từ " . number_format($voucher['min_order_amount']) . " VNĐ!";
        header("Location: cart.php");
        exit;
    }

    $discount_amount = 0;
    if ($voucher['discount_type'] === 'fixed') {
        $discount_amount = $voucher['discount_value'];
    } elseif ($voucher['discount_type'] === 'percent') {
        $discount_amount = ($subtotal * $voucher['discount_value']) / 100;
    }

    if ($discount_amount > $subtotal) {
        $discount_amount = $subtotal;
    }

    $_SESSION['applied_voucher'] = [
        'id'              => $voucher['id'],
        'code'            => $voucher['code'],
        'discount_amount' => $discount_amount
    ];

    $_SESSION['voucher_success'] = "Áp dụng mã giảm giá thành công! Đã giảm " . number_format($discount_amount) . " VNĐ.";
    header("Location: cart.php");
    exit;
}
?>