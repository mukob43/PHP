<?php

require_once 'config.php';// TODO-1: เชื่อมต่อฐานข้อมูลด้วย PDO



if (!isset($_GET['key'])) {
    header("Location: index.php");
    exit;
}


$key = $_GET['key'];
// ดึงข้อมูลสมาชิกที่จะถูกแก้ไข
/*
TODO-5: เตรียม/รัน SELECT (เฉพาะ role = 'member')
SQL แนะนำ:
SELECT * FROM users WHERE user_id = ? AND role = 'member'
- ใช้ prepare + execute([$user_id])
- fetch(PDO::FETCH_ASSOC) แล้วเก็บใน $user
*/

$stmt = $conn->prepare("SELECT * FROM `tb6646_036` WHERE `key` = ?");
$stmt->execute([$key]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
// TODO-6: ถ้าไม่พบข้อมูล -> แสดงข้อความและ exit;
if (!$key) {
    echo "<h3>ไม่พบสมาชิก</h3>";
    exit;
}
// ========== เมื่อผู้ใช้กด Submit ฟอร์ม ==========
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO-7: รับค่า POST และ trim
    $std_id = trim($_POST['std_id']);
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $n_name = trim($_POST['n_name']);
    $mail = trim($_POST['mail']);
    $tel = trim($_POST['tel']);
    
    // TODO-8: ตรวจความครบถ้วน และตรวจรูปแบบอีเมล
    if ($std_id === '' || $mail === '') {
        $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = "รูปแบบอีเมลไม่ถูกต้อง";
    }
    // TODO-9: ถ้า validate ผ่าน ให้ตรวจสอบซ้ำ (username/email ชนกับคนอื่นที่ไม่ใช่ตัวเองหรือไม่)
// SQL แนะนำ:
// SELECT 1 FROM users WHERE (username = ? OR email = ?) AND user_id != ?
    // if (!$error) {
    //     $chk = $conn->prepare("SELECT 1 FROM `tb6646_036` WHERE (std_id = ? OR mail = ?) AND 'key' != ?");
    //     $chk->execute([$std_id, $mail, $key]);
    //     if ($chk->fetch()) {
    //         $error = "ชื่อผู้ใช้หรืออีเมลนี้มีอยู่แล้วในระบบ";
    //     }
    // }
   
            // อัปเดตเฉพาะข้อมูลทั่วไป

 
         if (!$error) {
        $chk = $conn->prepare("SELECT 1 FROM tb6646_036 WHERE (std_id = ? OR mail = ?)");
        $chk->execute([$std_id, $mail]);
        if ($chk->fetch()) {
        $error = "รหัสนักศึกษาหรืออีเมลนี้มีอยู่ในระบบ";
        }
    }
            
    // เขียน update แบบปกติ: ถ้าไม่ซ้ำ -> ทำ UPDATE
        if (!$error) {
        $upd = $conn->prepare("UPDATE tb6646_036 SET 
        std_id = ?, f_name = ?, l_name = ?, n_name = ?,mail = ? , tel = ?
         WHERE `key` = ?");
        $upd->execute([$std_id, $f_name, $l_name, $n_name , $mail , $tel , $key]);
        // TODO-11: redirect กลับหน้า users.php หลังอัปเดตสำเร็จ
        header("Location: index.php?edit=success");
        exit;
        }
        $student['std_id'] = $std_id;
        $student['mail'] = $mail;
    }
    

    // TODO-10: ถ้าไม่ซ้ำ -> ทำ UPDATE
// SQL แนะนำ:
// UPDATE users SET username = ?, full_name = ?, email = ? WHERE user_id = ?
// OPTIONAL: อัปเดตค่า $user เพื่อสะท้อนค่าที่ช่องฟอร์ม (หากมี error)

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลนักศึกษา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #c0fda8ff, #d9ffb6ff);
            background-size: 400% 400%;
            animation: gradient-animation 15s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        @keyframes gradient-animation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
            border-color: #565e64;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
    </style>
</head>

<body class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4"><i class="fas fa-user-edit me-2"></i>แก้ไขข้อมูลนักศึกษา</h2>
        <a href="index.php" class="btn btn-secondary mb-3"><i
                class="fas fa-arrow-left me-1"></i>กลับหน้ารายชื่อนักศึกษา</a>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">รหัสนักศึกษา</label>
                <input type="text" name="std_id" class="form-control" required
                    value="<?= htmlspecialchars($student['std_id']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อ</label>
                <input type="text" name="f_name" class="form-control"required
                    value="<?= htmlspecialchars($student['f_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">นามสกุล</label>
                <input type="text" name="l_name" class="form-control"required
                    value="<?= htmlspecialchars($student['l_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อเล่น</label>
                <input type="text" name="n_name" class="form-control"required
                    value="<?= htmlspecialchars($student['n_name']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">อีเมล</label>
                <input type="email" name="mail" class="form-control" required
                    value="<?= htmlspecialchars($student['mail']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">เบอร์โทร</label>
                <input type="text" name="tel" class="form-control"required
                    value="<?= htmlspecialchars($student['tel']) ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>บันทึกการแก้ไข</button>
            </div>
           
            
        </form>
    </div>
</body>

</html>
