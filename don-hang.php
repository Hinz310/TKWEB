<?php
session_start();

if (!isset($_SESSION["vai_tro"]) || $_SESSION["vai_tro"] != "admin") {
    header("Location: ../dangnhap.php");
    exit();
}

include "../Ketnoi.php";

$sql = "
SELECT 
    don_hang.ma_don_hang,
    nguoi_dung.ho_va_ten,
    don_hang.tong_tien,
    don_hang.dia_chi_giao,
    don_hang.so_dien_thoai,
    don_hang.trang_thai,
    don_hang.ngay_dat
FROM don_hang
INNER JOIN nguoi_dung
ON don_hang.ma_nguoi_dung = nguoi_dung.ma_nguoi_dung
ORDER BY don_hang.ma_don_hang DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("LỖI SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Quản lý đơn hàng</title>

<style>

body {
    font-family: Arial, sans-serif;
    margin: 30px;
    background-color: #f5f5f5;
}

h1 {
    text-align: center;
}

.container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #eeeeee;
}

.button {
    display: inline-block;
    padding: 7px 12px;
    border: 1px solid #999;
    background-color: #eeeeee;
    text-decoration: none;
    color: black;
}

.button:hover {
    background-color: #dddddd;
}

</style>

</head>

<body>

<div class="container">

<h1>QUẢN LÝ ĐƠN HÀNG</h1>

<p>
    <a href="index.php">← Về trang quản trị</a>
</p>

<table>

<tr>

<th>Mã đơn</th>

<th>Khách hàng</th>

<th>Tổng tiền</th>

<th>Địa chỉ giao</th>

<th>Số điện thoại</th>

<th>Trạng thái</th>

<th>Ngày đặt</th>

<th>Thao tác</th>

</tr>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

?>

<tr>

<td>
    <?php echo $row["ma_don_hang"]; ?>
</td>

<td>
    <?php echo htmlspecialchars($row["ho_va_ten"]); ?>
</td>

<td>
    <?php echo number_format($row["tong_tien"]); ?> VNĐ
</td>

<td>
    <?php echo htmlspecialchars($row["dia_chi_giao"]); ?>
</td>

<td>
    <?php echo htmlspecialchars($row["so_dien_thoai"]); ?>
</td>

<td>
    <?php echo htmlspecialchars($row["trang_thai"]); ?>
</td>

<td>
    <?php echo $row["ngay_dat"]; ?>
</td>

<td>

<a class="button"
   href="cap-nhat-don-hang.php?id=<?php echo $row["ma_don_hang"]; ?>">

   Cập nhật

</a>

</td>

</tr>

<?php

    }

} else {

?>

<tr>

<td colspan="8">
    Chưa có đơn hàng
</td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>