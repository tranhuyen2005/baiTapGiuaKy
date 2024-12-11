<?php
// Tạo kết nối
$conn = new mysqli('localhost', 'root', '', 'QLSV_TranThiThuHuyen');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lọc dữ liệu nếu có tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Truy vấn tìm kiếm
$sql = "SELECT * FROM table_students WHERE fullname LIKE '%$search%' OR hometown LIKE '%$search%'";
$result = $conn->query($sql);

// Hàm format giới tính
function formatGender($gender) {
    return $gender == 1 ? 'Nam' : 'Nữ';
}

// Hàm format trình độ học vấn
function formatLevel($level) {
    $levels = ['Tiến sĩ', 'Thạc sĩ', 'Kỹ sư', 'Khác'];
    return isset($levels[$level]) ? $levels[$level] : 'Không rõ';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link rel="stylesheet" href="style_bang.css">
    
</head>
<body>
    <div class="container">
        <h1>Danh sách sinh viên</h1>
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm theo tên hoặc quê quán..." class="search-input" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="search-btn">Tìm kiếm</button>
            <a href="them.php" class="btn-add">Thêm sinh viên</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Giới Tính</th>
                    <th>Quê Quán</th>
                    <th>Trình Độ Học Vấn</th>
                    <th>Nhóm</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['fullname'] ?></td>
                            <td><?= date("d/m/Y", strtotime($row['dob'])) ?></td>
                            <td><?= formatGender($row['gender']) ?></td>
                            <td><?= $row['hometown'] ?></td>
                            <td><?= formatLevel($row['level']) ?></td>
                            <td>Nhóm <?= $row['group_number'] ?></td>
                            <td>
                                <a class="btn" href="sua.php?id=<?= $row['id'] ?>">Sửa</a>
                                <a class="btn btn-delete" href="xoa.php?id=<?= $row['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Không có sinh viên nào phù hợp với tìm kiếm!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
