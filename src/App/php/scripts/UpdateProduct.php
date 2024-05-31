<?php
    use App\Enums\UserAcess\UserAcess;
    use App\Class\Database\Database;

    if (unserialize($_SESSION['acessType']) != UserAcess::USER_ADM) {
        header('location: index.php');
        exit();
    }

    $message;

    if (isset($_POST['PrdId'])) {
            $PdrInfo = [
                $_POST['PrdName'],
                $_POST['PrdDesc'],
                $_POST['PrdPrice'],
                $_POST['category'],
            ];

        if (IsInfoSet($PdrInfo)) {
            $sql = "SELECT * FROM COMIDA WHERE COMIDA_NOME = ? AND COMIDA_ID <> ?";

            $conn = new Database();
            $conn = $conn->connect();

            $query = $conn->prepare($sql);
            $query->execute([$_POST['PrdName'], $_POST['PrdId']]);

            if ($query->rowCount() == 0) {
                $sql = "UPDATE COMIDA SET COMIDA_NOME = ?, COMIDA_DESC = ?, COMIDA_PRECO = ?, COMIDA_CAT = ? WHERE COMIDA_ID = ?";

                $query = $conn->prepare($sql);
                $query->execute([
                    $_POST['PrdName'],
                    $_POST['PrdDesc'],
                    $_POST['PrdPrice'],
                    $_POST['category'],
                    $_POST['PrdId']
                ]);

                if (isset($_FILES['PrdImage']) && IsImage($_FILES['PrdImage'])) {
                    $sql = "UPDATE IMAGENS SET IMAGEM_CONTEUDO = ?, IMAGEM_FORMATO = ? WHERE COMIDA_ID = ?";

                    $imagem = addslashes(trim(SaveImageBinaryCode($_FILES['PrdImage'], 'assets/images/uploads/')));
                    $formato = $_FILES['PrdImage']['type'];

                    $query = $conn->prepare($sql);
                    $query->execute([$imagem, $formato, $_POST['PrdId']]);
                }
                $message = 'Produto alterado com sucesso';
            } else {
                $message = 'O produto ja existe';
            }
        } else {
            $message = 'Preencha todas as informações corretamente';
        }
    }
