<?php
$title = "Register";
require_once 'Template/header.php';
require_once './Config/database.php';
$errors = [];
$email  = $name  = "";
if (isset($_SESSION['logged_in']) == 1) {
    echo 's';
    header('location:  index.php');
    die();
}
if ('POST' === $_SERVER['REQUEST_METHOD']) {
     $email                 = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name                  = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password              = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
    if (empty($name)) {
        array_push($errors, 'name is required');
    }
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
        $userExists = $mysqli->query("select email from users where email = '$email' limit 1");
        if ($userExists->num_rows) {

            array_push($errors, 'email used');
        } else {
             $password = password_hash($password, PASSWORD_DEFAULT);
            $mysqli->query("INSERT INTO users (email,name,password) VALUES ('$email' , '$name' , '$password')");

            $_SESSION['logged_in'] = true;
             $_SESSION['user_id']         = $mysqli->insert_id;
            $_SESSION['user_name']       = $name;
            $_SESSION['success_message'] = "you logged in $name";
            header('location: index.php');

        }
    }
}
?>

<div id="register" class="pt-5">
    <hr>
    <?php include 'Template/errors.php'?>
    <form action="" method="post">
        <div class="form-group pt-2">
            <label class="form-label mt-4" for="email"> Email </label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email ?>">
        </div>
        <div class="form-group pt-2">
            <label class="form-label mt-4" for="name">Name </label>
            <input type="text" name="name" class="form-control" placeholder="name" value="<?php echo $name ?>">
        </div>
        <div class="form-group pt-2">
            <label class="form-label mt-4" for="password"> Password </label>
            <input type="password" name="password" class="form-control" placeholder="pasword">
        </div>
        <div class="form-group pt-2">
            <label class="form-label mt-4" for="password_confirmation"> Confirm password </label>
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="password confirmation">
        </div>

        <div class="form-group pt-2">
            <a href="login.php" class="card-link">Already have an account? login here</a>
        </div>

        <div class="form-group pt-2">
            <button class="btn btn-success">Register!</button>
        </div>
    </form>
</div>
<?php

include './Template/footer.php';
?>
