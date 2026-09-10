<?php

session_start();

include "Ketnoi.php";

$thong_bao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $mat_khau = $_POST["mat_khau"];

    $sql = "SELECT * FROM nguoi_dung WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $nguoi_dung = $result->fetch_assoc();

        if (
            password_verify(
                $mat_khau,
                $nguoi_dung["mat_khau"]
            )
        ) {

            $_SESSION["ma_nguoi_dung"] =
                $nguoi_dung["ma_nguoi_dung"];

            $_SESSION["ho_ten"] =
                $nguoi_dung["ho_va_ten"];

            $_SESSION["vai_tro"] =
                $nguoi_dung["vai_tro"];


            if ($nguoi_dung["vai_tro"] == "admin") {

                header("Location: admin/index.php");

            } else {

                header("Location: index.php");
            }

            exit();

        } else {

            $thong_bao = "Mật khẩu không đúng!";
        }

    } else {

        $thong_bao = "Email không tồn tại!";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Đăng nhập</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            width: 400px;
            margin: 80px auto;
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

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
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
        }

        .link {
            text-align: center;
            margin-top: 15px;
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

        <button type="submit">
            Đăng nhập
        </button>

    </form>

    <div class="link">

        <a href="dangky.php">
            Chưa có tài khoản? Đăng ký
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