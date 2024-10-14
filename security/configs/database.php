<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_PORT', 3306);
define('DB_NAME', 'app_web1');
// Kết nối đến MySQL với mysqli
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Nếu kết nối thành công, có thể thực hiện các truy vấn


// Đóng kết nối sau khi thực hiện xong các thao tác
mysqli_close($conn);
?>