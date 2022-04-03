<?php
$title = "Register";
require_once 'Template/header.php';
require_once './Config/database.php';
$errors = [];
$email  = "";
if (isset($_SESSION['logged_in']) == 1) {
    echo '<script>location.href="http://127.0.0.1/project_php"</script>';
    die();
}
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $email    = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    if (empty($email)) {
        array_push($errors, 'Email is required');
    }

    if (empty($password)) {
        array_push($errors, 'password is required');
    }

    if (!count($errors)) {
        $userExists = $mysqli->query("SELECT  id, name , email , password , role FROM users WHERE email = '$email' limit 1")->fetch_assoc();
        if (!count($userExists)) {
            array_push($errors, 'Eamil error');
        } else {
            $hashed_pass = $userExists['password'];
            if (password_verify($password, $hashed_pass)) {
                //login

                $_SESSION['logged_in']       = true;
                $_SESSION['user_id']         = $userExists['id'];
                $_SESSION['user_role']       = $userExists['role'];
                $_SESSION['user_name']       = $userExists['name'];
                $_SESSION['success_message'] = "Welocme " . $_SESSION['user_name'];
                echo 'admin' == $_SESSION['user_role'] ? '<script>location.href="http://127.0.0.1/project_php/admin"</script>' : '<script>location.href="http://127.0.0.1/
                /"</script>';
            } else {
                //  password error
                array_push($errors, 'password error');

            }
            echo password_verify($password, $hashed_pass);
        }
    }
}
?>

<div id="login" class="pt-5">
    <h4>Login</h4>
    <hr>
    <?php include 'Template/errors.php'?>
    <form action="" method="post">
        <div class="form-group pt-2">
            <label class="form-label mt-4" for="email"> Email </label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email ?>">
        </div>

        <div class="form-group pt-2">
            <label class="form-label mt-4" for="password"> Password </label>
            <input type="password" name="password" class="form-control" placeholder="pasword">
        </div>
        <div class="form-group pt-2">
            <a href="password_rest.php" class="card-link">Forget you password?</a>
        </div>
        <div class="form-group pt-2">
            <button class="btn btn-success">Login!</button>
        </div>
    </form>
</div>
<?php

include './Template/footer.php';
?>