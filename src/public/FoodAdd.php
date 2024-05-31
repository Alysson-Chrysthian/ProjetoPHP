<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    use App\Class\Controller\Food;
    use App\Class\Controller\Image;
    use App\Enums\UserAcess\UserAcess;

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
        exit();
    }

    if (unserialize($_SESSION['acessType']) != UserAcess::USER_ADM) {
        header('location: index.php');
    }

    $message;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $PdrInfo = [
            $_POST['PrdName'],
            $_POST['PrdDesc'],
            $_POST['PrdPrice'],
            $_POST['category'],
            $_FILES['PrdImage']
        ];

        if (IsInfoSet($PdrInfo)) {

            $isImageValid = IsImage($_FILES['PrdImage']);

            if (!$isImageValid) {
                $message = 'A imagem selecionada não é valida';
            } else {
                $food = new Food($_POST['PrdName'], $_POST['PrdPrice'], $_POST['PrdDesc'], $_POST['category'], $_SESSION['user_id']);
                
                $validFood = $food->ValidateInfo();
                $foodExist = $food->VerifyIfExist();
                
                if ($foodExist) {
                    $message = 'O produto que você esta tentando cadastrar ja existe';
                } 
                elseif (!$validFood) {
                    $message = 'As informações inseridas nao sao validas';
                } 
                else {
                    $foodId = $food->Register();
                    $imageContent = SaveImageBinaryCode($_FILES['PrdImage'], 'assets/images/uploads/');
                    $image = new Image($_FILES['PrdImage']['type'], $foodId, $imageContent);
                    $image->Register();
                    $message = 'Produto cadastrado com sucesso';
                }
            }

        } else {
            $message = 'preencha todas as informações adequadamente';
        }

    }

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
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 750px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
        <section id="AddPrd">
            <h1>
                Novo produto
                <span class="material-symbols-outlined">
                    inventory_2
                </span>
            </h1>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="PrdNameId">Nome do produto</label>
                    <input type="text" name="PrdName" id="PrdNameId" required>
                </div>
                <div class="input-group">
                    <label for="PrdDescId">Descrição do produto</label>
                    <textarea name="PrdDesc" id="PrdDescId" required></textarea>
                </div>
                <div class="input-group">
                    <label for="PrdPriceId">Preço do produto</label>
                    <input type="text" name="PrdPrice" id="PrdPriceId" required>
                </div>
                <div class="input-group">
                    <label for="categoryId">Categoria do produto</label>
                    <select name="category" id="categoryId" required>
                        <option value="1">churrasco</option>
                        <option value="2">bebida</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="PrdImageId">Foto do produto</label>
                    <input type="file" name="PrdImage" id="PrdImageId" accept="image/*" required>
                </div>
                <div>
                    <button type="submit">
                        Adicionar Produto
                    </button>
                </div>
                <a href="FoodList.php">Ver lista de produtos cadastrados</a>
            </form>
            <p id="erro">
                <?php if (isset($message)) print $message ?>
            </p> 
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
    <script src="../App/js/CheckFileSize.js"></script>
</body>
</html>