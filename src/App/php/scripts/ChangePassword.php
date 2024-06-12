<?php

session_start();

require_once '../../../vendor/autoload.php';
require_once '../helpers/helpers.php';

use App\Class\Database\Database;
use App\Class\Regex\UserRegex;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new Database();
    $conn = $conn->connect();

    if (!preg_match(UserRegex::REGEX_PASS, $_POST['pass'])) {
        $_SESSION['error'] = 'A senha digitada é invalida';
        header('location: ../../../public/ForgotPassword.php');
        exit();
    }

    if ($_POST['pass'] === $_POST['passConfirm']) {

        $sql = "UPDATE CLIENTES SET CLIENTE_SENHA = :senha WHERE CLIENTE_ID = :id";

        $query = $conn->prepare($sql);
        $query->execute([
            ':senha' => hash('sha256', $_POST['pass']),
            ':id' => $_SESSION['user_id']
        ]);


        $_SESSION['error'] = 'Senha alterada com sucesso';
        header('location: ../../../public/UserProfile.php');
        exit();
    }

    $_SESSION['error'] = 'As senhas digitadas nao sao iguais';
    header('location: ../../../public/ForgotPassword.php');
    exit();

}

header('location: ../../../public/index.php');
exit();