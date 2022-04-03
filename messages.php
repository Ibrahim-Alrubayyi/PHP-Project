<?php
$title = 'Messages';
require_once './Template/header.php';
require './Config/database.php';
require './Config/app.php';
$query = 'select * , m.id as mesg_id , s.id as ser_id from messages m left join service s on m.service_id = s.id order by m.id';
$mesg  = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);

if (!isset($_GET['id'])) {
    ?>
<h2>Recived Mesges</h2>
<div class="table-responsive ">
    <table class=" table-striped table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Seander name</th>
                <th>Seander email</th>
                <th> Servoce </th>
                <th>file</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mesg as $m) {?>
            <tr>
                <td><?php echo $m['mesg_id'] ?></td>

                <td><?php echo $m['contact_name'] ?></td>
                <td><?php echo $m['email'] ?></td>
                <td><?php echo $m['name'] ?></td>
                <td><?php echo $m['docment'] ?></td>
                <td>
                    <a href="?id=<?php echo $m['mesg_id'] ?>" class="btn btn-sm btn-primary">View</a>
                    <form action="" method="post" style="display: inline-block;">
                        <input type="hidden" name="message_id" value="<?php echo $m['mesg_id'] ?>">
                        <button class="btn btn-danger btn-sm">DELETE</button>
                    </form>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php } else {
    $mesgQuery = "SELECT * FROM messages m LEFT JOIN service s ON m.service_id = s.id WHERE m.id = $_GET[id] limit 1 ";

    $messgae = $mysqli->query($mesgQuery)->fetch_array(MYSQLI_ASSOC);
    ?>
<div class="card text-white bg-primary mb-3 mt-3">
    <h5 class="card-header">Meesge From : <?php echo $messgae['contact_name'] ?><br>
        <small div="text-muted">Email From : <?php echo $messgae['email'] ?></small>
    </h5>
    <div class="card-body">
        <div class="card-title">SERVICE :<?php echo $messgae['name'] ? $messgae['name'] : " no service" ?></div>
        <p class="card-text"><?php echo $messgae['messg'] ?></p>
    </div>
    <?php if ($messgae['docment']) {?>
    <div class="card-footer">
        Atrchment : <a href="<?php echo $config['app_url'] . $messgae['docment'] ?>">Download File</a>
    </div>
    <?php }?>
</div>
<?php }?>
<?php
//عند الحذف
if (isset($_POST['message_id'])) {

    $st = $mysqli->prepare('delete from messages where id = ?');
  
    $st->bind_param('i', $dbMessage_id);
    $dbMessage_id = $_POST['message_id'];
    $st->execute();
 
     echo '<script>location.href="http://127.0.0.1/project_php/messages.php"</script>';
    die();
}
require_once './Template/footer.php';
