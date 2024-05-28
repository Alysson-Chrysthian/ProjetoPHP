<?php
    require_once '../../../vendor/autoload.php';
    require_once '../Helpers/Helpers.php';

    session_start();

    use App\Class\Controller\User;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $user = new User(
            $_POST['name'],
            $_POST['cpf'],
            $_POST['email'],
            $_POST['password'],
            $_POST['nasc']
        );

        if (!VerifyUser($user)) {
            $_SESSION['erro'] = 'Usuario ja existe ou informações foram preenchidas incorretamente';
            header('location: ../../../public/SignUp.php');
            die();
        }

        $id = $user->RegisterUser();
        CreateUserSession($id, isset($_POST['StillConn']));

    }

    header('location: ../../../public/index.php');