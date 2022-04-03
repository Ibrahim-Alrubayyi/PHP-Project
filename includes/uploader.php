<?php
require './Config/database.php';
function filterString($filed)
{
    $filed = filter_var(trim($filed), FILTER_SANITIZE_STRING);
    if (empty($filed)) {

        return false;
    } else {

        return $filed;
    }

};
 function filterEmail($filed)
{
    $filed = filter_var(trim($filed), FILTER_SANITIZE_EMAIL);

     if (filter_var($filed, FILTER_VALIDATE_EMAIL)) {
        return $filed;
    } else {
        return false;
    }
    ;

};
 
function canUploads($file)
{
    $allowed = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ];

    
     $maxSixe = 7 * 1024;
     $fileMainType = mime_content_type($file['tmp_name']);
     $fileSize = $file['size'];
     if (!in_array($fileMainType, $allowed)) {
        return "ملفك غير مقبول";
    }
    ;

     if ($fileSize > $maxSixe) {
        return "ملفك كبير الحجم والحد هو 7";
    }
    return true;
}
//----------------------
$nameError = $emailError = $docmentError = $textAreaError = "";
$name      = $email      = $messge      = '';
$uplodDir  = 'uploads';

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    $name = filterString($_POST['name']);
    if (false == $name) {
        $nameError                        = 'Your name is reaqied';
        $_SESSION['contact_form']['name'] = '';

    } else {
        $_SESSION['contact_form']['name'] = $name;

    }
    ;

    $email = filterEmail($_POST['email']);
    if (false == $email) {
        $emailError                        = 'Your email is invaild';
        $_SESSION['contact_form']['email'] = '';

    } else {
        $_SESSION['contact_form']['email'] = $email;

    }
    ;

    $messge = filterString($_POST['messge']);
    if (!$messge) {
        $_SESSION['contact_form']['messge'] = '';

        $textAreaError = 'you must enter messge';
    } else {
        $_SESSION['contact_form']['messge'] = $messge;

    }

    if (isset($_FILES['document']) && 0 == $_FILES['document']['error']) {

        $canUpload = canUploads($_FILES['document']);

        if (true === $canUpload) {
            echo "Can you Uploads";
             if (!is_dir($uplodDir)) {
                umask(0);
                mkdir($uplodDir, 0775);
            }
             $fileName = time() . $_FILES['document']['name'];

            if (file_exists($uplodDir . '/' . $fileName)) {
                $docmentError = 'الصوره موجوده ';
            } else {
                move_uploaded_file($_FILES['document']['tmp_name'], $uplodDir . '/' . $fileName);

            }
         } else {
            $docmentError = $canUpload;
        }

    }
    if (!$nameError && !$emailError && !$docmentError && !$textAreaError) {

        $fileName ? $fileName = $uplodDir . "/" . $fileName : $fileName = null;

        $statement = $mysqli->prepare('INSERT INTO messages
        (service_id , contact_name , email , docment , messg)
        VALUES( ? , ? , ? , ? , ?)
        ');
        
        $statement->bind_param('issss', $dbService_id, $dbContact_name, $dbEmail, $dbDocment, $dbMessg);
        $dbService_id   = $_POST['service_id'];
        $dbContact_name = $name;
        $dbEmail        = $email;
        $dbDocment      = $fileName;
        $dbMessg        = $messge;
        $statement->execute();

       
        unset($_SESSION['contact_form']);
        header('Location:contact.php');
        die();

    }

}
;
