<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risca Faca Food Corporation</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/style.css">
    <link rel="stylesheet" href="assets/styles/android/BuyProduct.css">
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 865px)">
    <link rel="stylesheet" href="assets/styles/desktop/style.css" media="screen and (min-width: 865px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
        <section id="background">
            <div>
                <h1>Risca Faca</h1>
                <p>Deixe o fogo transformar sua fome em felicidade</p>
            </div>
        </section>
        <section id="products">
            <?php
                $pesq = '';
                if (isset($_GET['pesq'])) {
                    $pesq = $_GET['pesq'];
                }

                $products = SelectAllProducts($pesq);
                
                if (count($products) == 0) {
                    print 'Não há nenhum produto disponivel';
                }

                foreach ($products as $id => $pdr) {
            ?>
            <div class="product" id="product-<? print $id ?>">
                <figure>
                    <img src="../App/php/scripts/ShowImage.php?id=<?php print $pdr['IMAGEM_ID'] ?>" alt="comida foto">
                </figure>
                <div class="Pdrinfo">
                    <!--Nome do produto-->
                    <p class="PdrName">
                        <?php print FormatDesc($pdr['COMIDA_NOME'], 15) ?>
                    </p>
                    <!--Container com o preço e a descrição do produto-->
                    <div class="PdrPriceAndDesc">
                        <p class="PdrDesc">
                            <?php print FormatDesc($pdr['COMIDA_DESC'], 15) ?>
                        </p>
                        <p class="PdrPrice">
                            <?php print FormatPrice($pdr['COMIDA_PRECO']) ?>
                        </p>
                    </div>
                    <!--Botao de comprar produto-->
                    <a href="../App/php/scripts/BuyProduct.php?PdrId=<?php print $pdr['COMIDA_ID'] ?>">
                        <button class="BuyProduct">
                            Comprar Agora
                        </button>
                    </a>
                </div>
            </div>
            <?php
                }
            ?>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
</body>
</html>