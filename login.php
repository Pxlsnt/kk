<?php
require_once 'config.php';

$error = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error[] = "กรุณากรอกข้อมูลให้ครบ";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {


            $_SESSION['user_id'] = $user['ชอื่ ฟิลดใ์น db'];
            $_SESSION['username'] = $user['ชอื่ ฟิลดใ์น db'];
            $_SESSION['role'] = $user['ชอื่ ฟิลดใ์น db'];


            $success = true;
            session_start();
            $_SESSION['user'] = $user['username'];
            header("Location: test.php");
            exit();
        } else {
            $error[] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Online Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .card {
        max-width: 800px;
        margin: auto;
        display: flex;
        flex-direction: row;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .card-left {
        background-color: #0097A7;
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
        margin-bottom: 10px;
    }

    .card-right {
        padding: 30px;
        width: 60%;
    }

    .form-label {
        color: #333;
    }

    .form-control {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #0097A7;
        box-shadow: 0 0 0 0.2rem rgba(0, 151, 167, 0.25);
    }

    .btn-primary {
        background-color: #0097A7;
        border: none;
    }

    .btn-primary:hover {
        background-color: #007c91;
    }

    .btn-link {
        color: #0097A7;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .card {
            flex-direction: column;
            width: 90%;
            height: auto;
        }

        .card-left,
        .card-right {
            width: 100%;
            text-align: center;
            padding: 20px;
        }
    }

    @media (min-width: 769px) {
        .card {
            width: 600px;
            height: auto;
        }

        .card-left {
            width: 40%;
            padding: 40px 20px;
        }

        .card-right {
            width: 60%;
            padding: 40px;
        }
    }
    </style>
</head>

<body>

    <div id="particles-js"></div>

    <div class="container p-3 d-flex justify-content-center align-items-center vh-100">
        <div class="card">

            <div class="card-left">
                <i class="bi bi-cart-fill"></i>
                <h4>Online Shop</h4>
            </div>

            <div class="card-right">
                <h2>Login</h2>

                <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($error as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username or Email</label>
                        <input type="text" class="form-control" name="username" id="username" required
                            placeholder="ชื่อผู้ใช้ หรืออีเมล">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required
                            placeholder="รหัสผ่าน">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div>
                            <a href="registeer.php" class="btn btn-link">Register</a>
                            <a href="#" class="btn btn-link">Forgot?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Particles JS -->
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