<?php
session_start();
require_once 'config.php';


if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE std_id = ?");
    $stmt->execute([$product_id]);
    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM tb6646_036";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .container {
            max-width: 1000px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1>รายการนักศึกษา</h1>

        <?php if (isset($_GET['add']) && $_GET['add'] === 'success'): ?>
            <div class="alert alert-success">เพิ่มข้อมูลสำเร็จ</div>
        <?php endif; ?>

        <?php if (isset($_GET['delete']) && $_GET['delete'] === 'success'): ?>
            <div class="alert alert-success">ลบข้อมูลเรียบร้อยแล้ว</div>
        <?php endif; ?>

        <form action="" method="POST" class="mb-3">
            <a href="add.php" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-1"></i>เพิ่มนักศึกษา</a>
        </form>

        <table id="productTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Nick Name</th>
                    <th>Mail</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($student['std_id']) ?></td>
                        <td><?= htmlspecialchars($student['f_name']) ?></td>
                        <td><?= htmlspecialchars($student['l_name']) ?></td>
                        <td><?= htmlspecialchars($student['n_name']) ?></td>
                        <td><?= htmlspecialchars($student['mail']) ?></td>
                        <td><?= htmlspecialchars($student['tel']) ?></td>
                        <td><?= htmlspecialchars($student['created_at']) ?></td>
                        <td>
                            <a href="edit_index.php?key=<?= $student['key'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?= $student['key'] ?>">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    คุณต้องการลบข้อมูลนี้ใช่หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <a id="deleteProductLink" href="#" class="btn btn-danger">ยืนยันการลบ</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>