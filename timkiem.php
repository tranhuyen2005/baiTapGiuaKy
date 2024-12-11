<?php
// Kiểm tra xem người dùng có nhập từ khóa tìm kiếm không
if (isset($_GET['search_term']) && !empty($_GET['search_term'])) {
    $search_term = $_GET['search_term'];

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'QLSV_TranThiThuHuyen');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Truy vấn cơ sở dữ liệu tìm kiếm theo tên hoặc quê quán
    $sql = "SELECT * FROM table_students WHERE fullname LIKE ? OR hometown LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term_wildcard = "%" . $search_term . "%"; // Thêm dấu % cho phép tìm kiếm với bất kỳ vị trí nào

    $stmt->bind_param("ss", $search_term_wildcard, $search_term_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra có kết quả không
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Giới Tính</th>
                    <th>Quê Quán</th>
                    <th>Trình Độ Học Vấn</th>
                    <th>Nhóm</th>
                </tr>";

        // Hiển thị kết quả tìm kiếm
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['fullname'] . "</td>
                    <td>" . $row['dob'] . "</td>
                    <td>" . ($row['gender'] == 1 ? 'Nam' : 'Nữ') . "</td>
                    <td>" . $row['hometown'] . "</td>
                    <td>" . ($row['level'] == 0 ? 'Tiến sĩ' : ($row['level'] == 1 ? 'Thạc sĩ' : ($row['level'] == 2 ? 'Kỹ sư' : 'Khác'))) . "</td>
                    <td>" . $row['group_number'] . "</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Không có sinh viên nào phù hợp với tìm kiếm!";
    }

    // Đóng kết nối
    $conn->close();
}
?>
