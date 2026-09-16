<?php

session_start();

// KIỂM TRA PHÂN QUYỀN
if (!isset($_SESSION["vai_tro"]) || $_SESSION["vai_tro"] != "admin") {

    header("Location: ../dangnhap.php");

    exit();
}

?>

<!DOCTYPE html>

<html lang="vi">

<head>

<meta charset="UTF-8">

<title>Trang quản trị</title>

</head>

<body>

<h1> Quản Lý Cửa Hàng Trái Cây</h1>

<p>
    Xin chào:
    <strong>
        <?php echo $_SESSION["ho_ten"]; ?>
    </strong>
</p>

<hr>

<h2>Chức năng quản trị</h2>

<ul>

<li>
    <a href="don-hang.php">
        Quản lý đơn hàng
    </a>
</li>

<li>
    Quản lý sản phẩm
</li>

<li>
    Quản lý danh mục
</li>

<li>
    Quản lý người dùng
</li>

</ul>

<hr>

<a href="../index.php">
    Về trang chủ
</a>

<br><br>

<a href="../logout.php">
    Đăng xuất
</a>

</body>

</html>