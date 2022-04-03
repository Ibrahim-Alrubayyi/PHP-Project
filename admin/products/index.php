<?php
$title = 'products';
include __DIR__ . '/../template/header.php';
$products = $mysqli->query('SELECT *  FROM products ORDER BY id')->fetch_all(MYSQLI_ASSOC);
?>


<div class="card">
    <div class="card-body">
        <a href="<?php echo $config['app_url'] ?>admin/products/create.php" class="btn btn-success">Create products</a>
        <div class="scard-header pt-3">
            products : <?php echo count($products) ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="0">#</th>
                        <th>name</th>
                        <th>DESCRIPTION</th>
                        <th>Price</th>
                        <th>img</th>
                        <th>actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id'] ?></td>
                        <td><?php echo $product['name'] ?></td>
                        <td><?php echo $product['description'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td><img src="<?php echo $config['app_url'] . $product['img'] ?>" width="100" alt=""></td>
                        <td class=" flex-column ">
                            <a href="<?php echo $config['app_url'] ?>admin/products/edit.php?id=<?php echo $product['id'] ?>"
                                class=" btn btn-warning   m-2">Edite</a>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $product['id'] ?>" />
                                <input type="hidden" name="image" value="<?php echo $product['img'] ?>" />
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

        if ($_POST['image']) {
            unlink('../../' . $_POST['image']);
        }
        $st = $mysqli->prepare('delete from products where id = ?');
       
        $st->bind_param('i', $id);
        $id = $_POST['id'];
        $st->execute();

 
         echo '<script>location.href="http://127.0.0.1/project_php/admin/products/index.php"</script>';
        die();
    }
}
?>
