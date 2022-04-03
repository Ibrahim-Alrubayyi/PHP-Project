<?php require_once __DIR__ . "/../Config/app.php";
session_start();

?>
<!DOCTYPE html>
<html lang="<?php echo $config['lang'] ?>" dir="<?php echo $config['dir'] ?>">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name'] . " | " . $title ?></title>
    <style>
    .custom-card-image {
        height: 200px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }

    <?php include "master.css";
    include "assets/style/bootstrap.min.css";
    ?>
    </style>
    <link rel="stylesheet" href="assets/style/bootstrap.min.css">
</head>

<body>
    <div class=" bg-primary shadow">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-0">


                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php"><?php echo $config['app_name'] ?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarColor01">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            <a class="nav-link" href="contact.php">Contact</a>

                        </div>
                        <div class="navbar-nav ms-auto">
                            <?php if (!isset($_SESSION['logged_in'])) {?>

                            <li class="nav-item">
                                <a href="login.php" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="register.php" class="nav-link">Register</a>
                            </li>

                            <?php } else {?>
                            <li class="nav-item">
                                <span class="nav-link">Hello, <?php echo $_SESSION['user_name'] ?></span>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php" class="nav-link">Logout</a>
                            </li>
                            <?php }?>
                        </div>


                    </div>
                </div>
            </nav>
        </div>

    </div>
    <div class="container">
        <?php include 'messages.php'?>