<?php

use App\Class\Controller\User;
use App\Class\Database\Database;
use App\Class\Regex\UserRegex;

$message;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $UserInfo = [
        $_POST['userName'],
        $_POST['userMail'],
        $_POST['userCpf'],
        $_POST['userNasc']
    ];

    if (IsInfoSet($UserInfo)) {

        $conn = new Database();
        $conn = $conn->connect();

        $user = new User([
            'name' => $_POST['userName'],
            'mail' => $_POST['userMail'],
            'cpf' => $_POST['userCpf'],
            'nasc' => $_POST['userNasc']
        ]);

        $sql = "SELECT * FROM CLIENTES WHERE CLIENTE_CPF = :cpf OR CLIENTE_EMAIL = :mail OR CLIENTE_NOME = :name";

        $query = $conn->prepare($sql);
        $query->execute([
            ':cpf' => $_POST['userCpf'],
            ':mail' => $_POST['userMail'],
            ':name' => $_POST['userName']
        ]);

        $ValidValuesToUpdate = $query->rowCount() <= 1 && $user->ValidateInfo(false);

        if ($ValidValuesToUpdate) {

            $sql = "UPDATE CLIENTES SET CLIENTE_NOME = :name, CLIENTE_EMAIL = :mail, CLIENTE_CPF = :cpf, CLIENTE_NASC = :nasc WHERE CLIENTE_ID = :id";

            $query = $conn->prepare($sql);
            $query->execute([
                ':name' => $_POST['userName'],
                ':mail' => $_POST['userMail'],
                ':cpf' => $_POST['userCpf'],
                ':nasc' => $_POST['userNasc'],
                ':id' => $_SESSION['user_id']
            ]);

            $message = 'Usuario alterado com sucesso';
        } else {
            $message = 'Alguma informação inserida é invalida';
        }
    } else {
        $message = 'Alguma das informações nao foi inserida';
    }
}