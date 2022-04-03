<?php
$title = 'Services';
include __DIR__ . '/../template/header.php';
$services = $mysqli->query('SELECT id , price , name , description FROM service ORDER BY id')->fetch_all(MYSQLI_ASSOC);
?>


<div class="card">
    <div class="card-body">
        <a href="<?php echo $config['app_url'] ?>admin/services/create.php" class="btn btn-success">Create service</a>
        <div class="scard-header pt-3">
            services : <?php echo count($services) ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="0">#</th>
                        <th>name</th>
                        <th>DESCRIPTION</th>
                        <th>Price</th>
                        <th>actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo $service['id'] ?></td>
                        <td><?php echo $service['name'] ?></td>
                        <td><?php echo $service['description'] ?></td>
                        <td><?php echo $service['price'] ?></td>
                        <td class=" flex-column">
                            <a href="<?php echo $config['app_url'] ?>admin/services/edit.php?id=<?php echo $service['id'] ?>"
                                class=" btn btn-warning   m-2">Edite</a>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $service['id'] ?>" />
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

        $st = $mysqli->prepare('delete from service where id = ?');
      
        $st->bind_param('i', $id);
        $id = $_POST['id'];
        $st->execute();
 
         echo '<script>location.href="http://127.0.0.1/project_php/admin/services/index.php"</script>';
        die();
    }
}
?>
