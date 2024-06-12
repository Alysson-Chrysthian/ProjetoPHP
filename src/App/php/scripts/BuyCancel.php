<?php
    require_once '../../../vendor/autoload.php';
    require_once '../helpers/helpers.php';

    use App\Class\Database\Database;

    if (isset($_GET['id'])) {
        $sql = "DELETE FROM COMPRA WHERE COMPRA_ID = :id";
    
        $conn = new Database();
        $conn = $conn->connect();
        $query = $conn->prepare($sql);
        $query->execute([':id' => $_GET['id']]);

        header('location: ../../../public/BuyCancellSuccess.html');
        exit();
    }

    header('location: ../../../public/index.php');
    exit();