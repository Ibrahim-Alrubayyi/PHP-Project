<?php
$title = 'Settings';
include __DIR__ . '/../template/header.php';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $st = $mysqli->prepare('UPDATE settings SET admin_email = ? , app_name = ? WHERE id =1 ');
    $st->bind_param('ss', $dbAdminEmail, $dbAppName);
    $dbAdminEmail = $_POST['admin_email'];
    $dbAppName    = $_POST['app_name'];
    $st->execute();
    echo '<script>location.href="index.php"</script>';
}
?>

<div class="card">
    <div class=" card-body">
        <h3>Update settings</h3>
        <form action="" method="post">
            <div class="  form-group pt-2">
                <label for="app_name">App name :</label>
                <input value="<?php echo $config['app_name'] ?>" type="text" name="app_name" id="app_name"
                    class="form-control">
            </div>
            <div class=" form-group pt-2">
                <label for="admin_email"> Admin email :</label>
                <input value="<?php echo $config['admin_email'] ?>" type="email" name="admin_email" id="admin_email"
                    class="form-control">
            </div>
            <div class="form-group pt-2">
                <button class="btn btn-success">Update settings</button>
            </div>
        </form>
    </div>
</div>
<?php
include __DIR__ . '/../template/footer.php';