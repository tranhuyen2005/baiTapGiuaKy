<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $level = $_POST['level'];
    $group_number = $_POST['group_number'];

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'QLSV_TranThiThuHuyen');

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Thêm sinh viên vào cơ sở dữ liệu
    $sql = "INSERT INTO table_students (fullname, dob, gender, hometown, level, group_number)
            VALUES ('$fullname', '$dob', $gender, '$hometown', '$level', '$group_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Sinh viên đã được thêm thành công!";
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <link rel="stylesheet" href="style_them.css">
</head>
<body>
<form method="post" action="them.php">
<h1>Thêm Sinh Viên Mới</h1>
    <div>
        <label for="fullname">Họ và Tên:</label>
        <input type="text" id="fullname" name="fullname" required>
    </div>
    <div>
        <label for="dob">Ngày Sinh:</label>
        <input type="date" id="dob" name="dob" required>
    </div>
    <div class="radio-group">
        <label>Giới Tính:</label>
        <input type="radio" name="gender" value="1" required> Nam
        <input type="radio" name="gender" value="0"> Nữ
    </div>
    <div>
        <label for="hometown">Quê Quán:</label>
        <input type="text" name="hometown" required>
    </div>
    <div>
        <label for="level">Trình Độ Học Vấn:</label>
        <select name="level" id="level" required>
            <option value="0">Tiến sĩ</option>
            <option value="1">Thạc sĩ</option>
            <option value="2">Kỹ sư</option>
            <option value="3">Khác</option>
        </select>
    </div>
    <div>
        <label for="group_number">Nhóm:</label>
        <input type="number" name="group_number" required>
    </div>
    <input type="submit" value="Lưu">
</form>
</body>
</html>
