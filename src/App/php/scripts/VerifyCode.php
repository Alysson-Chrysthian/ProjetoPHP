<?php

session_start();

require_once '../../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['code'] === $_SESSION['code']) {
        unset($_SESSION['code']);
        
        $_SESSION['Verified'] = true;
        header('location: ../../../public/ForgotPassword.php');
        exit;
    } else {
        unset($_SESSION['code']);
        $_SESSION['erro'] = 'Codigo errado, por favor tente novamente';
        header('location:../../../public/VerifyMail.php');
        exit;
    }

}

header('location: ../../../public/index.php');
exit;