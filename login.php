<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE (username = ? OR email = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }


        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, #f0faff, #ffffff);
            z-index: 0;
        }


        .center-box {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 380px;
            max-width: calc(100% - 40px);
            z-index: 2;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(2, 8, 23, 0.12);
            overflow: hidden;
        }


        .card-custom {
            border: none;
            border-radius: 12px;
            padding: 28px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(245, 252, 255, 0.7));
        }


        .brand {
            display: block;
            text-align: center;
            margin-bottom: 14px;
        }

        .brand h2 {
            margin: 0;
            font-size: 22px;
            color: #024b6e;
            letter-spacing: -0.3px;
        }


        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(2, 136, 209, 0.12);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }


        .form-control::placeholder {
            color: #aaa;
        }


        .form-control:focus {
            background-color: #fff;
            border-color: #0288d1;
            box-shadow: 0 0 0 0.2rem rgba(2, 136, 209, 0.2);
        }


        .btn-primary {
            background-color: #0288d1;
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
        }


        .btn-primary:hover {
            background-color: #0277bd;
        }


        .btn-link {
            color: #0288d1;
            text-decoration: none;
        }


        .alert-suc {
            background: rgba(12, 145, 80, 0.08);
            color: #0c9150;
            border: 1px solid rgba(12, 145, 80, 0.12);
            padding: 10px 12px;
            border-radius: 8px;
        }


        .alert-err {
            background: rgba(255, 69, 58, 0.06);
            color: #b32419;
            border: 1px solid rgba(255, 69, 58, 0.1);
            padding: 10px 12px;
            border-radius: 8px;
        }

        .small-note {
            font-size: 13px;
            color: #6b7c86;
            text-align: center;
            margin-top: 10px;
        }


        @media (max-width: 480px) {
            .center-box {
                width: calc(100% - 32px);
                padding: 12px;
            }

            .card-custom {
                padding: 18px;
            }
        }
    </style>

</head>

<body>
    <div id="particles-js"></div>


    <div class="center-box">
        <div class="card-custom">
            <div class="brand">
                <h2>ยินดีต้อนรับกลับ</h2>
            </div>


            <?php if ($error): ?>
                <div class="alert-err"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>


            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username_or_email" class="form-label">ชื่อผู้ใช้ หรือ อีเมล</label>
                    <input type="text" class="form-control" id="username_or_email" name="username_or_email" placeholder="กรอกชื่อผู้ใช้หรืออีเมล" required>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required>
                </div>


                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                </div>


                <div class="small-note mt-3">
                    ยังไม่มีบัญชี? <a href="registeer.php" class="btn btn-link">ลงทะเบียน</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>