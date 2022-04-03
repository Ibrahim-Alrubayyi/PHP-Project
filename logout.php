<?php
session_start();
if ($_SESSION['logged_in']) {
    $_SESSION                    = [];
    $_SESSION['success_message'] = 'You logout ';
    header('location:index.php');
    die();
}