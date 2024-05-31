<?php
    require_once '../../../vendor/autoload.php';

    use App\Class\Database\Database;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM IMAGENS WHERE IMAGEM_ID = :id";

        $conn = new Database();
        $conn = $conn->connect();

        $query = $conn->prepare($sql);
        $query->execute([':id' => $id]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        $format = $result['IMAGEM_FORMATO'];
        $image = $result['IMAGEM_CONTEUDO'];

        header('content-type: '.$format);

        print stripslashes($image);
    }

    header('location: ../../../public/index.php');