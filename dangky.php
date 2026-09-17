<?php
session_start();
include "Ketnoi.php";

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ho_va_ten     = trim($_POST["ho_va_ten"] ?? "");
    $email         = trim($_POST["email"] ?? "");
    $mat_khau      = $_POST["mat_khau"] ?? "";
    $so_dien_thoai = trim($_POST["so_dien_thoai"] ?? "");
    $dia_chi       = trim($_POST["dia_chi"] ?? "");

    // 1. Kiểm tra Email/Username đã tồn tại trong bảng users chưa
    $sql_check = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $email, $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result && $result->num_rows > 0) {
        $thong_bao = "<span style='color: red;'>Email này đã được sử dụng! Vui lòng dùng email khác.</span>";
    } else {
        // 2. Mã hóa mật khẩu an toàn
        $mat_khau_ma_hoa = password_hash($mat_khau, PASSWORD_DEFAULT);
        $vai_tro = "Khách hàng"; // Vai trò mặc định trong CSDL

        // 3. Chèn tài khoản mới vào bảng users (Dùng email làm username)
        $sql = "INSERT INTO users (username, password, fullname, email, phone, address, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $email, $mat_khau_ma_hoa, $ho_va_ten, $email, $so_dien_thoai, $dia_chi, $vai_tro);

        if ($stmt->execute()) {
            $thong_bao = "<span style='color: green; font-weight: bold;'>🎉 Đăng ký thành công! Đang chuyển sang trang Đăng nhập...</span>";
            header("refresh:2;url=dangnhap.php");
        } else {
            $thong_bao = "<span style='color: red;'>Đăng ký thất bại: " . htmlspecialchars($conn->error) . "</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Trái Cây Miền Nam</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        h1 {
            text-align: center;
            color: #27ae60;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #219150;
        }

        .thong-bao {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #27ae60;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
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
            placeholder="Nhập họ và tên đầy đủ"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            placeholder="Nhập địa chỉ email"
            required
        >

        <label>Mật khẩu</label>
        <input
            type="password"
            name="mat_khau"
            placeholder="Nhập mật khẩu"
            required
        >

        <label>Số điện thoại</label>
        <input
            type="text"
            name="so_dien_thoai"
            placeholder="Nhập số điện thoại liên hệ"
            required
        >

        <label>Địa chỉ nhận hàng</label>
        <textarea
            name="dia_chi"
            placeholder="Nhập địa chỉ giao hàng chi tiết"
            required
        ></textarea>

        <button type="submit">
            Đăng ký tài khoản
        </button>

    </form>

    <div class="link">
        <a href="dangnhap.php">
            Đã có tài khoản? Đăng nhập ngay
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