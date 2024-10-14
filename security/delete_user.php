<?php
require_once 'models/UserModel.php';
require_once 'csrf_token.php';
require_once 'helper.php';

$userModel = new UserModel();


if (!empty($_GET['id']) && !empty($_GET['csrf_token'])) {

    if (hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {

        $user_id = decryptUserId($_GET['id']);
        // // Test token
        // $token = $_GET['csrf_token'];
        // echo $token;
        if ($userModel->deleteUserById($user_id)) {
            echo "User deleted successfully!";
        } else {
            echo "Failed to delete user.";
        }
    } else {

        echo "Invalid CSRF token!";
        exit;
    }
} else {

    echo "Invalid request!";
    exit;
}


header('Location: list_users.php');
exit;
?>
