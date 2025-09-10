<?php
session_start();
require './config.php';

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>แผงควบคุมผู้ดูแลระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            font-weight: bold;
            color: #212529;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        h2::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background: #0d6efd;
            margin: 10px auto 0;
            border-radius: 5px;
        }

        p {
            text-align: center;
            font-size: 1.1rem;
            color: #495057;
        }

        .row .col-md-4 {
            display: flex;
            justify-content: center;
        }

        .btn {
            padding: 20px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .container {
            max-width: 900px;
        }
    </style>
</head>

<body class="container mt-4">
    <h2>ระบบผู้ดูแลระบบ</h2>
    <p class="mb-4">ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="product_detail.php" class="btn btn-primary w-100">จัดการสินค้า</a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="orders.php" class="btn btn-success w-100">จัดการคำสั่งซื้อ</a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="users.php" class="btn btn-warning w-100">จัดการสมาชิก</a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="categories.php" class="btn btn-dark w-100">จัดการหมวดหมู่</a>
        </div>
    </div>
    <a href="../logout.php" class="btn btn-secondary mt-3">ออกจากระบบ</a>
</body>

</html>
