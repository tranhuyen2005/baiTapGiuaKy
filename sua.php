<?php
// Lấy ID từ URL
$id = $_GET['id'];

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'QLSV_TranThiThuHuyen');

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin sinh viên
$sql = "SELECT * FROM table_students WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Xử lý form nếu người dùng gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_number = $_POST['group_number']; // Chỉnh sửa tên biến cho khớp với trong form

    // Cập nhật thông tin sinh viên
    $sql = "UPDATE table_students SET fullname='$fullname', dob='$dob', gender=$gender, hometown='$hometown', level=$level, group_number=$group_number WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Sinh viên đã được cập nhật thành công!";
        header("Location: index.php"); // Sau khi cập nhật, chuyển hướng về trang danh sách
        exit(); // Thêm exit để ngừng thực thi mã sau khi chuyển hướng
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh Viên</title>
    <link rel="stylesheet" href="style_sua.css"> 
</head>
<body>
    <form method="post" action="sua.php?id=<?= $id ?>" class="sua-form">
        <h1>Sửa Sinh Viên</h1>

        <!-- Nhóm label và input cho Họ và Tên -->
        <div>
            <label for="fullname">Họ và Tên:</label>
            <input type="text" id="fullname" name="fullname" value="<?= $row['fullname'] ?>" required>
        </div>

        <!-- Nhóm label và input cho Ngày Sinh -->
        <div>
            <label for="dob">Ngày Sinh:</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <!-- Nhóm label và radio cho Giới Tính -->
        <div>
            <label for="gender">Giới Tính:</label>
            <input type="radio" name="gender" value="1" <?= $row['gender'] == 1 ? 'checked' : '' ?>> Nam
            <input type="radio" name="gender" value="0" <?= $row['gender'] == 0 ? 'checked' : '' ?>> Nữ
        </div>

        <!-- Nhóm label và input cho Quê Quán -->
        <div>
            <label for="hometown">Quê Quán:</label>
            <input type="text" name="hometown" value="<?= $row['hometown'] ?>" required>
        </div>

        <!-- Nhóm label và select cho Trình Độ Học Vấn -->
        <div>
            <label for="level">Trình Độ Học Vấn:</label>
            <select name="level" id="level" required>
                <option value="0" <?= $row['level'] == 0 ? 'selected' : '' ?>>Tiến sĩ</option>
                <option value="1" <?= $row['level'] == 1 ? 'selected' : '' ?>>Thạc sĩ</option>
                <option value="2" <?= $row['level'] == 2 ? 'selected' : '' ?>>Kỹ sư</option>
                <option value="3" <?= $row['level'] == 3 ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <!-- Nhóm label và input cho Nhóm -->
        <div>
            <label for="group_number">Nhóm:</label>
            <input type="number" name="group_number" value="<?= $row['group_number'] ?>" required>
        </div>

        <!-- Nút submit -->
        <div>
            <input type="submit" value="Cập nhật">
        </div>
    </form>
</body>
</html>
