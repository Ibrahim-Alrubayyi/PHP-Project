<?php
$title = 'Create service';
include __DIR__ . '/../template/header.php';

$errors = [];
$price  = $name  = $description  = "";

if ('POST' === $_SERVER['REQUEST_METHOD']) {
     $price       = mysqli_real_escape_string($mysqli, $_POST['price']);
    $name        = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);

    if (empty($price)) {
        array_push($errors, 'price is required');
    }
    if (empty($name)) {
        array_push($errors, 'name is required');
    }
    if (empty($description)) {
        array_push($errors, 'description is required');
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

            $q = "INSERT INTO service (description,name,price) VALUES ('$description' , '$name' , '$price')";
            $db->exec($q);

        } catch (PDOException $er) {
            array_push($errors, $er->getMessage());

        }

        if (!count($errors)) {
            echo "<script>location.href = 'http://127.0.0.1/project_php/admin/services'</script>";
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
                <button class="btn btn-success">Create!</button>
            </div>
        </form>
    </div>

</div>
<?php
include __DIR__ . '/../template/footer.php';
