<?php
session_start();
include "Ketnoi.php";

$thong_bao = "";

// Hiển thị thông báo nếu được chuyển hướng từ cart_actions.php
if (isset($_SESSION['error'])) {
    $thong_bao = "<span style='color: red; font-weight: bold;'>" . htmlspecialchars($_SESSION['error']) . "</span>";
    unset($_SESSION['error']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST["email"] ?? "");
    $mat_khau = $_POST["mat_khau"] ?? "";

    // 1. Truy vấn tài khoản từ bảng users
    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $nguoi_dung = $result->fetch_assoc();

        $password_db = $nguoi_dung["password"] ?? $nguoi_dung["mat_khau"] ?? "";

        // Kiểm tra mật khẩu mã hóa hoặc so sánh trực tiếp
        $is_valid_password = password_verify($mat_khau, $password_db) || ($mat_khau === $password_db);

        if ($is_valid_password) {
            $user_id  = $nguoi_dung["id"] ?? $nguoi_dung["ma_nguoi_dung"] ?? 1;
            $fullname = $nguoi_dung["fullname"] ?? $nguoi_dung["ho_va_ten"] ?? $nguoi_dung["ho_ten"] ?? "Khách hàng";
            $role     = $nguoi_dung["role"] ?? $nguoi_dung["vai_tro"] ?? "Khách hàng";

            // 2. Thiết lập Session đồng bộ
            $_SESSION["user_id"]       = $user_id;
            $_SESSION["ma_nguoi_dung"] = $user_id;

            $_SESSION["fullname"]      = $fullname;
            $_SESSION["ho_ten"]        = $fullname;

            $_SESSION["role"]          = $role;
            $_SESSION["vai_tro"]       = $role;

            // 3. Điều hướng người dùng (Đã sửa cú pháp if và đổi tên file chuyển hướng)
            $role_clean = strtolower(trim($role));
            if ($role_clean === "admin" || $role_clean === "quản lý" || $role_clean === "quan ly") {
                // Chuyển hướng sang trang quản lý đơn hàng của Admin
                header("Location: don-hang.php");
                exit();
            } else {
                // Khách hàng thông thường về Trang chủ
                header("Location: index.php");
                exit();
            }

        } else {
            $thong_bao = "<span style='color: red;'>Mật khẩu không đúng! Vui lòng kiểm tra lại.</span>";
        }

    } else {
        $thong_bao = "<span style='color: red;'>Email hoặc tên đăng nhập không tồn tại!</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Trái Cây Miền Nam</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 60px auto;
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

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
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

    <h1>ĐĂNG NHẬP</h1>

    <?php if ($thong_bao != "") { ?>
        <p class="thong-bao">
            <?php echo $thong_bao; ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Email hoặc Tên đăng nhập</label>
        <input
            type="text"
            name="email"
            placeholder="Nhập email hoặc tên đăng nhập"
            required
        >

        <label>Mật khẩu</label>
        <input
            type="password"
            name="mat_khau"
            placeholder="Nhập mật khẩu"
            required
        >

        <button type="submit">
            Đăng nhập
        </button>

    </form>

    <div class="link">
        <a href="dangky.php">
            Chưa có tài khoản? Đăng ký ngay
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