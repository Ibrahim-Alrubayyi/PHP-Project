<?php
$title = 'user';
include __DIR__ . '/../template/header.php';
$users = $mysqli->query('SELECT id , email , name , role FROM users ORDER BY id')->fetch_all(MYSQLI_ASSOC);
$sum   = $mysqli->query('SELECT SUM(id)   FROM users  ');
?>


<div class="card">
    <div class="card-body">
        <a href="<?php echo $config['app_url'] ?>admin/users/create.php" class="btn btn-success">Create user</a>
        <div class="scard-header pt-3">
            Users : <?php echo count($users) ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="0">#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['name'] ?></td>
                        <td><?php echo $user['role'] ?></td>
                        <td class=" flex-column">
                            <a href="<?php echo $config['app_url'] ?>admin/users/edit.php?id=<?php echo $user['id'] ?>"
                                class=" btn btn-warning   m-2">Edite</a>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>" />
                                <button class="btn btn-danger m-2">delete</button>

                            </form>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../template/footer.php';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['id'])) {

        $st = $mysqli->prepare('delete from users where id = ?');
     
        $st->bind_param('i', $id);
        $id = $_POST['id'];
        $st->execute();
 
         echo '<script>location.href="http://127.0.0.1/project_php/admin/users/index.php"</script>';
        die();
    }
}
?>
