<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
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
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 750px)">
    <link rel="stylesheet" href="assets/styles/desktop/style.css" media="screen and (min-width: 750px)">

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
                if (isset($_POST['pesq'])) {
                    $pesq = $_POST['pesq'];
                }

                $products = SelectAllProducts($pesq);

                foreach ($products as $pdr) {
                    print('<div class="product">');
            ?>
                <figure>
                    <img src="../App/php/scripts/ShowImage.php?id=<?php print $pdr['IMAGEM_ID'] ?>" alt="comida foto">
                </figure>
                <div class="Pdrinfo">
                    <p class="PdrName">
                        <?php
                            $PdrName = substr($pdr['COMIDA_NOME'], 0, 17);
                            if ($PdrName != $pdr['COMIDA_NOME']) {
                                $PdrName .= '...';
                            }
                            print $PdrName;
                        ?>
                    </p>
                    <div class="PdrPriceAndDesc">
                        <p class="PdrDesc">
                            <?php
                            $pdrDesc = substr($pdr['COMIDA_DESC'], 0, 17);
                            if ($pdrDesc != $pdr['COMIDA_DESC']) {
                                $pdrDesc .= '...';
                            }
                            print  $pdrDesc;
                            ?>
                        </p>
                        <p class="PdrPrice">
                            <?php 
                            $price = FormatPrice($pdr['COMIDA_PRECO']);
                            $price = explode('.', $price);
                            print $price[0].'<span>.'.$price[1].'</span>';
                            ?>
                        </p>
                    </div>
                    <a href="#" class="BuyProduct">Comprar Agora</a>
                </div>
            <?php
                print('</div>');
            }
            ?>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
</body>
</html>