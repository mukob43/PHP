<?php
    require_once 'config.php';

    $error = []; //Array to hold error messages

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //รับค่าจากฟอร์ม
        $username = trim($_POST['username']);
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        //ตรวจสอบว่ากรอกข้อมูลครบหรือไม่ (empty)
        if(empty($username) || empty($fullname)|| empty($email)|| empty($password)|| empty($confirm_password)){
            $error[] = "กรุณากรอกชื่อผู้ใช้";


            //ตรวจสอบว่าอีเมลถูกต้องหรือไม่ (filter_var)
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $error[] = "ตรวจสอบรูปแบบอีเมล";


            //ตรวจสอบรหัสผ่านและยืนยันรหัสผ่านว่าตรงกันหรือไม่
        }elseif($password !==$confirm_password){
            $error[] = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน";


        }else{
            //ตรวจสอบว่ามีชื่อผู้ใช้หรืออีเมลถูกใช้ไปแล้วหรือไม่
            $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username,$email]); 

            if($stmt->rowCount() >0){
                $error[]= "ชื่อผู้ใช้หรืออีเมลนี้มีคนใช้แล้ว";

            }
        }

        if(empty($error)){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users(username,full_name,email,password,role) VALUES (?, ?, ?, ?, 'member')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username,$fullname,$email,$hashedPassword]);

        //ถ้าบันทึกสำเร็จให้เปลี่ยนเส้นทางไปหน้าล็อคอิน
        header("Location login.php?register=success");
        exit();
    }

        }
        

        //นำข้อม฿ลไปบันทึกในฐานข้อมูล
        
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f0f8f4; /* สีพื้นหลังเขียวอ่อน */
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h2 {
            color: #4caf50; /* สีเขียวเข้ม */
            text-align: center;
        }

        .form-label {
            color: #4caf50;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #4caf50;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #81c784; /* สีเขียวอ่อนเมื่อโฟกัส */
            box-shadow: 0 0 5px rgba(81, 199, 132, 0.6);
        }

        .btn-primary {
            background-color: #66bb6a; /* ปุ่มสีเขียว */
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #81c784;
        }

        .btn-link {
            color: #66bb6a;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="container register-container">
    <h2 class="text-center mb-4">สมัครสมาชิก</h2>
    <hr>    
<?php if (!empty($error)): // ถ ้ำมีข ้อผิดพลำด ให้แสดงข ้อควำม ?>
<div class="alert alert-danger">
<ul>
<?php foreach ($error as $e): ?>
<li><?= htmlspecialchars($e) ?></li>
<!--ใช ้ htmlspecialchars เพื่อป้องกัน XSS -->
<!-- < ? = คือ short echo tag ?> -->
<!-- ถ ้ำเขียนเต็ม จะได ้แบบด ้ำนล่ำง -->
<?php // echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

    

    <form action="" method="post">
        <div>
            <label for="username" class="form-label">ชื่อผู้ใช้</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้" 
 value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?> " required> 
        </div>

        <div>
            <label for="fullname" class="form-label">ชื่อ-สกุล</label>
            <input type="text" name="fullname" id="fullname" class="form-control" placeholder="ชื่อ-สกุล"
value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?>" required>
        </div>

        <div>
            <label for="email" class="form-label">อีเมล</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="อีเมล"
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?> " required>  
        </div>

        <div>
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="text" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" required>
        </div>

        <div>
            <label for="confirm_password" class="form-label">ยืนยันรหัสผ่าน</label>
            <input type="text" name="confirm_password" id="confirm_password" class="form-control" placeholder="ยืนยันรหัสผ่าน"required>
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
            <a href="login.php" class="btn btn-link">เข้าสู่ระบบ</a>
        </div>

    </form>


    </div>

    <script scr="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
