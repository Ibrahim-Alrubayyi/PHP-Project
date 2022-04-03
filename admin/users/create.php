<?php
$title = 'Create users';
include __DIR__ . '/../template/header.php';

$errors = [];
$email  = $name  = $role  = "";

if ('POST' === $_SERVER['REQUEST_METHOD']) {
     $email    = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name     = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $role     = mysqli_real_escape_string($mysqli, $_POST['role']);

    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
    if (empty($name)) {
        array_push($errors, 'name is required');
    }
    if (empty($password)) {
        array_push($errors, 'password is required');
    }
    if (empty($role)) {
        array_push($errors, 'role is required');
    }

    if (!count($errors)) {
        $dsn  = 'mysql:host=localhost;dbname=app';
        $user = 'root';
        $pass = '';
        $opt  = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ];
        try {
            $db = new PDO($dsn, $user, $pass, $opt);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $q = "INSERT INTO users (email,name,password,role) VALUES ('$email' , '$name' , '$password', '$role')";
            $db->exec($q);

        } catch (PDOException $er) {
            array_push($errors, $er->getMessage());

        }

        if (!count($errors)) {
            echo "<script>location.href = 'http://127.0.0.1/project_php/admin/'</script>";
            die();
        }

    }
}
?>
<div class="card">
    <div class="card-body">
        <?php include __DIR__ . '/../template/errors.php'?>
        <form action="" method="post">
            <div class="form-group pt-2">
                <label for="email"> Email </label>
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group pt-2">
                <label for="name">name </label>
                <input type="text" name="name" class="form-control" placeholder="name">
            </div>
            <div class="form-group pt-2">
                <label for="password"> password </label>
                <input type="password" name="password" class="form-control" placeholder="pasword">
            </div>
            <div class="form-group w-25">
                <label for="role">Role :</label>
                <select name="role" id="role" class="form-control">
                    <option value="user" <?php if ('user' == $role) {
    echo 'selected';
}
?>>User</option>
                    <option value="admin" <?php if ('admin' == $role) {
    echo 'selected';
}
?>>Admin</option>
                </select>
            </div>
            <div class="form-group pt-2">
                <button class="btn btn-success">Create!</button>
            </div>
        </form>
    </div>

</div>
<?php
include __DIR__ . '/../template/footer.php';
