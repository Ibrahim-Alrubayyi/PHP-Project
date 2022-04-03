<?php
$title = "Contact";
require_once 'Template/header.php';
include_once './includes/uploader.php';
require_once './Config/database.php';
require './classes/Service.php';
require './classes/Product.php';

if (isset($_SESSION['contact_form'])) {
    print_r($_SESSION['contact_form']);
}

$s          = new Service;
$s->taxRate = .05;

$service = $mysqli->query('SELECT id,name,price FROM service ORDER BY name')->fetch_all(MYSQLI_ASSOC);

?>
</br>
<h1>Contact us</h1>
<form enctype="multipart/form-data" method="POST" action="<?php echo $config['app_url'] . 'messages.php' ?>">
    <div class="form-group">
        <label for="name" class="form-label mt-4">Your Name</label>
        <input type="text" value="<?php if (isset($_SESSION['contact_form'])) {
    echo $_SESSION['contact_form']['name'];
}
?>" name="name" class="form-control" placeholder="Name">
        <span class="invalid-feedback"><?php echo $nameError ?></span>

    </div>
    <div class="form-group">
        <label for="email" class="form-label mt-4">Your email</label>
        <input value="<?php if (isset($_SESSION['contact_form'])) {
    echo $_SESSION['contact_form']['email'];
}
?>" type="email" name="email" class="form-control" placeholder="email">
        <span class="invalid-feedback"><?php echo $emailError ?></span>

    </div>
    <div class="form-group">
        <label for="document" class="form-label mt-4">Your document</label>
        <input type="file" name="document" class="form-control" />
        <span class="invalid-feedback"><?php echo $docmentError ?></span>
    </div>


    <div class="form-group">
        <label for="service" class="form-label mt-4"> service</label>
        <select name="service_id" id="service_id" class="form-select w-25">
            <?php foreach ($service as $ser) {?>
            <option value="<?php echo $ser['id'] ?>"><?php echo $ser['name'] . '(' . $s->price($ser['price']) . ')' ?>
            </option>
            <?php }?>

        </select>
    </div>


    <div class="form-group">
        <label for="messge" class="form-label mt-4">Your messge</label>
        <textarea name="messge" class="form-control" spellcheck="false" rows="3" placeholder="messge"><?php if (isset($_SESSION['contact_form'])) {
    echo $_SESSION['contact_form']['messge'];
}

?></textarea>
        <span class="invalid-feedback"><?php echo $textAreaError ?></span>

    </div>
    <div class="form-group mt-4">
        <button class="btn btn-primary">Send</button>
    </div>
</form>


<?php require_once 'Template/footer.php'?>