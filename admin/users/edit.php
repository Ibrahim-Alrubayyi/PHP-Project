<?php
$title = 'Edit users';
include __DIR__ . '/../template/header.php';
if (!isset($_GET['id']) || !$_GET['id']) {
    die('missing error');
}

$errors = [];
$st     = $mysqli->prepare("select * from users where id = ? limit 1");
$st->bind_param('i', $userId);
$userId = $_GET['id'];
$st->execute();

$user = $st->get_result()->fetch_assoc();

$name  = $user['name'];
$email = $user['email'];
$role  = $user['role'];

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (empty($_POST['email'])) {
        array_push($errors, 'Email is required');
    }
    if (empty($_POST['name'])) {
        array_push($errors, 'name is required');
    }
    if (empty($_POST['role'])) {
        array_push($errors, 'role is required');
    }

    if (!count($errors)) {
        $st = $mysqli->prepare("update users set name = ? ,  email = ?, role = ? , password = ? where id = ? ");
        $st->bind_param('ssssi', $dbname, $dbemail, $dbrole, $dbpassword, $dbid);
        $dbname                          = $_POST['name'];
        $dbemail                         = $_POST['email'];
        $dbrole                          = $_POST['role'];
        $_POST['password'] ? $dbpassword = password_hash($_POST['password'], PASSWORD_DEFAULT) : $dbpassword = $user['password'];
        $dbid                            = $_GET['id'];

        //Cheak email used or not
        $userExists = $mysqli->query("select email from users where email = '$dbemail' limit 1");
        if ($userExists->num_rows) {
            array_push($errors, 'email used');
        } else {
            $st->execute();
            echo "<script>location.href= 'index.php'</script>";

        }
    }
}
?>

<div class="card">
    <div class="card-body">
        <?php include __DIR__ . '/../template/errors.php'?>
        <form action="" method="POST">
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
                <button class="btn btn-success">Update!</button>
            </div>
        </form>
    </div>

</div>
<?php
include __DIR__ . '/../template/footer.php';