<?php

use App\Class\Database\Database;
use App\Enums\UserAcess\UserAcess;

require_once '../vendor/autoload.php';
require_once '../App/php/helpers/helpers.php';

session_start();

if (unserialize($_SESSION['acessType']) == UserAcess::USER_NORMAL) {
    
    $sql = "DELETE FROM CLIENTES WHERE CLIENTE_ID = :id";

    $conn = new Database();
    $conn = $conn->connect();

    $query = $conn->prepare($sql);
    $query->execute([':id' => $_SESSION['user_id']]);

    session_unset();
    session_destroy();

    setcookie('user_id', '', time() - 1000, '/');
    setcookie('acessType', '', time() - 1000, '/');
}

header('location: index.php');