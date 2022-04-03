<?php
$title = "Password rest";
require_once 'Template/header.php';
require_once './Config/database.php';
require_once './Config/app.php';
$errors = [];
if (isset($_SESSION['logged_in']) == 1) {
    header('location:  index.php');
    die();
}
if ('POST' === $_SERVER['REQUEST_METHOD']) {
     $email = mysqli_real_escape_string($mysqli, $_POST['email']);

    if (empty($email)) {
        array_push($errors, 'Email is required');
    }

    if (!count($errors)) {
        $userExists = $mysqli->query("SELECT  id, email   FROM users WHERE email = '$email' limit 1")->fetch_assoc();
        if (count($userExists)) {
             $tokenExists = $mysqli->query("delete from password_rests where user_id = '$userExists[id]' ");

            $token = bin2hex(random_bytes(16));

            $expires_at = date("y-m-d h:i:s", strtotime('+1 day'));

            $mysqli->query("insert into password_rests (user_id , token , expires_at) values ('$userExists[id]','$token','$expires_at')");

        }
        $_SESSION['success_message'] = 'PLEASE CHEACK TOU EMAIL';

        $CHANGE_URL = $config['app_url'] . 'change_paassword?token=' . $token;
        $header     = 'MIME-Version: 11.0' . "\r \n" . 'contact-type: text/html; charset=UTF-8' . "\r \n";
        $header .= 'FROM: ' . $config['admin_email'] . "\r \n" .
        'Reply-To: ' . $config['admin_email'] . "\r \n" .
        'X-Mailer: PHP/' . phpversion();

        $htmlMessg = '<html><body> ';
        $htmlMessg .= '<a style="color:#ff0000;">' . $CHANGE_URL . '</a>';
        $htmlMessg .= '</body></html>';
        mail($email, 'PASSWORD REST', $htmlMessg, $header);
        header('location: password_rest.php');
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
            <label for="email"> Email </label>
            <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group pt-2">
            <button class="btn btn-primary">rest!</button>
        </div>
    </form>
</div>
<?php

include './Template/footer.php';
?>
