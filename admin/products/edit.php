<?php
$title = 'Edit prodect';
include __DIR__ . '/../template/header.php';

require_once __DIR__ . '/../../classes/Upload.php';

if (!isset($_GET['id']) || !$_GET['id']) {
    die('missing error');
}

$errors = [];
$st     = $mysqli->prepare("select * from products where id = ? limit 1");
$st->bind_param('i', $productId);
$productId = $_GET['id'];
$st->execute();

$product = $st->get_result()->fetch_assoc();

$name        = $product['name'];
$description = $product['description'];
$price       = $product['price'];
$image       = $product['img'];

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (empty($_POST['description'])) {
        array_push($errors, 'description is required');
    }
    if (empty($_POST['name'])) {
        array_push($errors, 'name is required');
    }
    if (empty($_POST['price'])) {
        array_push($errors, 'price is required');
    }
    if (isset($_FILES['image']) && 0 == $_FILES['image']['error']) {

        $upload       = new Upload('uploads/products');
        $upload->file = $_FILES['image'];
        $errors       = $upload->upload();
        if (!count($errors)) {
            unlink('../../' . $image);
            $image = $upload->filePath;
        }

    }
    if (!count($errors)) {
        $st = $mysqli->prepare("update products set name = ? ,  description = ?, price = ? , img = ?  where id = ? ");
        $st->bind_param('ssdsi', $dbname, $dbdescription, $dbprice, $dbimage, $dbid);
        $dbname        = $_POST['name'];
        $dbdescription = $_POST['description'];
        $dbprice       = $_POST['price'];
        $dbimage       = $image;
        $dbid          = $_GET['id'];

        $st->execute();
        echo "<script>location.href= 'index.php'</script>";

    }
}
?>
<div class="card">
    <div class="card-body">
        <?php include __DIR__ . '/../template/errors.php'?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group pt-2">
                <label for="name"> name </label>
                <input value="<?php echo $name ?>" type="text" name="name" class="form-control" placeholder="name">
            </div>
            <div class="form-group pt-2">
                <label for="description">description </label>
                <textarea cols="30" rows="10" name="description" class="form-control"
                    placeholder="description"><?php echo $description ?></textarea>
            </div>
            <div class="form-group pt-2">
                <label for="price"> price </label>
                <input type="text" name="price" class="form-control" placeholder="price" value="<?php echo $price ?>">
            </div>
            <div class="form-group pt-2">
                <img src="<?php echo $config['app_url'] . $image ?>" width="150">
                <label for="image"> image </label>
                <input type="file" name="image" id="image">
            </div>

            <div class="form-group pt-2">
                <button class="btn btn-success">Create!</button>
            </div>
        </form>
    </div>

</div>
<?php
include __DIR__ . '/../template/footer.php';