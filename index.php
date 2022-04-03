<?php
$title = 'Home Page';
require './Template/header.php';
require 'classes/Service.php';
require 'classes/Product.php';
require 'Config/app.php';
require 'Config/database.php';
$Service          = new Service;
$Service->taxRate = .5;

$prodectObj          = new Product;
$prodectObj->taxRate = .05;

?>


<?php if ($Service->availbe) {
    ?>

<h1 class="pt-3">Start Shopping!</h1>
<?php
$prodects = $mysqli->query('SELECT * FROM `products`')->fetch_all(MYSQLI_ASSOC);
    ?>
<div class="row">

    <?php foreach ($prodects as $pred) {?>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <?php echo $pred['name'] ?>
            </div>
            <div class="card-body shadow">

                <div class="custom-card-image card-image d-block user-select-none"
                    style="background-image: url('<?php echo $config['app_url'] . $pred['img'] ?>'); background-size:contain;">
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $pred['description'] ?></p>
                    <p class="card-text">
                    <div class="text-success"> <?php echo $pred['price'] ?> SAR</div>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>


<?php }
$mysqli->close();
require_once './Template/footer.php'?>