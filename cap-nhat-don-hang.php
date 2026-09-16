<?php
session_start();

if (!isset($_SESSION["vai_tro"]) || $_SESSION["vai_tro"] != "admin") {
    header("Location: ../dangnhap.php");
    exit();
}

include "../Ketnoi.php";

if (!isset($_GET["id"])) {
    die("Không tìm thấy mã đơn hàng.");
}

$id = $_GET["id"];

/* Lấy thông tin đơn hàng */
$sql = "SELECT * FROM don_hang WHERE ma_don_hang = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$don_hang = $result->fetch_assoc();

if (!$don_hang) {
    die("Không tìm thấy đơn hàng.");
}

/* Khi Admin nhấn Lưu */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $trang_thai = $_POST["trang_thai"];

    $sql_update = "
        UPDATE don_hang
        SET trang_thai = ?
        WHERE ma_don_hang = ?
    ";

    $stmt_update = $conn->prepare($sql_update);

    $stmt_update->bind_param(
        "si",
        $trang_thai,
        $id
    );

    $stmt_update->execute();

    header("Location: don-hang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cập nhật đơn hàng</title>

<style>

body {
    font-family: Arial, sans-serif;
    margin: 40px;
    background-color: #f5f5f5;
}

.box {
    width: 500px;
    margin: auto;
    background-color: white;
    border: 1px solid #ccc;
    padding: 25px;
    border-radius: 8px;
}

h1 {
    text-align: center;
}

.thong-tin {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
}

select {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}

button {
    padding: 10px 20px;
    margin-top: 15px;
    cursor: pointer;
}

a {
    text-decoration: none;
}

</style>

</head>

<body>

<div class="box">

<h1>CẬP NHẬT ĐƠN HÀNG</h1>

<div class="thong-tin">

<p>
<strong>Mã đơn hàng:</strong>
<?php echo $don_hang["ma_don_hang"]; ?>
</p>

<p>
<strong>Tổng tiền:</strong>
<?php echo number_format($don_hang["tong_tien"]); ?> VNĐ
</p>

<p>
<strong>Địa chỉ giao:</strong>
<?php echo htmlspecialchars($don_hang["dia_chi_giao"]); ?>
</p>

<p>
<strong>Số điện thoại:</strong>
<?php echo htmlspecialchars($don_hang["so_dien_thoai"]); ?>
</p>

<p>
<strong>Trạng thái hiện tại:</strong>
<?php echo htmlspecialchars($don_hang["trang_thai"]); ?>
</p>

</div>

<form method="POST">

<label>Trạng thái đơn hàng:</label>

<select name="trang_thai">

<option value="Đang xử lý"
<?php
if ($don_hang["trang_thai"] == "Đang xử lý") {
    echo "selected";
}
?>
>
Đang xử lý
</option>

<option value="Đã giao"
<?php
if ($don_hang["trang_thai"] == "Đã giao") {
    echo "selected";
}
?>
>
Đã giao
</option>

<option value="Hủy"
<?php
if ($don_hang["trang_thai"] == "Hủy") {
    echo "selected";
}
?>
>
Hủy
</option>

</select>

<br>

<button type="submit">
Lưu trạng thái
</button>

</form>

<br>

<a href="don-hang.php">
← Quay lại danh sách đơn hàng
</a>

</div>

</body>

</html>