<?php

include "Ketnoi.php";

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ho_va_ten = $_POST["ho_va_ten"];
    $email = $_POST["email"];
    $mat_khau = $_POST["mat_khau"];
    $so_dien_thoai = $_POST["so_dien_thoai"];
    $dia_chi = $_POST["dia_chi"];

    // Kiểm tra email đã tồn tại
    $sql_check = "SELECT * FROM nguoi_dung WHERE email = ?";

    $stmt_check = $conn->prepare($sql_check);

    $stmt_check->bind_param("s", $email);

    $stmt_check->execute();

    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {

        $thong_bao = "Email đã được sử dụng!";

    } else {

        // Mã hóa mật khẩu
        $mat_khau_ma_hoa = password_hash(
            $mat_khau,
            PASSWORD_DEFAULT
        );

        // Tài khoản đăng ký mặc định là khách hàng
        $vai_tro = "khach_hang";

        $sql = "
            INSERT INTO nguoi_dung
            (
                ho_va_ten,
                email,
                mat_khau,
                so_dien_thoai,
                dia_chi,
                vai_tro
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssssss",
            $ho_va_ten,
            $email,
            $mat_khau_ma_hoa,
            $so_dien_thoai,
            $dia_chi,
            $vai_tro
        );

        if ($stmt->execute()) {

            $thong_bao =
                "Đăng ký thành công! Bạn có thể đăng nhập.";

        } else {

            $thong_bao =
                "Đăng ký thất bại: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Đăng ký</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        .thong-bao {
            text-align: center;
            margin-top: 15px;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>ĐĂNG KÝ</h1>

    <?php if ($thong_bao != "") { ?>

        <p class="thong-bao">
            <?php echo $thong_bao; ?>
        </p>

    <?php } ?>

    <form method="POST">

        <label>Họ và tên</label>

        <input
            type="text"
            name="ho_va_ten"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Mật khẩu</label>

        <input
            type="password"
            name="mat_khau"
            required
        >

        <label>Số điện thoại</label>

        <input
            type="text"
            name="so_dien_thoai"
            required
        >

        <label>Địa chỉ</label>

        <textarea
            name="dia_chi"
            required
        ></textarea>

        <button type="submit">
            Đăng ký
        </button>

    </form>

    <div class="link">

        <a href="dangnhap.php">
            Đã có tài khoản? Đăng nhập
        </a>

    </div>

    <div class="link">

        <a href="index.php">
            ← Về trang chủ
        </a>

    </div>

</div>

</body>

</html>