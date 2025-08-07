<?php
    require_once 'config.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //รับค่าจาก form 
        $username = trim($_POST['username']);
        $fname = trim($_POST['fname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];


        //นำข้อมูลบันทึกลงฐานข้อมูล
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username,full_name,email,password,role) VALUES (?,?,?,?,'admin')";
        $stmt = $conn -> prepare($sql);
        $stmt -> execute([$username,$fname,$email,$hashedPassword]);
        

    }
    
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>register</title>
</head>
<body>

<div class="container mt-5">
    <h2> Register </h2>
    <form action="" method="post">
        <div>
            <label for="username" class="form-label">User</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="ชื่่อผู้ใช้" required>
        </div>
        <div>
            <label for="fname" class="form-label">Full Name</label>
            <input type="text" name="fname" class="form-control" id="fname" placeholder="ชื่อ - นามสกุล" required>
        </div>
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="อีเมล" required>
        </div>
        <div>
            <label for="password" class="form-label">Password</label>
            <input type="text" name="password" class="form-control" id="password" placeholder="รหัสผ่าน" required>
        </div>
        <div>
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="text" name="cpassword" class="form-control" id="cpassword" placeholder="ยืนยันรหัสผ่าน" required>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Login</a>
        </div>
        
    </form>

</div>

















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>