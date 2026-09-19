<?php
// apply_voucher.php
session_start();

// Kiểm tra và kết nối CSDL
if (file_exists('config/db.php')) {
    require_once 'config/db.php';
} elseif (file_exists('db.php')) {
    require_once 'db.php';
} else {
    die("Lỗi kết nối CSDL!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucher_code = trim($_POST['voucher_code'] ?? '');

    if (empty($voucher_code)) {
        $_SESSION['voucher_error'] = "Vui lòng nhập mã giảm giá!";
        header("Location: giohang.php");
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
        header("Location: giohang.php");
        exit;
    }

    // Truy vấn kiểm tra mã voucher
    try {
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
            header("Location: giohang.php");
            exit;
        }

        if ($voucher['used_count'] >= $voucher['usage_limit']) {
            $_SESSION['voucher_error'] = "Mã giảm giá này đã hết lượt sử dụng!";
            header("Location: giohang.php");
            exit;
        }

        $min_amount = $voucher['min_order_amount'] ?? $voucher['min_order_value'] ?? 0;
        if ($subtotal < $min_amount) {
            $_SESSION['voucher_error'] = "Giá trị đơn hàng tối thiểu phải từ " . number_format($min_amount) . " VNĐ!";
            header("Location: giohang.php");
            exit;
        }

        $discount_amount = 0;
        $discount_type = $voucher['discount_type'] ?? 'fixed';
        $discount_value = $voucher['discount_value'] ?? 0;

        if ($discount_type === 'fixed') {
            $discount_amount = $discount_value;
        } elseif ($discount_type === 'percent') {
            $discount_amount = ($subtotal * $discount_value) / 100;
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

    } catch (Exception $e) {
        $_SESSION['voucher_error'] = "Lỗi xử lý Voucher: " . $e->getMessage();
    }

    header("Location: giohang.php");
    exit;
}
?>