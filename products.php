<?php
require '../config.php'; // TODO: เชื่อมต่อฐานข้อมูลด้วย PDO
require 'auth_admin.php';

// เพิ่มสินค้าใหม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name        = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);   // floatval() ใช้แปลงเป็น float
    $stock       = intval($_POST['stock']);     // intval() ใช้แปลงเป็น integer
    $category_id = intval($_POST['category_id']);
    // ค่าที่ได้จากฟอร์มเป็น string เสมอ

    if (!empty($name) && $price > 0) { // ตรวจสอบชื่อและราคาสินค้า
        $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, stock, category_id ) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $stock, $category_id]);

        header("Location: products.php");
        exit;
    }
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
    header("Location: products.php");
    exit;
}

// ดึงรายการสินค้า
$stmt = $conn->query("SELECT p.*, c.category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.category_id 
                    ORDER BY p.created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ดึงหมวดหมู่
$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        h2 {
            font-size: 2.5rem;
            color: #343a40;
            margin-bottom: 30px;
        }

        h5 {
            color: #007bff;
        }

        .alert {
            margin-top: 15px;
            font-size: 1rem;
        }

        .form-control, .btn {
            border-radius: 8px;
        }

        .btn {
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table td a {
            text-decoration: none;
        }

        .table td a:hover {
            color: #fff;
        }

        .table td a.btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .table td a.btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25);
        }

        .row.g-3 {
            margin-bottom: 20px;
        }

        .form-control.me-2 {
            width: 300px;
        }

        .btn-primary.w-100 {
            width: 100%;
        }

        .alert-danger,
        .alert-success {
            font-size: 1.1rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">จัดการสินค้า</h2>
        <a href="index.php" class="btn btn-secondary mb-3">← กลับหน้าผู้ดูแล</a>

        <!-- ฟอร์มเพิ่มสินค้าใหม่ -->
        <form method="post" class="row g-3 mb-4">
            <h5>เพิ่มสินค้าใหม่</h5>
            <div class="col-md-4">
                <input type="text" name="product_name" class="form-control" placeholder="ชื่อสินค้า" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="ราคา" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="stock" class="form-control" placeholder="จำนวน" required>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select" required>
                    <option value="">เลือกหมวดหมู่</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <textarea name="description" class="form-control" placeholder="รายละเอียดสินค้า" rows="2"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" name="add_product" class="btn btn-primary w-100">เพิ่มสินค้า</button>
            </div>
        </form>

        <!-- แสดงรายการสินค้า -->
        <h5>รายการสินค้า</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคา</th>
                    <th>คงเหลือ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?> บาท</td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <a href="products.php?delete=<?= $p['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบสินค้านี้?')">ลบ</a>
                            <a href="edit_product.php?id=<?= $p['product_id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
