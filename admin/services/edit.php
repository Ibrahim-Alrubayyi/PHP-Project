<?php
$title = 'Edit service';
include __DIR__ . '/../template/header.php';
if (!isset($_GET['id']) || !$_GET['id']) {
    die('missing error');
}

$errors = [];
$st     = $mysqli->prepare("select * from service where id = ? limit 1");
$st->bind_param('i', $serviceId);
$serviceId = $_GET['id'];
$st->execute();

$service = $st->get_result()->fetch_assoc();

$name        = $service['name'];
$description = $service['description'];
$price       = $service['price'];

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

    if (!count($errors)) {
        $st = $mysqli->prepare("update service set name = ? ,  description = ?, price = ?   where id = ? ");
        $st->bind_param('ssdi', $dbname, $dbdescription, $dbprice, $dbid);
        $dbname        = $_POST['name'];
        $dbdescription = $_POST['description'];
        $dbprice       = $_POST['price'];
        $dbid          = $_GET['id'];

        //Cheak email used or not
        $userExists = $mysqli->query("select name from service where name = '$dbname' limit 1");
        if ($userExists->num_rows) {
            array_push($errors, 'name used');
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
        <form action="" method="post">
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
                <button class="btn btn-success">Update!</button>
            </div>
        </form>
    </div>

</div>
<?php
include __DIR__ . '/../template/footer.php';