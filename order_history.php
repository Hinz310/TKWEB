<?php
// order_history.php
session_start();
require_once 'config/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT o.*, v.code as voucher_code 
    FROM orders o 
    LEFT JOIN vouchers v ON o.voucher_id = v.id 
    WHERE o.user_id = :user_id 
    ORDER BY o.created_at DESC
");
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll();

function getOrderDetails($pdo, $order_id) {
    $stmt = $pdo->prepare("
        SELECT od.*, p.image 
        FROM order_details od 
        LEFT JOIN products p ON od.product_id = p.id 
        WHERE od.order_id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    return $stmt->fetchAll();
}
?>

<h2>Lịch Sử Đơn Hàng Của Bạn</h2>

<?php if (empty($orders)): ?>
    <p>Bạn chưa có đơn hàng nào trong hệ thống.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div style="border: 1px solid #ddd; margin-bottom: 20px; padding: 15px; border-radius: 5px;">
            <h3>Đơn hàng: <?= htmlspecialchars($order['order_code']) ?></h3>
            <p>Ngày đặt: <?= $order['created_at'] ?> | Trạng thái: <strong><?= htmlspecialchars($order['order_status']) ?></strong></p>
            <p>Người nhận: <?= htmlspecialchars($order['customer_name']) ?> - <?= htmlspecialchars($order['customer_phone']) ?></p>
            <p>Địa chỉ: <?= htmlspecialchars($order['shipping_address']) ?></p>
            <p>Tổng tiền hàng: <?= number_format($order['subtotal']) ?> VNĐ</p>
            <p>Mã giảm giá (<?= htmlspecialchars($order['voucher_code'] ?? 'Không') ?>): -<?= number_format($order['discount_amount']) ?> VNĐ</p>
            <p>Thực thanh toán: <strong style="color: #e74c3c;"><?= number_format($order['final_amount']) ?> VNĐ</strong></p>

            <h4>Danh sách sản phẩm:</h4>
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $details = getOrderDetails($pdo, $order['id']);
                    foreach ($details as $item): 
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= number_format($item['price']) ?> VNĐ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['total_price']) ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
<?php endif; ?>