<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL;
$_id = NULL;

function generateRandomKey($length = 5) {
    return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', ceil($length / strlen($x)))), 1, $length);
}

function encodeId($id) {
    $randomKey = generateRandomKey();
    return strtr(base64_encode($randomKey . $id), '+/', '*&') . $randomKey;
}

function decodeId($encodedId) {
    $randomKeyLength = 5;
    $key = substr($encodedId, -$randomKeyLength);
    return substr(base64_decode(strtr(substr($encodedId, 0, -$randomKeyLength), '*&', '+/')), strlen($key));
}

function validateName($name) {
    return (empty($name) || !preg_match('/^[A-Za-z0-9]{5,15}$/', $name)) ? "Tên không hợp lệ." : true;
}

function validatePassword($password) {
    return (empty($password) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()]).{5,10}$/', $password)) ? "Mật khẩu không hợp lệ." : true;
}

$errorMessages = [];

if (!empty($_GET['id'])) {
    $_id = decodeId($_GET['id']);
    $user = $userModel->findUserById($_id);
}

if (!empty($_POST['submit'])) {
    $nameValidation = validateName($_POST['name']);
    $passwordValidation = validatePassword($_POST['password']);
    
    if ($nameValidation !== true) $errorMessages[] = $nameValidation;
    if ($passwordValidation !== true) $errorMessages[] = $passwordValidation;

    if (empty($errorMessages)) {
        !empty($_id) ? $userModel->updateUser($_POST) : $userModel->insertUser($_POST);
        header('location: list_users.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Biểu mẫu người dùng</title>
    <?php include 'views/meta.php'; ?>
</head>
<body>
    <?php include 'views/header.php'; ?>
    <div class="container">
        <?php if ($errorMessages) { ?>
            <div class="alert alert-danger"><?php echo implode('<br>', $errorMessages); ?></div>
        <?php } ?>
        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning">Biểu mẫu người dùng</div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo encodeId($_id); ?>">
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input class="form-control" name="name" placeholder="Tên" value="<?php echo $user[0]['name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Gửi</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-success">Không tìm thấy người dùng!</div>
        <?php } ?>
    </div>
</body>
</html>
