<?php
if (count($errors)) {

    ?>

<div class="alert alert-danger">
    <?php foreach ($errors as $er) {?>

    <p><?php echo $er ?></p>



    <?php }?>
</div>



<?php
}