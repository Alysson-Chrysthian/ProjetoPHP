<?php
    require_once '../../../vendor/autoload.php';
    require_once '../Helpers/Helpers.php';

    session_start();

    use App\Class\Controller\User;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new User('', '', $_POST['email'], $_POST['password'], '');

        $UserLog = $user->VerifyIfCanLog();

        if (!$UserLog) {
            $_SESSION['erro'] = 'Usuario não existe';
            header('location: ../../../public/LogInUser.php');
            die();
        }

        CreateUserSession($UserLog, isset($_POST['StillConn']));

    }

    header('location: ../../../public/index.php');