<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$id = null;

// Kiểm tra và lấy ID từ GET
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID người dùng không hợp lệ.");
}

// Nếu có yêu cầu xóa từ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra token CSRF
    if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Xóa người dùng hiện có
        $userModel->deleteUserById($id);
        header('Location: list_users.php');
        exit();
    } else {
        die("Token CSRF không hợp lệ.");
    }
}

// Tạo token CSRF nếu chưa có
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận xóa người dùng</title>
    <style>
        .alert {
            padding: 20px;
            background-color: #f44336; /* Màu nền đỏ */
            color: white; /* Màu chữ trắng */
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .warning-message {
            font-weight: bold;
        }
        .button-container {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>Xác nhận xóa người dùng</h1>
    
    <div class="alert">
        <span class="warning-message">Cảnh báo!</span> Đây là một liên kết độc hại có thể lộ thông tin của bạn. Vui lòng cân nhắc trước khi XÓA người dùng có ID <?php echo htmlspecialchars($id); ?>.
    </div>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="button-container">
            <button type="submit">Xóa</button>
            <a href="list_users.php">Hủy</a>
        </div>
    </form>
</body>
</html>


