<?php
require_once 'config.php';

$error = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($username) || empty($fname) || empty($email) || empty($password) || empty($cpassword)) {
        $error[] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "กรุณากรอกอีเมลให้ถูกต้อง";
    } elseif ($password !== $cpassword) {
        $error[] = "รหัสผ่านไม่ตรงกัน";
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            $error[] = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว";
        }
    }

    if (empty($error)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username,full_name,email,password,role) VALUES (?,?,?,?,'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fname, $email, $hashedPassword]);

        $success = true;
        echo "<script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 3000);
        </script>";
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
            z-index: -1;
        }

        .card-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            position: relative;
        }

        .card {
            width: 100%;
            max-width: 850px;
            display: flex;
            flex-direction: row;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .card-left {
            background-color: #0288d1;
            color: white;
            padding: 30px 20px;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-left i {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .card-left h4 {
            font-weight: 500;
        }

        .card-right {
            padding: 30px;
            width: 60%;
        }

        .form-label {
            color: #333;
        }

        .form-control {
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            color: #333;
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
        }

        .btn-primary:hover {
            background-color: #0277bd;
        }

        .btn-link {
            color: #0288d1;
        }

        .alert-success,
        .alert-danger {
            font-size: 0.95rem;
            padding: 10px 15px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
            }

            .card-left,
            .card-right {
                width: 100%;
                text-align: center;
            }

            .card-left {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>

    <div class="card-wrapper">
        <div class="card">

            <!-- Left -->
            <div class="card-left">
                <i class="bi bi-cart-fill"></i>
                <h4>Online Shop</h4>
            </div>

            <!-- Right -->
            <div class="card-right">
                <h2>Register</h2>

                <?php if ($success): ?>
                    <div class="alert alert-success">✅ สมัครสมาชิกสำเร็จแล้ว! กำลังเปลี่ยนหน้า...</div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($error as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">User</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="ชื่อผู้ใช้" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">Full Name</label>
                        <input type="text" name="fname" class="form-control" id="fname" placeholder="ชื่อ - นามสกุล" value="<?= isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="อีเมล" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?> ">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="รหัสผ่าน" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="ยืนยันรหัสผ่าน" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="login.php" class="btn btn-link">Login</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Particles.js library -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 40,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#0288d1"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": true
                },
                "size": {
                    "value": 5,
                    "random": true
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#0288d1",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 3,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "repulse": {
                        "distance": 100,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    </script>
</body>

</html>