<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
require_once 'helper.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;

if (!empty($_GET['id'])) {
    $user_id = decryptUserId($_GET['id']);
    $user = $userModel->findUserById($user_id);//Update existing user
    $_id = $user_id;
}
$error = [];

if (!empty($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $error['name'] = 'Name is required';

    } elseif (!preg_match('/^[a-zA-Z0-9]{5,15}$/', $_POST['name'])) {
        $errors['name'] = "Name must be 5-15 characters and only contain letters and numbers!";
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password is required!";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()]).{5,10}$/', $_POST['password'])) {
        $errors['password'] = "Password must be 5-10 characters and include at least one lowercase letter, one uppercase letter, one number, and one special character!";
    }

    if (empty($errors)) {
        if (!empty($_id)) {
            $userModel->updateUser($_POST);
        } else {
            $userModel->insertUser($_POST);
        }
        header('location: list_users.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>

<body>
    <?php include 'views/header.php' ?>
    <div class="container">

        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                User update
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $_id ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($user[0]['name']))
                        echo $user[0]['name'] ?>'>
                    <?php if (!empty($errors['name'])) { ?>
                        <small class="text-danger"><?php echo $errors['name']; ?></small>   
                    <?php } ?>
                </div>
                <!-- Password Input Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <?php if (!empty($errors['password'])) { ?>
                        <small class="text-danger"><?php echo $errors['password']; ?></small>
                    <?php } ?>
                </div>

                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                User not found!
            </div>
        <?php } ?>
    </div>
</body>

</html>