<?php
    session_start();

    require_once '../../../vendor/autoload.php';
    require_once '../helpers/helpers.php';

    use App\Class\Database\Database;

    if (isset($_GET['PdrId'])) {
        $sql = "SELECT COMIDA_PRECO FROM COMIDA WHERE COMIDA_ID = :id";

        $conn = new Database();
        $conn = $conn->connect();
        $query = $conn->prepare($sql);
        $query->execute([':id' => $_GET['PdrId']]);

        $query = $query->fetch(PDO::FETCH_ASSOC);
        $price = $query['COMIDA_PRECO'];

        $sql = "INSERT INTO COMPRA VALUES(DEFAULT, ?, ?, ?, ?)";

        $query = $conn->prepare($sql);
        $query->execute([$_SESSION['user_id'], $_GET['PdrId'], date('Y-m-d'), $price]);
    
        header('location: ../../../public/SuccessBuy.html');
        exit();
    }

    header('location: ../../../public/index.php');
    exit();