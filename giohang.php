<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
$applied_voucher = $_SESSION['applied_voucher'] ?? null;

// Tính tổng tiền hàng
$subtotal = 0;
if (!empty($cart)) {
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}

// Tính tiền giảm giá
$discount_amount = $applied_voucher['discount_amount'] ?? 0;
$final_total = max(0, $subtotal - $discount_amount);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Trái Cây Miền Nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <style>
        .cart-container { max-width: 1100px; margin: 30px auto; padding: 0 15px; }
        .cart-table img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; }
        .summary-card { background: #f8f9fa; border-radius: 10px; padding: 20px; border: 1px solid #e0e0e0; }
    </style>
</head>

<body>
        <!-- THANH THÔNG BÁO -->
<div class="top-notice">
    Giảm <strong>20.000đ</strong> cho đơn hàng khi nhập voucher <strong>TRAICAY20K</strong>
</div>

    <!-- HEADER -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="main-logo">
                    <img src="images/logo.png" alt="Trái Cây Miền Nam">
                </a>
                <nav>
                    <a href="index.php" class="btn btn-outline-success me-2">🏠 Trang chủ</a>
                    <a href="order_history.php" class="btn btn-outline-primary">📜 Lịch sử đơn hàng</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="cart-container">
        <h2 class="mb-4 text-success font-weight-bold">🛒 GIỎ HÀNG CỦA BẠN</h2>

        <!-- THÔNG BÁO LỖI/THÀNH CÔNG -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-5">
                <p class="fs-4 text-muted">Giỏ hàng của bạn hiện đang rỗng.</p>
                <a href="index.php" class="btn btn-success btn-lg">Quay lại mua sắm</a>
            </div>
        <?php else: ?>

            <div class="row">
                <!-- DANH SÁCH MÓN HÀNG -->
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $id => $item): 
                                    $item_total = $item['price'] * $item['quantity'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="images/<?= htmlspecialchars($item['image']); ?>" class="me-3" alt="">
                                                <strong><?= htmlspecialchars($item['name']); ?></strong>
                                            </div>
                                        </td>
                                        <td><?= number_format($item['price']); ?>₫</td>
                                        <td>
                                            <form action="cart_actions.php?action=update" method="POST" class="d-flex align-items-center" style="width: 110px;">
                                                <input type="hidden" name="product_id" value="<?= $id; ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" class="form-control form-control-sm me-1 text-center" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-danger fw-bold"><?= number_format($item_total); ?>₫</td>
                                        <td>
                                            <a href="cart_actions.php?action=delete&id=<?= $id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="index.php" class="btn btn-outline-secondary">← Tiếp tục chọn hàng</a>
                        <a href="cart_actions.php?action=clear" class="btn btn-outline-danger" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">Xóa sạch giỏ hàng</a>
                    </div>
                </div>

                <!-- TỔNG TIỀN VÀ KHUYẾN MÃI -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="summary-card">
                        <h4 class="mb-3">TỔNG CỘNG ĐƠN HÀNG</h4>

                        <!-- FORM NHẬP VOUCHER -->
                        <form action="apply_voucher.php" method="POST" class="mb-3">
                            <label class="form-label font-weight-bold">Mã giảm giá (Voucher):</label>
                            <div class="input-group">
                                <input type="text" name="voucher_code" class="form-control" placeholder="Mã giảm giá" value="<?= htmlspecialchars($applied_voucher['code'] ?? ''); ?>">
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                            <?php if (isset($_SESSION['voucher_success'])): ?>
                                <small class="text-success d-block mt-1"><?= $_SESSION['voucher_success']; unset($_SESSION['voucher_success']); ?></small>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['voucher_error'])): ?>
                                <small class="text-danger d-block mt-1"><?= $_SESSION['voucher_error']; unset($_SESSION['voucher_error']); ?></small>
                            <?php endif; ?>
                        </form>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tiền hàng:</span>
                            <span><?= number_format($subtotal); ?>₫</span>
                        </div>

                        <?php if ($discount_amount > 0): ?>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá (<?= htmlspecialchars($applied_voucher['code']); ?>):</span>
                                <span>-<?= number_format($discount_amount); ?>₫</span>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                            <span>Tổng thanh toán:</span>
                            <span class="text-danger"><?= number_format($final_total); ?>₫</span>
                        </div>

                        <!-- FORM THANH TOÁN -->
                        <h5 class="mb-2">Thông tin giao hàng:</h5>
                        <form action="process_checkout.php" method="POST">
                            <div class="mb-2">
                                <input type="text" name="customer_name" class="form-control" placeholder="Họ và tên người nhận" required value="<?= htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['ho_ten'] ?? ''); ?>">
                            </div>
                            <div class="mb-2">
                                <input type="text" name="customer_phone" class="form-control" placeholder="Số điện thoại" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="shipping_address" class="form-control" rows="2" placeholder="Địa chỉ nhận hàng chi tiết" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Phương thức thanh toán:</label>
                                <select name="payment_method" class="form-select">
                                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="Bank">Chuyển khoản ngân hàng</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">XÁC NHẬN ĐẶT HÀNG</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>

</body>
</html>