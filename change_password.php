<?php

$title = "Change password";
require_once 'Template/header.php';
require_once './Config/database.php';
$errors = [];
if (isset($_SESSION['logged_in'])) {
    header('location:  index.php');
    die();
}
if (!isset($_GET['token']) || !$_GET['token']) {
    header('location:  index.php');
    die('where prameters');
}

$token = $_GET['token'];

$now = date('y-m-d h:i:s');

$stmt = $mysqli->prepare("select * from password_rests where token = ? AND expires_at >  '$now' ");
$stmt->bind_param('s', $token);
$stmt->execute();

$result = $stmt->get_result();

if (!$result->num_rows) {

    die();
}

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $password              = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

    if (empty($password)) {
        array_push($errors, 'password is required');
    }
    if (empty($password_confirmation)) {
        array_push($errors, 'password confirmation is required');
    }
    if ($password_confirmation !== $password) {
        array_push($errors, 'password don\'t match ');

    }

    if (!count($errors)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $userId = $result->fetch_assoc()['user_id'];

        $mysqli->query("UPDATE users SET password  = '$password_hashed' WHERE id = '$userId' ");

        $mysqli->query("DELETE FROM password_rests where user_id = '$userId'");

        $_SESSION['success_message'] = 'YOU PASSWORD CHANGE !';

        header('location: login.php');
        die();
    }
}
?>

<div id="password_reset" class="pt-5">
    <h4>password reset</h4>
    <h5 class="text-info">Fill inputs</h5>
    <hr>
    <?php include 'Template/errors.php'?>
    <form action="" method="post">
        <div class="form-group pt-2">
            <label for="password"> new password </label>
            <input type="password" name="password" class="form-control" placeholder="password">
        </div>
        <div class="form-group pt-2">
            <label for="password_confirmation"> password_confirmation </label>
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="password confirmation">
        </div>
        <div class="form-group pt-2">
            <button class="btn btn-primary">rest!</button>
        </div>
    </form>
</div>
<?php

include './Template/footer.php';
?>