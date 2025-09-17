<?php
require '../config.php'; // TODO: เชื่อมต่อฐานข้อมูลด้วย PDO
// TODO: การ์ดสิทธิ์ (Admin Guard)
// แนวทาง: ถ้า !isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' -> redirect ไป ../login.php แล้ว exit;
require 'auth_admin.php';

// เพิ่มหมวดหมู่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if ($category_name) {
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$category_name]);
        header("Location: category.php");
        exit;
    }
}

// ลบหมวดหมู่
// ตรวจสอบว่าหมวดหมู่นี้ยังถูกใช้อยู่หรือไม่
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];

    // ตรวจสอบว่าหมวดหมู่นี้ยังถูกใช้อยู่หรือไม่
    $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $stmt->execute([$category_id]);
    $productCount = $stmt->fetchColumn();

    if ($productCount > 0) {
        // ถ้ามีสินค้าอยู่ในหมวดหมู่นี้
        $_SESSION['error'] = "ไม่สามารถลบหมวดหมู่นี้ได้ เนื่องจากยังมีสินค้าที่ใช้งานหมวดหมู่นี้อยู่";
    } else {
        // ถ้าไม่มีสินค้า ให้ลบได้
        $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->execute([$category_id]);
        $_SESSION['success'] = "ลบหมวดหมู่เรียบร้อยแล้ว";
    }

    header("Location: category.php");
    exit;
}

// ลบหมวดหมู่ (แบบไม่มีการตรวจสอบว่ายังมีสินค้าในหมวดหมู่นี้หรือไม่)
// if (isset($_GET['delete'])) {
//     $category_id = $_GET['delete'];
//     $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
//     $stmt->execute([$category_id]);
//     header("Location: category.php");
//     exit;
// }

// แก้ไขหมวดหมู่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = trim($_POST['new_name']);
    if ($category_name) {
        $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
        $stmt->execute([$category_name, $category_id]);
        header("Location: category.php");
        exit;
    }
}

// ดึงหมวดหมู่ทั้งหมด
$categorise = $conn->query("SELECT * FROM categories ORDER BY category_id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการหมวดหมู่</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
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

        .alert {
            margin-top: 15px;
            font-size: 1rem;
        }

        table {
            margin-top: 30px;
            border-collapse: separate;
            border-spacing: 0 10px;
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
            padding: 20px;
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

        .form-control {
            border: 2px solid #ced4da;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25);
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

        .table td a.btn-sm {
            padding: 5px 15px;
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
        <h2 class="text-center">จัดการหมวดหมู่สินค้า</h2>

        <!-- Success and Error Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mb-3">← กลับหน้าผู้ดูแล</a>

        <!-- Add New Category Form -->
        <form method="post" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="category_name" class="form-control" placeholder="ชื่อหมวดหมู่ใหม่" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add_category" class="btn btn-primary w-100">เพิ่มหมวดหมู่</button>
            </div>
        </form>

        <!-- Categories List -->
        <h5>รายการหมวดหมู่</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ชื่อหมวดหมู่</th>
                    <th>แก้ไขชื่อ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorise as $cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat['category_name']) ?></td>
                        <td>
                            <form method="post" class="d-flex">
                                <input type="hidden" name="category_id" value="<?= $cat['category_id'] ?>">
                                <input type="text" name="new_name" class="form-control me-2" placeholder="ชื่อใหม่" required>
                                <button type="submit" name="update_category" class="btn btn-warning btn-sm">แก้ไข</button>
                            </form>
                        </td>
                        <td>
                            <a href="category.php?delete=<?= $cat['category_id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('คุณต้องการลบหมวดหมู่นี้หรือไม่?')">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
