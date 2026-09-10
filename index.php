<?php
include "Ketnoi.php";

$sql = "SELECT * FROM san_pham ORDER BY ma_san_pham DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cửa hàng trái cây miền Nam</title>

    <link rel="stylesheet" href="Style.css">
</head>

<body>

    <!-- HEADER -->
    <header>
        <h1>🍊 CỬA HÀNG TRÁI CÂY MIỀN NAM</h1>

        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="dangnhap.php">Đăng nhập</a>
            <a href="dangky.php">Đăng ký</a>
            <a href="giohang.php">Giỏ hàng</a>
        </nav>
    </header>


    <!-- NỘI DUNG -->
    <main>

        <h2>Danh sách sản phẩm</h2>

        <div class="san-pham-container">

            <?php
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
            ?>

                    <div class="san-pham">

                        <img 
                            src="images/<?php echo htmlspecialchars($row['hinh_anh']); ?>" 
                            alt="<?php echo htmlspecialchars($row['ten_san_pham']); ?>"
                        >

                        <h3>
                            <?php echo htmlspecialchars($row['ten_san_pham']); ?>
                        </h3>

                        <p>
                            <strong>
                                <?php echo number_format($row['gia']); ?> VNĐ
                            </strong>
                        </p>

                        <p>
                            Xuất xứ:
                            <?php echo htmlspecialchars($row['xuat_xu']); ?>
                        </p>

                        <p>
                            Còn:
                            <?php echo $row['so_luong_ton']; ?>
                            sản phẩm
                        </p>

                        <button>
                            Thêm vào giỏ hàng
                        </button>

                    </div>

            <?php
                }

            } else {
                echo "<p>Chưa có sản phẩm.</p>";
            }
            ?>

        </div>

    </main>


    <!-- FOOTER -->
    <footer>
        <p>© 2026 Cửa hàng trái cây miền Nam</p>
    </footer>

</body>

</html>