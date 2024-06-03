<?php
    session_start();
    
    use App\Enums\UserAcess\UserAcess;
    use App\Class\Database\Database;

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';
    require_once '../App/php/scripts/UpdateProduct.php';

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
        exit();
    }

    if (unserialize($_SESSION['acessType']) != UserAcess::USER_ADM) {
        header('location: index.php');
        exit();
    }

    if (!isset($_GET['id'])) {
        header('location: index.php');
        exit();
    }

    $sql = "SELECT * FROM COMIDA JOIN IMAGENS ON IMAGENS.COMIDA_ID = COMIDA.COMIDA_ID WHERE COMIDA.COMIDA_ID = :id";

    $conn = new Database();
    $conn = $conn->connect();

    $query = $conn->prepare($sql);
    $query->execute([':id' => $_GET['id']]);
                        
    $result = $query->fetch(\PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar produto</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/AddFood.css">
    <link rel="stylesheet" href="assets/styles/android/alterPdr.css">
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 865px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
        <section id="AddPrd">
            <h1>
                Alterar produto
                <span class="material-symbols-outlined">
                    inventory_2
                </span>
            </h1>
            <form action="<?php print $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="PrdId">Codigo do produto</label>
                    <input type="text" name="PrdId" id="PrdId" required value="<?php print $result['COMIDA_ID'] ?>" readonly>
                </div>
                <div class="input-group">
                    <label for="PrdNameId">Nome do produto</label>
                    <input type="text" name="PrdName" id="PrdNameId" required value="<?php print $result['COMIDA_NOME'] ?>">
                </div>
                <div class="input-group">
                    <label for="PrdDescId">Descrição do produto</label>
                    <textarea name="PrdDesc" id="PrdDescId" required><?php print $result['COMIDA_DESC'] ?></textarea>
                </div>
                <div class="input-group">
                    <label for="PrdPriceId">Preço do produto</label>
                    <input type="text" name="PrdPrice" id="PrdPriceId" required value="<?php print $result['COMIDA_PRECO'] ?>">
                </div>
                <div class="input-group">
                    <label for="categoryId">Categoria do produto</label>
                    <select name="category" id="categoryId" required>
                        <option value="1" <?php print $result['COMIDA_CAT'] == 'churrascaria' ? 'selected' : '' ?>>churrasco</option>
                        <option value="2" <?php print print $result['COMIDA_CAT'] == 'bebida' ? 'selected' : '' ?>>bebida</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="PrdImageId">Foto do produto</label>
                    <img src="../App/php/scripts/ShowImage.php?id=<?php print $result['IMAGEM_ID'] ?>" alt="Foto do produto" id="imgPdr">
                    <input type="file" name="PrdImage" id="PrdImageId" accept="image/*">
                </div>
                <div>
                    <button type="submit">
                        Alterar produto
                    </button>
                </div>
                <a href="FoodList.php">Ver lista de produtos cadastrados</a>
            </form>
            <p id="erro">
                <?php print isset($message) ? $message : '' ?>
            </p> 
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
    <script src="../App/js/CheckFileSize.js"></script>
</body>
</html>